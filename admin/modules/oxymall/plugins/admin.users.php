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
class COXYMallUsers extends CPlugin{
	
	var $tplvars; 

	function COXYMallUsers() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.users.")) {
			$sub = str_replace("oxymall.plugin.users." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			//read the module
			$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("users");
			

			switch ($sub) {

				case "landing":					
					$data = new CSQLAdmin("users/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$this->PrepareFields(&$data->forms["forms"], $sub);

					$data->functions = array( 
							"onstore_prepare" => array(&$this , "StoreUser"),
							"onstore" => array(&$this , "StoreUser"),
					);					

					return $data->DoEvents();
				break;

				case "groups":					
					$data = new CSQLAdmin("users/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
					return $data->DoEvents();
				break;

				case "settings":
					$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("users");
					urlredirect("index.php?mod=oxymall&sub=oxymall.plugin.modules.default&action=details&module_id={$this->tpl_module['module_id']}");

				break;

				case "scan":
					return "under construction";
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
	
	function StoreUser($record) {
		//check if is a new user
		if (!$record["user_id"]) {
			$_POST["user_date"]				= time();
			$_POST["user_email_original"]	= $_POST["user_email"];
			$_POST["user_key_code"]			= md5($_POST["user_email"] . time());
			$_POST["user_key_date"]			= time();
			$_POST["user_password_plain"]	= $_POST["user_pass"];
			$_POST["user_password"]			= md5($_POST["user_pass"]);

			//update the record
			$record = $_POST;

			switch ($_POST["user_status"]) {
				case "1":	$email = "set_mail_confirm";	break;
				case "2":	$email = "set_mail_welcome";	break;
				case "3":	$email = "set_mail_pending";	break;
				case "4":	$email = "set_mail_suspended"; 	break;
			}

			$id = $this->module->plugins["mail"]->SendMail(
				$this->module->plugins["mail"]->GetMail(
					$this->tpl_module["settings"][$email],
					$record
				)
			);			

		}
		
		//update password
		if ($record["user_id"] && $record["user_pass"]) {

			$this->db->QueryUpdate(
				$this->tables["plugin:users"],
				array(
					"user_password" => md5($record["user_pass"]),
				),
				"user_id='{$record[user_id]}'"
			);
		}

		//notification emails if the status was changed
		if ($record["user_id"] && $_POST["send_mail"]) {


			switch ($_POST["user_status"]) {
				case "1":	$email = "set_mail_confirm";	break;
				case "2":	$email = "set_mail_welcome";	break;
				case "3":	$email = "set_mail_pending";	break;
				case "4":	$email = "set_mail_suspended"; 	break;
			}

			$id = $this->module->plugins["mail"]->SendMail(
				$this->module->plugins["mail"]->GetMail(
					$this->tpl_module["settings"][$email],
					$record
				)
			);			

			//hell knows why this happends
			$_POST["send_mail"] = 0;

		}
		

	}


}

?>
