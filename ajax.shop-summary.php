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

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$_GET["_PAGE"] = "ajax";
$_GET["mod"] = "oxymall";
$_GET["sub"] = "oxymall.plugin.shop.ajax.summary";

require "oxybase.php";
?>