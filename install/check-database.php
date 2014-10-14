<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: check-database.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies

require "lib/validate.php";

$messages = array(
	1	=>	"<span class='red'>Cant connect to server!</span> <br><br>Message returned by server: {MSG}",
	3	=>  "<span class='red'>Database doesnt exists or user doesnt have permissions to access it! </span> <br><br>Message returned by server: {MSG}",
	4	=>  "<span class='red'>Cant read the tables list! </span> <br><br>Message returned by server: {MSG}",
	5	=>  "<span class='red'>The tables bellow are conflicting with the new install. Do you want to delete them, if not please select another database ?</span> <br><br><ul><li>{MSG}</li></ul>",
);

SetXMLMime();

$link = @mysql_connect (
	$_POST["server"] . ( $_POST["port"] !="3306" ?":" . $_POST["port"] : "") , 
	$_POST["username"],
	$_POST["password"]
);

$code = "ok";
if (!$link) {
	$messages[1] = str_replace("{MSG}" , mysql_error() , $messages[1]);
	$message = $messages[1];
	$code = "error";
} else {
	//check the database
	if (!@mysql_select_db ( $_POST["database"] )) {
		$code = "error";
		$messages[3] = str_replace("{MSG}" , mysql_error() , $messages[3]);
		$message = $messages[3];
	} else {

		//check for tables conflict
		if (is_array($_CONF["database"]["table"])) {
			$sql = "SHOW TABLES FROM `{$_POST[database]}`";
			$result = @mysql_query($sql);

			if (!$result) {
				$code = "error";
				$messages[4] = str_replace("{MSG}" , mysql_error() , $messages[4]);
				$message = $messages[4];
			} else {
				while ($row = mysql_fetch_row($result)) {
					$tables[$row[0]] = $row[0];
				}

				$error = false;
				foreach ($_CONF["database"]["table"] as $key => $val) {
					if ($tables[$val]) {
						$error = true;
						$err_tables[] = $val;
					}					
				}

				if ($error) {
					$code = "db";
					$messages[5] = str_replace("{MSG}" , implode("</li><li>" , $err_tables) , $messages[5]);
					$message = $messages[5];
				}
			}
		}		
	}
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data><status>" . ($code ) . "</status><message><![CDATA[{$message}]]></message></data>";
?>