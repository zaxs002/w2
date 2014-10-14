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

$error_msg = "Error importing the database. Please contact our support at <a href='mailto:support@oxylustemplates.com'>support@oxylustemplates.com</a> to solve this issue.<br><br>Errors:<br><br>";

require "lib/validate.php";

$conf = new CConfig($_POST["installData"] , "string" );
$conf_data = $conf->vars["data"];

$db = new CDatabase(
	array(
		"server"	=> $conf_data["mysql"]["server"],
		"login"		=> $conf_data["mysql"]["username"],
		"password"	=> $conf_data["mysql"]["password"],
		"default"	=> $conf_data["mysql"]["database"]
	) 
);

$db->Query("DROP TABLE IF EXISTS " . implode("," , $_CONF["database"]["table"]));


$db_file = file("database.sql");
$code = "ok";

foreach ($db_file as $key => $val) {

	$val = trim($val);

	if (substr($val, -1) == ";") {

		$last .= $val;

		$result = $db->Query($last);
		//echo "Q: {$last} \n";
		if (!$result) {
			$error_msg .= $last . " " . mysql_error($db->conn_id);
			$code = "error";
		}

		$last = "";

	} else {
		$last .= $val;
	}

}


if ($code == "error") {
	$message = $error_msg;
}

SetXMLMime();
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data><status>{$code}</status><message><![CDATA[{$message}]]></message></data>";
?>