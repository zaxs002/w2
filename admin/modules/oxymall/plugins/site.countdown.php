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
class COXYMallCountDown extends CPlugin{
	
	var $tplvars; 

	function COXYMallCountDown() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.countdown.")) {
			$sub = str_replace("oxymall.plugin.countdown." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();




			switch ($sub) {
				default:					
					return $this->Landing();
				break;
			}
			

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
			"landing"	=> "landing.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}
	} 

	function Landing() {
		global $_CONF;

	
		//if expired redirect to the new page
		if ($this->tpl_module["settings"]["set_launchdate"] < time()) {
			urlredirect($this->tpl_module["settings"]["set_link_redirect"]);
		}
		
		$this->module->plugins["modules"]->SetSeo(
			$this->tpl_module
		);


		$return = $this->private->templates["landing"]->blockReplace(
			"Main" , 
			array(

				"server_time"	=> time(),

				"data_year"		=> date("Y" , $this->tpl_module["settings"]["set_launchdate"]),
				"data_month"	=> date("m" , $this->tpl_module["settings"]["set_launchdate"]),
				"data_day"		=> date("d" , $this->tpl_module["settings"]["set_launchdate"]),
				
				"data_hour"		=> date("G" , $this->tpl_module["settings"]["set_launchdate"]),
				"data_minute"	=> date("i" , $this->tpl_module["settings"]["set_launchdate"]),

				"comments"	=> $this->module->plugins["comments"]->Comments(
					$this->tpl_module["mod_url"] . "/" ,
					$this->tpl_module["settings"]["set_fbcomments"]
				),

				"title"			=> $this->tpl_module["mod_long_name"],

			)
		);

		return CTemplateStatic::Replace(
			$return , 
			$this->tpl_module["settings"]
		);
	}
	
	function GetAllLinks($module , $links) {
	}
	
}

?>