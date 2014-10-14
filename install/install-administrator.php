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

$error_msg = "Error creating the administrator user. Please contact our support at <a href='mailto:support@oxylustemplates.com'>support@oxylustemplates.com</a> to solve this issue.";

require "lib/validate.php";

$conf = new CConfig($_POST["installData"] , "string" );
$conf_data = $conf->vars["data"];

$link = @mysql_connect (
	$conf_data["mysql"]["server"], 
	$conf_data["mysql"]["username"],
	$conf_data["mysql"]["password"]
);


@mysql_select_db ( $conf_data["mysql"]["database"] );

@mysql_query("INSERT INTO `site_users` (`user_id`, `user_key`, `user_first_name`, `user_last_name`, `user_login`, `user_password`, `user_email`, `user_level`, `user_protect_delete`, `user_protect_edit`, `user_log_last_login`, `user_log_last_ip`, `user_log_create`, `user_log_tries`, `user_log_image_text`, `user_log_status`, `user_contact_phone`, `user_contact_phone2`, `user_contact_phone3`, `user_contact_addr`, `user_contact_city`, `user_contact_state`, `user_contact_zip`, `user_contact_country`, `user_perm`) VALUES
('', '', 'Administrator', '', '" . ($conf_data["admin"]["username"]) . "', '" . md5($conf_data["admin"]["password"]) . "', '" . ($conf_data["admin"]["email"]) . "', 0, 0, 0, " . time() . ", '', 0, 0, '', 0, '', '', '', '', '', '', '', '', '');");

$code = "ok";

SetXMLMime();
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data><status>{$code}</status><message><![CDATA[{$message}]]></message></data>";
?>
