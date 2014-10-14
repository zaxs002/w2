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
class COXYMallHomepage extends CPlugin{
	
	var $tplvars; 

	function COXYMallHomepage() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.homepage.")) {
			$sub = str_replace("oxymall.plugin.homepage." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

			switch ($sub) {

				case "images":
					$data = new CSQLAdmin("homepage/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"]);

					return $data->DoEvents();
				break;

				case "landing":
						//fix for module var
						$_POST["module_id"] = $this->tpl_module["module_id"];

						$data = new CFormSettings($this->forms_path  . $sub . ".xml" ,$_CONF["forms"]["admintemplate"] , $this->db,$this->tables);

						$data->form["title"] = CTemplateStatic::Replace(
							$data->form["title"],
							array( "title" => $this->tpl_module["mod_name"])
						);

						$data->form["fields"]["homepage_header_" . $this->tpl_module["mod_id"]] = $data->form["fields"]["header"];
						unset($data->form["fields"]["header"]);

						$data->form["fields"]["homepage_products_" . $this->tpl_module["mod_id"]] = $data->form["fields"]["products"];
						unset($data->form["fields"]["products"]);

						if ($data->Done()) {
							$this->vars->SetAll($_POST);
							$this->vars->Save();							
						}
						
						return $data->Show($this->vars->data);
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

		$forms["add"]["title"] = CTemplateStatic::Replace(
			$forms["add"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);
 
		$width = $this->tpl_module["settings"]["set_thumbwidth"];
		$height = $this->tpl_module["settings"]["set_thumbheight"];

		if (is_array($forms["edit"]["fields"]["item_image"])) {

			if ($this->tpl_module["settings"]["set_toggleproportionalresizeonthumb"] == "1") {
				$forms["edit"]["fields"]["item_image"]["thumbnails"]["resize"]["width"] = 
				$forms["add"]["fields"]["item_image"]["thumbnails"]["resize"]["width"] = $width;

				$forms["edit"]["fields"]["item_image"]["thumbnails"]["resize"]["height"] = 
				$forms["add"]["fields"]["item_image"]["thumbnails"]["resize"]["height"] = $height;

				$forms["add"]["fields"]["item_image"]["title"] = 
				$forms["edit"]["fields"]["item_image"]["title"] = CTemplateStatic::ReplaceSingle(
					$forms["edit"]["fields"]["item_image"]["title"] ,
					"size" , 
					"(" . $width . " x "  . $height . "px)"
				);
			} else {
				$forms["add"]["fields"]["item_image"]["title"] = 
				$forms["edit"]["fields"]["item_image"]["title"] = CTemplateStatic::ReplaceSingle(
					$forms["edit"]["fields"]["item_image"]["title"] ,
					"size" , 
					""
				);
			}
			

			if ($this->tpl_module["settings"]["set_reverseorder"]) {
				$forms["list"]["sql"]["vars"]["order_mode"]["import"] = "desc";
			}

		}
	
	}
}

?>