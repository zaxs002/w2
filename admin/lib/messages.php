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
	//administration area
	require_once _LIBPATH . "messages.admin.php";


/**
* description
*
* @library	
* @author	
* @since	
*/
class CMessages {

	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $data;

	function CMessages($database , $table) {
		global $_LANGUAGE;

		$this->name = "messages";
		$this->database = $database;
		$this->table = $table;

		$this->language = $_LANGUAGE;

		$this->Load();

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
	function Load() {
		//read the mesages
		$this->data = $this->database->QFetchRowArray("SELECT * FROM {$this->table} ");

		if (is_array($this->data)) {
			foreach ($this->data as $key => $val) {
				$this->data[$val["msg_code"]] = $val;
				unset($this->data[$key]);
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
	function Get($code) {
		//read the code
		return $this->database->QFetchArray("SELECT * FROM {$this->table} WHERE " /*msg_lang='{$this->language}' AND */ . "msg_code='{$code}'");
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
	function LoadVars($module) {

		$this->data = $this->database->QFetchRowArray("SELECT * FROM {$this->table} "); //WHERE msg_lang='{$this->language}'");

		$module = strtoupper($module);

		if (is_array($this->data)) {
			foreach ($this->data as $key => $val) {

				if (!$val["msg_user_title_protect"]) {
					$final["MODULE::$module::LANG.{$val[msg_code]}.title"] = $val["msg_user_title"];
					$this->vars["{$val[msg_code]}.title"] = $val["msg_user_title"];
				}

				if (!$val["msg_user_body_protect"]) {
					$final["MODULE::$module::LANG.{$val[msg_code]}.msg"] = $val["msg_user_body"];
					$this->vars["{$val[msg_code]}.msg"] = $val["msg_user_body"];
				}

				unset($this->data[$key]);
			}			
		}		

		return $final;
	}
	
}

?>