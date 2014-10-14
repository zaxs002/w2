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
class CTemplateDynamic{
	
	function CTemplateDynamic($source , $source_type = "file") {
		$this->source = array(
				"file" => $source , 
				"type" => $source_type
			);		

		$this->dynamic = true;
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
	function Replace($vars , $clear) {
		$this->__checkObject();

		return $this->template->Replace($vars , $clear);
		
	}

	function EmptyVars($vars = array()) {
		$this->__checkObject();

		//if i have variables then dinamicaly replace them
		if (count($vars)) 
			$this->template->Replace($vars , false);			
		
		return $this->template->EmptyVars();
	}

	function SwapIO() {
		$this->__checkObject();

		$this->template->input = $this->template->output;
	}



	function Block($block) {
		$this->__checkObject();

		if (!is_object($this->template->blocks[$block])) {
			$this->error($block);
			return NULL;
		} else {
			return $this->template->blocks[$block]->output;
		}
	}

	function BlockSetInput($block , $data) {
		$this->__checkObject();

		if (!is_object($this->template->blocks[$block])) {
			$this->error($block);
			return NULL;
		} else {
			return $this->template->blocks[$block]->input = $data;
		}
	}
	
	
	function BlockReplace($block , $vars = array(), $clear = true) {
		$this->__checkObject();

		if (!is_object($this->template->blocks[$block])) {
			$this->error($block);
			return NULL;
		} else {

			return $this->template->blocks[$block]->Replace($vars , $clear);
		}
	}

	function BlockEmptyVars($block , $vars , $clear = true) {
		$this->__checkObject();

		if (!is_object($this->template->blocks[$block])) {
			$this->error($block);
			return NULL;
		} else {
			$this->template->blocks[$block]->Replace($vars , false);
			return $this->template->blocks[$block]->EmptyVars();
		}
	}


	function BlockSwapIO($block) {
		$this->__checkObject();

		if (!is_object($this->template->blocks[$block])) {
			$this->error($block);
			return NULL;
		} else {
			$this->template->blocks[$block]->input = $this->template->blocks[$block]->output;
		}
	}
		
	function __checkObject() {
		if (!is_object($this->template)) {
			$this->template = new CTemplate(
						$this->source["file"],
						$this->source["type"]
				);
		}
	}

	function BlockExists() {
		$this->__checkObject();

		if (func_num_args() > 0) {
			$blocks = func_get_args();

			$error = true;
			for ($i = 0; $i < count($blocks); $i++) {
				if (!is_object($this->template->blocks[$blocks[$i]])) {
					return false;
				}				
			}				
		}		

		return $error;
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
	function Error($block) {
		CError::Msg("
			<pre>
				CTemplateDynamic::BlockSwapIO::_invalid object
					- block: {$block} doesnt exist
					- template: {$this->source[file]}
			</pre>
		");
	}
	

}

?>