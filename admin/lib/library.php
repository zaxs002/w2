<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: library.php,v 0.0.1 09/03/2003 20:38:15 Exp $
	Abstract Library Class

	contact:
		www.oxylus.ro
		office@oxylus.ro

* @library	Abstract Library Class
* @author	OXYLUS [OXYLUS.ro <devel@oxylus.ro>]
* @since	PHPbase 0.0.1
*/

class CLibrary {
	/**
	* unique library identifier
	*
	* @var string
	*
	* @access private
	*/
	var $name;

	/**
	* constructor which sets the lib`s name
	*
	* @param string $name	unique library identifier
	*
	* @return void
	*
	* @acces public
	*/
	function CLibrary($name) {
		$this->name = $name;
	}
}
?>