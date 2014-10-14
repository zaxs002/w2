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
class CDir{
	
	var $tplvars; 

	function CDir(
			$path , 
			$ext = "",
			$recursive = false
	) {
		$this->path = $path;
		$this->ext = $ext;
		$this->recursive = $recursive;

		$this->__readDir($path);
		
		return $this->_files;
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
	function __readDir($path) {
		$d = dir($path);
		while (false !== ($entry = $d->read())) {

			if ($this->recursive && is_dir($path . "/" . $entry))
				$this->__readDir($path . "/" . $entry);	

			if (!is_dir($path . "/" . $entry)) {
				if ((($this->ext != "") && strstr($entry , $this->ext)) || ($this->ext == "")) {			
						$this->_files[] = $path . "/" . $entry;
				}
			}
		}
		$d->close();
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
	function GetFiles($dir , $ext = false) {
		return CDir::__getfiles($dir , false , $ext) ;
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
	function GetFilesRec($dir , $ext = false) {
		return CDir::__getfiles($dir , TRUE , $ext) ;
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
	function __getfiles($dir , $rec = TRUE , $ext) {
		$array = array();
		$d = dir($dir);
		while (false !== ($entry = $d->read())) {
		  if($entry!='.' && $entry!='..') {
			  $entry = $dir.'/'.$entry;
			  if(is_dir($entry)) {
				  if ($rec == true)
					//$array[] = $entry;
					$array = array_merge($array, CDir::__getfiles($entry , $rec , $ext));
			  } else {
				  if (($ext && stristr($entry , $ext )) || !$ext) {
					  $array[] = $entry;
				  }				  
			  }
		  }
		}
		$d->close();
		return $array;

	}
	
	
}

?>