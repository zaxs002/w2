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
class COXYMallNews extends CPlugin{
	
	var $tplvars; 

	function COXYMallNews() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();
		


		if (strstr($_GET["sub"] , "oxymall.plugin.news.")) {
			$sub = str_replace("oxymall.plugin.news." , "" ,$_GET["sub"]);
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
			"list"					=> "list.htm",
			"details"				=> "details.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}
	} 


	function Listing() {
		global $base;

		$records = $this->GetRecords();

		if (is_array($records["records"])) {
			foreach ($records["records"] as $key => $val) {
				$records["records"][$key]["brief"] = $val["item_brief"] ? $this->private->templates["list"]->blockReplace("Brief" , $val) : "";

				$records["records"][$key]["item_date"] = date($this->tpl_module["settings"]["set_date_format"] , $val["item_date"]);
			}			
		}

		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		return CTemplateStatic::Replace(
			$this->private->templates["list"]->blockReplace(
				"Main",
				array(
					"content"	=> $base->html->table(
						$this->private->templates["list"],
						"",
						$records["records"]
					),

					"title"		=> $this->tpl_module["mod_long_name"],

					"paging"=> $this->module->plugins["paging"]->Paging(
						$records["pages"] , 
						$records["page"], 
						array(
							"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/") ,
							"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{PAGE}/") ,
						),

						array(
							"ipp"	=> $records["ipp"],
							"total"	=> $records["count"]
						)

					),
				)
			),
			array_merge(
				$this->tpl_module,
				$this->tpl_module["settings"]
			)
			
		);
	}

	function Details() {
		global $_CONF;
		
		$record = $this->GetRecord($_GET["topic"]);

		if (!is_array($record["current"])) {
			$this->module->plugins["common"]->Redirect404();
		}


		$record["current"]["next"] = $this->private->templates["details"]->blockReplace(
			"Next" . (is_array($record["next"]) ? "" : "Disabled"), 
			$record["next"]
		);
		
		$record["current"]["prev"] = $this->private->templates["details"]->blockReplace(
			"Prev" . (is_array($record["prev"]) ? "" : "Disabled"), 
			$record["prev"]
		);


		$this->module->plugins["modules"]->SetSeo($record["current"]);
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		//add the comments
		$record["current"]["comments"] = $this->module->plugins["comments"]->Comments(
			$this->tpl_module["mod_url"] . "/" . $record["current"]["item_url"] . "-" . $record["current"]["item_id"] . "/",
			$this->tpl_module["settings"]["set_fbcomments"]
		);
		

		return CTemplateStatic::ReplacE(
			$this->private->templates["details"]->blockReplace(
				"Details",
				$record["current"]
			),
			array_merge(
				$this->tpl_module,
				$this->tpl_module["settings"]
			)
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
	function GetRecord($id) {
		$item = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:news_items']} WHERE module_id={$this->tpl_module[mod_id]} AND item_id={$id}"
		);

		if (!is_array($item)) {
			return false;
		}

		$next = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:news_items']} WHERE module_id={$this->tpl_module[mod_id]} AND item_date >= {$item['item_date']} AND item_id!={$item['item_id']}"
		);

		if (is_array($next)) {
			$next["link"]	= $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $next["item_url"] . "-" . $next["item_id"] . "/");
		}

		$prev = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:news_items']} WHERE module_id={$this->tpl_module[mod_id]} AND item_date <= {$item['item_date']} AND item_id!={$item['item_id']}"
		);

		if (is_array($prev)) {
			$prev["link"]	= $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $prev["item_url"] . "-" . $prev["item_id"] . "/");
		}

		$item["back"]	= $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" );

		

		return array(
			"prev"		=> $prev,
			"next"		=> $next,
			"current"	=> $item,

			"ipp"		=> $count,

		);
	}
	
	
	function GetRecords() {
		
		$count = $this->tpl_module["settings"]["set_items"];
		$page = $_GET["page"];

		$item_count = $this->db->RowCount(
			$this->tables['plugin:news_items'],
			"WHERE module_id={$this->tpl_module[mod_id]}"
		);

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:news_items']} " . 
			"WHERE module_id={$this->tpl_module[mod_id]} " .
			"ORDER BY  item_date DESC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_Array($items)) {
			foreach ($items as $key => $val) {
				$items[$key]["link"]	= $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $val["item_url"] . "-" . $val["item_id"] . "/");

			}			
		}

		return array(
			"records"	=> $items, 
			"count"		=> $item_count , 
			"pages"		=> $item_count ? ceil($item_count / $count) : 1,
			"page"		=> $page,
		);

	}
	


	
	function GetAllLinks($module , $links) {
		//get all news for this module

		$news = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:news_items']} " .
			"WHERE module_id={$module[mod_id]}"
		);

		if (is_array($news)) {
			foreach ($news as $key => $val) {
				$links[] = array(
					"url" => $this->module->plugins["modules"]->PrepareLink($module["mod_url"] . "/" . $val["item_url"] . "-" . $val["item_id"] . "/"),
					"priority" => "0.8",
				);
			}
		}

	}

}

?>