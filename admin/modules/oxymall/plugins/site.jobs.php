<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies

/**
* description
*
* @library	
* @author	
* @since	
*/
class COXYMallJobs extends CPlugin{
	
	var $tplvars; 

	function COXYMallJobs() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.jobs.")) {
			$sub = str_replace("oxymall.plugin.jobs." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

			switch ($sub) {
				case "landing":					
					return $this->Listing();
				break;

				case "item":
					return $this->Details();
				break;

				case "ajax.send":
					return $this->AjaxSend();
				break;

				case "download":
					return $this->DownloadResume();
				break;
			}
			

		}

	}


	function __init() {
		global $_CONF;

		if ($this->__inited) {
			return "";
		}

		$this->__inited = true;
		
		$path = $this->tpl_path;

		$templates = array(
			"landing"	=> "landing.htm",
			"details"	=> "details.htm",
			"fields"	=> "fields.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
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
	function Listing() {
		global $base , $_CONF;	

		$cats = $this->GetCategories();

		//if no category, nothign to show
		if (!is_array($cats)) {
			return "";
		}
		

		//detect the first cat
		if (!$_GET["cat"]) {
			$cat = $cats[0];
			$_GET["cat"] = $cat["cat_url"];
		} else {
			foreach ($cats as $key => $val) {
				if ($val["cat_url"] == $_GET["cat"]) {
					$cat = $val;
				}				
			}			
		}

		$cats = $this->ProcessCats($cats);
		$items = $this->GetRecords($cat);

		//process the seo 
		$this->module->plugins["modules"]->SetSeo($cat);
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		
		return CTemplateStatic::Replace(
			CTemplateStatic::Replace(
				$this->private->templates["landing"]->BlockReplace(
					"Main",
					array(

						"categories"	=> $this->module->plugins["common"]->Categories(
							$this->ProcessCats($cats),
							$_GET["cat"],
							$this->tpl_module["settings"]["set_categories_type"]
						),

						"items"	=> $base->html->Table(
							$this->private->templates["landing"],
							"",	
							$items["records"]
						),

						"paging"=> $this->module->plugins["paging"]->Paging(
							$items["pages"] , 
							$items["page"], 
							array(
								"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{$cat[cat_url]}/" ),
								"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{$cat[cat_url]}/{PAGE}/") ,
							),

							array(
								"ipp"	=> $items["ipp"],
								"total"	=> $items["count"]
							)
						),

						"header"	=> $cat["cat_description"] ? $this->private->templates["landing"]->blockReplace(
							"Header",
							$cat
						) : "",

					)
				),
				$cat				
			),
			$this->tpl_module["settings"]
		);
	}


	function ProcessCats($cats) {

		if (is_Array($cats)) {

			//if i have just one category do not show a thing
			if (count($cats) == 1) {
				return "";
			}

			foreach ($cats as $key => $val) {
				$cats[$key]["link"]	= $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $val["cat_url"] . "/");
			}			

			return $cats;
			
		}
	
	}
	

	function GetCategories() {
		$cats = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:jobs_cats']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY cat_order"
		);

		return $cats;
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
	function Details() {
		global $_CONF , $base;

		$item = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:jobs_items']},{$this->tables['plugin:jobs_cats']} WHERE item_cat=cat_id AND item_id={$_GET[item]}"
		);


		if (!is_array($item)) {
			$this->module->plugins["common"]->Redirect404();
		}


		//add the comments
		$item["comments"]	= $this->module->plugins["comments"]->Comments(
			$this->tpl_module["mod_url"] . "/{$item[cat_url]}/{$item[item_url]}/{$item[item_id]}",
			$this->tpl_module["settings"]["set_fbcomments"] 
		);

		$this->module->plugins["modules"]->SetSeo($item);
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);


		//parepare the fields
		$item["apply"]	= $this->applyForm($item);

		$item["back"] = $this->module->plugins["modules"]->PrepareLink(
			$this->tpl_module["mod_url"] . "/" . $item["cat_url"] . "/"
		);

		$return = $this->private->templates["details"]->blockReplace(
			"Details" , 
			$item
		);

		return CTemplateStatic::Replace(
			$return ,
			$this->tpl_module["settings"]
		);
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
	function ApplyForm($item) {
		global $base; 

		$this->__init();

		//prepare the fields
		$fields = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:jobs_fields']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
		);


		$this->tpl_module["settings"]["set_post_comment"] = nl2br($this->tpl_module["settings"]["set_post_comment"]);

		if (is_array($fields)) {
			$cnt = 0;
			foreach ($fields as $key => $val) {

				if ($val["item_type"] == "userdroplist") {
					$tmp = @explode("\n" , $val["item_options"]);
					foreach ($tmp as $k => $v) {
						if (trim($v)) {
							$val["options"] .= "<option>" . trim($v) . "</option>";
						}
					}
				}

				if ($val["item_size"] == "small") {

					if ($cnt == 1) {
						$val["class"] = " ";
					} else {
						$val["class"] = "clear pr12 ";
					}

					$cnt = !$cnt;


				
				} else {

					$cnt = 0;
					$val["class"] = "clear";

				}
								

				//size
				$val["size"] = $this->private->templates["fields"]->blockReplace(
					$val["item_size"] == "small" ? "smallsize" : "bigsize",
					array()
				);

				$val["field"] = $this->private->templates["fields"]->blockreplace(
					$val["item_type"], 
					$val
				);
			


				$fields[$key]["content"] = $this->private->templates["fields"]->blockReplace(
					$val["item_size"] == "small" ? "Small" : "Big",
					$val
				);
				
			}
		}

		return CTemplateStatic::Replace(
			$this->private->templates["fields"]->blockReplace(
				"Main" , 
				array(
					"fields"	=> $base->html->table(
						$this->private->templates["fields"],
						"",
						$fields
					),

					"upload"	=> $this->private->templates["fields"]->blockReplace(						
						"Upload",
						array()					
					),

					"item_id"	=> $item["item_id"],
				)
			),
			$this->tpl_module["settings"]
		);

	}
	
	

	function GetRecords($cat) {
		
		$count = $this->tpl_module["settings"]["set_items"];
		$page = $_GET["page"];

		$item_count = $this->db->RowCount(
			$this->tables['plugin:jobs_items'],
			"WHERE module_id={$this->tpl_module[mod_id]} AND item_cat={$cat[cat_id]} "
		);

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:jobs_items']} " . 
			"WHERE module_id={$this->tpl_module[mod_id]}  AND item_cat={$cat[cat_id]} " .
			"ORDER BY  item_order ASC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_Array($items)) {
			foreach ($items as $key => $val) {

				$val["item_small_description"] = nl2br($val["item_small_description"]);

				$items[$key]["brief"] = $val["item_small_description"] ? $this->private->templates["landing"]->blockReplace(
					"Brief",
					$val
				) : "";

				$items[$key]["item_date"] = date($this->tpl_module["settings"]["set_date_format"] , $val["item_date"]);

				$items[$key]["link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{$cat[cat_url]}/" . $val["item_url"] . "/" . $val["item_id"] . "/");

			}			
		}

		return array(
			"records"	=> $items, 
			"count"		=> $item_count , 
			"pages"		=> $item_count ? ceil($item_count / $count) : 1,
			"page"		=> $page,

			"ipp"		=> $count,
		);

	}



	function AjaxSend() {
		global $_CONF , $_SESS;

		if (!is_array($job = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:jobs_items']} WHERE item_id='{$_POST[job]}'"))) {
			return $this->module->plugins["common"]->ErrorMSG(
				"Invalid Job"
			);
		}

		$_GET["module_id"] = $job["module_id"];

		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

		$fields = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:jobs_fields']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
		);

		if (is_array($fields)) {
			foreach ($fields as $key => $val) {
				if ($val["item_required"] && !$_POST[$val["item_field"]]) {
					return $this->module->plugins["common"]->ErrorMSG(
						$val["item_error_msg"]
					);
				}
			}			
		}

		if ($_POST["image_code"] != $_SESS["XML_verify_key"]) {
			return $this->module->plugins["common"]->ErrorMSG(
				$this->tpl_module["settings"]["set_verificationcodeerror"]
			);
		}


		//save the email to database
		$id = $this->db->QueryInsert(
			$this->tables["plugin:jobs_resumes"],
			$resume = array(
				"resume_date"	=> time(),
				"resume_job"	=> $job["item_id"],
				"module_id"		=> $job["module_id"],

				"resume_mail"	=> $_POST["email"],
				"resume_first_name"	=> $_POST["first_name"],
				"resume_last_name"	=> $_POST["last_name"],
				"resume_phone"	=> $_POST["phone"],

				"resume_note"	=> CTemplateStatic::Replace(
					$this->tpl_module["settings"]["set_email_message"],
					$_POST
				),


				"resume_cv"		=> $_POST["files"] != "" ? 1 : 0,
				"resume_cv_file"=> $_POST["files"],
				"resume_code"	=> md5(microtime_float()),

			)
		);

		$vars = $_POST;

		//process the image if needed
		if ($_POST["files"]) {
			//process the file

			if (file_exists("upload/userfiles/" . $_POST["files"])) {
				rename("upload/userfiles/" . $_POST["files"] , "upload/resumes/{$id}.file");

				chmod("upload/resumes/{$id}.file" , 0777);
			}

			$vars["attachment_link"] = $_CONF["url"]. "resume-download.php?file=" . $resume["resume_code"]; 
		} else 
			$vars["attachment_link"] = "";



		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_admin"],
				array_merge(
					$vars,
					$job
				)
			)
		);			

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_client"],
				array_merge(
					$vars,
					$job
				)
			)
		);			

		return $this->module->plugins["common"]->SuccessMSG(
			$this->tpl_module["settings"]["set_text_success"]
		);
		
	}

	function DownloadResume() {
		if (is_array($file = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:jobs_resumes']} WHERE resume_code='{$_GET[file]}'"))) {
			$mime = new CMime();
			$mime->set("unknown");
			$mime->FileName($file["resume_cv_file"]);

			readfile("upload/resumes/{$file[resume_id]}.file");
			die();
		}

		else die("Invalid request!	");
		
	}


	function GetAllLinks($module , $links) {
	

	}

}

?>