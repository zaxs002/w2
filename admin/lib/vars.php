<?php

/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: vars.php,v 0.0.1 09/03/2003 20:38:15 Exp $

	contact:
		www.oxylus.ro
		office@oxylus.ro

* @author	OXYLUS [OXYLUS.ro <devel@oxylus.ro>]
* @since	PHPbase 0.0.1
*/
class CVars {
	var $database;
	var $table;
	var $data = array();
	var $modif = FALSE;

	function CVars($database,$table) {
		//$this->database = (is_object($database)) ? &$database : new CDatabase($database);
		if (is_object($database))
			$this->database = &$database;
		else
			$this->database = new CDatabase($database);

		$this->table = $table;

		return $this->Load();
	}

	function Load() {
		global $_USER;
		$vars = $this->database->QFetchRowArray("SELECT * FROM `$this->table`");

		if (is_array($vars))
			foreach ($vars as $key => $var) {

				if (strtolower($var["name"]) != "retrunurl") {
					if (isset($var["base_user"]) && ($var["base_user"] != $_USER["user_id"])) {
						unset($vars[$key]);
					} else				
						$this->data[$var["name"]] = stripslashes($var["value"]);
				}			
			}
	}

	function SetAll($var) {
		$this->data = array_merge ($this->data ,$var);
		$this->modif = TRUE;
	}
	

	function Set($name,$value,$force = FALSE) {
		$value = addslashes($value);
		 if ($force == TRUE) {
				 $this->database->Query("UPDATE `$this->table` SET `value` = '$value' WHERE (`name` = '$name')");
			 
			 if ($this->database->AffectedRows() == 0) {
				 $this->database->Query("INSERT INTO `$this->table` (`name`,`value`) VALUES ('$name','$value')");
			 }
		 }

		 $this->data["$name"] = $value;
		 $this->modif = TRUE;
	}

	function Get($name) {
		return $this->data["$name"];
	}

	function Save() {
		global $_USER;
		$table_fields = $this->database->GetTableFields($this->table); 

		// any modifications?
		if ($this->modif == TRUE) {
			// prepare names and values
			foreach ($this->data as $name => $val) {
				
				if (strtolower($name) != "returnurl") {
					$val = addslashes($val);
					$values[] = "('$name','$val'" . (in_array("base_user",$table_fields) ? ",'{$_USER[user_id]}'" : '') . ")";
				}			
			}

			// build names and values
			$values = implode(", ",$values);

			// do the nasty things
			$this->database->Query("DELETE FROM `$this->table` " . (in_array("base_user",$table_fields) ? " WHERE `base_user`='{$_USER[user_id]}'" : ''));
			$this->database->Query("INSERT INTO `$this->table` (`name`,`value`" . (in_array("base_user",$table_fields) ? ",`base_user`" : '') . ") VALUES $values");
			
		}
	}
}
?>