<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: module.php,v 0.0.1 18/11/2005 13:11:00 author Exp $
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
class CModule {
	
	var $tplvars; 
	var $templates; 
	var $tables; 
	var $vars; 
	var $db; 
	var $messages; 
	var $admin;  


	function CModule($name) {
		$this->name = $name;

		//here we must initialize the module		

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
	function __init() {
		
		//build the path to the module
		$this->path = _MODPATH . $this->name . "/" ;
		$_CONF["forms"]["adminpath"] = _MODPATH . $_MOD . "/forms/";

		//read the module config if any exists
		if (file_exists( $this->path . "/" . "module.xml")) {
			$this->config = new CConfig($this->path . "module.xml");
			$this->_CONF = $this->config->vars["module"];

			if ($this->admin)
				$this->config->vars["module"]["templates"] = is_array($this->config->vars["module"]["admin"]["templates"]) ? $this->config->vars["module"]["admin"]["templates"] : $this->config->vars["module"]["templates"];
			else
				$this->config->vars["module"]["templates"] = is_array($this->config->vars["module"]["site"]["templates"]) ? $this->config->vars["module"]["site"]["templates"] : $this->config->vars["module"]["templates"];
			

			//load the specific files
			if (is_array($this->config->vars["module"]["templates"])) {

				if ($perm = strtolower($this->config->vars["module"]["templates"]["perm"])) {
					unset($this->config->vars["module"]["templates"]["perm"]);
				}
				

				foreach ($this->config->vars["module"]["templates"] as $key => $val) {
					if (($key != "path") && ($key != "perm")) {
						$template = isset($this->config->vars["module"]["templates"]["path"]) ? $this->config->vars["module"]["templates"]["path"] . $val : $this->path . "/templates/" . $val ;

						//detect if i need to load the templates dinamicaly or static
						if ($perm == "false")
							$this->private->templates[$key] = new CTemplateDynamic( $template);
						else 
							$this->private->templates[$key] = new CTemplate( $template);
						
						
					}
					
					//$this->private->templates[$key] = new CTemplate(_MODPATH . $_MOD . "/templates/" . $val );
				}								
			}

			//check if i need to create a new database especialy for this module
			//make a connection to db
			if (is_array($this->config->vars["module"]["database"])) {
				$this->private->db = new CDatabase($this->config->vars["module"]["database"]);
			}

			if ($this->admin)
				$this->private->tables = is_array($this->config->vars["module"]["admin"]["tables"]) ? $this->config->vars["module"]["admin"]["tables"] : $this->config->vars["module"]["tables"];
			else
				$this->private->tables = is_array($this->config->vars["module"]["site"]["tables"]) ? $this->config->vars["module"]["site"]["tables"] : $this->config->vars["module"]["tables"];

			//load the tables
			if (is_array($this->config->vars["module"]["tables"])) {
				$this->private->tables = is_array($this->config->vars["module"]["admin"]["tables"]) ? $this->config->vars["module"]["admin"]["tables"] : $this->config->vars["module"]["tables"];
				
				//do a check for the private vars table if available
				foreach ($this->private->tables as $key => $val) {
					if ($key == "vars")			
						$this->private->vars = new CVars($this->db , $val);
					
					if ($key == "messages") {
						$this->private->messages = new CMessages($this->db , $val);
					}
				}															
			}
		}

		//load the module xml
		if (file_exists( $this->path . "/" . "menu.xml") && $this->admin) {

			$menu = new CConfig ($this->path . "/" . "menu.xml");

			if (is_array($menu->vars["menu"]["level_" . $_SESS["minibase"]["raw"]["user_level"] ] ))
				$menu = $menu->vars["menu"]["level_" . $_SESS["minibase"]["raw"]["user_level"] ];
			else
				$menu = $menu->vars["menu"];

			$this->private->menu = $menu;
		}


		$this->start = true;
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
	function __adminMenu() {
		global $_SESS , $_TSM , $_USER;

		//do a check for the templates  and blocks 
		$__template_blocks = array(
									"Menu" ,
									"MenuGroup",
									"LinksGroup",
									"LinksElement",
									"TitleLink",
									"TitleNoCollapse",
									"Collapse"
								);
		$__template = "menus";

		//check for the main tempalte
		if (!is_object($this->templates["menus"]))
			return false;
	
		//check for the template blocks
		if (is_array($__template_blocks)) {
			foreach ($__template_blocks as $k => $block) {
				if (!is_object($this->templates[$__template]->blocks[$block])) {
					return false;
				}				
			}			
		}
		

		//everithing is okay, proceed to themenu building
		

		if (file_exists( $this->path . "/" . "menu.xml") && $this->admin) {

			$menu = $this->private->menu;

			if (is_array($menu)) {
				$tmp_menu = "";
				foreach ($menu as $key => $val) {
					$_links = "";
					$_links2 = "";

					if ((isset($val["level"]) && $_USER["user_level"] == $val["level"]) || (!isset($val["level"]))) {
					
						if (is_array($val["links"])) {
							foreach ($val["links"] as $k => $v) {
								$_links[] = array(
												"title"	=> is_array($v) ? $v["title"] : ucwords($k),
												"link" => is_array($v) ? $v["link"] : $v
											);
								$_links2[] = array(
												"title"	=> is_array($v) ? $v["title"] : ucwords($k),
												"link" => is_array($v) ? $v["link"] : $v
											);
							}								
						}

						$val["title"] = $val["title"] ? $val["title"] : ucwords ($key);
						$val["id"] = str_replace(" ", "_" , $key);
						
						$sublinks = "";
						if (is_array($_links2)) {
							foreach ($_links2 as $k => $_link) {
								if (is_array($_link["link"])) {
									switch ($_link["link"]["type"]) {
										case "var":
											$sublinks .= $_link["link"]["value"];
										break;
									}										
								} else {
									$sublinks .= is_object($this->templates["menus"]->blocks["LinksElement"]) ? $this->templates["menus"]->blocks["LinksElement"]->Replace($_link) : "";
								}									
							}								
						}

						if ($GLOBALS["_TMP"]["module"]["alternance"]) {
							$GLOBALS["_TMP"]["module"]["alternance"] = 0;
							$alternance = "Alt";
						} else {
							$GLOBALS["_TMP"]["module"]["alternance"] = 1;
							$alternance = "";
						}
						
						
						$tmp_menu .= is_object($this->templates["menus"]->blocks["MenuGroup"]) ? $this->templates["menus"]->blocks["MenuGroup"]->Replace(array(
											"title_data" => $this->templates["menus"]->blocks[$val["link"] ? "TitleLink" : "Title"]->Replace($val) ,
											"data" => $sublinks ? $this->templates["menus"]->blocks["LinksGroup"]->Replace(array("DATA" => $sublinks)) : "",
											"id" => $val["id"],
											"alternance" => $alternance,
											"collapse" =>is_array($_links) ? $this->templates["menus"]->blocks["Collapse"]->Replace($val) : ""
										)) : "";
					}
				}						


				$menus .= $tmp_menu;
				$output = $tmp_menu;
			}										
		} else {
			//do a search for menus
			if (file_exists(_MODPATH . $_MOD . "/" . "menu.htm") && $this->admin) {
				//read the menus
				$tmp_menu = new CTemplate(_MODPATH . $_MOD . "/" . "menu.htm");

				//check if there is made any difference between users levels
				if (is_object($tmp_menu->blocks["MenuLevel" . (int)$_SESS["minibase"]["raw"]["user_level"]]))
					$_menu .= $tmp_menu->blocks["MenuLevel" . (int)$_SESS["minibase"]["raw"]["user_level"]]->output;
				else
					//load a menu block depending the user level
					$_menu .= !count($tmp_menu->blocks) ? $tmp_menu->output : "";

				$menus .= $_menu;
				$output = $_menu;
				
			} else {
				//here will be in future the xml menu
			}
		}

		$_TSM["MINIBASE.MENU." . $this->name] = $output;
		return $output;
	}
	
	

	/**
	* description replaces the final variables int he output and returns the data
	*
	* @param $data string input template to be replaced ( string )
	* @param $vars array optional template variables to be merged with $this->tplvars
	*
	* @return
	*
	* @access
	*/
	function __render($data , $vars = array()) {

		$vars = array_merge($vars , (array)$this->tpl_vars);

		if (is_array($vars )) {
			//inizialize a new template
			$tmp = new CTemplate($data , "string");

			return $tmp->Replace($vars);
		} else 
			return $data;
	}

	/**
	* description loads the messages and the conf in the templates
	*
	* @access private
	*/
	function __loadvars() {

		
		if (is_object($this->private->messages)) {
			$this->tpl_vars = array_merge((array)$this->tplvars , $this->private->messages->LoadVars($this->name));
		}

		//check to see if the config has anything in it
		if (is_array($this->_CONF["conf"])) {
			foreach ($this->_CONF["conf"] as $key => $val)
				$this->tpl_vars["MODULE::" . strtoupper($this->name) . "::CONF." . strtoupper($key)] = $val;
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
	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE;
		$this->__loadvars();
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
	function __protect() {
		if ($this->name != $_GET["mod"]) {
			return false;
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
	function __page($title , $body ) {
		global $_TSM;

		$_TSM["CPAGE::TITLE"] = $title;

		if ($this->templates["page"]) {
			return $this->templates["page"]->Replace(array(
					"CPAGE::TITLE" => $title,
					"CPAGE::BODY" => $body
				));
		} else
			return $body;
		
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
	function __title($title) {
		global $_TSM;
		$_TSM["CPAGE::TITLE"] = $title;
	}
	
	
}

?>