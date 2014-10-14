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
class COXYMall extends CModule{
	
	var $tplvars; 

	function COXYMall() {
		parent::CModule("oxymall");
		
		//get the core part
		$this->path = _MODPATH  . $this->name;
//		$this->coreFiles = CDir::GetFiles($this->path . "/core/",  ".php");
		$this->pluginsFiles = CDir::GetFilesRec($this->path . "/plugins/",  ".php");
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
		parent::__init();

		//load the core and the p[lugins
		//initialize the core and the plugins
		if (is_array($this->coreFiles)) {
			foreach ($this->coreFiles as $key => $val) {
				if (strstr($val , "admin." ) && strstr($val , ".php" )) {
					//read the file
					include_once($val);
					$file = str_replace("admin." , "" , basename($val , ".php"));
					eval('$this->core[' . $file . '] = new COXYMall' . $file . '();');
					$this->core[$file]->db = &$this->db;
					$this->core[$file]->tables = &$this->private->tables;
					$this->core[$file]->__parent_templates = &$this->templates;
					$this->core[$file]->vars = &$this->private->vars;
					$this->core[$file]->tpl_path = _MODPATH . "/" . $this->name . "/core/templates/{$file}/" ;
					$this->core[$file]->forms_path = _MODPATH . "/" . $this->name . "/core/forms/{$file}/" ;
					$this->core[$file]->module = &$this;
				}
			}			
		}


		if (is_array($this->pluginsFiles)) {
			foreach ($this->pluginsFiles as $key => $val) {
				if (strstr($val , "admin." ) && strstr($val , ".php" )) {
					//read the file
					include_once($val);
					$file = str_replace("admin." , "" , basename($val , ".php"));
					eval('$this->plugins[' . $file . '] = new COXYMall' . $file . '();');
					$this->plugins[$file]->db = &$this->db;
					$this->plugins[$file]->tables = &$this->private->tables;
					$this->plugins[$file]->__parent_templates = &$this->templates;
					$this->plugins[$file]->vars = &$this->private->vars;
					$this->plugins[$file]->tpl_path = _MODPATH . "/" . $this->name . "/plugins/templates/{$file}/" ;
					$this->plugins[$file]->forms_path = _MODPATH . "" . $this->name . "/plugins/forms/{$file}/" ;
					$this->plugins[$file]->module = &$this;
				}
			}			
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
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		if (!$this->__protect())
			return false;

		if (is_array($this->core)) {
			//save tthe forms path
			$tmp = $_CONF["forms"]["adminpath"];

			foreach ($this->core as $key => $val) {
				//temp fix
				
				$_CONF["forms"]["adminpath"] = _MODPATH . "/" . $this->name . "/core/forms/" ;
				if ($data = $val->doEvents()) {
					if ($data !== FALSE) {
						return $data;
					}					
				}
			}			

			//restore it 
			$_CONF["forms"]["adminpath"] = $tmp; 
		}

		if (is_array($this->plugins)) {
			//save tthe forms path
			$tmp = $_CONF["forms"]["adminpath"];

			foreach ($this->plugins as $key => $val) {
				//temp fix
				
				$_CONF["forms"]["adminpath"] = _MODPATH . "/" . $this->name . "/plugins/forms/" ;
				if ($data = $val->doEvents()) {
					if ($data !== FALSE) {
						return $data;
					}					
				}
			}			

			//restore it 
			$_CONF["forms"]["adminpath"] = $tmp; 
		}
		

		
	}

	function __protect() {

		if ($this->name != $_GET["mod"])
			return false;

		global $_USER;

		if ($_USER["user_level"]) {
			$perm = explode("," , $_USER["user_perm"]);

			if ($_REQUEST["module_id"]) {
				if (!in_array($_REQUEST["module_id"] , $perm)) {
					die("Permission Denied!");
				}			
			}

		}
				
		
		parent::__protect();

		return true;
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
		global $_USER;
		//get all the modules
		$modules = $this->db->QFetchRowArray("SELECT * FROM {$this->private->tables['core:user_modules']} ORDER BY mod_order ASC");
		$core = $this->db->QFetchRowArray("SELECT * FROM {$this->private->tables['core:modules']} WHERE module_unique_enabled=1 AND  module_unique=0 ORDER BY module_name");

		if ($_USER["user_level"]) {
			$perm = explode("," , $_USER["user_perm"]);
		}


		if (is_array($core)) {

			foreach ($core as $key => $val) {

				if (!$_USER["user_level"]) {
					$this->private->menu["Global Modules"]["links"][$val["module_name"]] = "index.php?mod=oxymall&sub=oxymall.plugin." . $val["module_code"] . ".landing";
				}				
			}			
		}

		if (is_array($modules)) {
			

			foreach ($modules as $k => $v) {
					$mod[$v["mod_parent"]][] = $v;
			}

			foreach ($mod[0] as $key => $val) {
							
				if (!is_array($mod[$val["mod_id"]])) {
					$this->private->menu[$val["mod_name"]] = array(
							"link" => "index.php?mod=oxymall&sub=oxymall.plugin." . $val["mod_module_code"] . ".landing&module_id=" . $val["mod_id"],
					);
				} else {
					$links = array();
					foreach ($mod[$val["mod_id"]] as $k => $v) {
						if ($v["mod_module_code"] == "category") {
							foreach ($mod[$v["mod_id"]] as $_k => $_v) {
								$links[$v["mod_name"] . " - " . $_v["mod_name"]] = "index.php?mod=oxymall&sub=oxymall.plugin." . $_v["mod_module_code"] . ".landing&module_id=" . $_v["mod_id"];
							}
						} else {
							$links[$v["mod_name"]] = "index.php?mod=oxymall&sub=oxymall.plugin." . $v["mod_module_code"] . ".landing&module_id=" . $v["mod_id"];
						}
					}
					
					$this->private->menu[$val["mod_name"]] = array(
						"links" => $links
					);
						
				}			
			}
		}
//			debug($this->private->menu,1);
		
/*
		debug($mod,1);


		if (is_array($modules)) {
			foreach ($modules as $key => $val) {
				if (!$_USER["user_level"] || ($_USER["user_level"] && in_array($val["mod_id"] , $perm))  ) {
					$this->private->menu[$val["mod_name"]] = array(
						"link" => "index.php?mod=oxymall&sub=oxymall.plugin." . $val["mod_module_code"] . ".landing&module_id=" . $val["mod_id"],
					);
				}

			}			
		}
*/		

		return parent::__adminMenu();

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
	function DashBoardItems() {
	}
	
	

}

?>