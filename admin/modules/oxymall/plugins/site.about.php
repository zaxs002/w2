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
class COXYMallAbout extends CPlugin{
	
	var $tplvars; 

	function COXYMallAbout() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		switch ($_GET["sub"]) {
			case "oxymall.plugin.about.landing":
				return $this->Main();
			break;
		}
	}

	function __init() {
		global $_CONF;

		if ($this->__inited) {
			return "";
		}

		$this->__inited = true;
		
		$path = $this->tpl_path;

		$templates = array(
			"main"					=> "main.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}

		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();
	} 


	function Main() {
		global $base , $_CONF;

		$this->__init();

		$this->module->plugins["modules"]->SetSeo(
			$this->tpl_module
		);

		return CTemplateStatic::Replace(
			$this->private->templates["main"]->blockReplace(
				"Main" ,
				array(
					"header" => $this->vars->data["about_header_" . $this->tpl_module["mod_id"]],
					"title" => $this->tpl_module["mod_long_name"],


					"comments"	=> $this->module->plugins["comments"]->Comments(
							$this->tpl_module["mod_url"] . "/",
							$this->tpl_module["settings"]["set_fbcomments"]
					),
				)
			),
			$this->tpl_module["settings"]
		);
		
	}

	function GetAllLinks($module , $links) {
	}
	

}

?>