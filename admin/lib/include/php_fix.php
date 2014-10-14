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


## fix for str_ireplace for php 5
if (!function_exists("str_ireplace")) {

	function str_Ireplace($search, $replace, $subject) {

		if (is_array($search)) {
			foreach ($search as $word) {
			$words[] = "/".$word."/i";
			}
		} else {
			$words = "/".$search."/i";
		}
		return preg_replace($words, $replace, $subject);
	}
}
?>