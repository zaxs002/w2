<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2010 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: library.php,v 0.0.1 03/03/2004 17:38:21 oxylus Exp $
	slqadmin class
*/

/**
* slqadmin  class
*
* @library	Library
* @author	oxylus [Emanuel Giurgea <emanuel@oxylus.ro>]
* @since	PHPbase 0.0.1
*/


class CSQLAdmin extends CLibrary {

	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $form;

	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $functions;
		

	function CSQLAdmin($section , $templates , $db , $tables , $extra = "") {
		global $_CONF;

		if (!$_GET["page"])
			$_GET["page"] = 1;		


		parent::CLibrary("SQLAdmin");
		
		//checking if the templates are orblects or path to a template file
		if (!is_array($templates))					
			//if path the load the tempmate form that file
			$this->templates = array("generic_form" => new CTemplate($templates));
		else
			$this->templates = $templates;
		
		$this->db = $db;
		$this->tables = $tables;
		//extra variables to be passed to cform
		$this->extra = $extra;

		if (is_array($section)) {
			$this->forms = $section;			
		} else {
		
			//loading the forms , changed the varialbes locations, but still keeping the compatibility
			$path = ($_CONF["forms"]["adminpath"] ? $_CONF["forms"]["adminpath"] : $_CONF["formspath"] );
			if (dirname($section)) {

				$path .= dirname($section) . "/" ;
				$section = basename($section);
			}
			
			//debuging part 
//			echo "<br>FILE:SQLADMIN:MAIN:{$path}{$section}.xml";
			if (defined("PB_DEBUG") && (PB_DEBUG == "1"))
				echo "<br>FILE:SQLADMIN:MAIN:{$path}{$section}.xml";

			$conf = new CConfig( $path . $section . ".xml");

			$this->forms = $conf->vars["form"];

			//loading the edit/add forms
			if (is_array($this->forms["forms"])) {
				
				foreach ($this->forms["forms"] as $key => $val) {	

					if (is_array($val)) {
						$form = CForm::Process($path . $val["file"]);	
						$this->forms["forms"][$key] = $form;						
						$this->forms["forms"][$key]["type"] = $val["type"];
					}
					

					if (strstr($val,"SHOW::")) {						
						$tmp = explode("::" , $val);						
						$form = is_array($this->forms["forms"][$tmp[1]]) ? $this->forms["forms"][$tmp[1]] : CForm::Process($path . $this->forms["forms"][$tmp[1]]);
						CForm::__private__showonly(&$form);
					} else 					
						if (file_exists($path . $val)){
							$form = CForm::Process($path . $val);
						}

					if (is_array($form)) {
						$this->forms["forms"][$key] = array_merge(
									$form , 
									array(
										"table" => &$this->forms["table"],
										"table_uid" => &$this->forms["table_uid"],
										"urilinks" => &$this->forms["urilinks"],
										"uridata" => &$this->forms["uridata"] 
									)
								);

						if (in_array($key , array("store" , "add" , "edit" , "details" , "search")) && !isset($this->forms["forms"][$key]["type"])) {
							$this->forms["forms"][$key]["type"] = "FORM";
						} else {
							if (in_array($key , array("list" , "search")) && !isset($this->forms["forms"][$key]["type"])) {
								$this->forms["forms"][$key]["type"] = "LIST";
							}							
						}						
					}
				}
				
				//prepare buttons
				foreach ($this->forms["forms"] as $key => $val) {	
					if ((($key == "edit")||($key == "add")) && isset($this->forms["forms"][$key]["buttons"]["button_edit"]))
						unset($this->forms["forms"][$key]["buttons"]["button_edit"]);
			
					if (($key == "details") && isset($this->forms["forms"][$key]["buttons"]["button_save"]))
						unset($this->forms["forms"][$key]["buttons"]["button_save"]);

					if (!($_GET["returnurl"] || $_POST["returnurl"]) && isset($this->forms["forms"][$key]["buttons"]["button_back"]))
						if (is_array($this->forms["forms"][$key]["buttons"]["button_back"])) {
							unset($this->forms["forms"][$key]["buttons"]["button_back"]);
						}

				}					

				if (is_array($this->forms["forms"]["search"])) {
					//prepare the list to be shown under a cform box
					$search = &$this->forms["forms"]["search"];

					if (is_array($search["search"]["simple"]) && is_array($search["search"]["advanced"])) 
						$search["search"] = $search["search"][$_GET["advanced"] ? "advanced" : "simple"];					

					if (is_array($search["search"])) {
						$search_type = &$search["search"];

						$search["fields"] = array_merge($search["fields"] , $search_type["fields"] );
						//append a field to show all the fields when a submit button is pressed

						//prepare the list form

						//check if the fields in the list will apear dinamicaly
						if (is_array($search_type["fields"]["fields"])) {

							if (is_array($_GET["fields"])) {
								$fields_list = $_GET["fields"];
							} else {							
								$fields_list = explode("," , strlen($_GET["fields"]) ? $_GET["fields"] : $search_type["fields"]["fields"]["default"]);
							}

							//if no getfields then set the default fields
							if (!is_array($_GET["fields"]))
								$_GET["fields"] = $fields_list;

							//process the $_GET["fields"]
							if (is_array($_GET["fields"])) {
								foreach ($_GET["fields"] as $__key => $__val) {
//									if ($__key != $__val) {
										$_GET["fields"][$__val] = $__val;
										unset($_GET["fields"][$__key]);
//									}
								}

//								debug($_GET["fields"]);
								
							}
							

							
							//remove the fields which arent defined, ONLY IF $_GET[fields] is set
							if (is_array($search_type["header"]) && is_array($_GET["fields"]) ) {
								foreach ($search_type["header"] as $key => $val) {
									if (!array_exists($key , $fields_list )) {
										unset($search_type["header"][$key]);
									}							
								}						
							}

						} else {
							// add all the existing gields
							if (is_array($search_type["header"]) && count($search_type["header"]))
								$this->forms["forms"]["list"]["fields"] = array_merge($search_type["header"],$this->forms["forms"]["list"]["fields"]);
						}

					}
				}
			}
		}

		$this->form = new CForm($this->templates["generic_form"], &$db , &$tables);

}

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function FormList($items = "" , $return_ajax = false , $page = 1) {
		global $base;

		$found_search = true;

			
		//prepare the listing way
		if (is_array($this->forms["forms"]["search"])) {
			if ($this->forms["forms"]["search"]["search"]["required"] == "true")
				$found_search = false;			
		} else
			$found_search = true;				

		//checking if hte values weren't inputed ion the main object

		if (is_array($this->items)) {
			$items = $this->items;
			$items_count = count($items);
		} else {
			if (is_array($items))
				$items_count = count($items);
		}
		//crap, preexecute a function, which is suposed in some times to preload the items too

		//check if exists a search screen
		if (is_array($this->forms["forms"]["search"])) {
			//prepare the list to be shown under a cform box
			$search = &$this->forms["forms"]["search"];

			if (($_GET["hidesearch"] != "true")) {
				$this->forms["forms"]["list"]["border"] = "";
				$this->forms["forms"]["list"]["subtitle"] = $this->forms["forms"]["list"]["title"];

			}

			//process the buttons
			if ($_GET["advanced"]) {
				unset($search["buttons"]["butt_advanced"]);
				unset($search["buttons"]["button_advanced"]);
			} else {
				if (isset($search)) {
					if (is_array($search["buttons"]["butt_simple"]))
						unset($search["buttons"]["butt_simple"]);

					if (is_array($search["buttons"]["button_simple"]))
						unset($search["buttons"]["button_simple"]);
				}			
			}

			if (is_array($search["search"])) {
				$search_type = &$search["search"];

				//put the remain fields in the front of the other in the listing xml
				if (is_array($search_type["header"])) {
					$this->forms["forms"]["list"]["fields"] = array_merge($search_type["header"],$this->forms["forms"]["list"]["fields"]);
				}								


				//check if exists  return url then show the return button
				if (!$_GET["returnurl"] && is_array($search["buttons"]["button_back"]))
					unset($search["buttons"]["button_back"]);
				
				//prepare the list form

				//check if the fields in the list will apear dinamicaly
				if (is_array($search_type["sql_fields"])) {

					//prepare the search query
					if (is_array($search_type["sql_fields"])) {

						

						//process the variables from the input source
						CForm::ProcessVariables($search, &$_GET);

						foreach ($search_type["sql_fields"] as $key => $val) {
							//add to query only variables which are found in $_GET, others get ignored
							switch (strtolower($val)) {
								case "=":
									if (isset($_GET[$key]) &&  strlen($_GET[$key]))
										$query[] = " `$key`='{$_GET[$key]}'";
								break;

								case "int":
									$query[] = " `$key`=" . ((int)$_GET[$key]) . "";
								break;
	
								case "%":
									if (isset($_GET[$key]) && strlen($_GET[$key]))
										$query[] = " `$key` LIKE '%{$_GET[$key]}%'";
								break;

								case "?%":
									if (isset($_GET[$key]) && strlen($_GET[$key]))
										$query[] = " `$key` LIKE '{$_GET[$key]}%'";
								break;

								case "%?":
									if (isset($_GET[$key]) && strlen($_GET[$key]))
										$query[] = " `$key` LIKE '%{$_GET[$key]}'";
								break;

								case "range":
									$start = "";
									$end = "";

									if ($_GET[$key . "_start"]) 
										$start = $_GET[$key . "_start"];
									if ($_GET[$key . "_end"])
										$end = $_GET[$key . "_end"];

									if ($start && $end)
										$query[] = " ((`$key` <= '$end') AND (`$key` >= '$start')) ";
									else
										if ($start)
											$query[] = " `$key` >= '$start' ";
										else if ($end)
												$query[] = " `$key` <= '$end' ";									
								break;

								case "in_set":
									if ($_GET["$key"]) {
										$query[] = " FIND_IN_SET('" . $_GET[$key] . "' , `{$key}`) ";
									}																		
								break;

								case "in":
									if (strlen($_GET[$key])) {
										$__tmp = implode("','" , explode("," , $_GET[$key]));								
										$query[] = " `{$key}` IN ( '{$__tmp}' ) ";
									}									
								break;
							}						
							
							//prepare the fields allowed for sorting
							$__fields[] = $key;
						}						

						//add the final condition to list
						if (is_array($query)) {
							
							
							if (count($query) > 1) {
								$this->forms["forms"]["list"]["sql"]["vars"]["condition"]["import"] = implode(" " . (array_exists($_GET["relation"] , array("and" , "or")) ? $_GET["relation"] : "and") . " " , $query);
							} else
								$this->forms["forms"]["list"]["sql"]["vars"]["condition"]["import"] = $query[0];
							
							if (!$this->forms["forms"]["list"]["sql"]["vars"]["req_condition"]["import"]) 
								$this->forms["forms"]["list"]["sql"]["vars"]["condition"]["import"] = " WHERE " . $this->forms["forms"]["list"]["sql"]["vars"]["condition"]["import"];
							else
								$this->forms["forms"]["list"]["sql"]["vars"]["condition"]["import"] = $this->forms["forms"]["list"]["sql"]["vars"]["req_condition"]["import"] . " AND " . $this->forms["forms"]["list"]["sql"]["vars"]["condition"]["import"];


							$found_search = true;
							
						} else {							
							if ($this->forms["forms"]["list"]["sql"]["vars"]["req_condition"]) 
								$this->forms["forms"]["list"]["sql"]["vars"]["condition"] = $this->forms["forms"]["list"]["sql"]["vars"]["req_condition"]; 
						}
						
					}

					//add the order field to the sql field
					if ($_GET["order"] && array_key_exists($_GET["order"] , $search_type["sql_fields"]))
						$this->forms["forms"]["list"]["sql"]["vars"]["order"]["import"] = $_GET["order"];
					
					//add the ordering mode to the sql vars
					if ($_GET["order_mode"] && array_exists($_GET["order_mode"] , array("ASC" , "DESC" )))
						$this->forms["forms"]["list"]["sql"]["vars"]["order_mode"]["import"] = $_GET["order_mode"];					

					//prepare the items number
					if ((int)$_GET["items"])
						$this->forms["forms"]["list"]["items"] = $this->forms["forms"]["list"]["sql"]["vars"]["items"]["import"] = (int)$_GET["items"];
					else
						$this->forms["forms"]["list"]["sql"]["vars"]["items"]["import"] = $this->forms["forms"]["list"]["items"];					
				
				}
				
			} else {
				//required condition
				$this->forms["forms"]["list"]["sql"]["vars"]["condition"] = $this->forms["forms"]["list"]["sql"]["vars"]["req_condition"]; 
			}
		}

		if ($found_search || ($_GET["search"])) {

			if (is_array($this->functions["list"]["pre"]))
				call_user_func($this->functions["list"]["pre"], &$items , &$items_count);


			$_GET["page"] = $_GET["page"] ? $_GET["page"] : 1;
			//auto index the element
			$start = $this->forms["forms"]["list"]["items"] * ($_GET["page"] - 1 );

			if (is_array($items)) {
				foreach ($items as $key => $val) {
					$items[$key]["_count"] = ++$start;
				}			
			}		


			//check if is a normal request or an ajax request
			if ($return_ajax) {
				return $this->form->AjaxList($this->forms["forms"]["list"] , $items , $count , $this->extra["list"] , $page);
			} else {			
				//$data = new CForm($this->templates["generic_form"], &$this->db , &$this->tables);
				$return = $this->form->SimpleList($this->forms["forms"]["list"] , $items , $count , $this->extra["list"]);
			}

		}

		//at this stage remove the unused sections
		unset($search["search"]);

//		debug($this->templates["generic_form"],1);

		if (is_array($search) && ($_GET["hidesearch"] != "true")) {			
			$search_form = new CForm($this->templates["generic_form"], &$this->db , &$this->tables);
			return $search_form->Show($search , array("values"=>$_GET) , array("after" => $return));
		} else
			return $return;
		
	}

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function SetFunction( $form , $event , $function) {
		$this->functions[$form][$event] = $function;
	}
	

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function ListProcess($pre = "" , $after = "" ) {

		$this->functions["list"]["pre"] = $pre;
		$this->functions["list"]["after"] = $after;
	}

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function StoreRecord($redirect = true) {
		global $base, $_CONF;


		//validating the input data
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			//doing a autodetect for storing type , edit or add
			//if $_GET["type"]	is set is simple, else detecting after the id form
			if (!isset($_GET["type"])) {
				if ($_POST[$this->forms["table_uid"]])
					$_GET["type"] = "edit";
				else
					$_GET["type"] = "add";
			}	

			//if validation succeeds then i move the files from /tmp to their directory, else i will proceed to add
			//precheck for uploaded files, like temporary images, etc.
			$form = $this->forms["forms"][$_GET["type"]];

			if (is_array($form["fields"])) {

				$_POST = CForm::ProcessVariables($form , $_POST);
				foreach ($form["fields"] as $key => $val) {
					//update the name value
					if (!$val["name"])
						$val["name"] = $key;
				
					switch ($val["type"]) {


						case "checkbox":
							if ($this->_set_store_nochecks != true) {
								if (!isset($_POST[$key])) {
									$_POST[$key] = "0";
								}
							}							
						break;

						case "upload":
							$file = true;
						case "image":
							unset($_POST[$key]);

							CForm::__private_uploads_pre($val , &$_fields);
							
						break;
					}							
				}						
			}

			//force for no validation sometimes
			if ($_GET["FORMvalidate"] == "false")
				$fields = "";
			else
				$fields = $this->form->Validate($this->forms["forms"][$_GET["type"]] , $_POST);
				
			if (!is_array($fields)) {
				//adding to database

				if ($this->functions["onstore_prepare"])
					call_user_func($this->functions["onstore_prepare"] , $_POST );

				//check if its an isert
				if ($_POST[$this->forms["table_uid"]] && is_array($this->db->QFetchArray("SELECT * FROM " . $this->tables[$this->forms["table"]] . " WHERE {$this->forms[table_uid]}='" . $_POST[$this->forms["table_uid"]] . "'"))) {
					$this->db->QueryUpdate($this->tables[$this->forms["table"]] , $_POST , "`" . $this->forms["table_uid"] . "`='" . $_POST[$this->forms["table_uid"]] . "'" );

					$id = $_POST[$this->forms["table_uid"]];
					$was_added = false;
				} else { 

					$id = $this->db->QueryInsert($this->tables[$this->forms["table"]] , $_POST);
					$_POST[$this->forms["table_uid"]] = $id;
					$was_added = true;

					
					//if i have an ordering function then auto generate the id
					if (is_array($this->forms["forms"]["list"]["order"])) {

						$ofield = $this->forms["forms"]["list"]["order"]["field"];

						$this->db->Query(
							"UPDATE {$this->tables[$this->forms['table']]} SET {$ofield}={$id} WHERE {$this->forms[table_uid]}={$id}"
						);

						//remove the order field

						unset($_POST[$ofield]);

					}
					
				}				

				//data stored, taking care of uploade files/images, etc
				if (is_array($form["fields"])) {
					foreach ($form["fields"] as $key => $val) {

						//update the name value
						if (!$val["name"])
							$val["name"] = $key;

						switch ($val["type"]) {
							case "upload":
							case "image":
								//checking if is really e file, else if no tmp is set then it can be the folder where are stored the values
								if (CForm::__private_uploads_after($val)) {
									$_POST[$key] = 1;
									$this->db->QueryUpdate($this->tables[$this->forms["table"]] , $_POST , "`" . $this->forms["table_uid"] . "`='" . $_POST[$this->forms["table_uid"]] . "'" );
								}
							break;

							default:
								if (is_array($val["file"]))
									SaveFileContents($_CONF["path"] . $_CONF["upload"] . $val["file"]["path"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"] , stripslashes($_POST[$key]));
							break;

						}
					}
				}

				if (!$_GET["type"]) {
					$_GET["type"] = $_POST[$this->forms["table_uid"]] ? "edit" : "add";
				}

				if ($this->functions["onstore"])
					call_user_func($this->functions["onstore"] , $_POST , $_GET["type"]);


				$this->templates["generic_form"]->blocks["Temp"]->input = $this->forms["forms"][$_GET["type"]]["redirect"];
				//replacing the values
				//die($this->templates["generic_form"]->blocks["Temp"]->Replace($_POST));

				//do this before anything
				if ($_POST["_after_save"]) {
					$_POST["after_save"] = $_POST["_after_save"];
				}				
				
				if ($_POST["after_save"]) {
					$vars = $this->form->GlobalVars($this->forms["forms"]["add"] , array_merge($_GET , $_POST)); 
					//the user wants to add another record after he adds the current one, so lets help him do it easy

					$location = new CTemplate($vars["self.uri.add"] . "&after_save={$_POST[after_save]}&returnurl=" . $_POST["returnurl"] , "string");
					UrlRedirect($location->Replace(array_merge($_GET , $_POST)));
				}
				

				if ($_GET["returnURL"]) {
					header("Location:" . urldecode($_GET["returnURL"]));
					exit;
				}

				if ($_POST["returnurl"]) {

					switch ($_GET["storeredirect"]) {

						case "STOREDETAILS":
							header("Location:" . basename($_SERVER["SCRIPT_NAME"]) . "?mod={$_GET[mod]}&sub={$_GET[sub]}&action={$this->forms[uridata][details]}&{$this->forms[table_uid]}={$_POST[$this->forms[table_uid]]}&returnurl={$_POST[returnurl]}");
							exit;
						break;

						case "ADDDETAILS":

							//if is a new adition the redirect to details
							if ($was_added) {
								header("Location:" . basename($_SERVER["SCRIPT_NAME"]) . "?mod={$_GET[mod]}&sub={$_GET[sub]}&module_id={$_GET[module_id]}&action={$this->forms[uridata][details]}&{$this->forms[table_uid]}={$_POST[$this->forms[table_uid]]}&returnurl={$_POST[returnurl]}");
								exit;
							} 
							//else co in next case
							
						default:
							$count = 1;
							while ($count < 10 ) {
								$_POST["returnurl"] = urldecode($_POST["returnurl"]);
								if (substr($_POST["returnurl"],0,1) == "/")
									break;

								$count ++;
							}

							$this->templates["generic_form"]->blocks["Temp"]->input = $_POST["returnurl"];					
							header("Location:" . $this->templates["generic_form"]->blocks["Temp"]->Replace(array_merge($_GET,$_POST)));
							exit;
						break;

					}
				
				}
				
				if ($redirect == true) {
					header("Location: " . CryptLink($this->templates["generic_form"]->blocks["Temp"]->Replace(array_merge($_GET,$_POST))));
					exit;
				} else {
					return true;
				}
			}
								
		} else {
			die("ARGH!!!");
			//redirecting to list page
			header("Location:" . str_replace("&action=store" , "" , $_SERVER["REQUEST_URI"]));
			exit;
		}				

		
		if (is_array($_fields["values"]))
			// read the default record, and merge the fields
			$fields["values"] = array_merge($fields["values"], $_fields["values"]);			

		if ($_POST[$this->forms["table_uid"]]) {			
			$data = $this->db->QFetchArray("SELECT * FROM `" . $this->tables[$this->forms["table"]] . "` WHERE `" . $this->forms["table_uid"] . "`='" . $_POST[$this->forms["table_uid"]] . "'" );
			
			$fields["values"] = array_merge($data , $fields["values"]);
	//		debug($fields);
		}			

		
		return $this->form->Show($this->forms["forms"][$_GET["type"]] , $fields , $this->extra[$_GET["type"]]);				
	}
	
	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function RestoreURI($section) {
		if (is_array($_GET)) {
			foreach ($_GET as $key => $val) {
				$out[$key] = $key . "=" . $val;
			}
						
			$out[$this->forms["uridata"]["action"]] = $this->forms["uridata"]["action"] . "=" . $this->forms["uridata"][$section];
			unset($out[$this->forms["table_uid"]]);

			return CryptLink($_SERVER["SCRIPT_NAME"] . "?" . implode("&" , $out));

			//return $_
		}		
	}
	

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function DoEvents($section = ""  , $extra = "" , $values = "") {
		global $base , $_CONF;

		if (is_array($extra)) {
			$this->extra = array_merge($this->extra , $extra);
		}

		switch ($_GET[$this->forms["uridata"]["action"]]) {

			case $this->forms["uridata"]["delete"]:

				if (($_GET["rconfirm"] == "true")&&($_GET["confirmed"] != "true")) {
					return $this->templates["generic_form"]->blocks["DeleteItem"]->Replace(array(
									"title" => $_GET["title"] ? urldecode($_GET["title"]) : "Delete Item",
									"description" => $_GET["description"] ? urldecode($_GET["description"]) : "Are you sure you want to delete this record?",
									"return" => urldecode($_GET["returnURL"]),
									"cancel_location" => urldecode($_GET["returnURL"]),
									"delete_location" => $_SERVER["REQUEST_URI"] . "&confirmed=true"
								));
				}

				if ($_SERVER["REQUEST_METHOD"] == "POST") {

					if (is_array($_POST[$this->forms["table_uid"]])) {
						foreach ($_POST[$this->forms["table_uid"]] as $key => $val) {
							$this->db->Query("DELETE FROM `" . $this->tables[$this->forms["table"]] . "` WHERE `" . $this->forms["table_uid"] . "`='" . $val . "'" );
						}						
					}


					if ($_GET["returnURL"]) {
						header("Location: " . CryptLink(urldecode($_GET["returnurl"])));
						exit;
					} else {
						header("Location:" . $_SERVER["HTTP_REFERER"]/*$this->RestoreURI("list")*/);
						exit;
					}

				} else {
				
					//searching for element
					$data = $this->db->QFetchArray("SELECT * FROM `" . $this->tables[$this->forms["table"]] . "` WHERE `" . $this->forms["table_uid"] . "`='" . $_GET[$this->forms["table_uid"]] . "'" );

					//checking if this is a valid data
					if (is_array($data)) {
						$this->db->Query("DELETE FROM `" . $this->tables[$this->forms["table"]] . "` WHERE `" . $this->forms["table_uid"] . "`='" . $_GET[$this->forms["table_uid"]] . "'" );

						if ($this->functions["ondelete"])
							call_user_func($this->functions["ondelete"] , $data);

					}


				
					if ($_GET["returnURL"]) {
						header("Location: " . CryptLink(urldecode($_GET["returnURL"])));
						exit;
					} else {
						header("Location:" . $_SERVER["HTTP_REFERER"]/*$this->RestoreURI("list")*/);
						exit;
					}
				}
				
			break;

			case $this->forms["uridata"]["store"]:
				return $this->StoreRecord();
			break;

			case $this->forms["uridata"]["add"]:
				$fields["values"] = $values["add"];
				return $this->form->Show($this->forms["forms"]["add"] , $fields , $this->extra["add"]);
			break;

			case $this->forms["uridata"]["edit"]:
				//searching for element
				$data = $values["edit"] ? $values["edit"] : $this->db->QFetchArray("SELECT * FROM `" . $this->tables[$this->forms["table"]] . "` WHERE `" . $this->forms["table_uid"] . "`='" . $_GET[$this->forms["table_uid"]] . "'" );

				if ($this->functions["onedit"])
					call_user_func($this->functions["onedit"] , &$data);


				//checking if this is a valid data
				if (is_array($data)) {
					$fields["values"] = $data;
					return $this->form->Show($this->forms["forms"]["edit"] , $fields , $this->extra["edit"]);
				} 

				header("Location:" . $this->RestoreURI("list"));
				exit;
				
			break;

			case $this->forms["uridata"]["details"]:

				//searching for element
				$data = $values["details"] ? $values["details"] : $this->db->QFetchArray("SELECT * FROM `" . $this->tables[$this->forms["table"]] . "` WHERE `" . $this->forms["table_uid"] . "`='" . $_GET[$this->forms["table_uid"]] . "'" );

				if ($this->functions["ondetails"])
					call_user_func($this->functions["ondetails"] , &$data);

				//checking if this is a valid data
				if (is_array($data)) {
					$fields["values"] = $data;
					return $this->form->Show($this->forms["forms"]["details"] , $fields, $this->extra["details"]);
				} 

				header("Location:" . $this->RestoreURI("list"));
				exit;
				
			break;

			case "ajax.reorder-records":

				if ($this->forms["forms"]["list"]["order"]) {
					//this can be time consuming
					set_time_limit(0);

					//shit
					if ($_POST["table_order"] && is_array($this->forms["forms"]["list"]["order"])) {

						//debug($_GET,1);

						$order = $this->forms["forms"]["list"]["order"];

						//read the items
						$items = $this->db->QFetchRowArray("SELECT {$this->forms[table_uid]} as id, {$order[field]} as oid FROM `" . $this->tables[$this->forms["table"]] . "` WHERE {$this->forms[table_uid]} in (" . implode("," , $_POST["table_order"]) . ") ORDER BY {$order[field]} {$order[mode]}" );

						if (is_array($items) && (count($items) == count($_POST["table_order"]))) {

							//invert the key with vars from new order
							foreach ($_POST["table_order"] as $key => $val) {
								$new_order[$val] = $key;
							}
							

							foreach ($items as $key => $val) {
								$items[$key]["noid"] = $items[$new_order[$val["id"]]]["oid"];
							}
							
							foreach ($items as $key => $val) {
								$this->db->QueryUpdate(
									$this->tables[$this->forms["table"]],
									array(
										$order["field"]	=> $val["noid"]
									),
									"{$this->forms[table_uid]} = {$val[id]}"
								);
							}
							
							die("1");
						}
					}

					die("0");
				}

				die("0");
							
			break;

			case $this->forms["uridata"]["search"]:
			case $this->forms["uridata"]["list"]:
			default:		

				if ($_GET["ajax"] == "true") {
					echo $this->FormList($values["list"] , true , $_GET["page"]);
					die();
				} else {				
					return $this->FormList($values["list"]);
				}
			break;

		}	
	}
}

/*

History

v0.0.4
	Unreleased
		Fixed the saving the value in a file, added stripslashes

v0.0.3
	Wensday 24 March 2004
		Moved SimpleList from sqladmin in forms class
		Added image element to SimpleList
		Added date element to SimpleList	
		Instead of $form array the data can be a path to an xml file
		The template is passed to sql admin, no longer loading from generic_form

v0.0.2
	Tuesday 16 March 2004
		Fixed, add/edit SQL query.

	Sunday 14 March 2004
		Added search support for list section.
		Added header titles to list section.
		Fixed the buttons apearance in list. ( they dont apear broken anymore )
		Added upload/resize/efects image form to forms library, FUCK loosing the image if the forms isnt complety
		validated from first time.
		Added html editor to forms library.		
		Fixed the image loosing when the form wasnt validated.
		Added the download from web image.

v0.0.1
	Wensday 3 March 2004 
		First version with basic options, edit, list, add.

*/
?>