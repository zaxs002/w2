<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss author Exp $
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
class CMessagesAdmin {
	function CMessagesAdmin($templates , $database , $tables) {
		$this->name = "messagesadmin";

		$this->db = $database;
		$this->templates = $templates;
		$this->tables = $tables;		
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE;

		$_CONF["forms"]["adminpath"] = _LIBPATH . "xml/"; 

		$data = new CSQLAdmin("messages", $this->templates,$this->db,$this->tables);
		return $data->DoEvents();
	}
}

?>