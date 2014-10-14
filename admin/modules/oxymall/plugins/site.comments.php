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
class COXYMallComments extends CPlugin{
	
	var $tplvars; 

	function COXYMallComments() {
		//$this->CPlugin($db, $tables , $templates);
	}

	function DoEvents(){
		global $base, $_CONF, $_TSM , $_VARS , $_USER , $_BASE , $_SESS;

		parent::DoEvents();

		if ($_GET["sub"] == "oxymall.plugin.comments.ajax.post") {
			return $this->AjaxPost();
		}

		if ($_GET["sub"] == "oxymall.plugin.comments.ajax.read") {
			return $this->AjaxRead();
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
			"fbcomments"				=> "fbcomments.htm",
			"comments"					=> "comments.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}

		$this->tpl_module = $this->module->plugins["modules"]->LoadDefaultModule("comments");

	} 

	function Comments($url , $type) {
		global $_CONF;

		switch ($type) {
			//local comments
			case "1":

				return $this->LocalComments(
					$this->module->plugins["modules"]->PrepareLink($url)
				);
			break;

			case "3":
				return $this->FBComments(
					$this->module->plugins["modules"]->PrepareLink($url)
				);
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
	function AjaxRead() {
		global $base;

		$this->__init();

		$comments = $this->GetRecords($_POST["url"]);
		$url = $_POST["url"];

		$return = $this->private->templates["comments"]->blockreplace(
			"AjaxMain" , 
			array(

				"comments"		=> $base->html->Table(
					$this->private->templates["comments"],
					"",
					$comments["records"]
				),

				"paging"=> $this->module->plugins["paging"]->Paging(
					$comments["pages"] , 
					$comments["page"], 
					array(
						"first"		=> "javascript:loadComments('" . urlencode($url) . "' , '{PAGE}');",
						"all"		=> "javascript:loadComments('" . urlencode($url) . "' , '{PAGE}');",
					),

					array(
						"ipp"	=> $comments["ipp"],
						"total"	=> $comments["count"]
					)
				)
			)
		);

		return CTemplateStatic::Replace(
			$return , 
			$this->tpl_module["settings"]
		);		

	}
	

	function FBComments($url) {
		$this->__init();

		return $this->private->templates["fbcomments"]->blockReplace(
			"Comments",
			array(
				"url"			=> $url,
				"set_items_fb"	=> $this->tpl_module["settings"]["set_items_fb"],
			)
		);
	}

	function LocalComments($url) {
		global $base , $_SESS;

		$this->__init();


		$comments = $this->GetRecords($url);


		$return = $this->private->templates["comments"]->blockreplace(
			"Main" , 
			array(

				"comments"		=> $base->html->Table(
					$this->private->templates["comments"],
					"",
					$comments["records"]
				),

				"paging"=> $this->module->plugins["paging"]->Paging(
					$comments["pages"] , 
					$comments["page"], 
					array(
						"first"		=> "javascript:loadComments('" . urlencode($url) . "' , '{PAGE}');",
						"all"		=> "javascript:loadComments('" . urlencode($url) . "' , '{PAGE}');",
					),

					array(
						"ipp"	=> $comments["ipp"],
						"total"	=> $comments["count"]
					)
				),


				"new_comment"	=> $this->private->templates["comments"]->blockREplace(
					"New",
					array(
						"url"		=> $url ,
						"capcha"	=> (($this->tpl_module["settings"]["set_post_capcha"] == "2") || (($this->tpl_module["settings"]["set_post_capcha"] == "1") && !$_SESS["client"]["user_id"])) ? 
							$this->private->templates["comments"]->blockReplace(
								"Capcha",
								array()
							) : "",

						"name"		=> $_SESS["client"]["user_first_name"],
						"email"		=> $_SESS["client"]["user_email"],
					)
				)
			)
		);

		//prepare the comments title
		if ($comments["count"]) {
			$this->tpl_module["settings"]["set_title"] = CTemplateStatic::Replace(
				$this->tpl_module["settings"]["set_title"],
				array(
					"comments"	=> $comments["count"]
				)
			);
		} else 
			$this->tpl_module["settings"]["set_title"] = $this->tpl_module["settings"]["set_titleno"];
	
		$this->tpl_module["settings"]["set_post_comment"] = nl2br($this->tpl_module["settings"]["set_post_comment"]);

		return CTemplateStatic::Replace(
			$return , 
			$this->tpl_module["settings"]
		);		
	}


	function GetRecords($url) {
		global $_CONF;
		
		$count = $this->tpl_module["settings"]["set_items"];
		$page = $_GET["page"];


		if ($this->tpl_module["settings"]["set_display"]) {
			$cond = " AND item_status=2 ";
		}
		

		$item_count = $this->db->RowCount(
			$this->tables['plugin:comments'],
			"WHERE item_url=\"{$url}\" {$cond} "
		);

		$page = $_POST["page"];

		if (!$page && $item_count) {
			$page = $item_count ? ceil($item_count / $count) : 1;
		} else 
			$page = (int)$page;

		$items = $this->db->QFetchRowArray(
			"SELECT * " . 
			"FROM {$this->tables['plugin:comments']} " . 
			"WHERE item_url=\"{$url}\" {$cond}  " . 
			"ORDER BY  item_date ASC " .
			"LIMIT " . ( max(0,($page - 1 ) * $count )) . " , " . $count 
		);

		if (is_Array($items)) {
			foreach ($items as $key => $val) {
				$items[$key]["item_body"]	=	nl2br(
					strip_tags(
						$val["item_body"]
					)
				);

				$items[$key]["item_date"] = date(
					$this->tpl_module["settings"]["set_comments_date_format"],
					$val["item_date"]
				);

				//process the link
				if ($val["item_website"]) {
					if (!stristr($val["item_website"] , "http://")) {
						$items[$key]["item_website"] = "http://" . $val["item_website"];
					}
				} else 
					$items[$key]["item_website"] = "#";

				//process gravatar link
				$items[$key]["avatar"] = "http://www.gravatar.com/avatar/" . md5($val["item_email"]) . "?s=80&d=" . urlencode($_CONF["url"] . "upload/default-images/comments-avatar.jpg");
				
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
	function AjaxPost() {
		global $_SESS;

		$this->__init();

		$fields = array(
			"name"		=> "set_post_alert_name",
			"email"		=> "set_post_alert_email",
			"message"	=> "set_post_alert_message"
		);

		foreach ($fields as $key => $val) {
			if (!$_POST[$key]) {
				return $this->module->plugins["common"]->ErrorMsg(
					$this->tpl_module["settings"][$val]
				);
			}			
		}

		//check for capcha
		if (($this->tpl_module["settings"]["set_post_capcha"] == "2") || (($this->tpl_module["settings"]["set_post_capcha"] == "1") && !$_SESS["client"]["user_id"])) {

			if ($_POST["image_code"] != $_SESS["XML_verify_key"]) {
				return $this->module->plugins["common"]->ErrorMSG(
					$this->tpl_module["settings"]["set_post_alert_capcha"]
				);
			}			

		}
		

		$this->db->QueryInsert(
			$this->tables["plugin:comments"],
			$comment = array(
				"item_user"		=> $_SESS["client"]["user_id"],
				"item_url"		=> $_POST["url"],
				"item_date"		=> time(),
				"item_author"	=> $_POST["name"],
				"item_website"	=> $_POST["website"],
				"item_email"	=> $_POST["email"],
				"item_body"		=> $_POST["message"],
				"item_status"	=> "1"	//pending				
			)
		);

		$email = $this->module->plugins["mail"]->SendMail(
			$this->module->plugins["mail"]->GetMail(
				$this->tpl_module["settings"]["set_mail_admin"],
				$comment
			)
		);			


		return $this->module->plugins["common"]->SuccessMsg(
			$this->tpl_module["settings"]["set_post_alert_success"],
			$this->tpl_module["settings"]["set_display"] ? "" : $_POST["url"]
		);

	}
	

	
	
}

?>