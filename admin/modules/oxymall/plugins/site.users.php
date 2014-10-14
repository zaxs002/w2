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


			$sub = str_replace("oxymall.plugin.users." , "" , $_GET["sub"]);

			$this->__init();
			$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("users");

			switch ($sub) {				
				case "signin":
					return $this->box_signin();
				break;

				case "register":
					return $this->box_register();
				break;

				case "recover":
					return $this->box_recover();
				break;

				case "logout":
					return $this->logout();
				break;

				//new modules


				case "confirm":
					return $this->confirm_account();
				break;

				case "recover-password":
					return $this->Recover_Password();
				break;



				case "ajax.login":
					return $this->ajax_login();
				break;

				case "ajax.login-facebook":
					return $this->ajax_login_facebook();
				break;

				case "ajax.recover":
					return $this->ajax_recover_password();
				break;

				case "ajax.register":
					return $this->ajax_register();
				break;

				case "ajax.register-facebook":
					return $this->ajax_register_facebook();
				break;

				case "dashboard":
					urlredirect($this->module->plugins["modules"]->PrepareLink("account/profile/"));
				break;


				case "profile":
					$this->__check_session();
					return $this->Profile();
				break;

				case "ajax.account-profile":
					return $this->ajax_update_profile();
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

			"summary"		=> "summary.htm",
			"login"			=> "login.htm",
			"register"		=> "register.htm",
			"recover"		=> "recover.htm",
			"user-menu"		=> "user-menu.htm",





			"page"			=> "page.htm",
			"profile"		=> "profile.htm",

			"account"		=> "account.xml",

		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}

		$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("users");

	}

	function __autologin() {
		global $_SESS;

		$this->__init();

		if (!$_SESS["client"]["user_id"]) {

			if ($_COOKIE["autologin"]) {
				
				$user = $this->db->QFEtchArray(
					"SELECT * FROM {$this->tables['plugin:users']} WHERE user_email='{$_COOKIE[username]}' AND user_status=2"
				);

				if (is_Array($user) && ($_COOKIE["keycode"] == md5($user["user_email"] . $user["user_password"]))) {
					$_SESS["client"] = $user;
				}			
			} else {

				//mabe i have the data in my facebook cookie
				if ($this->tpl_module["settings"]["set_register_type"] == "2") {

					$facebook = new Facebook(array(
					  'appId'  => $this->vars->data["set_facebook_app"],
					  'secret' => $this->vars->data["set_facebook_secret"],
					));

					if ($user = $facebook->getUser()) {
						$user_data = $this->db->QFEtchArray(
							"SELECT * FROM {$this->tables['plugin:users']} WHERE user_fbid='{$user}' AND user_status=2"
						);
					}
					

					//$session = 	$facebook->api('/me');

					//debug($session,1);

					



					if (is_array($user_data)) {
						$_SESS["client"] = $user_data;
					} else {
						//do nothing, i the user is suspended from admin
					}
				}
			}
				
		} else {

			//if user not here means it was banned from admin panel

			//update the user_Account
			$user = $this->db->QFEtchArray(
				"SELECT * FROM {$this->tables['plugin:users']} WHERE user_id='{$_SESS[client][user_id]}' AND user_status=2"
			);

			if (!is_array($user)) {
				unset($_SESS["client"]);
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
	function __check_session($r = "") {
		global $_SESS;

		if (!is_array($_SESS["client"])) {
			urlredirect($this->module->plugins["modules"]->PrepareLink("account/signin/") . ($r ? "?r=" . urlencode($r) : ""));
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
	function ActionLinks() {
		return array(
			"link:login"			=> $this->module->plugins["modules"]->PrepareLink("account/signin/") . ($_GET["r"] ? "?r=" . urlencode($_GET["r"]) : ""),
			"link:register"			=> $this->module->plugins["modules"]->PrepareLink("account/signup/") . ($_GET["r"] ? "?r=" . urlencode($_GET["r"]) : ""),
			"link:recover"			=> $this->module->plugins["modules"]->PrepareLink("account/recover/") . ($_GET["r"] ? "?r=" . urlencode($_GET["r"]) : ""),
			"link:logout"			=> $this->module->plugins["modules"]->PrepareLink("account/logout/"),
			"link:account"			=> $this->module->plugins["modules"]->PrepareLink("account/dashboard/"),
			"link:profile"			=> $this->module->plugins["modules"]->PrepareLink("account/profile/"),
			"link:profile-shop"		=> $this->module->plugins["modules"]->PrepareLink("account/profile-shop/"),
			"link:profile-history"	=> $this->module->plugins["modules"]->PrepareLink("account/history/"),
		);
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
	function Summary() {
		global $_SESS , $_CONF;

		$this->__init();

		if (!$this->tpl_module["module_unique_enabled"]) {
			return "";
		}

		if ($this->tpl_module["settings"]["set_register_type"] == "2") {
			$facebook = new Facebook(array(
			  'appId'  => $this->vars->data["set_facebook_app"],
			  'secret' => $this->vars->data["set_facebook_secret"],
			));

			$user = $facebook->getUser();

		}

		if (is_array($_SESS["client"])) {
			$return = $this->private->templates["summary"]->BlockReplace(
				"User" , 
				array_merge(
					$_SESS["client"],
					$this->tpl_module["settings"]
				)
			);
		} else {

			if ($facebook) {
				$return = CTemplateStatic::Replace(
					$this->private->templates["summary"]->blockReplace(
						"NoUserFacebook",
						array_merge(
							$this->tpl_module["settings"],
							array(
								"fb_login" => htmlspecialchars($facebook->getLoginUrl(
										array(
											"redirect_uri"		=> $_CONF["url"] . "ajax.users-login-facebook.php",
											"scope"				=> $this->tpl_module["settings"]["set_facebook_scope"]
										)
									)
								)
							)
						)
					)
				);
			} else {			

				$return = CTemplateStatic::Replace(
					$this->private->templates["summary"]->blockReplace(
						"NoUser",
						$this->tpl_module["settings"]
					)
				);
			}
		}

		return CTemplateStatic::Replace(
			$return , 
			$this->ActionLinks()
		);
		
	}

	function checkLoggedIn() {
		global $_SESS , $_CONF;

		if (is_array($_SESS["client"])) {
			urlredirect($_CONF["url"]);
		}		
	}
	
	
	function box_signin() {
		$this->checkLoggedIn();

		if ($this->tpl_module["settings"]["set_register_type"] == "2") {

			$facebook = new Facebook(array(
			  'appId'  => $this->vars->data["set_facebook_app"],
			  'secret' => $this->vars->data["set_facebook_secret"],
			));

			$facebook_html = $this->private->templates["login"]->blockReplace(
				"Fb" , 
				array(
					"fb_login" =>	$facebook->getLoginUrl(
						array(
							"redirect_uri"		=> $_CONF["url"] . "ajax.users-login-facebook.php",
							"scope"				=> $this->tpl_module["settings"]["set_facebook_scope"]
						)
					)
				)
			);
		}
		
				
		
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		$return = CTemplateStatic::Replace(
			$this->private->templates["login"]->blockReplace(
				"Main",
				array_merge(
					$this->tpl_module["settings"],
					array(
						"facebook_login" => $facebook_html					
					)
				)
			),
			array(
				"r"	=> $_GET["r"]
			)
		);



		return $this->texts($return);

	}
	
	function box_register() {
		global $base , $_CONF;

		$this->checkLoggedIn();
		
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		//get all countries 
		$countries = $this->db->QFetchRowArray("SELECT * FROM {$this->tables['plugin:users_countries']} ORDER BY item_title ASC");

		if (is_array($countries)) {
			foreach ($countries as $key => $val) {
				$_countries[] = "'{$val[item_iso]}':'{$val[item_title]}'";
			}
			
		}
		

		switch ($this->tpl_module["settings"]["set_register_type"]) {
			//temporary disabled
			case "_2":
				return $this->Texts(
					$this->private->templates["register"]->blockReplace(
						"Facebook",
						array(
							"redirect_uri_enc"	=> urlencode($_CONF["url"] . "ajax.users-register-facebook.php"),
							"redirect_uri"		=> ($_CONF["url"] . "ajax.users-register-facebook.php"),

							"fields"			=> CTemplateStatic::Replace(
								(stripslashes(stripslashes($this->tpl_module["settings"]["set_facebook_extra_fields"]))),
								array(
									"countries"	=> @implode(',' , $_countries),
								)
							),

						)
					)
				);
			break;

			default:	

				//local registration

				$return = $this->private->templates["register"]->blockReplace(
					"Main",
					$this->tpl_module["settings"]
				);

				return CTemplateStatic::Replace(
					$return , 
					$this->ActionLinks()
				);

			break;
		}
		


	}
	
	function box_recover() {
		$this->checkLoggedIn();
		
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		$return = $this->private->templates["recover"]->blockReplace(
			"Main",
			$this->tpl_module["settings"]
		);

		return CTemplateStatic::Replace(
			$return , 
			$this->ActionLinks()
		);

	}













	function Recover_Password() {
		global $_CONF;

		$user = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:users']} WHERE user_key_code=\"{$_GET[key]}\" AND user_key_date <= " . (time() + 3600 * 48 )
		);



		if (!is_array($user)) {
			$this->module->plugins["modules"]->RedirectToModule(
				$this->tpl_module["settings"]["set_page_recover_invalid"]
			);
		}
		

		//update the password

		$user["user_password"] = RandomWord(5);


		$this->db->QueryUpdate(
			$this->tables['plugin:users'] , 
			array(
				"user_password"		=> md5($user["user_password"]),
				"user_key_date"		=> "0",
				"user_key_code"		=> "",

			) ,
			"user_id={$user[user_id]}"
		);


		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_forgot_new"],
				$user
			)
		);			


		$this->module->plugins["modules"]->RedirectToModule(
			$this->tpl_module["settings"]["set_page_recover"]
		);
	}

	function ajax_recover_password() {
		global $_SESS;

		if(!$_POST["email"]){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_recover_notvalidemailalert"]
			);
		}

		$user = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:users']} WHERE user_email=\"{$_POST[email]}\"");

		if(!is_array($user)){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_recover_notvalidemailalert"]
			);
		}

		$key = md5($_POST["email"] . time());
		$user["user_key_code"] = $key;

		$this->db->QueryUpdate(
			$this->tables["plugin:users"],
			array(				
				"user_key_date"	=> time(),
				"user_key_code"		=> $key,
			),
			"user_id={$user[user_id]}"
		);

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_forgot_link"],
				$user
			)
		);			

		return  $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_recover_successalert"]
		);

	}

	function ajax_register() {
		global $_CONF , $_SESS;


		if(!$_POST["first_name"]){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_namealert"]
			);
		}

		if(!$_POST["last_name"]){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_namealert"]
			);
		}

		if(!$_POST["email"]){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_usernamealert"]
			);
		}

		if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST["email"])){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_notvalidemailalert"]
			);
		}

		if($_POST["email"] != $_POST["confirm_email"]){
			return $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_emailsalert"]
			);
		}

		//check if users already exists
		$user = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:users']} WHERE user_email=\"{$_POST[email]}\"");

		if(is_array($user)){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_existsalert"]
			);
		}

		if(!$_POST["password"]){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_passwordalert"]
			);
		}
		
		if($_POST["password"] != $_POST["confirm_password"]){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_wrongpasswordsalert"]
			);
		}


		if(!$_POST["tos"]){
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_register_tosalert"]
			);
		}

		//generate the user record
		$user = array(
			"user_email"			=> $_POST["email"],
			"user_email_original"	=> $_POST["email"],
			"user_first_name"		=> $_POST["first_name"],
			"user_last_name"		=> $_POST["last_name"],

			"user_password"			=> md5($_POST["password"]),
			
			//store this for password
			"user_password_plain"	=> $_POST["password"],

			"user_date"				=> time(),
			"user_key"				=> md5($_POST["email"] . time()),
			"user_key_code"			=> md5($_POST["email"] . time()),
			"user_key_date"			=> time(),

			"user_status"			=> $this->tpl_module["settings"]["set_default_status"],

			"user_groups"			=> $this->tpl_module["settings"]["set_default_group"],

			//store address
			"user_address"		=> $_POST["user_address_1"],
			"user_address_2"		=> $_POST["user_address_2"],
			"user_city"				=> $_POST["user_city"],
			"user_state"			=> $_POST["user_state"],
			"user_zip"				=> $_POST["user_zip"],
			"user_phone"			=> $_POST["user_phone"],

			//save data
			"user_register_ip"		=> $_SERVER["REMOTE_ADDR"],

		);

		//check if user is banned
		if ($this->isBanned($user , false)) {
		}
		

		//generate the keycode for this user
		$id = $this->db->QueryInsert(
			$this->tables["plugin:users"],
			$user
		);

		//$this->db->Query("delete from {$this->tables['plugin:users']} where user_id={$id}");

		//make the list of emails to be sent
		switch ($this->tpl_module["settings"]["set_default_status"]) {
			//inactive
			case "1":
				$email = "set_mail_confirm";
			break;

			//active
			case "2":
				$email = "set_mail_welcome";
			break;

			case "3":
				$email = "set_mail_pending";
			break;
		}

		//send the mail 


		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"][$email],
				$user
			)
		);

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_admin"],
				$user
			)
		);

		return  $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_register_successalert"]
		);
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
	function ajax_register_facebook() {
		global $_SESS;

		$facebook = new Facebook(array(
		  'appId'  => $this->vars->data["set_facebook_app"],
		  'secret' => $this->vars->data["set_facebook_secret"],
		));

		$data = $facebook->getSignedRequest();

		if (is_array($data["registration"])) {

			//check if i have this user already registered 

			$user = $this->db->QFetchArray(
				"
				SELECT * FROM 
					{$this->tables['plugin:users']}
				WHERE 
					user_email='{$data[registration][email]}'

				"
			);

			$name = explode(" " , $data["registration"]["name"]);
			$first_name = $name[0];
			unset($name[0]);
			$last_name = @implode(" " , $name);


			if (is_array($user)) {
				
				$this->db->QueryUpdate(
					$this->tables['plugin:users'],
					array(
						"user_fbid"			=> $data["user_id"],
						"user_status"		=> $user["user_status"] < 2 ? 2 : $user["user_status"],
						"user_first_name"	=> $user["user_first_name"] ? $user["user_first_name"] : $first_name,
						"user_last_name"	=> $user["user_last_name"] ? $user["user_last_name"] : $last_name,
						"user_city"			=> $user["user_city"] ? $user["user_city"] : $data["registration"]["city"],
						"user_state"		=> $user["user_state"] ? $user["user_state"] : $data["registration"]["state"],
						"user_zip"			=> $user["user_zip"] ? $user["user_zip"] : $data["registration"]["zip"],
						"user_country"		=> $user["user_country"] ? $user["user_country"] : strtoupper($data["registration"]["country"]),
						"user_address"		=> $user["user_address"] ? $user["user_address"] : $data["registration"]["address"],
						"user_gender"		=> $user["user_gender"] ? $user["user_gender"] : $data["registration"]["gender"],
						"user_bday"			=> $user["user_bday"] ? $user["user_bday"] : $data["registration"]["birthday"],
					),
					"user_email='{$data[registration][email]}'"
				);

				$user = $this->db->QFetchArray(
					"
					SELECT * FROM 
						{$this->tables['plugin:users']}
					WHERE 
						user_email='{$data[registration][email]}'

					"
				);

			} else {

				$id = $this->db->QueryInsert(
					$this->tables['plugin:users'],
					array(
						"user_fbid"			=> $data["user_id"],
						"user_status"		=> "2",
						"user_first_name"	=> $first_name,
						"user_last_name"	=> $last_name,
						"user_city"			=> $data["registration"]["city"],
						"user_state"		=> $data["registration"]["state"],
						"user_zip"			=> $data["registration"]["zip"],
						"user_country"		=> strtoupper($data["registration"]["country"]),
						"user_address"		=> $data["registration"]["address"],
						"user_gender"		=> $data["registration"]["gender"],
						"user_bday"			=> $data["registration"]["birthday"],

						"user_date"			=> time(),


						"user_password"		=> md5($data["registration"]["password"]),
						
						//store this for password
						"user_password_plain"	=> $data["registration"]["password"],

						"user_date"			=> time(),
						"user_key"			=> md5($data["registration"]["email"] . time()),
						"user_key_code"		=> md5($data["registration"]["email"] . time()),
						"user_key_date"		=> time(),

						"user_email"		=> $data["registration"]["email"],
						"user_groups"		=> $this->tpl_module["settings"]["set_default_group_facebook"],
					)
				);


				$user = $this->db->QFetchArray(
					"
					SELECT * FROM 
						{$this->tables['plugin:users']}
					WHERE 
						user_email='{$data[registration][email]}'
					"
				);


			}
			

			$email = $this->module->plugins["mail"]->SendMail(
				$this->module->plugins["mail"]->GetMail(
					$this->tpl_module["settings"]["set_mail_welcome_facebook"],
					$user
				)
			);			


			//force login 
			$_SESS["client"] = $user;


		}		

		$this->module->plugins["modules"]->RedirectToModule(
			$this->tpl_module["settings"]["set_page_facebook"]
		);
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
	function ajax_register_facebook_summary() {
		global $_CONF , $_SESS;

		$facebook = new Facebook(array(
		  'appId'  => $this->vars->data["set_facebook_app"],
		  'secret' => $this->vars->data["set_facebook_secret"],
		));

	    $user_profile = $facebook->api('/me');

		//check fo see if i have an user with this email 

		$local_user = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:users']} WHERE user_email='{$user_profile[email]}'"
		);

		if (is_array($local_user)) {
				$this->db->QueryUpdate(
					$this->tables['plugin:users'],
					$new_user = array(
						"user_fbid"			=> $user_profile["id"],
						"user_status"		=> $local_user["user_status"] < 2 ? 2 : $local_user["user_status"],
						"user_first_name"	=> $user_profile["first_name"],
						"user_last_name"	=> $user_profile["last_name"],

						"user_gender"		=> $user_profile["gender"],
						"user_bday"			=> $user_profile["birthday"],
					),
					"user_email='{$user_profile[email]}'"
				);

				$user = array_merge(
					$local_user , 
					$new_user
				);

		} else {
				$id = $this->db->QueryInsert(
					$this->tables['plugin:users'],
					$user = array(
						"user_fbid"			=> $user_profile["id"],
						"user_status"		=> "2",
						"user_first_name"	=> $user_profile["first_name"],
						"user_last_name"	=> $user_profile["last_name"],

						"user_gender"		=> $user_profile["gender"],

						"user_bday"			=> $user_profile["birthday"],

						"user_date"			=> time(),
						"user_key"			=> md5($user_profile["email"] . time()),
						"user_key_code"		=> md5($user_profile["email"] . time()),
						"user_key_date"		=> time(),

						"user_email"		=> $user_profile["email"],
						"user_groups"		=> $this->tpl_module["settings"]["set_default_group_facebook"],
					)
				);

				
				//send the mail to thanks for loging in 
				$email = $this->module->plugins["mail"]->SendMail(
					$this->module->plugins["mail"]->GetMail(
						$this->tpl_module["settings"]["set_mail_welcome_facebook"],
						$user
					)
				);	

				//force login 
				$_SESS["client"] = $this->GetUserById($id);

				//redirect to welcome page for facebook
				$this->module->plugins["modules"]->RedirectToModule(
					$this->tpl_module["settings"]["set_page_facebook"]
				);
		}
		
		//force login 
		$_SESS["client"] = $user;

		urlredirect($_CONF["url"]);
	}
	
	
	
	function confirm_account() {
		global $_CONF , $_SESS;

		if (!$_GET["key"]) {
			$this->module->plugins["modules"]->RedirectToModule(
				$this->tpl_module["settings"]["set_page_confirmed_invalid"]
			);
		}

		//check the key
		$user = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:users']} WHERE user_key_code=\"{$_GET[key]}\" and user_status=1");

		if (!is_array($user)) {
			$this->module->plugins["modules"]->RedirectToModule(
				$this->tpl_module["settings"]["set_page_confirmed_invalid"]
			);
		}
		
		//update the status

		$this->db->QueryUpdate(
			$this->tables['plugin:users'],
			array(
				"user_status"	=> $this->tpl_module["settings"]["set_default_confirm_status"]
			),
			"user_id={$user[user_id]}"
		);


		//make the list of emails to be sent
		switch ($this->tpl_module["settings"]["set_default_confirm_status"]) {
			//active
			case "2":
				$email = "set_mail_welcome";
			break;

			case "3":
				$email = "set_mail_pendings";
			break;
		}

		//send the mail 

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"][$email],
				$user
			)
		);


		//if user doesnt need admin confirmation then autologin
		if ($this->tpl_module["settings"]["set_default_confirm_status"] == "2") {
			$_SESS["client"] = $user;	
		}

		//save the user in session, to autologin him
		$this->module->plugins["modules"]->RedirectToModule(
			$this->tpl_module["settings"]["set_page_confirmed"]
		);
	}
		

	function ajax_login() {
		global $_CONF , $_SESS;

		//check for username
		if (!$_POST["email"]) {
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_login_useremailalert"]
			);
		}

		//check for password
		if (!$_POST["password"]) {
			return $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_login_passwordalert"]
			);
		}

		//download the user
		$user = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:users']} WHERE user_email=\"{$_POST[email]}\"");

		//check for user
		if (!is_array($user)) {
			return $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_login_wronginfoalert"]
			);
		}

		if (!$user["user_password"]) {
			return $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_login_facebook"]
			);
		}
		
		
		//check for password
		if (md5($_POST["password"])!= $user["user_password"]) {
			return $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_login_wronginfoalert"]
			);
		}
		
		//check if the user is suspended
		if ($user["user_status"] == 4) {
			return $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_login_usersuspendedalert"]
			);
		}

		//check if i can login if account isnt confirmed
		if (($user["user_status"] == 1) && !stristr($this->tpl_module["settings"]["set_login"] , 1)) {
			return $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_login_usernotconfirmedalert"]
			);
		}

		//check if the user is trying to login from a banned domain
		if ($this->isBanned($user)) {
			///not implemented in simple version
		}

		//save the access ip
		if (is_array($acc = $this->db->QFetchArray("SELECT * FROM {$this->tables['plugin:users_access']} WHERE access_user={$user[user_id]} AND access_ip='{$_SERVER[REMOTE_ADDR]}'"))) {
			//update last access to current date
			$this->db->QueryUpdate(
				$this->tables['plugin:users_access'],
				array(
					"access_last"	=> time(),
					"access_times"	=> $acc["access_times"]  + 1
				),
				"access_id={$acc[access_id]}"
			);
		} else {
			//save a new ip for this user
			$this->db->QueryInsert(
				$this->tables['plugin:users_access'],
				array(	
					"access_user"	=> $user["user_id"],
					"access_ip"		=> $_SERVER["REMOTE_ADDR"],
					"access_last"	=> time(),
					"access_times"	=> 1,
				)
			);
		}


		//check if i have the autoremember
		if ($_POST["remember"]) {
			$time = time()+3600 *24 * 3600 ; // one year ahead
			setcookie("autologin", "true", $time , "/");  
			setcookie("username", $user["user_email"], $time , "/");  
			setcookie("keycode" , md5($user["user_email"] . $client["user_password"]) , $time , "/");
		}
		
		//save the user in session
		$_SESS["client"] = $user;

		$this->UpdateSession($user);
	

		return $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_login_correctloginalert"],
			$_POST["r"] ? $this->module->plugins["modules"]->PrepareLink($_POST["r"]) : $_CONF["url"]
		);
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
	function ajax_login_facebook() {
		global $_SESS , $_CONF;


		$facebook = new Facebook(array(
		  'appId'  => $this->vars->data["set_facebook_app"],
		  'secret' => $this->vars->data["set_facebook_secret"],
		));

		$user = $facebook->getUser();

		$_SESS["facebook"] = array(
			"state"			=> $_SESSION["fb_" . $this->vars->data["set_facebook_app"] . "_state"],
			"code"			=> $_SESSION["fb_" . $this->vars->data["set_facebook_app"] . "_code"],
			"user"			=> $_SESSION["fb_" . $this->vars->data["set_facebook_app"] . "_user_id"], 
			"access_token"	=> $_SESSION["fb_" . $this->vars->data["set_facebook_app"] . "_access_token"],
		);

		if ($user) {
			$user_data = $this->db->QFetchArray(
				"SELECT * FROM {$this->tables['plugin:users']} WHERE user_fbid='{$user}'"
			);

			if (is_array($user_data)) {
				$_SESS["client"] = $user_data;
			} else {
				$this->ajax_register_facebook_summary();
			}
		}
	
		//redirect to homepage
		urlredirect($_CONF["url"]);

	}
	


	function ajax_update_profile() {
		global $_SESS;

		if (!$_SESS["client"]["user_id"]) {
			return $this->module->plugins["common"]->SuccessMsg(
				"",
				$this->module->plugins["modules"]->PrepareLink("signin/")
			);
		}

		$fields = array(
			"user_first_name",
			"user_last_name",
		);


		if ($_SERVER["REQUEST_METHOD"] != "POST") {
			return "invalid request";
		}		

		if (!$_POST["user_first_name"]) {
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_account_firstalert"]
			);
		}
		
		if (!$_POST["user_last_name"]) {
			return  $this->module->plugins["common"]->ErrorMsg(
				$this->tpl_module["settings"]["set_account_lastalert"]
			);
		}

		if ($_POST["user_password_new"]) {
			$new_data["user_password_plain"] = $_POST["user_password_new"];
			$new_data["user_password"] = md5($_POST["user_password_new"]);

			//check if current password its exact 
			if ($_SESS["client"]["user_password"]) {
				if (md5($_POST["user_password"]) != $_SESS["client"]["user_password"]) {
					return  $this->module->plugins["common"]->ErrorMsg(
						$this->tpl_module["settings"]["set_account_currentpasswordalert"]
					);
				}			
			}
			

			//check the new pass against confirmation
			if ($_POST["user_password_new"] != $_POST["user_password_confirm"]) {
				return  $this->module->plugins["common"]->ErrorMsg(
					$this->tpl_module["settings"]["set_account_wrongnewpasswordalert"]
				);
			}
			
		}

		//prepare the update field
		foreach ($fields as $key => $val) {
			$new_data[$val] = $_POST[$val];
		}
			
		$this->db->QueryUpdate(
			$this->tables['plugin:users'],
			$new_data,
			"user_id=" . $_SESS["client"]["user_id"]
		);

		$this->UpdateSession();

		return  $this->module->plugins["common"]->SuccessMsg(			
			$this->tpl_module["settings"]["set_account_successalert"]
		);

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
	function isBanned($user , $login = true) {
		//works in extended version only
		return false;
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
	function GetUserById($id) {
		$user = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:users']} WHERE user_id={$id}"
		);

		return $user;
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
	function UpdateUserById($id , $data) {

		if (!is_array($data)) {
			return false;
		}
		
		$this->db->QueryUpdate(
			$this->tables['plugin:users'],
			$data,
			"user_id={$id}"
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
	function Logout() {
		global $_SESS, $_CONF;

		unset($_SESS["client"]);

		//remove the rememberme cookie cookies
		$time = time()-3600 *24 ; // one year ahead
		setcookie("autologin", "", $time , "/");  
		setcookie("username", "", $time , "/");  
		setcookie("keycode" , "" , $time , "/");


		if ($this->tpl_module["settings"]["set_register_type"] == "2") {
			$facebook = new Facebook(array(
			  'appId'  => $this->vars->data["set_facebook_app"],
			  'secret' => $this->vars->data["set_facebook_secret"],
			));

			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');

				urlredirect($facebook->getLogoutUrl(
					array(
						"next"	=> $_CONF["url"]
					)
				));

			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;

				urlredirect($_CONF["url"]);

			}

		} else {
			urlredirect($_CONF["url"]);
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
	function Profile() {
		global $_SESS;

		$data = $_SESS["client"];

		$return  = CTemplateStatic::ReplacE(
			$this->private->templates["profile"]->blockreplace(
				"User",
				$data
			),
			array(
				"shop_menu"	=> $this->module->plugins["shop"]->UserMenu(),
				"user_menu"	=> $this->module->plugins["users"]->UserMenu("1"),
				
			)
		);

		return $this->Texts(
			$return
		);
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
	function Texts($content) {
		$this->__init();

		return CTemplateStatic::Replace(
			$content ,

			array_merge(
				$this->tpl_module["settings"],
				$this->ActionLinks()
			)
		);
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
	function UpdateSession($client = array()) {
		global $_SESS;

		if (!$_SESS["client"]) {
			return "";
		}
				

		if (!count($client)) {
			//read the user again
			$client = $this->GetUserById($_SESS["client"]["user_id"]);
		}
		


		$fields = array(
			"user_shipping_phone"			=> "order_shipping_phone",
			"user_shipping_country"			=> "order_shipping_country",
			"user_shipping_zip"				=> "order_shipping_zip",
			"user_shipping_state"			=> "order_shipping_state",
			"user_shipping_city"			=> "order_shipping_city",
			"user_shipping_address_1"		=> "order_shipping_address_1",
			"user_shipping_address_2"		=> "order_shipping_address_2",
			"user_shipping_last_name"		=> "order_shipping_last_name",
			"user_shipping_first_name"		=> "order_shipping_first_name",
			"user_billing_phone"			=> "order_billing_phone",
			"user_billing_country"			=> "order_billing_country",
			"user_billing_zip"				=> "order_billing_zip",
			"user_billing_state"			=> "order_billing_state",
			"user_billing_city"				=> "order_billing_city",
			"user_billing_address_1"		=> "order_billing_address_1",
			"user_billing_address_2"		=> "order_billing_address_2",
			"user_billing_last_name"		=> "order_billing_last_name",
			"user_billing_first_name"		=> "order_billing_first_name",
		);

		foreach ($fields as $key => $val) {
			$_SESS["checkout"]["billing"][$val] = $client[$key];
		}


		$_SESS["client"] = $client;
		
	}
	

	function UserMenu($selected = "") {
		$this->__init();

		return $this->texts(
			$this->private->templates["user-menu"]->BlockReplace(
				"Menu",
				array(
					"selected_1"	=> $selected == "1" ? "selected" : "",
				)
			)
		);
			
	}
	
	
	
}

?>