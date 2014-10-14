<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies

/**
* description
*
* @library	
* @author	
* @since	
*/
class CError{
	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function Msg($title , $msg , $kill = 0) {

		echo "<b>$title :</b> $msg";

		if ($kill == 1) {
			die();
		}
		
	}
	
}

?>