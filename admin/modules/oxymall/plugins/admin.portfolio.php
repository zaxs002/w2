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
class COXYMallPortfolio extends CPlugin{
	
	var $tplvars; 

	function COXYMallPortfolio() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.portfolio.")) {
			$sub = str_replace("oxymall.plugin.portfolio." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

			switch ($sub) {

				case "landing":
				case "cats":
					$data = new CSQLAdmin("portfolio/landing", $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"] , $sub);

					return $data->DoEvents();

				break;

				case "projects":

					if ($_GET["action"] == "details") {
						$data = new CSQLAdmin("portfolio/images" , $this->__parent_templates,$this->db,$this->tables,$extra);
						$extra["details"]["after"] = $data->DoEvents();
					}
					
					$data = new CSQLAdmin("portfolio/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"] , $sub);
					return $data->DoEvents();

				break;

				case "images":
					
					$data = new CSQLAdmin("portfolio/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"] , $sub);

					return $data->DoEvents();

				break;

			}
		}
	}

	function PrepareFields($forms , $sub = "") {

		if (is_array($forms["search"])) {
			$forms["search"]["title"] = CTemplateStatic::Replace(
				$forms["search"]["title"],
				array( "title" => $this->tpl_module["mod_name"])
			);
		}

		if (is_array($forms["details"])) {
			$forms["details"]["title"] = CTemplateStatic::Replace(
				$forms["details"]["title"],
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
	}

}

?>