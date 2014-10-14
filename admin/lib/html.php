<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: html.php,v 0.0.1 09/03/2003 20:38:15 Exp $
	HTML Forms

	contact:
		www.oxylus.ro
		office@oxylus.ro

* @library	HTML
* @author	OXYLUS [OXYLUS.ro <devel@oxylus.ro>]
* @since	PHPbase 0.0.1
*/

class CHTML {

	function CustomPaging($template , $preffix = "" , $show = 10 , $pages , $current , $link , $jump = true) {

		if ($pages <= 1) {
			return "";
		}

		$tpl = &$template;

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
			$link3 = $link["jump"];
		} else
			$link0 = $link1 = $link2 = $link;

		if($lastpage > 1) {	
			
			if ($page > 1) {
				$html.= $tpl->blockReplace(
					$preffix . "Back" , 
					array(
						"url" => CTemplateStatic::Replace( $current == 2 ? $link0 : $link1 , array("page" => $prev )),
						"page" => $prev
					)
				);
			} else {
				$html.= $tpl->blockReplace(
					$preffix . "BackDisabled" , 
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
							$preffix . "PageCurrent" , 
							array(
								"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
								"page" => $counter
							)
						);
					else
						$html .= $tpl->blockReplace(
							$preffix . "Page" , 
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
								$preffix . "PageCurrent" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
						else
							$html .= $tpl->blockReplace(
								$preffix . "Page" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
					}

					$html .= $tpl->blockReplace(
						$preffix . "Dots" , 
						array()
					);
					$html .= $tpl->blockReplace(
						$preffix . "Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => $lpm1 )),
							"page" => $lpm1
						)
					);
					$html .= $tpl->blockReplace(
						$preffix . "Page" , 
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
						$preffix . "Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link0 , array("page" => 1 )),
							"page" => 1
						)
					);
					$html .= $tpl->blockReplace(
						$preffix . "Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => 2 )),
							"page" => 2
						)
					);
					$html .= $tpl->blockReplace(
						$preffix . "Dots" , 
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
								$preffix . "PageCurrent" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
						else
							$html .= $tpl->blockReplace(
								$preffix . "Page" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
					}
					$html .= $tpl->blockReplace(
						$preffix . "Dots" , 
						array()
					);

					$html .= $tpl->blockReplace(
						$preffix . "Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => $lpm1 )),
							"page" => $lpm1
						)
					);
					$html .= $tpl->blockReplace(
						$preffix . "Page" , 
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
						$preffix . "Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link0 , array("page" => 1 )),
							"page" => 1
						)
					);
					$html .= $tpl->blockReplace(
						$preffix . "Page" , 
						array(
							"url" => CTemplateStatic::Replace( $link1 , array("page" => 2 )),
							"page" => 2
						)
					);
					$html .= $tpl->blockReplace(
						$preffix . "Dots" , 
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
								$preffix . "PageCurrent" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
						else
							$html .= $tpl->blockReplace(
								$preffix . "Page" , 
								array(
									"url" => CTemplateStatic::Replace( $tmp_link , array("page" => $counter )),
									"page" => $counter
								)
							);
					}
				}
			}

			if ($page < $lastpage) {
				$html.= $tpl->blockReplace(
					$preffix . "Next" , 
					array(
						"url" => CTemplateStatic::Replace( $link1 , array("page" => $next )),
						"page" => $next
					)
				);
			} else {
				$html.= $tpl->blockReplace(
					$preffix . "NextDisabled" , 
					array(
						"url" => CTemplateStatic::Replace( $link1 , array("page" => $next )),
						"page" => $next
					)
				);
			}

		}

		return  $tpl->blockReplace(
			$preffix . "Main" , 
			array(
				"data" => $html,
				"jump" => $jump ? $tpl->blockReplace(
					$preffix . "Jump" , 
					array(
						"url" => $link1,
					)
				) : ""
			)
		);

	}

	/**
	* generates paging from user data
	*
	* @param mixed $template	template file or object to work w/
	* @param int $ic			total number of items
	* @param int $ipp			items per page
	* @param int $cp			current page
	* @param array $vars		template vars [if any]
	* @param bool $pn			also include prev/next controls? [defaults to TRUE]
	*
	* @return string html page code
	*
	* @access public
	*/
	function Paging($template,$ic,$ipp,$cp,$vars,$pn = TRUE) {

		if ($ipp == 0) 
			return "";

		// check to see if paging required
		if ($ic > $ipp) {
			// init vars
			$result = "";

			// load template
			if (!is_object($template)) {
				$template = new CTemplate($template);
			}

			// set some helper templates
			$tpl_normal = $template->blocks["Page"];
			$tpl_active = $template->blocks["PageActive"];

			// compute page count
			$pc = round(ceil($ic / $ipp));

			// validate page
			if ($cp < 1)
				$cp = 1;
			elseif ($cp > $pc)
				$cp = $pc;

			// iterate thru all the pages
			for ($i = 0; $i < $pc; $i++) {
				// increment zerobased iterator
				$pn = $i + 1;

				// build template and make clickable if needed
				$tpl = ($pn == $cp) ? $tpl_active : $tpl_normal;

				// fill vars
				$vars["PAGE"] = $pn;
				$vars["FACE"] = $pn;

				// replace vars and add to result
				$result .= $tpl->Replace($vars);
			}

			// build prev/next
			if ($pn == TRUE) {
				// check if first page
				if ($cp > 1) {
					// fill vars
					$vars["PAGE"] = $cp - 1;
					$vars["FACE"] = $template->blocks["Prev"]->output;

					// replace vars and prepend to result
					$result = $tpl_normal->Replace($vars) . $result;
				}

				// check if last page
				if ($cp < $pc) {
					// fill vars
					$vars["PAGE"] = $cp + 1;
					$vars["FACE"] = $template->blocks["Next"]->output;

					// replace vars and append to result
					$result .= $tpl_normal->Replace($vars);
				}
			}

			// add the extra info and the pages to the result
			$return["ITEM_COUNT"] = $ic;
			$return["CURRENT_PAGE"] = $cp;
			$return["PAGE_COUNT"] = $pc;
			$return["PAGES"] = $result;

			// return the result
			return $template->blocks["Main"]->Replace($return);
		} else
			return "";
	}

	/**
	* dinamically generates a select form element w/ the provided data
	*
	* @param string $name		tag name attribute
	* @param array $vars		array of option values in the form of "VAL" => "NAME"
	* @param object $template	template object to use for generation
	* @param string $block		name of template block which contains the select body
	* @param string $selected	selected item if any [defaults to void]
	* @param array	$extra_vars	extra variables to be replaced in each option [keys must be
	*							the same of $vars to work properly]
	* @param array	$global_vars extra variables to be replaced in select
	*
	* @return string generated html code
	*
	* @access public
	*/
	function FormSelect($name,$vars,$template,$block,$selected = "",$extra_vars = array(), $global_vars = array()) {

		if (is_array($vars))
			foreach ($vars as $key => $val) {
				$replace = array(
					"VALUE" => $key,
					"NAME" => $val,
					"SELECTED" => (($key == $selected) ? " selected=\"selected\"" : "")
				);
				
				if (is_array($extra_vars[$key]))
					$replace = array_merge($replace,$extra_vars[$key]);

				$options .= $template->blocks["{$block}Option"]->Replace($replace);
			}

		if (count($global_vars) != 0)
			$select = $global_vars;
		$select["NAME"] = $name;
		$select["OPTIONS"] = $options;

		return $template->blocks["$block"]->Replace($select);
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
	function Select(
		$template,
		$block,
		$values , 
		$selected = "",
		$extra = array()
		) {

		if (is_array($values)) {
			$_values = array();

			//check if thee is an extra infications field
			if ($values["fields"]) {
				$__field__title = $values["fields"]["title"];
				$__field__value = $values["fields"]["value"];

				$values = $values["items"];

				unset($values["fields"]);
			} else {
				$__field__title = "title";
				$__field__value = "value";
			}

			//check for the selected element if exists
			if (!$template->blockExists($block . "OptionSelected"))
				$__selected = $block . "Option";
			else
				$__selected = $block . "OptionSelected";

			$__normal = $block . "Option";
			$__main = $block ;

			if (is_array($values)){

				foreach ($values as $key => $val) {
					if (!is_array($val))
						$_values[] = array($__field__title =>$val , $__field__value => $key);
					else
						$_values[] = $val;
				}

				$values = $_values;
	
				foreach ($values as $key => $val)
					
					$output .= $template->BlockReplace(
					
						($selected == $val[$__field__value] ? $__selected : $__normal) , 
						array(
							"title" => $val[$__field__title],
							"value" => $val[$__field__value]
						)
					);
			}

			$return = $template->blockReplace($__main , array ("options" => $output ) );
					
			if (is_array($extra) && count($extra))
				//if there are extra values replace them in the existing table
				return CTemplateStatic::Replace($return , $extra);
			else
				//else return the default 
				return $return;			
		}

		//no values so nothing to return
		return "";
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
	function Table($template,$template_block,$data,$has_paging = FALSE,$element_count = 0,$elements_per_page = 0,$page = 0,$paging_template = NULL,$paging_vars = array()) {
		if (is_array($data) && count($data)) {
			foreach ($data as $element) 
				$return .= $template->BlockReplace($template_block . "Element",$element);

			$group = "Group";			
		} else {
			$return = $template->BlockReplace($template_block . "Empty" , array());
			$group = "Group" . ( $template->blockExists($template_block . "GroupEmpty") ? "Empty" : "");
		}

		if ($has_paging == TRUE) {
			$paging = $this->Paging($paging_template,$element_count,$elements_per_page,$page,$paging_vars);

			return $template->BlockReplace(
					$template_block . $group, 
					array(
						"DATA" => $return, 
						"PAGING" => $paging
					)
			);
		} else {
			return $template->BlockReplace(
					$template_block . $group, 
					array(
						"DATA" => $return, 
						//"PAGING" => $paging
					)
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
	function TableSimple($template,$block,$items,$vars = array(),$filler_func = NULL,$paging = NULL,$page = 0,$tic = 0,$paging_vars = array()) {
		$item_count = count($items);

		if (is_array($items)) {
			foreach ($items as $item) {
				if (is_array($filler_func) && is_array($item))
					call_user_func($filler_func,&$item);

				if ($template->dynamic)
					$rows .= $template->BlockReplace("{$block}Row",$item);
				else				
					$rows .= $template->blocks["{$block}Row"]->Replace($item);
			}
		} else
			if ($template->dynamic)
				$rows .= $template->BlockReplace("{$block}Row",$item);
			else
				$rows = $template->blocks["{$block}Empty"]->output;

		// setup paging
		$_paging = ($paging != NULL) ? $this->Paging($paging,$tic,$item_count,$page,$paging_vars) : "";

		// return the built layout
		return $template->blocks[$block]->Replace(array_merge(array("ROWS" => $rows, "PAGING" => $_paging),$vars));
	}

	/**
	* uses the specified data array to build a very simple table
	*
	* @param object	$template	template to use
	* @param string	$block		template block to use
	* @param array	$data		data array to be processed
	*
	* @return mixed the table or void if empty data
	*
	* @access public
	*/
	function TableLight($template,$block,$data) {
		if ($data == "")
			return "";
		else {
			foreach ($data as $item)
				$rows .= $template->blocks["{$block}Row"]->Replace($item);

			return $template->blocks[$block]->Replace(array("ROWS" => $rows));
		}
	}

	/**
	* builds and displays a multi row/col html table
	*
	* @param mixed $template	template file name or object
	* @param string $block		template block which contains the table body
	* @param array $items		array w/ the table items
	* @param int $rc			row count
	* @param int $cc			column count
	* @param array $vars		array of variables to be replaced in block [if needed]
	* @param mixed $filler_func	array of object and method to call for filling other vars in the item
	* @param mixed $paging		template filename or object used for paging [defaults to NULL]
	* @param int $page			current `page'
	* @param int $tic			total item count [used for paging]
	* @param array $paging_vars	array of vars to be replaced in the paging templates
	*
	* @return string html code of the built table
	*
	* @access public
	*/
	function TableComplex($template,$block,$items,$rc,$cc,$vars = array(),$filler_func = NULL,$paging = NULL,$page = 0,$tic = 0,$paging_vars = array()) {
		// compute item count ?
		$item_count = count($items);

		// if we have any items we proceed
		if (is_array($items)) {
			// recompute row/column count
			$row_count = /*$rc ;*/ceil(count($items) / $cc);
			$column_count = $cc ;//ceil(count($items) / $row_count);

			// setup the column and row data
			$columns = "";
			$rows = "";

			// and the position in the data array
			$key = 0;

			// iterate thru all the rows
			for ($i = 0; $i < $row_count; $i++) {

				// iterate thru all the row`s columns
				for ($j = 0; $j < $column_count; $j++) {
					// set our current item
					$item = $items[$key];

					// then feed it to the filler func if needed
					if (is_array($filler_func) && is_array($item))
						call_user_func($filler_func,&$item);

					// populate column data + check if the cell is empty
					$columns .= (is_array($item)) ? $template->blocks["Column"]->Replace($item) : $template->blocks["ColumnEmpty"]->output;

					// increment the position in the data array
					$key++;
				}

				// populate the row data and reset the column data to prepare it for the next row
				$rows .= $template->blocks["Row"]->Replace(array("COLUMNS" => $columns));
				$columns = "";
			}
		} else
			// we dont have any items so we handle it gracefully
			$rows = $template->blocks["Empty"]->output;
		// setup paging
		$_paging = ($paging != NULL) ? $this->Paging($paging,$tic,$rc*$cc/*$item_count*/,$page,$paging_vars) : "";

		// return the built layout
		return $template->blocks[$block]->Replace(array_merge(array("ROWS" => $rows, "PAGING" => $_paging),$vars));
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
	function error($template,$id) {
		return $template->blocks[$id]->output;
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
	function FormRadio($template,$block,$name,$vars) {
		if (is_array($vars)) {
			foreach ($vars as $key => $val) {
				$vars[$key]["name"] = $name;
			}


			return $this->Table($template, $block , $vars);
			
		}
		return "";
	}
	

/*

0.7
	Addeg GroupEmpty to table funciton. if no elements are passed to the template and the group empty exists then it will be used
	instead of the normal group element

0.6
	Fixed select function when the variables isnt an array

0.4
	Saturday 15 September 2007
		Added the new select funntion. 
		It works only with 

0.3
	Friday 24 August 2007
		Removed SettingsPage();

0.2 
	Thursday 2 August 2007
		
		Added support for dynamic templates

0.1 
	09/03/2003
		Basic functions

*/


}
?>