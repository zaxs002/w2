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
class COXYMallContact extends CPlugin{
	
	var $tplvars; 

	function COXYMallContact() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.contact.")) {
			$sub = str_replace("oxymall.plugin.contact." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

			switch ($sub) {

				case "texts":

						$data = new CFormSettings($this->forms_path  . $sub . ".xml" ,$_CONF["forms"]["admintemplate"] , $this->db,$this->tables);

						$this->prepareFieldS(&$data->form);

						if ($data->Done()) {

							if ($_POST["contact_image_{$this->tpl_module[mod_id]}_radio_type"] == -1) {
								@unlink("../upload/contact/{$this->tpl_module[mod_id]}.png");
								$_POST["contact_image_{$this->tpl_module[mod_id]}"] = "";
							}

							//unset some fields

							$fields = array(
								"_temp",
								"_radio_type",
								"_upload_web",
								"_temp_file",
								"_crop_oxbc"
							);

							$pref = "contact_image_{$this->tpl_module[mod_id]}";

							foreach ($fields as $key => $val) {
								if (isset($_POST[$pref . $val])) {
									unset($_POST[$pref . $val]);
								}								
							}

							$this->vars->SetAll($_POST);
							$this->vars->Save();							
						}
						
						return $data->Show($this->vars->data);
				break;
	

				case "items":
					$sub = "landing";
				case "landing":

					if ($_GET["item_id"]) {
						$this->db->QueryUpdate(
							$this->tables["plugin:contact_messages"],
							array(
								"item_new" => 0,
							),
							"item_id='{$_GET[item_id]}'"
						);
					}
					

					$data = new CSQLAdmin("contact/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
					$this->PrepareMSGFields(&$data->forms["forms"]);
					return $data->DoEvents();
				break;

				case "links":
					$data = new CSQLAdmin("contact/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareMSGFields(&$data->forms["forms"]);

					return $data->DoEvents();
				break;

				case "fields":
					$data = new CSQLAdmin("contact/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareMSGFields(&$data->forms["forms"]);
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
	function PrepareFields($form) {
		$form["title"] = CTemplateStatic::Replace(
			$form["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);


		foreach ($form["fields"] as $key => $val) {
			if ($val["type"] == "image") {
				$val["file"]["default"] = $this->tpl_module["mod_id"];
			}			

			$fields["contact_" . $key . "_" . $this->tpl_module["mod_id"]] = $val;
		}
		
		$form["fields"] = $fields;
	}


	function PrepareMSGFields($forms) {

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

		$forms["details"]["title"] = CTemplateStatic::Replace(
			$forms["details"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);

		$forms["add"]["title"] = CTemplateStatic::Replace(
			$forms["add"]["title"],
			array( "title" => $this->tpl_module["mod_name"])
		);
	}
}

?>