<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

*/



	$_TSM["PRIV.BASE.HREF"] = 	
			dirname((strtoupper($_SERVER["HTTPS"]) == "on" ? "https://" :  "http://") . 
			$_SERVER["HTTP_HOST"] . 
			($_SERVER["SERVER_PORT"] != 80 ? ':' . $_SERVER["SERVER_PORT"] : '') .
			$_SERVER["SCRIPT_NAME"] ) . "/";	

	$_CONF["url"] = str_replace("admin/" , "" , $_TSM["PRIV.BASE.HREF"]);; 
	
?>