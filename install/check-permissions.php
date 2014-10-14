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

$message_error = "Please set writting permissions to the red folders before continuing!";
$message_success = "";

$errors = array(
	0	=> "<p align=\"center\" class=\"red\">unwritable</p>",
	1	=> "<p align=\"center\" class=\"green\">writable</p>",
	2	=> "<p align=\"center\" class=\"red\">cant create</p>",
);

require "lib/validate.php";

//fix if ther is just one folder
if (!is_array($_CONF["folders"]["check"])) {
	$_CONF["folders"]["check"] = array(
		$_CONF["folders"]["check"]
	);
}

if (!is_array($_CONF["folders"]["create"])) {
	$_CONF["folders"]["create"] = array(
		$_CONF["folders"]["create"]
	);
}



//check the permissions for the check folders
if (is_array($_CONF["folders"]["check"])) {
	foreach ($_CONF["folders"]["check"] as $key => $val) {
		if (is__writable($val)) {
			$folders[$val] = 1;
		} else {
			$folders[$val] = 0;
		}			
	}	
}



if (is_array($_CONF["folders"]["create"])) {
	foreach ($_CONF["folders"]["create"] as $key => $val) {

		if (is_dir($val)) {
			if (is__writable($val)) {
				$folders[$val] = 1;
			} else {
				$folders[$val] = 0;
			}			
		} else {
			if (!@mkdir($val , 0777)) {
				$folders[$val] = 2;
			} else 
				@chmod($val , 0777);
		}
	}	
}

$ok = true;

if (is_array($folders)) {
	foreach ($folders as $key => $val) {
		switch ($val) {
			case 0:
			case 2:
				$ok = false;

			default:
				$content .= "<row type=\"default\" height=\"22\"><cell><![CDATA[<i>{$key}</i>]]></cell><cell width=\"80\"><![CDATA[" . $errors[$val] . "]]></cell></row>";
			break;
		}
	}	
}
	

$xml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data><status>" . ($ok ? "ok" : "error" ) . "</status><message><![CDATA[" . ($ok ? $message_success : $message_error ) ."]]></message><dataGrid width=\"480\" border=\"1\">" . $content . "</dataGrid></data>";

setXmlMime();

echo $xml;

die();

?>