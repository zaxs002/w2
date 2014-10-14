<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2010 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

//$_MODULES["oxymall"]->private->vars->data["set_links_type"] = "1";
// dependencies
global $_GET , $myget;

//$_MODULES["oxymall"]->private->vars->data["set_links_type"] = 1;

if ($_SERVER["REQUEST_URI"]) {
	$_SERVER_URL = $_SERVER["REQUEST_URI"];
} else
	$_SERVER_URL = $_SERVER["REDIRECT_URL"];

//check if the site its hosted in a subdomain
if ($script_path = dirname($_SERVER["SCRIPT_NAME"])) {
	
	if ($script_path != "/") {
		$_SERVER_URL = str_replace(
			$script_path , 
			"", 
			$_SERVER_URL
		);
	}
	
}

if (!$_MODULES["oxymall"]->private->vars->data["set_links_type"]) {
	$_SERVER_URL = str_replace(
		"index.php/" , 
		"",
		$_SERVER_URL
	);
	
} 
//check if the urls its build with index.php

//check for the default configuration for links
if (substr($_SERVER_URL,0,1) == "/") {
	$_SERVER_URL = substr($_SERVER_URL,1);
} 


if (stristr($_SERVER_URL , "index.php")) {
	$_SERVER_URL = str_replace("index.php" , "" , $_SERVER_URL);
}


if (stristr($_SERVER_URL , "?")) {
	$proc = explode("?" , $_SERVER_URL);
	$vars = $proc["1"];
	$_SERVER_URL = $proc[0];

	$vars = @explode("&" , $vars);

	if (count($vars)) {
		foreach ($vars as $key => $val) {
			$var = explode("=" , $val);
			
			$_GET[$var[0]] = urldecode($var[1]);
		}		
	}
	

	
		

}


$tmp = explode("/" , $_SERVER_URL);
$mod_code = trim($tmp[0]);




//fast quick for when the site its in root

if (!$mod_code) {
	//get the first module
	$module = $_MODULES["oxymall"]->plugins["modules"]->GetFirstModuleByCode(true);


	if (!$_MODULES["oxymall"]->private->vars->data["set_links_type"]) {
		$_SERVER_URL = $module["mod_url"] . "/";
		
	} else {
		$_SERVER_URL = "/" . $module["mod_url"] . "/";
	}
} else {


	//get the detected module
	$module = $_MODULES["oxymall"]->plugins["modules"]->GetModuleByCode($mod_code , true);
	
}

if (is_array($module)) {

	//process the cuustom url
	$_GET["module_id"] = $module["mod_id"];
}
//load the redirects path


$redirects = file("local/redirects.txt");

//change the redirect tabs with space
if (is_array($redirects)) {
	foreach ($redirects as $key => $val) {
		$redirects[$key] = str_replace("\t" , " " , $val);
	}	
}

//change the modules code in the rules
if (is_array($redirects)) {
	foreach ($redirects as $key => $val) {
		if (trim($val)) {
			//echo "__" . $module["mod_module_code"] . "_module__" ;
			$rules[] = str_replace(
				"__" . $module["mod_module_code"] . "_module__" , 
				$module["mod_url"],
				trim($val)
			);
		}
	}
	
	
	if (is_array($rules)) {

		//this script its killing the global $_GET
		$htaccess = new HTAccess ($_GET);
		foreach ($rules as $key => $val) {
			$htaccess->setLine($val);				
		}
	}

	//process the link and extra variables
	
	if (!$_MODULES["oxymall"]->private->vars->data["set_links_type"]) {
		$link = str_replace("index.php/" , "" , $_SERVER_URL);
	} else  {
		$link = $_SERVER_URL;
	}

	if (substr($link,0,1) == "/") {
		$link = substr($link,1);
	}


	if (strstr($link , "?")) {
		$link = explode("?" , $link );
		$vars = explode("&" , $link["1"]);
		$link = $link[0];
		
		foreach ($vars as $key => $val) {
			$tmp = explode("=" , $val );
			if (!$_GET[trim($tmp[0])])
				$_GET[trim($tmp[0])] = ($tmp[1]);
		}								
	}			


	$htaccess->execute($link);

	if ($_GET["_PAGE"]) {
		global $_PAGE;
		$_PAGE = $_GET["_PAGE"];
	}			
	
	if ($_GET["sub"]) {
			header("HTTP/1.1 200 OK");
	}
}

//check if the scriptname its php


if ($_GET["mod"] == "detect-redirect") {
	$_MODULES["oxymall"]->plugins["modules"]->Redirect404();
}	


?>