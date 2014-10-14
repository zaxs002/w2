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
//error_reporting(0);

error_reporting(0);

//error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE);


if (file_exists("../upload/conf/database.php")) {
	die("Site already installed. If you want to start another install please delete the upload/conf/database.php file.");
}

@ini_set("allow_call_time_pass_reference" , "1");

require_once "lib/database.php";
require_once "lib/common.php";
require_once "lib/config.php";

function SetXMLMime() {
	header("Content-Type:text/xml");
}


$conf = new CConfig("config.xml");
$_CONF = $conf->vars["install"];

function is__writable($path) {
	//will work in despite of Windows ACLs bug
	//NOTE: use a trailing slash for folders!!!
	//see http://bugs.php.net/bug.php?id=27609
	//see http://bugs.php.net/bug.php?id=30931


    if (is_dir($path))
        return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
}
?>