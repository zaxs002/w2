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
class COXYMallPortfolio extends CPlugin{	
	
	var $tplvars; 

	function COXYMallPortfolio() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.portfolio.")) {
			$sub = str_replace("oxymall.plugin.portfolio." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

			switch ($sub) {
				case "landing":					
					return $this->Listing();
				break;

				case "details":
					return $this->Details();
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
			"details"	=> "details.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}
	} 

	function Listing() {
		global $base , $_CONF;

		$classes = array(
			"3"	=> "three-cols",
			"4"	=> "four-cols",
		);


		$cats = $this->GetCategories();

		//detect the first cat
		if (!$_GET["cat"]) {
			$cat = $cats[0];
			$_GET["cat"] = $cat["cat_url"];
		} else {
			foreach ($cats as $key => $val) {
				if ($val["cat_url"] == $_GET["cat"]) {
					$cat = $val;
				}				
			}			
		}

		if (!is_array($cat)) {
			return "";
		}

		$cats = $this->ProcessCats($cats);
		$items = $this->GetRecords($cat);

		//process the seo 
		$this->module->plugins["modules"]->SetSeo($cat);
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		
		$return = CTemplateStatic::Replace(
			$this->private->templates["landing"]->BlockReplace(
				"Main",
				array(

					"categories"	=> $this->module->plugins["common"]->Categories(
						$this->ProcessCats($cats),
						$_GET["cat"],
						$this->tpl_module["settings"]["set_categories_type"]
					),

					"content"	=> $base->html->Table(
						$this->private->templates["landing"],
						"Items",	
						$items["records"]
					),

					"paging"=> $this->module->plugins["paging"]->Paging(
						$items["pages"] , 
						$items["page"], 
						array(
							"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $cat["cat_url"] . "/"),
							"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $cat["cat_url"] . "/{PAGE}/") ,
						),

						array(
							"ipp"	=> $items["ipp"],
							"total"	=> $items["count"]
						)
					),
						
					"header"	=> $cat["cat_description"] ? $this->private->templates["landing"]->blockReplace(
						"Header",
						$cat
					) : "",

					"comments"	=> $this->module->plugins["comments"]->Comments(
							$this->tpl_module["mod_url"] . "/" . $cat["cat_url"].  "/",
							$this->tpl_module["settings"]["set_fbcomments"]
					),

					"class"		=> $classes[$this->tpl_module["settings"]["set_items_column"]],


				)
			),
			$cat				
		);
		

		return CTemplateStatic::Replace(
			$return , 
			$this->tpl_module["settings"]
		);
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
	function ProcessCats($cats) {

		if (is_Array($cats)) {

			//if i have just one category do not show a thing
			if (count($cats) == 1) {
				return "";
			}

			foreach ($cats as $key => $val) {
				$cats[$key]["link"]	= $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $val["cat_url"] . "/");
			}			

			return $cats;
			
		}
	
	}
	

	function GetCategories() {
		$cats = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:portfolio_cats']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY cat_order"
		);

		return $cats;
	}
	
	
	function GetRecords($cat) {
		if (!is_array($cat)) {
			return "";
		}
		
		
		$count = $this->tpl_module["settings"]["set_items"];
		$page = $_GET["page"];

		$item_count = $this->db->RowCount(
			$this->tables['plugin:portfolio_projects'],
			"WHERE module_id={$this->tpl_module[mod_id]} AND project_cat={$cat[cat_id]}"
		);

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT *  
			FROM 
				{$this->tables['plugin:portfolio_cats']} as c,
				{$this->tables['plugin:portfolio_projects']} 
			
			WHERE 
				c.module_id={$this->tpl_module[mod_id]} 
				AND project_cat={$cat[cat_id]} 
				AND cat_id=project_cat 
			ORDER BY  
				project_order ASC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_Array($items)) {
			foreach ($items as $key => $val) {
				$items[$key]["link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $val["cat_url"] . "/" . $val["project_url"] . "-" . $val["project_id"] . "/");
			}			
		}

		return array(
			"records"	=> $items, 
			"count"		=> $item_count , 
			"pages"		=> $item_count ? ceil($item_count / $count) : 1,
			"page"		=> $page,

			"ipp"		=> $count,
		);
	}

	function Details() {
		global $base;

		$project = $this->db->QFetchArray(
			"SELECT *  
			FROM 
				{$this->tables['plugin:portfolio_cats']} as c,
				{$this->tables['plugin:portfolio_projects']} 
			
			WHERE 
				c.module_id={$this->tpl_module[mod_id]} 
				AND project_id={$_GET[item]} 
				AND cat_id=project_cat 
			"
		);
		

		if (!is_array($project)) {
			$this->module->plugins["common"]->Redirect404();
		}

		$items = $this->db->QFetchRowArray(
			"SELECT * 
			FROM 
				{$this->tables['plugin:portfolio_items']}
			WHERE 
				item_project={$project[project_id]}
			ORDER BY 
				item_order ASC
			"
		);

		if (is_array($items)) {
			foreach ($items as $key => $val) {

				switch ($val["item_type"]) {
					case "1":
						$items[$key]["link"] = "upload/portfolio/{$val[item_id]}.jpg";
					break;

					case "2":
						$items[$key]["link"] = "upload/portfolio/{$val[item_id]}.mp4";
					break;

					case "4":
						$items[$key]["link"] = $val["item_youtube"];
					break;
				}
			}			
		}

		$project["images"] = $base->html->Table(
			$this->private->templates["details"],
			"Items",
			$items
		);	

		$project["comments"] = $this->module->plugins["comments"]->Comments(
			$this->tpl_module["mod_url"] . "/" . $project["cat_url"]  . "/" . $project["project_url"] . "-" . $project["project_id"]  . "/",
			$this->tpl_module["settings"]["set_fbcomments"] 
		);

		$project["back_link"] = $this->module->plugins["modules"]->PrepareLink(
				$this->tpl_module["mod_url"] . "/" . $project["cat_url"]  . "/"
		);

		$project["link"] = $project["project_link"] ? $this->private->templates["details"]->BlockReplace("Link" , $project ) : "";

		$return = $this->private->templates["details"]->blockReplace(
			"Main", 
			$project
		);



		return CTemplateStatic::REplace(
			$return,
			$this->tpl_module["settings"]
		);
		
	}
	
	
	function GetAllLinks($module , $links) {

	}

}

?>