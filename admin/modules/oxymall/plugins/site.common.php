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
class COXYMallCommon extends CPlugin{
	
	var $tplvars; 

	function COXYMallCommon() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();
	}

	function __init() {
		global $_CONF;

		if ($this->__inited) {
			return "";
		}

		$this->__inited = true;
		
		$path = $this->tpl_path;

		$templates = array(
			"categories"				=> "categories.htm",
			"errors"					=> "errors.htm",
			"fbcomments"				=> "fbcomments.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}
	} 

	function ErrorMsg($msg) {

		$this->__init();

		return $this->private->templates["errors"]->blockReplace(
			"Error" , 
			array(
				"msg"	=> $msg
			)
		);
	}
	
	function SuccessMsg($msg , $redirect = "") {

		$this->__init();

		return $this->private->templates["errors"]->blockReplace(
			"Success" , 
			array(
				"msg"	=> $msg,
				"redirect"	=> $redirect ? $this->private->templates["errors"]->blockReplace("Redirect" , array("url" => $redirect)) : "",
			)
		);
	}

	function Categories( $categories , $selected , $type) {
		global $base; 

		$this->__init();

		if (is_array($categories)) {
			foreach ($categories as $key => $val) {		
				if ($val["cat_url"] == $_GET["cat"]) {
					$categories[$key]["selected"] = $this->private->templates["categories"]->blockReplace("Selected" , array());
				} else {
					$categories[$key]["selected"] = "";
				}
			}
		}

		//if there is only one category dont show the dropdown
		if (count($categories) < 2) {
			return "";
		}
		

		
		//autodetect the menu type
		if (!in_array($type , array("1" , "2")) ) {
			if (count($categories) >3 ) {
				$type = "2";
			} else {
				$type = "1";			
			}
		}		
		
		switch ($type) {
			case "1":
				return $base->html->Table(
					$this->private->templates["categories"],
					"Menu",	
					$categories
				);
			break;

			case "2":
				return $base->html->Table(
					$this->private->templates["categories"],
					"Dropdown",	
					$categories
				);
			break;
		}		
	}

	function Redirect404() {
		global $_CONF;

		$module = $this->module->plugins["modules"]->GetModuleById($this->vars->data["set_404"]);
		header("HTTP/1.1 404 Not Found");
		header("Location: " . $this->module->plugins["modules"]->PrepareLink($module["mod_url"] . "/"));
		exit();
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
	function LinkTarget($target = "") {
		return $target ? " target=\"{$target}\" " : "";
	}
	
	
}

?>