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
class COXYMallNewsletters extends CPlugin{
	
	var $tplvars; 

	function COXYMallNewsletters() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if ($_GET["sub"] == "oxymall.plugin.newsletters.subscribe") {
			return $this->SubscribeUser();
		}

	}

	function __init() {
		global $_CONF;

		if ($this->__inited) {
			return "";
		}

		$this->__inited = true;
		
		$path = $this->tpl_path;

		$templates = array(
			"main"					=> "main.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}

		$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("newsletters");
	} 


	function Main() {
		global $base;

		$this->__init();

		//load the module

		if ($this->tpl_module["module_unique_enabled"]) {
			return CTemplateStatic::Replace(
				$this->private->templates["main"]->blockReplace(
					"Main" ,
					$this->tpl_module["settings"]
				)			
			);
		} else {
			return "";
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
	function Button() {
		$this->__init();

		if ($this->tpl_module["module_unique_enabled"]) {
			return $this->private->templates["main"]->blockReplace(
				"Button",
				$this->tpl_module["settings"]
			);
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
	function SubscribeUser() {

		$this->__init();

		if (!$_POST["email"]) {
			return $this->module->plugins["common"]->ErrorMsg(				
				$this->tpl_module["settings"]["set_wrongemailtext"]
			);
		}
		
		if (!$_POST["name"] && ($_POST["action"]=="1")) {
			return $this->module->plugins["common"]->ErrorMsg(				
				$this->tpl_module["settings"]["set_wrongnametext"]
			);
		}

		
		switch ($_POST["action"]) {
			case "1":
				//check if user exists
				$user = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:newsletters_subscribers']} WHERE item_email=\"{$_POST[email]}\"");

				if (is_array($user)) {
					return $this->module->plugins["common"]->ErrorMsg(
						$this->tpl_module["settings"]["set_alreadysubscribedalert"]
					);
				}
				
				//insert the user 
				$this->db->QueryInsert(
					$this->tables["plugin:newsletters_subscribers"],
					array(
						"item_name"	=> $_POST["name"],
						"item_email"	=> $_POST["email"],
						"item_date"	=> time(),
					)
				);

				return $this->module->plugins["common"]->SuccessMsg(
					$this->tpl_module["settings"]["set_successubscribe"]
				);
			break;

			case "2":
				//check if user exists
				$user = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:newsletters_subscribers']} WHERE item_email=\"{$_POST[email]}\"");

				if (!is_array($user)) {
					return $this->module->plugins["common"]->ErrorMsg(
						$this->tpl_module["settings"]["set_alreadyunsubscribedalert"]
					);
				}

				$this->db->Query("DELETE FROM {$this->tables['plugin:newsletters_subscribers']} WHERE item_id={$user[item_id]}");

				return $this->module->plugins["common"]->SuccessMsg(
					$this->tpl_module["settings"]["set_succesunsubscribe"]
				);
			break;

			default:
				return $this->module->plugins["common"]->ErrorMsg(
					$this->tpl_module["settings"]["set_failtext"]
				);
			break;
		}	
	}
	

	function GetAllLinks($module , $links) {
	}


}

?>