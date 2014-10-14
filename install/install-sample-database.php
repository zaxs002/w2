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

$error_msg = "Error importing the sample content database. Please contact our support at <a href='mailto:support@oxylustemplates.com'>support@oxylustemplates.com</a> to solve this issue.<br><br>Errors:<br><br>";

require "lib/validate.php";

$conf = new CConfig($_POST["installData"] , "string" );
$conf_data = $conf->vars["data"];

if ($conf_data["installsamplecontent"]) {

	$code = "ok";

	if (file_exists("database-sample.sql")) {


		$db = new CDatabase(
			array(
				"server"	=> $conf_data["mysql"]["server"],
				"login"	=> $conf_data["mysql"]["username"],
				"password"	=> $conf_data["mysql"]["password"],
				"default"	=> $conf_data["mysql"]["database"]
			) 
		);


		$db_file = file("database-sample.sql");
		$code = "ok";

		foreach ($db_file as $key => $val) {
			if (trim($val)) {
				$result = $db->Query($val);
				if (!$result) {
					$error_msg .= mysql_error($db->conn_id);
					$code = "error";
				}
			}	
		}

		if ($code == "error") {
			$message = $error_msg;
		}


	} 
} else {
		$code = "error";
}


SetXMLMime();
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data><status>{$code}</status><message><![CDATA[{$message}]]></message></data>";
?>