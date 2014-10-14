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
class COXYMallProducts extends CPlugin{
	
	var $tplvars; 

	function COXYMallProducts() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.products.")) {
			$sub = str_replace("oxymall.plugin.products." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

			switch ($sub) {


				case "landing":
					$data = new CSQLAdmin("products/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"], $sub);

					return $data->DoEvents();

				break;

				case "products":

					switch ($_GET["section"]) {
						case "2":
							$data = new CSQLAdmin("products/variations", $this->__parent_templates,$this->db,$this->tables,$extra);
							$extra["details"]["after"] = $data->doEvents();
						break;

						case "3":
							$data = new CSQLAdmin("products/images", $this->__parent_templates,$this->db,$this->tables,$extra);
							$extra["details"]["after"] = $data->doEvents();
						break;

						case "4":
							$data = new CSQLAdmin("products/reviews", $this->__parent_templates,$this->db,$this->tables,$extra);
							$extra["details"]["after"] = $data->doEvents();
						break;

						case "5":
							$data = new CSQLAdmin("products/questions", $this->__parent_templates,$this->db,$this->tables,$extra);
							$extra["details"]["after"] = $data->doEvents();
						break;

						case "6":
							$data = new CSQLAdmin("products/files", $this->__parent_templates,$this->db,$this->tables,$extra);
							$extra["details"]["after"] = $data->doEvents();
						break;
					}
					
					
					$data = new CSQLAdmin("products/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					if ($_GET["action"] == "details") {
						$data->forms["forms"]["details"]["tabs"]["t" . (int)$_GET["section"]]["active"] = "true";

						if ($_GET["section"]) {
							foreach ($data->forms["forms"]["details"]["fields"] as $key => $val) {
								if ($key!="item_title") {
									unset($data->forms["forms"]["details"]["fields"][$key]);
								}
								
							}
						}
					} else {
						unset($data->forms["forms"]["edit"]["tabs"]);
						unset($data->forms["forms"]["add"]["tabs"]);
					}

					$this->PrepareFields(&$data->forms["forms"] , $sub);


					return $data->DoEvents();

				break;

				case "files":
				case "reviews":
				case "questions":
				case "allreviews":
				case "allquestions":
					$data = new CSQLAdmin("products/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"] , $sub);

					return $data->doEvents();
				break;

				case "variations":
				case "images":

					$data = new CSQLAdmin("products/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);					

					$this->PrepareFields(&$data->forms["forms"] , $sub);
					return $data->doEvents();
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

	}

}

?>