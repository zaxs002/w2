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

		if (strstr($_GET["sub"] , "oxymall.plugin.background.")) {
			$sub = str_replace("oxymall.plugin.background." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			switch ($sub) {

				case "landing":				
					$data = new CSQLAdmin("background/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
					return $data->DoEvents();
				break;

				case "modules":
					$data = new CSQLAdmin("background/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
					return $data->DoEvents();
				break;

			}
		}
	}

}

?>