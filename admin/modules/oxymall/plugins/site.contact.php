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

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

			switch ($sub) {
				default:					
					return $this->Landing();
				break;

				case "ajax.send":
					return $this->AjaxSendMessage();
				break;
			}
			

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
			"landing"	=> "landing.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
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
	function Landing() {
		global $base, $_SESS;

		//prepare the fields
		$fields = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:contact_fields']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
		);

		if (is_array($fields)) {
			$cnt = 1;
			foreach ($fields as $key => $val) {

				if ($val["item_type"] == "userdroplist") {
					$tmp = @explode("\n" , $val["item_options"]);
					foreach ($tmp as $k => $v) {
						if (trim($v)) {
							$val["options"] .= "<option>" . trim($v) . "</option>";
						}
					}
				}

				if ($val["item_size"] == "small") {

					if ($cnt == 1) {
						$val["class"] = " ";
					} else {
						$val["class"] = "clear pr12 ";
					}

					$cnt = !$cnt;


				
				} else {

					$cnt = 0;
					$val["class"] = "clear";

				}
								

				//size
				$val["size"] = $this->private->templates["landing"]->blockReplace(
					$val["item_size"] == "small" ? "smallsize" : "bigsize",
					array()
				);

				$val["field"] = $this->private->templates["landing"]->blockreplace(
					$val["item_type"], 
					$val
				);
				


				$fields[$key]["content"] = $this->private->templates["landing"]->blockReplace(
					$val["item_size"] == "small" ? "Small" : "Big",
					$val
				);
				
			}
		}

		$this->module->plugins["modules"]->SetSEO(
			$this->tpl_module
		);

		$return = $this->private->templates["landing"]->blockREplacE(
			"Main",
			array(
				"fields"	=> $base->html->table(
					$this->private->templates["landing"],
					"",
					$fields
				),

				"mod_id"	=> $this->tpl_module["mod_id"],

				"header" => $this->vars->data["contact_header_" . $this->tpl_module["mod_id"]],
				"subtitle" => $this->vars->data["contact_subtitle_" . $this->tpl_module["mod_id"]],
				"formtitle" => $this->vars->data["contact_title_" . $this->tpl_module["mod_id"]],

				"set_toggledescriptionpanel" => $this->vars->data["contact_subtitle_" . $this->tpl_module["mod_id"]] ? "1" : "0",

				"set_rightpanelpicture" => $this->vars->data["contact_image_" . $this->tpl_module["mod_id"]] ? $this->private->templates["landing"]->blockReplace(
					"image" , 
					array(
						"mod_id"	=> $this->tpl_module["mod_id"],
						"image_link" => $this->vars->data["contact_image_link_" . $this->tpl_module["mod_id"]] ? $this->vars->data["contact_image_link_" . $this->tpl_module["mod_id"]] : "#",
						"image_link_target" => $this->vars->data["contact_image_link_target_" . $this->tpl_module["mod_id"]],
					)
				) : "",



				"title" => $this->tpl_module["mod_long_name"],


				"links"	=> $base->html->table(
					$this->private->templates["landing"], 
					"Links" , 
					$this->db->QFetchRowArray(
						"SELECT * FROM {$this->tables['plugin:contact_links']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
					)
				),


			)
		);


		return CTemplateStatic::Replace(
			$return , 
			$this->tpl_module["settings"]
		);
	}
	


	function AjaxSendMessage() {
		global $_CONF , $_NO_HTACCESS , $_SESS;

		$this->__init();

		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

		$fields = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:contact_fields']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
		);

		if (is_array($fields)) {
			foreach ($fields as $key => $val) {
				if ($val["item_required"] && !$_POST[$val["item_field"]]) {
					return $this->module->plugins["common"]->ErrorMSG(
						$val["item_error_msg"]
					);
				}
			}			
		}

		if ($_POST["image_code"] != $_SESS["XML_verify_key"]) {
			return $this->module->plugins["common"]->ErrorMSG(
				$this->tpl_module["settings"]["set_verificationcodeerror"]
			);
		}
		
		
		$vars = $_POST;

		//save the email to database
		$id = $this->db->QueryInsert(
			$this->tables["plugin:contact_messages"],
			$contact = array(
				"module_id"		=> $this->tpl_module["mod_id"],
				"item_new"		=> 1,
				"item_date"		=> time(),
				"item_email"	=> $vars["email"],
				"item_name"		=> $vars["name"],
				"item_subject"	=> $vars["subject"],
				"item_message"	=> CTemplateStatic::Replace(
					$this->tpl_module["settings"]["set_email_message"],
					$vars
				),

				"item_code"		=> md5(microtime_float()),

			)
		);

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_admin"],
				$vars
			)
		);			

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_client"],
				$vars
			)
		);			
		

		return $this->module->plugins["common"]->SuccessMSG(
			$this->tpl_module["settings"]["set_succestext"]
		);

	}


	function GetAllLinks($module , $links) {
	}
		
}

?>