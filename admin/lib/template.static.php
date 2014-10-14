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
class CTemplateStatic{
	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	
	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function Replace($tmp , $data = array()) {
		$template = new CTemplate($tmp , "string");
		return $template->replace($data);
	}

	function EmptyVars($tmp , $data = array()) {
		$template = new CTemplate($tmp , "string");

		if (count($data)) {
			$template->replace($data , false);
		}
		
		return $template->emptyvars();
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
	function ReplaceSingle($tmp , $var , $value) {
		return CTemplateStatic::Replace(
			$tmp , 
			array(
				$var => $value
			)
		);
	}
	
	
}

/*

History

0.2
	Saturday 15 September 2007
		Added BlockExists()

0.1
	Friday 03 August 2007
		Basic functionality
	
*/

?>