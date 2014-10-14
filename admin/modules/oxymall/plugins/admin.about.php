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
class COXYMallAbout extends CPlugin{
	
	var $tplvars; 

	function COXYMallAbout() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.about.")) {
			$sub = str_replace("oxymall.plugin.about." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

			switch ($sub) {

				case "landing":

						//fix for module var
						$_POST["module_id"] = $this->tpl_module["module_id"];

						$data = new CFormSettings($this->forms_path  . $sub . ".xml" ,$_CONF["forms"]["admintemplate"] , $this->db,$this->tables);

						$data->form["title"] = CTemplateStatic::Replace(
							$data->form["title"],
							array( "title" => $this->tpl_module["mod_name"])
						);

						$data->form["fields"]["about_header_" . $this->tpl_module["mod_id"]] = $data->form["fields"]["header"];
						unset($data->form["fields"]["header"]);



						if ($data->Done()) {
							$this->vars->SetAll($_POST);
							$this->vars->Save();							
						}
						
						return $data->Show($this->vars->data);
				break;

			}
		}
	}

}

?>