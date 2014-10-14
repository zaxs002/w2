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

		if (strstr($_GET["sub"] , "oxymall.plugin.sharing.")) {
			$sub = str_replace("oxymall.plugin.sharing." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->tpl_module = $this->module->plugins["modules"]->getDefaultModuleInfo("sharing");

			switch ($sub) {

				case "landing":
					
					$data = new CSQLAdmin("sharing/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

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
	function PrepareFields($forms) {

	}
	

}

?>