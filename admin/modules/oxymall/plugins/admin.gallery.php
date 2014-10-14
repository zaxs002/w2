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
class COXYMallGallery extends CPlugin{
	
	var $tplvars; 

	function COXYMallGallery() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.gallery.")) {
			$sub = str_replace("oxymall.plugin.gallery." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

			switch ($sub) {

				case "landing":
				
					$data = new CSQLAdmin("gallery/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"] , $sub);
					return $data->DoEvents();

				break;

				case "images":
					
					$data = new CSQLAdmin("gallery/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"] , $sub);

					return $data->DoEvents();

				break;

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
	function PrepareFields($forms , $sub) {

		if (is_array($forms["search"])) {
			$forms["search"]["title"] = CTemplateStatic::Replace(
				$forms["search"]["title"],
				array( "title" => $this->tpl_module["mod_name"])
			);
		}

		$forms["list"]["title"] = CTemplateStatic::Replace(
			$forms["list"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		$forms["edit"]["title"] = CTemplateStatic::Replace(
			$forms["edit"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		$forms["add"]["title"] = CTemplateStatic::Replace(
			$forms["add"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		if ($this->tpl_module["settings"]["set_reverseorder"] && ($sub == "images")) {
			$forms["list"]["sql"]["vars"]["order_mode"]["import"] = "desc";
		}

		if ($this->tpl_module["settings"]["set_reverseorder_albums"] && ($sub == "landing")) {
			$forms["list"]["sql"]["vars"]["order_mode"]["import"] = "desc";

		}

	}
	

}

?>