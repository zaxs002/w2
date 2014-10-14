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

class CFile {
	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function GetContent($file_name) {
		if (!file_exists($file_name)) {
			return null;
		}
	
		$file = fopen($file_name,"r");
		
		//checking if the file was succesfuly opened
		if (!$file)
			return null;

		if (strstr($file_name,"://"))
			while (!feof($file))
				$result .= fread($file,1024);
		else
			$result = @fread($file,filesize($file_name));

		fclose($file);

		return $result;

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
	function SaveContents($file_name , $content) {
		$file = fopen($file_name,"w");
		fwrite($file,$content);
		fclose($file);
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
	function Extension($file_name) {
		$tmp = explode("." , $file_name);
		return $tmp[count($tmp) - 1];
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
	function Name2Url($filename) {

		$replace = array(
				" "  =>  "-",
				"&"  =>  "-and-",
				"?"  =>  "", 
				"'"  =>  "-",
				"/"  =>  "-",
				"!"  =>  "",
				","  =>  "-",
				"\""  =>  "",
				"'"  =>  "",
				":"  =>  "-",
				"_"  =>  "-",
				"--"  =>  "-"
			);

		foreach ($replace as $key => $val) {
			$filename = str_replace($key , $val , $filename);
		}

		return strtolower($filename);
	}
	
	
}
?>