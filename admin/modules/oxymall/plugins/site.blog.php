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
class COXYMallBlog extends CPlugin{
	
	var $tplvars; 

	function COXYMallblog() {
		//$this->CPlugin($db, $tables , $templates);
	}


	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if (strstr($_GET["sub"] , "oxymall.plugin.blog.")) {
			$sub = str_replace("oxymall.plugin.blog." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

			switch ($sub) {
				case "tag":
				case "search":
				case "landing":					
					return $this->Search();
				break;

				case "item":
					return $this->Details();
				break;

				case "publisher":
					return $this->Publisher();
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
			"listing"	=> "listing.htm",
			"details"	=> "details.htm",
			"publisher"	=> "publisher.htm",
			"tags"		=> "tags.htm",
			"form"		=> "form.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}
	} 

	function Search() {
		global $base;

		$cats = $this->GetCategories();

		if ($_GET["cat"]) {
			foreach ($cats as $key => $val) {
				if ($val["cat_url"] == $_GET["cat"]) {
					$cat = $val;
				}				
			}			
		}

		switch ($_GET["search"]) {
			case "tag":
				$items = $this->GetRecords(
					array(
						"item_tags"	=> $_GET["tag"]
					)
				);
				$title = urldecode($_GET["tag"]);

				$links = array(
					"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/search/tag/{$_GET[tag]}/"),
					"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/search/tag/{$_GET[tag]}/{PAGE}/")  ,
				);
			break;

			case "all":
				$items = $this->GetRecords();
				$title = $cats["all"]["cat_title"];

				$links = array(
					"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/"),
					"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{PAGE}/")  ,
				);

			break;

			case "category":
				$items = $this->GetRecords(
					array(
						"item_cat"	=> $cat["cat_id"]
					)
				);
				$title = $cat["cat_title"];

