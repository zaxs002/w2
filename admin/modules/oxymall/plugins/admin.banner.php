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
class COXYMallBanner extends CPlugin{
	
	var $tplvars; 

	function COXYMallBanner() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.banner.")) {
			$sub = str_replace("oxymall.plugin.banner." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

			switch ($sub) {

				case "landing":
					if ($_GET["action"] == "itemdetails") {
						$data = new CSQLAdmin("banner/" . "texts", $this->__parent_templates,$this->db,$this->tables,$extra);
						$extra["details"]["after"] = $data->DoEvents();
					}
					
					$data = new CSQLAdmin("banner/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"]);
					return $data->DoEvents();
				break;

				case "texts":
					$data = new CSQLAdmin("banner/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
					$this->PrepareFields(&$data->forms["forms"]);
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
	function PrepareFields($forms) {
		$forms["list"]["title"] = CTemplateStatic::Replace(
			$forms["list"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		$forms["edit"]["title"] = CTemplateStatic::Replace(
			$forms["edit"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		$forms["details"]["title"] = CTemplateStatic::Replace(
			$forms["details"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		$forms["add"]["title"] = CTemplateStatic::Replace(
			$forms["add"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		$width = $this->tpl_module["settings"]["set_imagewidth"];
		$height = $this->tpl_module["settings"]["set_imageheight"];

		$forms["edit"]["fields"]["item_image"]["thumbnails"]["resize"]["width"] = 
		$forms["details"]["fields"]["item_image"]["thumbnails"]["resize"]["width"] = 
		$forms["add"]["fields"]["item_image"]["thumbnails"]["resize"]["width"] = $width;

		$forms["edit"]["fields"]["item_image"]["thumbnails"]["resize"]["height"] = 
		$forms["details"]["fields"]["item_image"]["thumbnails"]["resize"]["height"] = 
		$forms["add"]["fields"]["item_image"]["thumbnails"]["resize"]["height"] = $height;

		$forms["add"]["fields"]["item_image"]["title"] = 
		$forms["details"]["fields"]["item_image"]["title"] = 
		$forms["edit"]["fields"]["item_image"]["title"] = CTemplateStatic::ReplaceSingle(
			$forms["edit"]["fields"]["item_image"]["title"] ,
			"size" , 
			$width . " x "  . $height
		);

		foreach ($forms["add"]["fields"] as $key => $val) {

			if (stristr($key , "item_set")) {
				$forms["add"]["fields"][$key]["default"] = $this->tpl_module["settings"]["set_" . $key];
			}
			
		}


		if ($this->tpl_module["settings"]["set_reverseorder"]) {
			$forms["list"]["sql"]["vars"]["order_mode"]["import"] = "desc";
		}
	}
	

}

?>