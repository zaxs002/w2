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

		if (strstr($_GET["sub"] , "oxymall.plugin.newsletters.")) {
			$sub = str_replace("oxymall.plugin.newsletters." , "" ,$_GET["sub"]);
			$action = $_GET["action"];


			if ($_GET["module_id"]) {
				//read the module
				$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);
			}
			
			switch ($sub) {
				case "landing":
					$sub = "subscribers";

				case "subscribers":
					$data = new CSQLAdmin("newsletters/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
					return $data->DoEvents();
				break;

				case "items":
					$data = new CSQLAdmin("newsletters/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);

					$data->functions = array( 
							"onstore" => array(&$this , "StoreNewsletter"),
					);					

					return $data->DoEvents();
				break;

				case "subscribers-export":
					return $this->ExportSubscribers();
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
	function ExportSubscribers() {
		$mime = new CMime();
		$mime->Set("csv");
		$mime->FileName("subscribers.csv");

		$subscribers = $this->db->QFetchRowArray("SELECT * FROM {$this->tables['plugin:newsletters_subscribers']}");

		echo putcsv(array("Email" , "Name"));

		if (is_array($subscribers)) {
			foreach ($subscribers as $key => $val) {

				echo putcsv(array($val["item_email"] , $val["item_name"]));

			}			
		}
		
		die();

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
	function StoreNewsletter($record) {

		@set_time_limit(0);

		if ($record["item_status"] == 2) {
			//send the newsletter to all users

			$users = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:newsletters_subscribers']} "
			);

			if (is_array($users)) {
				foreach ($users as $key => $user) {

					//maybe at some point add protection duplicates

					$this->module->plugins["mail"]->AddToQueue(
						array(
							"email_from"		=> $record["item_from_email"],
							"email_from_name"	=> $record["item_from_name"],

							"email_to"			=> $user["item_email"],
							"email_to_name"		=> $user["item_name"],

							"email_subject"		=> CTemplateStatic::Replace(
								$record["item_title"],
								array(
									"name"	=> $user["item_name"],
									"email"	=> $user["item_email"]
								)
							),
							"email_body"		=> CTemplateStatic::Replace(
								$record["item_body"],
								array(
									"name"	=> $user["item_name"],
									"email"	=> $user["item_email"]
								)
							)
						)
					);

					//save in history
					$this->db->QueryInsert(
						$this->tables['plugin:newsletters_history'],
						array(
							"history_name"			=> $user["item_name"],
							"history_email"			=> $user["item_email"],
							"history_newsletter"	=> $record["item_id"],
							"history_date"			=> time(),
							"history_status"		=> "1"							
						)
					);
				}
				
			}

			//update the newsletter to sent status
			$this->db->QueryUpdate(
				$this->tables['plugin:newsletters_items'],
				array(
					"item_status"	=> "3"
				),
				"item_id={$record[item_id]}"
			);
			
		}		
	}
	


}

?>