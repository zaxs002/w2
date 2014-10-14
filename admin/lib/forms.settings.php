<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss author Exp $
	description
*/

// dependencies
#require_once _LIBPATH . "forms.php";


/**
* description
*
* @library	
* @author	
* @since	
*/
class CFormSettings extends CForm{
	function CFormSettings($xml , $templates , $db , $tables) {
		parent::CForm($templates, $db , $tables,$xml);
		$this->name = "formsettings";

		$this->method = strtoupper($this->form["method"] ? $this->form["method"] : "post");
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
	function Show($values , $extra = array()) {
		//check if i should show the details
		if (is_array($this->_errors)) {			
			$edit = true;
		} else {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				//redirect to the showing mode;
				$location = new CTemplate($this->form["redirect"] , "string");
				URLRedirect($location->Replace(parent::GlobalVars($this->form)) , "js");
			} else 

				$edit = $_GET["action"] == "edit" || $_GET["action"] == "store" ? true : false;
		}

		if ($edit == false) {

			//convert the editable fields to the showing ones
			if (is_array($this->form["fields"])) {
				parent::__private__showonly(&$this->form);
			}

			//remove the edit and back buttons
			
			if (!$_GET["returnurl"])
				unset($this->form["buttons"]["back"]);

			unset($this->form["buttons"]["save"]);
			unset($this->form["action"]);

			
		} else {
			//remove the edit button
			unset($this->form["buttons"]["edit"]);
		}
		
		return parent::Show(
					$this->form , 
					is_array($this->_errors) ? $this->_errors : array(
						"values" => $values,
						"error" => $this->error
					),
					$extra
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
	function Validate() {

		if ($_SERVER["REQUEST_METHOD"] != $this->method) 
			return 1;

		if ($this->method == "GET" )
			$data = &$_GET ;
		else
			$data = &$_POST;
		
		CForm::ProcessVariables($this->form, $data);
		
		$this->_errors = parent::Validate($this->form  , $data);		

		$this->valid = !(int)is_array($this->_errors);		

		//$this->__private_process_uploads();
	}

	function Done() {

		$this->Validate();				
		$this->Uploads();

		if ($this->valid) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$this->DoUploads();
				return true;
			}
		}

		return false;
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
	function Uploads() {

		if (is_array($this->form["fields"])) {
			foreach ($this->form["fields"] as $key => $val) {

				if (!$val["name"])
					$val["name"] = $key;
				
				switch ($val["type"]) {
					case "upload":						
					case "image":						
						
						$this->__private_uploads_pre($val);
					break;
				}
				
			}			
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
	function DoUploads() {

		if (is_array($this->form["fields"])) {
			foreach ($this->form["fields"] as $key => $val) {
				if (!$val["name"])
					$val["name"] = $key;
								
				switch ($val["type"]) {
					case "upload":						
					case "image":						
						$this->__private_uploads_after($val);


						//remove the extra fields
						unset($_POST["portfolio_img_temp"]);
						unset($_POST["portfolio_img_radio_type"]);
						unset($_POST["portfolio_img_upload_web"]);
					break;
				}
				
			}			
		}		
	}
	

	

	function DoEvents(){
	}
}


?>