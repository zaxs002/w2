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
class COXYMallBackground extends CPlugin{
	
	var $tplvars; 

	function COXYMallBackground() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;
		parent::DoEvents();
	}

	function __init() {
		global $_CONF;

		if ($this->__inited) {
			return "";
		}

		$this->__inited = true;
		
		$path = $this->tpl_path;

		$templates = array(
			"main"					=> "main.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}

		$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("background");
	} 


	function Main() {
		global $base;

		$this->__init();

		$order = "rand()";

		if ($_GET["module_id"]) {
			//load the images for this module
			$items = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:background_items']} " .
				"WHERE item_module={$_GET[module_id]} " . 
				"ORDER BY {$order}"
			);
		}

		if (!is_array($items)) {
			//load the images for this module
			$items = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:background_items']} " .
				"WHERE item_module=0 " . 
				"ORDER BY {$order}"
			);
		}

		return $this->private->templates["main"]->blockReplace(
			"Main" ,
			array(
				"items" => $base->html->Table(
					$this->private->templates["main"],
					"Items",
					$items
				)
			)
		);
	}

	function GetAllLinks($module , $links) {
	}	
}

?>