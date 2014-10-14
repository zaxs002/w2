<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies

if (!is_array($_SESS["minibase"])) {
	if ($_COOKIE["autologin"] == "true") {
		//get the default user

		$user = $this->db->QFetchArray("SELECT * FROM site_users WHERE `user_login`='$_COOKIE[username]'");


		if (is_array($user)) {
			if ($_COOKIE["keycode"] == md5($user["user_login"] . $user["user_password"])) {
				$_SESS["minibase"]["raw"] = $user;
				$_SESS["minibase"]["user"] = 1;
			}			
		}
	}
}

?>