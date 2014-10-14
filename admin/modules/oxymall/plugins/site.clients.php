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
class COXYMallClients extends CPlugin{
	
	var $tplvars; 

	function COXYMallClients() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.clients.")) {
			$sub = str_replace("oxymall.plugin.clients." , "" ,$_GET["sub"]);
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

					"comments"	=> $this->module->plugins["comments"]->Comments(
						$this->tpl_module["mod_url"] . "/" . $cat["cat_url"]  . "/",
						$this->tpl_module["settings"]["set_fbcomments"] 
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
			"SELECT * FROM {$this->tables['plugin:clients_cats']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY cat_order"
		);

		return $cats;
	}
	
	
	function GetRecords($cat) {
		
		$count = $this->tpl_module["settings"]["set_items"];
		$page = $_GET["page"];

		$item_count = $this->db->RowCount(
			$this->tables['plugin:clients_images'],
			"WHERE module_id={$this->tpl_module[mod_id]} AND item_cat={$cat[cat_id]}"
		);

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:clients_images']} " . 
			"WHERE module_id={$this->tpl_module[mod_id]} AND item_cat={$cat[cat_id]} " .
			"ORDER BY  item_order DESC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_Array($items)) {
			foreach ($items as $key => $val) {
				$items[$key]["content"] = $this->private->templates["landing"]->blockReplace($val["item_url"] ? "Link" : "NoLink" , $val);
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


	function GetAllLinks($module , $links) {
		$cats = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:clients_cats']} " .
			"WHERE module_id={$module[mod_id]}"
		);


		if (is_array($cats)) {
			foreach ($cats as $key => $val) {
				$links[] = array(
					"url" => $module["mod_url"] . "/" . $val["cat_url"] . "-" . $val["cat_id"] . "/",
					"priority" => "0.8",
				);
			}
		}
	}

}

?>