				$links = array(
					"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{$cat[cat_url]}/"),
					"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{$cat[cat_url]}/{PAGE}/")  ,
				);
			break;

			case "search":
				$items = $this->GetRecords(
					array(
						"item_title"	=> $_GET["q"]
					)
				);
				$title = urldecode($_GET["q"]);

				$links = array(
					"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/search/?q={$_GET[q]}"),
					"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/search/?q={$_GET[q]}&page={PAGE}")  ,
				);

			break;

		}
		

		$items = $this->GetRecords(
			array(
				"item_tags"	=> $_GET["tag"]
			)
		);

		$items["records"] = $this->ProcessRecords($items["records"]);

		//process the seo 
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);
		
		$return = $this->private->templates["listing"]->BlockReplace(
				"Main",
				array(

					"search_form"	=> $this->SearchForm($_GET),


					"categories"	=> $this->module->plugins["common"]->Categories(
						$this->ProcessCats($cats),
						"",
						$this->tpl_module["settings"]["set_categories_type"]
					),

					"items"	=> $base->html->Table(
						$this->private->templates["listing"],
						"Items",	
						$items["records"]
					),

					"paging"=> $this->module->plugins["paging"]->Paging(
						$items["pages"] , 
						$items["page"], 
						$links
						,

						array(
							"ipp"	=> $items["ipp"],
							"total"	=> $items["count"]
						)

					),					

					"cat_title"	=> $title
				)
		);

		return $this->texts(
			$return
		);
		
	}

	function ProcessCats($cats) {

		if (is_Array($cats)) {

			//if i have just one category do not show a thing
			if (count($cats) == 1) {
				return "";
			}


			foreach ($cats as $key => $val) {
				
				if (!$val["link"]) 
					$cats[$key]["link"] =$this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . ($val["cat_url"] ? $val["cat_url"] . "/" : ""));
			}						
		}

		//debug($cats,1);

		return $cats;
	
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
	function ProcessRecords($items) {
		if (is_array($items)) {
			foreach ($items as $key => $val) {
				$items[$key]["item_date"] = date($this->tpl_module["settings"]["set_date_format"] , $val["item_date"]);

				switch ($_GET["back"]) {
					case "all":
						$items[$key]["details_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/{$val[item_url]}-{$val[item_id]}/" );
					break;

					case "cat":
						$items[$key]["details_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $_GET["cat"] . "/{$val[item_url]}-{$val[item_id]}/");
					break;

					case "author":
						$items[$key]["details_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/publishers/" . $_GET["user"] . "/{$val[item_url]}-{$val[item_id]}/");
					break;
				}

				$items[$key]["author_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/publishers/{$val[author_url]}/");

				$items[$key]["tags"] = $this->TopicTags($val);			
			}			

			return $items;
		}
		
	}
	
	

	function GetCategories() {
		$cats = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:blog_cats']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY cat_order"
		);

		$_cats = array(
			"all" => array(
				"cat_url"	=> "",
				"cat_title"	=> $this->tpl_module["settings"]["set_label_title"],
			)
		);

		if (is_array($cats)) {
			foreach ($cats as $key => $val) {
				$_cats[] = $val;
			}			
		}	
		return $_cats;
	}
	

	function Details() {
		global $_CONF;
		
		$record = $this->GetRecord($_GET["item"]);

		if (!is_array($record["current"])) {
			$this->module->plugins["common"]->Redirect404();
		}

		$this->module->plugins["modules"]->SetSeo($record["current"]);
		$this->module->plugins["modules"]->SetSeo($this->tpl_module);

		$record["current"]["comments"] = $this->module->plugins["comments"]->Comments(
			$this->tpl_module["mod_url"] . "/" . $record["current"]["item_url"] . "-" . $record["current"]["item_id"] .  "/",
			$this->tpl_module["settings"]["set_fbcomments"]
		);


		//prere the back link
		switch ($_GET["back"]) {
			case "all":
				$record["current"]["back_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" );
			break;

			case "cat":
				$record["current"]["back_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $_GET["cat"] . "/");
			break;

			case "author":
				$record["current"]["back_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/publishers/" . $_GET["user"] . "/");
			break;
		}

		//process date
		$record["current"]["item_date"] = date($this->tpl_module["settings"]["set_date_format"] , $record["current"]["item_date"]);

		//author link
		$record["current"]["author_link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/publishers/{$record[current][author_url]}/");

		$record["current"]["tags"] = $this->TopicTags($record["current"]);



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
			"SELECT * FROM 
				{$this->tables['plugin:blog_authors']},
				{$this->tables['plugin:blog_items']} as i
				
			WHERE 
				i.module_id={$this->tpl_module[mod_id]} 
				AND author_id=item_author 
				AND item_id={$id}"
		);

		if (!is_array($item)) {
			return false;
		}

		return array(
			"prev"		=> $prev,
			"next"		=> $next,
			"current"	=> $item,
		);
	}

	
	function GetRecords($query = array()) {

		$sort = array(
			"t"	=> "item_title",
			"d"	=> "item_date",
			"a"	=> "author_name",
		);

		$order_t = array(
			"a"	=> "ASC",
			"d"	=> "DESC"
		);

		if (!$sort[$_GET["s"]]) {
			$default_sort = "d";
		} else {
			$default_sort = $_GET["s"];
		}
		
		if ($_GET["o"] == "a") {
			$default_order = "a";
		} else {
			$default_order = "d";
		}

		$order = $sort[$default_sort];
		$order_mode = $order_t[$default_order];

		
		$count = $this->tpl_module["settings"]["set_items"];
		$page = $_GET["page"];

		if ($query["item_title"]) {
			$tmp = explode(" " , $query["item_title"]);
			foreach ($tmp as $key => $val) {
				$title_search .= " +" . trim($val);
			}			
		}		

		$search = array(									
			"item_title"	=> " MATCH (item_title) AGAINST ('{$title_search}' IN BOOLEAN MODE) ",
			"item_tags"		=> " MATCH (item_tags) AGAINST ('+{$query[item_tags]}' IN BOOLEAN MODE) ",
			"item_cat"		=> " find_in_set({$query[item_cat]} , item_cat) ",
			"item_author"	=> " item_author={$query[item_author]} ",
		);

		if (count($query)) {
			foreach ($search as $key => $val) {
				if (!$query[$key]) {
					unset($search[$key]);
				}								
			}
			
			if (count($search)) {
				$cond = " AND " . implode(" AND " , $search );
			}			
		}

		
		$item_count = $this->db->RowCount(
			$this->tables['plugin:blog_items'],
			"WHERE module_id={$this->tpl_module[mod_id]} {$cond}"
		);

		$page = $_GET["page"];

		if (!$page && $item_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:blog_items']} as b , {$this->tables['plugin:blog_authors']} " . 
			"WHERE b.module_id={$this->tpl_module[mod_id]} AND author_id=item_author {$cond}" .
			"ORDER BY  {$order} {$order_mode} " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		return array(
			"records"	=> $items, 
			"count"		=> $item_count , 
			"pages"		=> $item_count ? ceil($item_count / $count) : 1,
			"page"		=> $page,

			"ipp"		=> $count
		);

	}


	
	function GetAllLinks($module , $links) {
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
	function Publisher() {
		global $base;

		$author = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:blog_authors']} WHERE author_url=\"{$_GET[user]}\""
		);


		if (!is_array($author)) {
			$this->module->plugins["common"]->Redirect404();
		}

		$template = &$this->private->templates["publisher"];


		$items = $this->GetRecords(
			array(
				"item_author"	=> $author["author_id"]
			)
		);
		$items["records"] = $this->ProcessRecords($items["records"]);


		$return = CTemplateStatic::Replace(
			$template->blockReplace(
				"Main" ,
				array(
					"search_form"	=> $this->SearchForm($_GET),

					"bio"	=> $author["author_bio"] ? $template->blockReplace(
						"Bio",
						$author
					) : "",

					"image"	=> $author["author_avatar"] ? $template->blockReplace(
						"Avatar",
						$author
					) : "",


					"topics"	=> $base->html->Table(
						$this->private->templates["listing"],
						"Items",	
						$items["records"]
					),

					"paging"=> $this->module->plugins["paging"]->Paging(
						$items["pages"] , 
						$items["page"], 
						array(
							"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/publishers/{$author[author_url]}/"),
							"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/publishers/{$author[author_url]}/{PAGE}/") 
						),
						array(
							"ipp"	=> $items["ipp"],
							"total"	=> $items["count"]
						)

					),

					"back"	=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/"),

				)
			),
			$author
		);		

		return $this->Texts(
			$return
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
	function Texts($content) {
		return CTemplateStatic::Replace(
			$content , 
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
	function TopicTags($topic) {

		if (!$topic["item_tags"]) {
			return "";
		}

		$tags = explode("," , $topic["item_tags"]);

		if (!count($tags)) {
			return "";
		}

		foreach ($tags as $key => $val) {
			if (trim($val)) {
				$_tags[] = array(
					"link"	=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/search/tag/" . trim($val)),
					"title"	=> trim($val),
					"class"	=> trim($val) == urldecode($_GET["tag"]) ? "selected" : "",
				);
			}		
		}

		if (!count($tags)) {
			return "";
		}

		global $base;

		return $base->html->table(
			$this->private->templates["tags"],
			"",
			$_tags
		);		
	}


	function SearchForm($vars) {
		global $base;

		$sort = array(
			"t"	=> $this->tpl_module["settings"]["set_filter_name"],
			"d"	=> $this->tpl_module["settings"]["set_filter_date"],
			"a"	=> $this->tpl_module["settings"]["set_filter_author"],
		);


		$order = array(
			""
		);

		if (!$sort[$_GET["s"]]) {
			$default_sort = "d";
		} else {
			$default_sort = $_GET["s"];
		}
		
		if ($_GET["o"] == "a") {
			$default_order = "a";
		} else {
			$default_order = "d";
		}

		switch ($_GET["search"]) {
			case "all":
				$base_url = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/?" );
			break;

			case "tag":
				$base_url = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/search/tag/"  . $_GET["tag"] . "/?");
			break;

			case "search":
				$base_url = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/search/?q="  . $_GET["q"] . "&" );
			break;

			case "category":
				$base_url = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $_GET["cat"] . "/?");
			break;

			case "author":
				$base_url = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/publishers/" . $_GET["user"] . "/?");
			break;
		}


		foreach ($sort as $key => $val) {
			$_sort[] = array(
				"class"	=> $key == $default_sort ? "selected" : "",
				"title"	=> $val,
				"link"	=> $base_url . "s={$key}" ,
			);
		}

		$_order = array(
			array(
				"class"	=> $default_order == "a" ? "selected" : "",
				"title"	=> $this->tpl_module["settings"]["set_filter_asc"],
				"link"	=> $base_url . "s={$default_sort}&o=a" ,
			),
			
			array(
				"class"	=> $default_order == "d" ? "selected" : "",
				"title"	=> $this->tpl_module["settings"]["set_filter_desc"],
				"link"	=> $base_url . "s={$default_sort}&o=d" ,
			)
		);


		return $this->private->templates["form"]->blockreplace(
			"Main",
			array(
				"sort"	=> $base->html->Table(
					$this->private->templates["form"],
					"Fields",
					$_sort
				),

				"order"	=> $base->html->Table(
					$this->private->templates["form"],
					"Fields",
					$_order
				),

				"link"	=> $this->module->plugins["modules"]->PrepareLink( $this->tpl_module["mod_url"] ."/search/" ),

				"search"	=> $_GET["q"] ? $_GET["q"] : $this->tpl_module["settings"]["set_filter_search"],


			)
		);
	}

	

}

?>