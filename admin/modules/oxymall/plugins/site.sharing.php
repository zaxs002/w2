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
class COXYMallSharing extends CPlugin{
	
	var $tplvars; 

	function COXYMallSharing() {
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

		$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("sharing");
	} 


	function Main() {
		global $base , $_CONF;

		$this->__init();

		if ($this->tpl_module["module_unique_enabled"]) {
			//load the images for this module
			$items = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:sharing']} " .
				" " . 
				"ORDER BY item_order ASC"
			);

			if (is_array($items)) {
				foreach ($items as $key => $val) {
					$items[$key]["target"] = $this->module->plugins["common"]->LinkTarget($val["item_target"]);
				}
				
			}
			

			return CTemplateStatic::REplace(
				CTemplateStatic::Replace(
					$this->private->templates["main"]->blockReplace(
						"Main" ,
						array(
							"items" => $base->html->Table(
								$this->private->templates["main"],
								"Items",
								$items
							),
						)
					),
					array(
						"status"		=> $this->tpl_module["module_unique_enabled"] ? "1" : "0",
						"url"			=> $_CONF["url"],
						"url_encoded"	=> urlencode($_CONF["url"]),
					)
				),
				$this->tpl_module["settings"]
			);

		} else 
			return "";			
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
	function Button() {
		$this->__init();

		if ($this->tpl_module["module_unique_enabled"]) {
			return $this->private->templates["main"]->blockReplace(
				"Button" , 
				$this->tpl_module["settings"]
			);
		}
	}
	
	

	function GetAllLinks($module , $links) {
	}

}

?>