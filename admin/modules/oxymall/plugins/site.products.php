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
class COXYMallProducts extends CPlugin{	
	
	var $tplvars; 

	function COXYMallProducts() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();
		if (strstr($_GET["sub"] , "oxymall.plugin.products.")) {
			$sub = str_replace("oxymall.plugin.products." , "" ,$_GET["sub"]);
			$action = $_GET["action"];

			$this->__init();
		
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();

			switch ($sub) {
				case "landing":					
					return $this->Landing();
				break;

				case "category":					
					return $this->Landing();
				break;

				case "product":
					return $this->ReplaceTexts(
						$this->Product()
					);
				break;

				case "ajax.post-question":
					return $this->AjaxPostQuestion();
				break;

				case "ajax.post-review":
					return $this->AjaxPostReview();
				break;

				case "ajax.reviews":
					return $this->AjaxReviews(
						(int)$_POST["pid"],
						max((int)$_POST["p"] , 2)
					);
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
			"details"	=> "details.htm",
			"form"		=> "form.htm",
			"landing"	=> "landing.htm",
			"products"	=> "products.htm",
			"ask"		=> "ask.htm",
			"reviews"		=> "review.htm",
			"specifications"		=> "specifications.htm",
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

		$products = $this->GetProducts($_GET);

		$products["records"] = $this->ProcessProducts($products["records"]);


		$return  = $this->private->templates["landing"]->blockreplace(
			"Main",
			array(
			
				"title"	=> $this->tpl_module["mod_long_name"],

				"content"	=> $this->private->templates["products"]->blockReplace(
					"Main",
					array(
						"products"	=> $base->html->table(
							$this->private->templates["products"],
							"",
							$products["records"]
						),
						
						"paging"=> $this->module->plugins["paging"]->Paging(
							$products["pages"] , 
							$products["page"], 
							array(
								"first"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . ($_GET["category"] ? $_GET["category"] . "/": "") . ($_GET["s"] ? "?s={$_GET[s]}&o={$_GET[o]}&q={$_GET[q]}": "") ) ,
								"all"		=> $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . ($_GET["category"] ? $_GET["category"] . "/": "") . ($_GET["s"] ? "?s={$_GET[s]}&o={$_GET[o]}&q={$_GET[q]}&page={PAGE}": "{PAGE}/") ) ,
							),
							array(
								"ipp"	=> $products["ipp"],
								"total"	=> $products["count"]
							)
						),

					)
				),

				"search_form"	=> $this->SearchForm($_GET),


				"categories"	=> $this->module->plugins["common"]->Categories(
					$this->GetCategories(),
					$_GET["cat"],
					$this->tpl_module["settings"]["set_categories_type"]
				),

				
			)
		);

		return $this->Texts($return);

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
	function SearchForm($vars) {
		global $base;

		$sort = array(
			"p"	=> $this->tpl_module["settings"]["set_filter_price"],
			"n"	=> $this->tpl_module["settings"]["set_filter_name"],
			"d"	=> $this->tpl_module["settings"]["set_filter_date"],
			"s"	=> $this->tpl_module["settings"]["set_filter_sales"],
		);

		$order = array(
			""
		);

		if (!$sort[$_GET["s"]]) {
			$default_sort = "n";
		} else {
			$default_sort = $_GET["s"];
		}
		
		if ($_GET["o"] == "d") {
			$default_order = "d";
		} else {
			$default_order = "a";
		}


		foreach ($sort as $key => $val) {
			$_sort[] = array(
				"class"	=> $key == $default_sort ? "selected" : "",
				"title"	=> $val,
				"link"	=> $this->module->plugins["modules"]->PrepareLink( $this->tpl_module["mod_url"] ."/" . ($_GET["category"] ? $_GET["category"] . "/": "") . "?s={$key}" . ($_GET["q"] ? "&q={$_GET[q]}" : "")),
			);
		}

		$_order = array(
			array(
				"class"	=> $default_order == "a" ? "selected" : "",
				"title"	=> $this->tpl_module["settings"]["set_filter_asc"],
				"link"	=> $this->module->plugins["modules"]->PrepareLink( $this->tpl_module["mod_url"] ."/" . ($_GET["category"] ? $_GET["category"] . "/": "") . "?s={$default_sort}&o=a" . ($_GET["q"] ? "&q={$_GET[q]}" : "")),
			),
			
			array(
				"class"	=> $default_order == "d" ? "selected" : "",
				"title"	=> $this->tpl_module["settings"]["set_filter_desc"],
				"link"	=> $this->module->plugins["modules"]->PrepareLink( $this->tpl_module["mod_url"] ."/" . ($_GET["category"] ? $_GET["category"] . "/": "") . "?s={$default_sort}&o=d" . ($_GET["q"] ? "&q={$_GET[q]}" : "")),
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

				"link"	=> $this->module->plugins["modules"]->PrepareLink( $this->tpl_module["mod_url"] ."/" . ($_GET["category"] ? $_GET["category"] . "/": "")),

				"search"	=> $_GET["q"] ? $_GET["q"] : $this->tpl_module["settings"]["set_filter_search"],


			)
		);
	}

