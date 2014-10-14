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
class COXYMallModules extends CPlugin{
	
	var $tplvars; 

	function COXYMallModules() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if ($_GET["sub"] == "oxymall.plugin.main.xml") {
			return $this->MainXml();
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
			"menu"					=> "menu.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}

		$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("newsletters");
	} 


	function GetFirstModuleByCode() {

		//read the small 
		$_module = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['core:user_modules']} " . 
			"WHERE mod_parent=0 " . 
			"ORDER BY mod_order ASC LIMIT 1"
		);

		if (is_array($_module)) {
		}
		

		return $_module;
	}



	function TopMenu() {		
		global $base , $_NO_HTACCESS , $_SESS;

		//$_GET["module_id"] = "34";

		$this->__init();

		if ($_SESS["client"]["user_id"]) {
			$cond = " ";
		} else {
			$cond = " AND mod_protected=0 ";
		}


		$modules = $this->db->QFetchRowArray(
			"SELECT * FROM " . 
				$this->tables['core:modules'] . ", " . 
				$this->tables['core:user_modules'] . " " . 
			"WHERE mod_module=module_id AND mod_status=1 {$cond}" .
			"ORDER BY mod_parent ASC,mod_order ASC"
		);

		if (is_array($modules)) {
			foreach ($modules as $key => $val) {

				if ($val["module_code"] == "external-link") {

					$set = unserialize($val["mod_settings"]);
					$val["link"] = $set["set_link"];
					$val["target"] = $this->module->plugins["common"]->LinkTarget($set["set_target"]);

				} else {

					$val["link"] = $this->ModuleLink($val);
					$val["target"] = "";

				}				

			
				if ($val["mod_invisible"]) {

				} else {
			
					if ($val["mod_parent"]) {

						if ($val["mod_id"] == $_GET["module_id"]) {
							$_modules[$val["mod_parent"]]["selected"] = $val["selected"] = $this->private->templates["menu"]->blockReplace("Selected" , array());
						}

						
						//id i font have a parent then i have a protected category 
						if ($_modules[$val["mod_parent"]]) {
							$_modules[$val["mod_parent"]]["sub"][] = $val;
						}
						

						
					} else {

						if ($val["mod_id"] == $_GET["module_id"]) {
							$val["selected"] = $this->private->templates["menu"]->blockReplace("Selected" , array());
						} 

						$_modules[$val["mod_id"]] = $val;
					}				

				}
			}			
		}

		if (is_array($_modules)) {
			foreach ($_modules as $key => $val) {
				if ($val["sub"]) {

					$val["subitems"] = $base->html->table(
						$this->private->templates["menu"],
						"SubMenu" , 
						$val["sub"]
					);
				} else 
					$_modules[$key]["subitems"] = "";
				
				$_modules[$key]["title"] = $this->private->templates["menu"]->blockReplace(
					$val["sub"] ? "NoLink" : "Link",
					$val
				);
			}			
		}
		

		

		return CTemplateStatic::Replace(
			$base->html->table(
				$this->private->templates["menu"],
				"Menu",
				$_modules
			),
			array(
				"selected" => ""
			)
		);

		die();
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
	function ModuleLink($module) {

		return $this->PrepareLink($module["mod_url"] . "/") ;
	}
	
	
	function LoadModuleInfo() {

		//read the small 
		$module = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['core:modules']} , {$this->tables['core:user_modules']} " . 
			"WHERE module_id=mod_module AND mod_id=\"{$_GET[module_id]}\""
		);

		if (is_array($module)) {
			$module["settings"] = (array) unserialize($module["mod_settings"]);
			$module["default"] = unserialize($module["module_settings"]);
		}

		if (is_Array($module["settings"])) {
			foreach ($module["settings"] as $key => $val) {
				$module["settings"][$key] = stripslashes($val);
			}
			
		}
		

		$this->module->EncodeItems(
			&$modules , 
			array(					
				"mod_module_code" , 
				"mod_name",
				"mod_long_name" , 
				"mod_urltitle" ,
				"mod_url" 
			)
		);


		return $module;
	}

	function LoadDefaultModule($mod) {

		//read the small 
		$module = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['core:modules']} " . 
			"WHERE module_code='{$mod}'"
		);


		if (is_array($module)) {
			$module["settings"] = unserialize($module["module_settings"]);
		}

		return $module;
	}



	function GetFirstModule() {

		//read the small 
		$_module = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['core:user_modules']} " . 
			"WHERE mod_parent=0 AND mod_module_code!='category' AND mod_invisible=0 AND mod_status=1 " . 
			"ORDER BY mod_order ASC LIMIT 1"
		);


		if (is_array($_module)) {
			$_module["settings"] = unserialize($_module["settings"]);
		}

		return $_module;
	}

	function GetModuleByCode($module) {

		//read the small 
		$_module = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['core:user_modules']} " . 
			"WHERE mod_url='{$module}'"
		);

		return $_module;
	}

	function GetModuleByID($module) {

		//read the small 
		$_module = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['core:user_modules']} " . 
			"WHERE mod_id='{$module}'"
		);

		return $_module;
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
	function GetIdFromLink($link) {
		$tmp = explode("-" , $link);

		return trim($tmp[count($tmp)-1]);
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
	function SetSeo($item) {
		global $_TSM;

		if ($item["seo_title"] && !$_TSM["PUB:SEO_TITLE"])
			$_TSM["PUB:SEO_TITLE"] = $item["seo_title"];

		if ($item["seo_desc"] && !$_TSM["PUB:SEO_DESC"])
			$_TSM["PUB:SEO_DESC"] = $item["seo_desc"];

		if ($item["seo_keys"] && !$_TSM["PUB:SEO_KEYS"])
			$_TSM["PUB:SEO_KEYS"] = $item["seo_keys"];
		
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
	function RedirectToModule($id , $link = false) {

		//read the small 
		$module = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['core:modules']} , {$this->tables['core:user_modules']} " . 
			"WHERE module_id=mod_module AND mod_id=\"{$id}\""
		);

		if (is_array($module)) {
			$module["settings"] = (array) unserialize($module["mod_settings"]);
			$module["default"] = unserialize($module["module_settings"]);
		}


		global $_CONF;

		//check the url based on module type

		if ($link) {
			return $this->PrepareLink($module["mod_url"] . "/");
		}
		
		urlredirect($this->PrepareLink($module["mod_url"] . "/"));
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
	function PrepareLink($link) {
		global $_CONF;

		//check if the link needs index.php ..

		if (!$this->vars->data["set_links_type"]) {
			return $_CONF["url"] . "index.php/" . $link;
		} else 	{
			return $_CONF["url"] . $link;
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

	
	function Redirect404() {
		global $_CONF;

		$module = $this->GetModuleById($this->vars->data["set_404"]);
		header("HTTP/1.1 404 Not Found");
		header("Location: " . $this->PrepareLink($module["mod_url"] . "/"));
		exit();
	}

	
}

?>