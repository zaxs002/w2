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
class COXYMallHomepage extends CPlugin{
	
	var $tplvars; 

	function COXYMallHomepage() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if ($_GET["sub"] == "oxymall.plugin.homepage.landing") {
			$this->__init();

			return $this->Landing();
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
	} 


	function Landing() {
		global $base , $_PAGE , $_CONF;


		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

		$template = new CTemplate($this->tpl_path . "main.htm");	

		$images = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:homepage_images']} " .
			"WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
		);

		if (is_array($images)) {
			foreach ($images as $key => $val) {
				$images[$key]["content"] = $this->private->templates["main"]->blockReplace(
					$val["item_link"] ? "Link" : "NoLink",
					$val
				);
			}
		}
		
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);					

		return CTemplateStatic::Replace(
			$this->private->templates["main"]->blockReplace(
				"Main" ,
				array(
					"mod_title" => $this->tpl_module["mod_long_name"],

					"header" => $this->vars->data["homepage_header_" . $this->tpl_module["mod_id"]],
					"scroller_items" => $base->html->Table(
						$this->private->templates["main"],
						"Images",
						$images
					),

					"products_text" => $this->vars->data["homepage_products_" . $this->tpl_module["mod_id"]],


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