	function GetCategories() {
		$cats = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:shop_cats']} WHERE module_id={$this->tpl_module[mod_id]} ORDER BY cat_order"
		);

		if (is_array($cats)) {
			foreach ($cats as $key => $val) {
				$cats[$key]["link"] = $this->module->plugins["modules"]->PrepareLink($this->tpl_module["mod_url"] . "/" . $val["cat_url"] . "/");
			}
		}
		

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
	function ProcessProducts($products) {

		if (is_array($products)) {
			foreach ($products as $key => $val) {
				$products[$key]["image"] = $this->private->templates["products"]->blockReplace(
					$val["item_image"] ? "Image" : "NoImage",
					$val
				);

				$products[$key]["price"] = $this->FormatPrice($val["item_price"]);

				if ($val["item_set_details"]) {
					$products[$key]["link:details"] = $this->module->plugins["modules"]->PrepareLink(
						$this->tpl_module["mod_url"] . "/" . $val["cat_url"] . "/" . $val["item_url"] . "-" . $val["item_id"] . "/"
					);

					$products[$key]["details"] = $this->private->templates["products"]->blockReplace(
						"Details",
						$products[$key]
					);
				} else {
					$products[$key]["link:details"] = "#";
					$products[$key]["details"] = "";
				}

				//check if i have shop for this module
				if ($this->tpl_module["settings"]["set_disable_add"]) {
					$products[$key]["add"] = "";
						
				} else {
					$products[$key]["add"] = $this->private->templates["products"]->blockReplace(
						"AddToCart",
						$products[$key]
					);
				}
				
				
			}			
		}
		

		return $products;
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
	function FormatPrice($price) {

		$sign = $this->vars->data["set_shop_currency_sign"];
		$spacer = "";

		$price = number_format(
			$price , 
			$this->vars->data["set_shop_number_dec_count"],
			$this->vars->data["set_shop_number_dec"],
			$this->vars->data["set_shop_number_mul"]
		);
	


		switch ($this->vars->data["set_shop_currencyposition"]) {
			case "before":
				return $sign . $spacer . $price;
			break;

			case "after":
				return $price . $spacer . $sign;
			break;
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
	function GetProducts($search) {

		$count = $this->tpl_module["settings"]["set_ipp"];


		$sort = array(
			"p"	=> "item_price",
			"n"	=> "item_title",
			"d"	=> "item_date",
			"s"	=> "item_sales",
		);

		$order_t = array(
			"a"	=> "ASC",
			"d"	=> "DESC"
		);

		if (!$sort[$_GET["s"]]) {
			$default_sort = "n";
		} else {
			$default_sort = $_GET["s"];
		}
		
		if ($_GET["o"] == "d") {
			$default_order = "d";
		} else {
			$default_order = "a";
		}

		$order = $sort[$default_sort];
		$order_mode = $order_t[$default_order];


		if ($_GET["pu"]) {
			$tmp = explode(" " , $_GET["pu"]);
			$_GET["pu"] = (int)trim($tmp[0]);
		}

		$q	= array(
			"category"	=> "cat_url LIKE \"{$_GET[category]}\" ",
		);

		if ($_GET["q"]) {
			$tmp = explode(" " , $_GET["q"]);
			foreach ($tmp as $key => $val) {
				$sql[] = " item_title like \"%{$val}%\"";
			}			
		}
		

		$query = $_GET;

		foreach ($query as $key => $val) {
			if ($val && $q[$key]) {
				$sql[] = $q[$key];
			}			
		}

		$products_count = $this->db->RowCount(
			"{$this->tables['plugin:shop_items']} as i , {$this->tables['plugin:shop_cats']} ",
			"WHERE i.module_id={$this->tpl_module[mod_id]} AND cat_id=item_cat  " . ($sql ? " AND " . implode(" AND " , $sql ) : " " )
		);

		$page = $_GET["page"];

		if (!$page && $products_count) {
			$page = 1;
		} else 
			$page = (int)$page;

		$products = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:shop_items']} as i , {$this->tables['plugin:shop_cats']} " . 
			"WHERE i.module_id={$this->tpl_module[mod_id]} AND cat_id=item_cat " .

			($sql ? " AND " . implode(" AND " , $sql ) : " " ) .

			" ORDER BY  {$order} {$order_mode} " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_Array($products)) {
			foreach ($products as $key => $val) {
				$products[$key]["prixsearch"] = number_format($val["prixsearch"] , 0 , "," , ".");
			}
			
		}

		$records = array(
			"records"	=> $products , 
			"count"		=> $products_count , 
			"pages"		=> $products_count ? ceil($products_count / $count) : 1,
			"page"		=> $page,

			"ipp"		=> $count,

		);

		return $records;
	}
	
	


	
	function AjaxPostReview() {

		$product = $this->db->QFEtchArray("SELECT * FROM {$this->tables['plugin:shop_items']} WHERE item_id=\"{$_POST['p']}\"");

		if (!is_array($product)) {
			return "Unknown error !";
		}

		//load the module info
		$_GET["module_id"] = $product["module_id"];
		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();
		

		//check for all fields
		$fields = array(
			"name"		=> "set_reviews_namealert", 
			"email"		=> "set_reviews_emailalert" , 
			"message"	=> "set_reviews_messagealert", 
		);

		foreach ($fields as $key => $val) {
			if (!$_POST[$key]) {
				return  $this->module->plugins["common"]->ErrorMsg(
					$this->tpl_module["settings"][$val]
				);
			}			
		}		
		
		$review = array(
			"module_id"			=> $product["module_id"],
			"item_date"			=> time(),
			"item_parent"		=> $product["item_id"],
			"item_name"			=> $_POST["name"],
			"item_email"		=> $_POST["email"],
			"item_text"			=> $_POST["message"],
			"item_status"		=> "1",
		);

		$this->db->QueryInsert(
			$this->tables["plugin:shop_reviews"],
			$review
		);

		//send the email for admin
		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_review_admin"],
				array_merge(
					$product , 
					$_POST
				)
			)
		);			

		//send the email for user
		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_review_client"],
				array_merge(
					$product , 
					$_POST
				)
			)
		);			

		return  $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_reviews_success"]
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
	function AjaxPostQuestion() {

		$product = $this->db->QFEtchArray("SELECT * FROM {$this->tables['plugin:shop_items']} WHERE item_id=\"{$_POST['p']}\"");

		if (!is_array($product)) {
			return "Unknown error !";
		}

		//load the module info
		$_GET["module_id"] = $product["module_id"];
		$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();
		

		//check for all fields
		$fields = array(
			"name"		=> "set_ask_namealert", 
			"phone"		=> "set_ask_phonealert",
			"email"		=> "set_ask_emailalert" , 
			"subject"	=> "set_ask_subjectalert", 
			"message"	=> "set_ask_messagealert", 
		);

		foreach ($fields as $key => $val) {
			if (!$_POST[$key]) {
				return  $this->module->plugins["common"]->ErrorMsg(
					$this->tpl_module["settings"][$val]
				);
			}			
		}		



		$question = array(
			"module_id"			=> $product["module_id"],
			"item_date"			=> time(),
			"item_parent"		=> $product["item_id"],
			"item_name"			=> $_POST["name"],
			"item_email"		=> $_POST["email"],
			"item_phone"		=> $_POST["phone"],
			"item_subject"		=> $_POST["subject"],
			"item_question"		=> $_POST["message"],
			"item_status"		=> "1",
		);

		$this->db->QueryInsert(
			$this->tables["plugin:shop_questions"],
			$question
		);

		//send the email for admin
		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_ask_admin"],
				array_merge(
					$product , 
					$_POST
				)
			)
		);			

		//send the email for user
		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_ask_client"],
				array_merge(
					$product , 
					$_POST
				)
			)
		);			


		return  $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_ask_success"]
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
	function Product() {
		$product = $this->GetProduct($_GET["product_id"]);

		if (!is_array($product)) {
			$this->module->plugins["common"]->Redirect404();
		}


		$product = $this->ProcessProduct($product);


		return $this->private->templates["details"]->blockReplace(
			"Main",
			$product
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
	function ProcessProduct($product , $raw = false) {
		global $base , $_CONF;

		$this->__init();

		$product["price"] = $this->FormatPrice($product["item_price"]);

		//process small images
		if (is_Array($product["gallery"])) {
			$product["gallery"] = $base->html->table(
				$this->private->templates["details"],
				"Images" , 
				$product["gallery"]
			);
		} else 
			$product["gallery"] = "";
		
		//process image
		$product["image"] = $this->private->templates["details"]->blockReplace(
			$product["item_image"] ? "Image" : "NoImage",
			$product
		);

		//process variations
		if (is_array($product["variations"])) {

			foreach ($product["variations"] as $key => $val) {
				$tmp = explode("\n" , $val["item_options"]);
				if (count($tmp)) {
					foreach ($tmp as $k => $v) {

						if (trim($v)) {
							$tmp2 = explode(":" , trim($v));

							$val["options"][$tmp2[0]] = array(
								"name"	=> $tmp2[0] . ($tmp2[1] ? "( " . ($tmp2[1] > 0 ? "+" : "-" ) .$this->formatPrice($tmp2[1]) . ")" : "") ,
								"value"	=> $tmp2[0],
								"price"	=> $tmp2[1]
							);
						}
					}
				}

				if (!$raw)
					$product["variations"][$key]["options"] = $base->html->Table(
						$this->private->templates["details"],
						"Options",
						$val["options"]
					);				
				else
					$product["variations"][$key]["options"] = $val["options"];
			}

			if (!$raw)
				$product["variations"] = $base->html->table(
					$this->private->templates["details"],
					"Variations",
					$product["variations"]
				);
		} else {

		}
		

		//check for comments
		$product["comments"] = $this->module->plugins["comments"]->Comments(
			$this->tpl_module["mod_url"] . "/" . $product["cat_url"] . "/" . $product["item_url"] . "-" . $product["item_id"] . "/",
			$this->tpl_module["settings"]["set_fbcomments"]
		);

		//process the specs 
		if ($product["item_specs"]) {
			$lines = explode("\n" , $product["item_specs"]);

			foreach ($lines as $key => $val) {
				$line = explode("|" , $val);

				foreach ($line as $k => $v) {
					$_lines[$key][$k] = $this->private->templates["specifications"]->blockReplace("SpecificationsLine" , array("value" => trim($v)));
				}

				$_lines[$key] = $this->private->templates["specifications"]->blockreplace(
					"SpecificationsRow",
					array(
						"data"	=> @implode("" , $_lines[$key])
					)
				);
			}

			$header = $_lines[0];
			unset($_lines[0]);

			$product["specifications"] = $this->private->templates["specifications"]->blockREplace(
				"Specifications",
				array(
					"header"		=> $header,
					"content"		=> @implode("" , $_lines)
				)
			);

			$product["specifications_button"] = $this->private->templates["specifications"]->blockREplace(
				"SpecificationsButton",
				$this->tpl_module["settings"]
			);

		} else {
			$product["specifications"] = "";
			$product["specifications_button"] = "";
		}


		//check for users reviews
		if ($this->tpl_module["settings"]["set_reviews"]) {
			$product["reviews_button"] = $this->private->templates["reviews"]->blockREplace(
				"Button",
				array_merge(
					$this->tpl_module["settings"],
					$product
				)
			);

			$reviews = $this->AjaxReviews($product["item_id"] , 1); 

			$product["reviews"] = $this->private->templates["reviews"]->blockReplace(
				"Reviews" , 
				array(
					"more"	=> $reviews ? $this->private->templates["reviews"]->blockREplace(
						"LoadMore",
						$product
					) : "",

					"new"	=> $this->private->templates["reviews"]->blockReplace(
						"NewReview",
						$product
					),

					"data"	=> $reviews
				)
			);
		} else {

			$product["reviews_button"] = "";
			$product["reviews"] = "";
		}

		//check for ask a question
		if ($this->tpl_module["settings"]["set_askquestion"]) {
			$product["ask_button"] = $this->private->templates["ask"]->blockREplace(
				"Button",
				array_merge(
					$this->tpl_module["settings"],
					$product
				)
			);

			$product["ask_widget"] = $this->private->templates["ask"]->blockREplace(
				"Main",
				array_merge(
					$this->tpl_module["settings"],
					$product
				)
			);
		} else {
			$product["ask_button"] = "";
			$product["ask_widget"] = "";
		}

		//process some links 
		$product["link:checkout"] = $this->module->plugins["modules"]->PrepareLink("cart/");

		//process the back link
		if ($_GET["category"]) {
			$product["link:back"] = $this->module->plugins["modules"]->PrepareLink(
				$this->tpl_module["mod_url"] . "/" . $product["cat_url"] . "/"
			);
		} else {
			$product["link:back"] = $this->module->plugins["modules"]->PrepareLink(
				$this->tpl_module["mod_url"] . "/"
			);
		}

		//parepare the next and back buttons ( not used in this version )
		$product["next"] = "";
		$product["back"] = "";


		if ($this->tpl_module["settings"]["set_disable_add"]) {
			$product["add"] = "";
				
		} else {
			$product["add"] = $this->private->templates["details"]->blockReplace(
				"AddToCart",
				$product
			);
		}


		return $product;
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
	function AjaxReviews($pid , $page) {
		global $base;

		$count = 2;

		$product = $this->db->QFetchArray("SELECT  * FROM {$this->tables['plugin:shop_items']} WHERE item_id={$pid}");

		if (!is_array($product)) {
			return "";
		}

		if (!$this->tpl_module["settings"]) {
			$_GET["module_id"] = $product["module_id"];
			$this->tpl_module = $this->module->plugins["modules"]->LoadModuleInfo();
		}
				
		if (!$page)
			$page = 1;
		else 
			$page = (int)$page;

		$reviews = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:shop_reviews']} " . 
			"WHERE item_parent={$product[item_id]} AND item_status=2 " .

			" ORDER BY  item_date DESC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_array($reviews)) {
			foreach ($reviews as $key => $val) {
				$reviews[$key]["date"] = date($this->tpl_module["settings"]["set_date_format_comments"] , $val["item_date"]);
			}
			
			return CTemplateStatic::Replace(
				$base->html->Table(
					$this->private->templates["reviews"],
					"",
					$reviews
				),
				$this->tpl_module["settings"]
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
	function GetProduct($id , $small = false) {

		if ($this->tpl_module["mod_id"])
			$cond = "AND p.module_id={$this->tpl_module[mod_id]}";
		else 
			$cont = "";
		

		$item = $this->db->QFetchArray(
			"SELECT * FROM {$this->tables['plugin:shop_items']} as p , {$this->tables['plugin:shop_cats']} " . 
			"WHERE item_cat=cat_id {$cond} AND item_id=\"{$id}\""
		);

		if (!is_array($item)) {
			return "";
		}

		if ($small) {
			return $item;
		}
		

		$item["gallery"] = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:shop_images']} WHERE item_parent={$item[item_id]} ORDER BY item_order"
		);

		if (is_array($item["gallery"])) {
			foreach ($item["gallery"] as $key => $val) {
				switch ($val["item_type"]) {
					case "1":
						$item["gallery"][$key]["source"] = "upload/shop/gallery/{$val[item_id]}.jpg";
					break;

					case "2":
						$item["gallery"][$key]["source"] = "upload/shop/gallery/{$val[item_id]}.mp4";
					break;

					case "4":
						$item["gallery"][$key]["source"] = $val["item_youtube"];
					break;

				}
				
			}			
		}
		

		$item["variations"] = $this->db->QFetchRowArray(
			"SELECT * FROM {$this->tables['plugin:shop_variations']} WHERE item_parent={$item[item_id]} ORDER BY item_order"
		);

		//replace variations keys
		if (is_array($item["variations"] )) {
			foreach ($item["variations"] as $key => $val) {
				$_vars[$val["item_name"]] = $val;
			}
			
			$item["variations"] = $_vars;
		}
		

		return $item;
	}
	


	function AlternateContent() {
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
	function ReplaceTexts($content) {
		return CTemplateStatic::Replace(
			$content , 
			$this->tpl_module["settings"]
		);
	}


	function Texts($content) {

		return CTemplateStatic::Replace(
			$content ,
			$this->tpl_module["settings"]
		);
	}

	
}


?>