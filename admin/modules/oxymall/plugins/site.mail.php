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
class COXYMallMail extends CPlugin{
	
	var $tplvars; 

	function COXYMallMail() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS , $_ADMIN;

		parent::DoEvents();


		if ($_ADMIN) {

			if (strstr($_GET["sub"] , "oxymall.plugin.mail.")) {
				$sub = str_replace("oxymall.plugin.mail." , "" ,$_GET["sub"]);
				$action = $_GET["action"];

				//read the module
				//$this->tpl_module = $this->module->plugins["modules"]->getModuleInfo($_GET["module_id"]);

				switch ($sub) {
					case "emails":
					case "queue":
						$data = new CSQLAdmin("mail/" . $sub, $this->__parent_templates,$this->db,$this->tables,$extra);
						//$this->PrepareFields(&$data->forms["forms"]);
						return $data->DoEvents();
					break;


					case "swiftmail":
							$data = new CFormSettings($this->forms_path  . $sub . ".xml" ,$_CONF["forms"]["admintemplate"] , $this->db,$this->tables);

							if ($data->Done()) {

								$this->vars->SetAll($_POST);
								$this->vars->Save();

								if ($_POST["test"]) {
									//send the test mail 
									$results = $this->SendMail(
										array(
											"email_to" => $_POST["test_to"],
											"email_from" => $_POST["test_to"],
											"email_subject" => $_POST["test_subject"],
											"email_body" => $_POST["test_body"],
										)
									);
									
								}													
							}
							return $data->Show($this->vars->data);
					break;

					case "send-mail":
						return $this->Cron();
					break;

				}
			}

		} else {

			if ($_GET["sub"] == "oxymall.plugin.mail.cron") {
				return $this->Cron();
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
	function GetMail($code , $vars = array()) {

		//try to read from cache
		if ($this->cache_mails[$code]) {

			$mail = $this->cache_mails[$code];

		} else {

			$mail = $this->db->QFetchArray(
				"SELECT * FROM {$this->tables['plugin:mail_emails']} WHERE email_status=1 AND email_code='{$code}'"
			);
			$this->cache_mails[$code] = $mail;

		}
		

		if (is_array($vars) && count($vars)) {

			$vars_to_replace = array(
				"email_subject",
				"email_from",
				"email_from_name",
				"email_to",
				"email_to_name",
				"email_body"
			);

			foreach ($vars_to_replace as $key => $val) {
				$mail[$val] = CTemplateStatic::Replace(
					$mail[$val],
					$vars
				);
			}			
		}
		


		return $mail;
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
	function AddToQueue($data) {

		$this->db->QueryInsert(
			$this->tables["plugin:mail_queue"],
			array(
				"mail_date"			=> time(),
				"mail_from_name"	=> $data["email_from_name"],
				"mail_from_email"	=> $data["email_from"],
				"mail_to_name"		=> $data["email_to_name"],
				"mail_to_email"		=> $data["email_to"],
				"mail_subject"		=> $data["email_subject"],
				"mail_body"			=> $data["email_body"],
				"mail_type"			=> "html",
				"mail_status"		=> "0",
				"mail_priority"		=> $data["priority"] ? $data["priority"]  : "5",
			)
		);

		return true;
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
	function SendMail() {
		global $_CONF;

		$params = AStripSlasshes(func_get_args());	
		//check to see the numbers of the arguments

		//debug($params);

		switch (func_num_args()) {
			case 1:
				$email = $params[0];
				$vars = array();
			break;

			case 2:
				$email = $params[0];
				$vars = $params[1];
			break;

			case 3:
				$to = $params[0];
				$email = $params[1];
				$vars = $params[2];
			break;

			case 4:
				$to = $params[0];
				$to_name = $params[1];
				$email = $params[2];
				$vars = $params[3];
			break;
		}

		if (isset($email["email_status"]) && !$email["email_status"]) {
			return false;
		}

		//this check its for templates, in case was sent an empty or disabled email template
		if (!($email["email_to"] && $email["email_from"])) {
			return false;
		}

		global $_CONF;

		$vars["site:url"] = $_CONF["url"];
			
				
		$msg = new CTemplate(stripslashes($email["email_body"]) , "string");
		$msg = $msg->Replace($vars);

		$sub = new CTemplate(stripslashes($email["email_subject"]) , "string");
		$sub = $sub->Replace($vars);

		$email["email_from"] = new CTemplate(stripslashes($email["email_from"]) , "string");
		$email["email_from"] = $email["email_from"]->Replace($vars);

		$email["email_from_name"] = new CTemplate(stripslashes($email["email_from_name"]) , "string");
		$email["email_from_name"] = $email["email_from_name"]->Replace($vars);

		if (!$email["email_reply"]) 
			$email["email_reply"] = $email["email_from"];
		if (!$email["email_reply_name"]) 
			$email["email_reply_name"] = $email["email_from_name"];

		//check if swift isnt configure
		if (!$this->vars->data["set_switft_transport"]) {
			$this->vars->data["set_switft_transport"] = "php-default";
		}
		


		if ($this->vars->data["set_switft_transport"] == "php-default") {
			$headers  = "MIME-Version: 1.0\r\n";

			if ($email["email_type"] == "text")
				$headers .= "Content-type: text/plain\r\n";
				
			else
				$headers .= "Content-type: text/html\r\n";

			//prepare the from fields
			if (!$email["email_hide_from"]) {
				$headers .= "From: {$email[email_from_name]}<{$email[email_from]}>\r\n";
				$headers .=	"Reply-To: {$email[email_reply_name]}<{$email[email_reply]}>\r\n";
			}

			$headers .= $email["headers"];
		
			if (!$email["email_hide_to"]) {
				return mail($email["email_to"] , $sub, $msg,$headers);		
			} else {
			}

			$headers .=	"X-Mailer: PHP/" . phpversion();

			return mail($to, $sub, $msg,$headers);				

		} else {

			require_once _LIBPATH . '../3rdparty/swift-4/swift_required.php'; 

			$recipients = array($email["email_to"] => $email["email_to_name"] ? $email["email_to_name"] : $email["email_to"]);	
			$from = array($email["email_from"] => $email["email_from_name"] ? $email["email_from_name"] : $email["email_from"]);	
			$body = $msg;
			$subject = $sub;
		
			//initialize the mail sending
			switch ($this->vars->data["set_switft_transport"]) {
				case "smtp":
					$transport = Swift_SmtpTransport::newInstance(
						$this->vars->data["set_swiftp_smtp_server"],
						$this->vars->data["set_swiftp_smtp_port"]
					);

					if ($this->vars->data["set_swiftp_smtp_auth"]) {
						$transport->setUsername($this->vars->data["set_swiftp_smtp_auth_username"]);
						$transport->setPassword($this->vars->data["set_swiftp_smtp_auth_password"]);
					}
					
					switch ($this->vars->data["set_swiftp_smtp_enc"]) {
						case "ssl":
							$transport->setEncryption("ssl");
						break;

						case "tls":
							$transport->setEncryption("tls");
						break;
					}
				break;

				case "sendmail":
					$transport = Swift_SmtpTransport::newInstance(
						$this->vars->data["set_swiftp_sendmail"]
					);
				break;
		
				case "php":
					$transport = Swift_SmtpTransport::newInstance();
				break;
			}
			
			
			$message = Swift_Message::newInstance($subject);
			$message->setBody(
				$body , 
				"text/html"
			);

			$message->setTo($recipients);

			$message->setFrom($from);

			$mailer = Swift_Mailer::newInstance($transport);
			$result = $mailer->send($message);

			//$message->setReadReceiptTo('emanuel@oxylus.ro');

			return true;
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
	function Cron() {
		global $_ADMIN;

		if ($_GET["mail_id"] && $_ADMIN) {
			//get the emails list
			$emails = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:mail_queue']} WHERE mail_id = \"{$_GET[mail_id]}\" ORDER BY mail_priority ASC , mail_date DESC "
			);
		} else {
			//get the emails list
			$emails = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:mail_queue']} WHERE mail_date_sent = 0 ORDER BY mail_priority ASC , mail_date DESC "
			);

		}
		 


		if (is_array($emails)) {
			foreach ($emails as $key => $data) {
				$this->module->plugins["mail"]->SendMail(
					array(
						"email_from_name"	=> $data["mail_from_name"],
						"email_from"		=> $data["mail_from_email"],

						"email_to_name"		=> $data["mail_to_name"],
						"email_to"			=> $data["mail_to_email"],

						"email_subject"		=> $data["mail_subject"],
						"email_body"		=> $data["mail_body"],

						"email_type"		=> "html",
					)
				);

				//update email status
				$this->db->QueryUpdate(
					$this->tables["plugin:mail_queue"],
					array(
						"mail_date_sent"	=> time(),
						"mail_status"		=> "1",
					),

					"mail_id={$data[mail_id]}"
				);

				$count ++;
			}
		}

		if ($_GET["returnURL"]) {
			urlredirect($_GET["returnURL"]);
		}
		
		
		echo "Sent {$count} emails...";
		die();
	}
	

}

?>