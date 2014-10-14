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

$error_msg = "";


require "lib/validate.php";


$conf = new CConfig($_POST["installData"] , "string" );
$conf_data = $conf->vars["data"];

if (is_Array($_CONF["skins-files"]["file"])) {
	foreach ($_CONF["skins-files"]["file"] as $key => $val) {
		copy(
			"skins-files/" . $val , 
			"../upload/" . $val
		);

		@chmod(
			"../upload/" . $val,
			0777
		);
	}
	
}

$code = "ok";

SetXMLMime();
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data><status>{$code}</status><message><![CDATA[{$message}]]></message></data>";
?>
