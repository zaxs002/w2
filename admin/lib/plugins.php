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
class CPlugin{
	
	var $tplvars; 

	function CPlugin($db, $tables, $templates) {		
		$this->db = $db;
		$this->tables = $tables;
		$this->templates = $templates;
		
	}

	function __init() {
		//load the config file
		$this->_xmlFile = dirname(__FILE__) . basename(__FILE__ , ".php") . ".xml";
		$this->_xmlPath = dirname(__FILE__) ;

		if (file_exists($this->_xmlFile)) {
			$conf = new CConfig($this->_xmlFile);
			$this->conf = $conf->vars["plugin"];

			//load the templates and the tables
			if (is_array($this->conf["tables"])) {
				foreach ($this->conf["tables"] as $key => $val) {
					$this->private->tables[$key] = $val;
				}
			}

			//load the templates
			if (is_array($this->conf["templates"])) {
				foreach ($this->conf["tables"] as $key => $val) {
					$this->private->templates[$key] = new CTemplateDyn($val);
				}
				
			}
			
		}
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
	function DoEvents() {
		global $_CONF;
		
//		$_CONF["forms"]["adminpath"] = "../"

	}
	
}

?>