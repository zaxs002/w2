<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2010 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

//check if the site was installed
if (!file_exists("upload/conf/database.php")) {
	header("Location: install/");
	exit();
}


// dependencies
$_GET["mod"] = "detect-redirect";
require "oxybase.php";
?>