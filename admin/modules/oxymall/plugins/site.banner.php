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
class COXYMallBanner extends CPlugin{
	
	var $tplvars; 

	function COXYMallBanner() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.banner.")) {
			$sub = str_replace("oxymall.plugin.banner." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

			switch ($sub) {
				case "landing":					
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
			"landing"	=> "main.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
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
	function Landing() {
		global $base;


		$images = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:banner_images']} " .
			"WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
		);

		$texts = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:banner_texts']} " .
			"WHERE module_id={$this->tpl_module[mod_id]}"
		);

		if (is_array($texts)) {
			foreach ($texts as $key => $val) {
				$val["item_width"] = $val["item_set_description_width"] ? $val["item_set_description_width"] : $this->tpl_module["settings"]["set_description_width"];
				$_texts[$val["item_parent"]][]  = $val;
			}
		}
		
		if (is_array($images)) {


			foreach ($images as $key => $val) {

				switch ($val["item_type"]) {
					case "1":

						$val["item_url"] = $val["item_url"] ? $val["item_url"] : "#";

						$images[$key]["type"] = $this->private->templates["landing"]->blockreplace(
							"Image" , 
							$val
						);
					break;

					case "2":

						if (stristr($val["item_video"] , "youtube.com")) {

							preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $val["item_video"], $vars);

							//parse_str( parse_url( $val["item_video"], PHP_URL_QUERY ), $vars);


							if ($vars["0"]) {
								$val["video"] = "http://www.youtube.com/embed/" . $vars["0"];
							}

						} else {

							if (stristr($val["item_video"] , "vimeo.com")) {

								$url = parse_url($val["item_video"], PHP_URL_PATH);

								$val["video"] = "http://player.vimeo.com/video{$url}?title=0&amp;byline=0&amp;portrait=0";
							} 
						}
						

						$images[$key]["type"] = $this->private->templates["landing"]->blockreplace(
							"Video" , 
							$val
						);
					break;
				}				


				$images[$key]["texts"] = $_texts[$val["item_id"]] ? $base->html->table(
					$this->private->templates["landing"],
					"Texts" , 
					$_texts[$val["item_id"]]
				) : "";
			}			
		}
		

			
		return $this->private->templates["landing"]->BlockreplacE(
			"Main" , 
			array(

				"slides"	=> $base->html->table(
					$this->private->templates["landing"],
					"Images" , 
					$images
				),

				"title"	=> $this->tpl_module["mod_long_name"],

				"stay"	=> $this->tpl_module["settings"]["set_stay"],


				"comments"	=> $this->module->plugins["comments"]->Comments(
					$this->tpl_module["mod_url"] . "/" ,
					$this->tpl_module["settings"]["set_fbcomments"] 
				),

			)
		);
	}
	


	function GenerateXml() {
		global $base;

		$this->module->plugins["modules"]->MimeXML();

		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

		$template = new CTemplate($this->tpl_path . "main.xml");

		if ($this->tpl_module["settings"]["set_reverseorder"]) {
			//load the images for this module
			$images = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:banner_images']} " .
				"WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order DESC"
			);
		} else {
			$images = $this->db->QFetchRowArray(
				"SELECT * FROM {$this->tables['plugin:banner_images']} " .
				"WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
			);
		}

		if (is_array($images)) {
			//read the texts for each item
			foreach ($images as $key => $val) {
				$images[$key]["items"] = $base->html->table(
					$template , 
					"Texts"	,
					$this->db->QFetchRowArray(
						"SELECT * FROM {$this->tables['plugin:banner_texts']} WHERE item_parent={$val[item_id]}"
					)
				);
			}
		}

		$this->module->EncodeItems(
			&$images, 
			array(					
				"item_url" , 
			)
		);

		if (is_array($images)) {
			foreach ($images as $key => $val) {
				$images[$key]["ext"] = $val["item_swf"]  ? "swf" : "jpg";
			}
		}

		return CTemplateStatic::Replace(
			$template->blockReplace(
				"Main" ,
				array(
					"mod_title" => $this->tpl_module["mod_long_name"],
					"mod_url" => $this->tpl_module["mod_url"],
					"images" => $base->html->Table(
						$template,
						"Images",
						$images
					)
				)
			),
			$this->tpl_module["settings"]
		);
		
	}
	
	function AlternateContent() {
		global $base; 

		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

		$template = new CTemplate($this->tpl_path . "main.htm");

		$images = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:banner_images']} " .
			"WHERE module_id={$this->tpl_module[mod_id]} ORDER BY item_order ASC"
		);

		if (is_array($images)) {
			foreach ($images as $key => $val) {
				$images[$key]["src"] = $template->blockReplace($val["item_type"] == "1" ? "Image" : "Swf" , $val);
			}			
		}
		

		return CTemplateStatic::Replace(
			$template->blockReplace(
				"Main" ,
				array(
					"mod_title" => $this->tpl_module["mod_long_name"],
					"images" => $base->html->Table(
						$template,
						"Images",
						$images
					)
				)
			),
			$this->tpl_module["settings"]
		);

	}

	function GetAllLinks($module , $links) {
	}
	
}

?>