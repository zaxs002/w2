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
class COXYMallTeam extends CPlugin{	
	
	var $tplvars; 

	function COXYMallTeam() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();


		if (strstr($_GET["sub"] , "oxymall.plugin.team.")) {

			$sub = str_replace("oxymall.plugin.team." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

			switch ($sub) {
				case "landing":					
					return $this->Listing();
				break;

				case "item":
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
		global $base;

		$cats = $this->GetCategories();

		//if no category, nothign to show
		if (!is_array($cats)) {
			return "";
		}
		
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

		$cats = $this->ProcessCats($cats);
		$items = $this->GetRecords($cat);

		//process the seo 
		$this->module->plugins["modules"]->SetSeo($cat);
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		
		return CTemplateStatic::Replace(
			$this->private->templates["landing"]->BlockReplace(
				"Main",
				array(

					"categories"	=> $this->module->plugins["common"]->Categories(
						$this->ProcessCats($cats),
						$_GET["cat"],
						$this->tpl_module["settings"]["set_categories_type"]
					),

					"items"	=> $base->html->Table(
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
				)
			),
			$cat
		);
		
	}
	

	function ProcessCats($cats) {

		if (is_Array($cats)) {

			//if i have just one category do not show a thing
			if (count($cats) == 1) {
				return "";
			}


			foreach ($cats as $key => $val) {
				$cats[$key]["link"]	= $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $val["cat_url"] . "/");
			}						
		}

		return $cats;
	
	}
	

	function GetCategories() {
		$cats = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:team_cats']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY cat_order"
		);

		return $cats;
	}
	
	
	function GetRecords($cat) {
		
		$count = $this->tpl_module["settings"]["set_items"];
		$page = $_GET["page"];

		$item_count = $this->db->RowCount(
			$this->tables['plugin:team_items'],
			"WHERE module_id={$this->tpl_module[mod_id]} AND item_cat={$cat[cat_id]}"
		);

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:team_items']} as i , {$this->tables['plugin:team_cats']} " . 
			"WHERE i.module_id={$this->tpl_module[mod_id]} AND item_cat={$cat[cat_id]} AND item_cat=cat_id " .
			"ORDER BY  item_order ASC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_array($items)) {
			foreach ($items as $key => $val) {
				$items[$key]["link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $val["cat_url"] . "/" . $val["item_url"] . "/" . $val["item_id"] . "/");
			}			
		}
		

		return array(
			"records"	=> $items, 
			"count"		=> $item_count , 
			"pages"		=> $item_count ? ceil($item_count / $count) : 1,
			"page"		=> $page,

			"ipp"		=> $count
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
	function Details() {
		global $_CONF;

		$item = $this->db->QFetchArray(
			"SELECT *  
			FROM 
				{$this->tables['plugin:team_cats']}, 
				{$this->tables['plugin:team_items']} as i  
			WHERE 
				i.module_id={$this->tpl_module[mod_id]} 
				AND item_id={$_GET[item]} AND 
				item_cat=cat_id  
			"			
		);

		if (!is_array($item)) {
			$this->module->plugins["common"]->Redirect404();
		}

		$this->module->plugins["modules"]->SetSeo($item);
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		//prepare the image
		$item["image"] = $item["item_large"] ? $this->private->templates["details"]->blockReplace(
			"Image",
			$item
		) : "";

		$item["back"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $item["cat_url"] . "/");

		$item["email"] = $item["item_email"] ? $this->private->templates["details"]->blockReplace("Email" , $item) : "";
		$item["phone"] = $item["item_phone"] ? $this->private->templates["details"]->blockReplace("Phone" , $item) : "";
		

		$item["comments"]	= $this->module->plugins["comments"]->Comments(
			$this->tpl_module["mod_url"] . "/" . $item["cat_url"] . "/" . $item["item_url"] . "/" . $item["item_id"],
			$this->tpl_module["settings"]["set_fbcomments"]
		);

		$return = $this->private->templates["details"]->blockReplace(
			"Details" , 
			$item
		);
		


		return $this->Texts($return);
	}

	function Texts($content) {

		return CTemplateStatic::Replace(
			$content ,
			$this->tpl_module["settings"]
		);
	}

	
	
	function GetAllLinks($module , $links) {

	}

}

?>