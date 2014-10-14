<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss author Exp $
	description
*/

// dependencies



$skin_pre = "after.";
$skin = $_CONF["admin"]["template"]["tpl"];


if (!$_GET["mod"] && $_USER) {
	
	$_TSM["PB_EVENTS"] = $_MODULES["oxymall"]->plugins["modules"]->DashBoard();
}

include_once("skin/iceBlue/local/after.capcha.php" );
include_once("skin/iceBlue/local/after.logo.php" );
include_once("skin/iceBlue/local/after.welcome.php" );

?>