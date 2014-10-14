<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: debug.php,v 0.0.1 28/08/2005 18:03:00 Emanuel Exp $
	description debugging functions
*/

// dependencies


/**
* description
*
* @param
*
* @return
*
* @access
*/
function PrintR($array , $die = false) {
	echo "<table><tr><td><pre style=\"background-color:white\">";
	print_r($array);
	echo "</pre></td></tr></table>";

	if ($die)
		die();
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
function Debug($array , $die = false) {
	if ($_SERVER["REMOTE_ADDR"] != "127.0.0.1") {
//		return "";
	}
	
	PrintR($array , $die);
}




?>