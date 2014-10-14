<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2007 OXYLUS Development
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

class COXYMallPaging extends CPlugin{
	
	var $tplvars; 

	function COXYMallPaging() {
		//$this->CPlugin($db, $tables , $templates);
	}


	function DoEvents(){
	}


	function __init() {
		global $_CONF , $_DOMAIN_CODE;

		if ($this->__inited) {
			return "";
		}

		$this->__inited = true;
		
		$path = $this->tpl_path;

		$templates = array(
			"paging" => "paging.htm",
		);

		foreach ($templates as $key => $val) {
			$this->private->templates[$key] = new CTemplateDynamic(
				$path . $val
			);
		}
	}


	function _Paging($pages , $current , $link , $total = 0) {

		$this->__init();

		if ($pages <= 1) {
			return "";
		}
		

		$tpl = &$this->private->templates["paging"];

		//defaults
		$adjacents = 3;
		$limit = 1;		
		$page = $current;
		
		//other vars
		$prev = $page - 1;									//previous page is page - 1
		$next = $page + 1;									//next page is page + 1
		$lastpage = ceil($pages / $limit);				//lastpage is = total items / items per page, rounded up.
		$lpm1 = $lastpage - 1;								//last page minus 1

		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/

		if (is_array($link)) {
			$link0 = $link["first"];
			$link1 = $link["all"];
			$link2 = $link["last"] ? $link["last"] : $link["all"];
		} else
			$link0 = $link1 = $link2 = $link;

		if($lastpage > 1) {	
			
			if ($page > 1) {
				$prev_html= $tpl->blockReplace(
					"Back" , 
					array(
						"url" => CTemplateStatic::Replace( $current == 2 ? $link0 : $link1 , array("page" => $prev )),
						"page" => $prev
					)
				);
			} else {
				$prev_html = $tpl->blockReplace(
					"BackDisabled" , 
					array(
						"page" => $prev
					)
				);
			}
			
						
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++) {

					//detect the link
					if ($counter == 1) {
						$tmp_link = $link0;
					} else {
						if ($counter == $lastpage)
							$tmp_link = $link2;
						else 
							$tmp_link = $link1;
					}

					if ($counter == $page)
						$html .= $tpl->blockReplace(
							"PageCurrent" , 
							array(
								"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
								"page" => $counter
							)
						);
					else
						$html .= $tpl->blockReplace(
							"Page" , 
							array(
								"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
								"page" => $counter
							)
						);
				}
			}
			elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 3))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{

						if ($counter == 1) {
							$tmp_link = $link0;
						} else {
							if ($counter == $lastpage)
								$tmp_link = $link2;
							else 
								$tmp_link = $link1;
						}


						if ($counter == $page)
							$html .= $tpl->blockReplace(
								"PageCurrent" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
						else
							$html .= $tpl->blockReplace(
								"Page" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
					}

					$html .= $tpl->blockReplace(
						"Dots" , 
						array()
					);
					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => $lpm1 )),
							"page" => $lpm1
						)
					);
					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => $lastpage )),
							"page" => $lastpage
						)
					);
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{

					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link0 , array("page" => 1 )),
							"page" => 1
						)
					);
					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => 2 )),
							"page" => 2
						)
					);
					$html .= $tpl->blockReplace(
						"Dots" , 
						array()
					);

					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{

						if ($counter == 1) {
							$tmp_link = $link0;
						} else {
							if ($counter == $lastpage)
								$tmp_link = $link2;
							else 
								$tmp_link = $link1;
						}

						if ($counter == $page)
							$html .= $tpl->blockReplace(
								"PageCurrent" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
						else
							$html .= $tpl->blockReplace(
								"Page" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
					}
					$html .= $tpl->blockReplace(
						"Dots" , 
						array()
					);

					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => $lpm1 )),
							"page" => $lpm1
						)
					);
					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => $lastpage )),
							"page" => $lastpage
						)
					);
				}
				//close to end; only hide early pages
				else
				{

					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link0 , array("page" => 1 )),
							"page" => 1
						)
					);
					$html .= $tpl->blockReplace(
						"Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => 2 )),
							"page" => 2
						)
					);
					$html .= $tpl->blockReplace(
						"Dots" , 
						array()
					);

					for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
					{
						if ($counter == 1) {
							$tmp_link = $link0;
						} else {
							if ($counter == $lastpage)
								$tmp_link = $link2;
							else 
								$tmp_link = $link1;
						}

						if ($counter == $page)
							$html .= $tpl->blockReplace(
								"PageCurrent" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
						else
							$html .= $tpl->blockReplace(
								"Page" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
					}
				}
			}

			if ($page < $lastpage) {
				$next_html = $tpl->blockReplace(
					"Next" , 
					array(
						"url" => CTemplateStatic::Replace( $link1 , array("page" => $next )),
						"page" => $next
					)
				);
			} else {
				$next_html= $tpl->blockReplace(
					"NextDisabled" , 
					array(
						"url" => CTemplateStatic::Replace( $link1 , array("page" => $next )),
						"page" => $next
					)
				);
			}

		}

		return  $tpl->blockReplace(
			"Main" , 
			array(
				"data" => $html,
				"next" => $next_html,
				"prev" => $prev_html,
				"from" => ($current - 1 ) * 7 + 1,
				"to" => min($total , ($current ) * 7 ),
				"total" => $total,
			)
		);

	}



	function Paging($pages , $current , $link , $ipp = 0) {
		$this->__init();
	
		$tpl = &$this->private->templates["paging"];

		$max = 7;

		if ($pages > 1) {

			if (is_array($link)) {
				$link0 = $link["first"];
				$link1 = $link["all"];
				$link2 = $link["last"] ? $link["last"] : $link["all"];
			} else
				$link0 = $link1 = $link2 = $link;

			//$current = 8;

			//i have less pages the max that fit
			if ($pages <= $count) {
				for ($i = 1 ; $i<= $pages ; $i++) {

					if ($i == 1) {
						$clink = $link0;
					} else {
						if ($i == $pages) {
							$clink = $link2;
						} else 
							$clink = $link1;					
					}

					$records[] = $tpl->blockReplace(
						"Page" . ($i == $current  ? "Current" : "")  , 

						array(
							"url" => CTemplateStatic::Replace($clink , array("page" => $i)) , 
							"page" => $i
						)
					);
				}
			} else {

				//i'm at the begining of the pages
				if ($current <= $max) {
					for ($i = 1 ; $i<= (min($pages , $max)) ; $i++) {

						if ($i == 1) {
							$clink = $link0;
						} else {
							if ($i == $pages) {
								$clink = $link2;
							} else 
								$clink = $link1;					
						}

						$records[] = $tpl->blockReplace(
							"Page" . ($i == $current  ? "Current" : "")  , 

							array(
								"url" => CTemplateStatic::Replace($clink , array("page" => $i)) , 
								"page" => $i
							)
						);
					}

					if ($pages > $max) {
						$records[] = $tpl->blockReplace("Middle" , array());
					}

				}  else {

					//i'm at the end of the pages
					if ($current > $pages - $max) {
						$records[] = $tpl->blockReplace("Middle" , array());

						for ($i = ($pages - $max+1) ; $i<= $pages ; $i++) {

							if ($i == 1) {
								$clink = $link0;
							} else {
								if ($i == $pages) {
									$clink = $link2;
								} else 
									$clink = $link1;					
							}

							$records[] = $tpl->blockReplace(
								"Page" . ($i == $current  ? "Current" : "")  , 

								array(
									"url" => CTemplateStatic::Replace($clink , array("page" => $i)) , 
									"page" => $i
								)
							);
						}
					} else {
						//i'm in the middle

						$records[] = $tpl->blockReplace("Middle" , array());
						$count = ceil($max / 2 );

						for ($i = $current - $count + 1; $i <= $current + $count -1; $i ++) {
							$records[] = $tpl->blockReplace(
								"Page" . ($i == $current  ? "Current" : "")  , 

								array(
									"url" => CTemplateStatic::Replace($link1 , array("page" => $i)) , 
									"page" => $i
								)
							);							
						}
						
						$records[] = $tpl->blockReplace("Middle" , array());


					}
				}				
			}
			
			

			$next_html = $tpl->blockReplace(
				($current < $pages) ? "Next" : "NextDisabled", 
				array(
					"url" => CTemplateStatic::Replace($link1 , array("page" => $current + 1)) , 
					"page" => $current + 1
				)
			);			


			$prev_html = $tpl->blockReplace(
				($current > 1) ? "Back" : "BackDisabled", 
				array(
					"url" => CTemplateStatic::Replace($current == 2 ? $link0 : $link1 , array("page" => $current - 1)) , 
					"page" => $current - 1
				)
			);


			if ($ipp) {

				$summary = $tpl->blockReplace(
					"Summary",
					array(
						"from"	=> ($current-1) * $ipp["ipp"] + 1,
						"to"	=> min($ipp["total"] , ($current-1) * $ipp["ipp"] + $ipp["ipp"]),
						"total"	=> $ipp["total"],
					)
				);
			}
			

			return $tpl->blockReplace(
				"Main", 
				array(	
					"sum"		=> $ipp ? $summary : "",

					"page"		=> $current , 
					"pages"		=> $pages,
					"prev"		=> $prev_html,
					"next"		=> $next_html,

					"data" => implode(
						$tpl->blockReplace("Sep" , array()),
						$records
					)
				)
			);
		} return "";
		
	}

	
}

?>