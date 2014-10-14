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

class CMime {
	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function CMime($file = null) {

		if ($file == null) {
			$file = _LIBPATH  . "include/mime.xml";
		}
		
		//load the xml file
		$tmp = new CConfig($file);
		$this->types = $tmp->data["content-type"];
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
	function Set($ext) {
		header("Content-type: " . $this->types[$ext]);
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
	function GetByExt($file) {
		//get the file extenstion
		$tmp = explode("." , $file);
		krsort($tmp);
		reset($tmp);

		$ext = $tmp[key($tmp)];

		return $this->types[strtolower($ext)] ? $this->types[strtolower($ext)] : $this->types["unknown"];
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
	function Filename($file) {
		header('Content-Disposition: attachment; filename="' . str_replace("%20" , " " , $file) . '"');
	}
	
	
	
}
?>