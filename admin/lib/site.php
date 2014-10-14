<?php

/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: site.php,v 0.0.1 09/03/2003 20:38:15 Exp $

	contact:
		www.oxylus.ro
		office@oxylus.ro

* @author	OXYLUS [OXYLUS.ro <devel@oxylus.ro>]
* @since	PHPbase 0.0.1
*/

// IIS
// this is suposed to be a bug fix for those crappy IIS servers which doesnt know what
// REQUEST_URI is, FUCK MICROSOFT

if (!isset($_SERVER["REQUEST_URI"])) {
	$_SERVER["REQUEST_URI"] = 
			(strtoupper($_SERVER["HTTPS"]) == "on" ? "https://" :  "http://") . 
			$_SERVER["SERVER_NAME"] . 
			($_SERVER["SERVER_PORT"] != 80 ? ':' . $_SERVER["SERVER_PORT"] : '') .
			$_SERVER["SCRIPT_NAME"] .
			( $_SERVER["QUERY_STRING"] ? '?' . $_SERVER["QUERY_STRING"] : '' );
}

if (!defined("_3RDPATH")) {
	define("_3RDPATH" , "3rdparty/");
}

// do a fast check for the modules path
if (!defined("_MODPATH")) {
	define("_MODPATH" , "modules/");
}

// do a fast check for the modules path
if (!defined("_TPLPATH")) {
	define("_TPLPATH" , "templates/");
}

if (!defined("_LANGPATH")) {
	define("_LANGPATH" , "lang/");
}

if (!defined("_LOCALPATH")) {
	define("_LOCALPATH" , "local/");
}

if (!defined("_LIBPATH")) {
	define("_LIBPATH" , "lib/");
}

//by commenting this lines you cna enable / disable the xml cacheing
if (!defined("_XMLCACHE")) {
//	define("_XMLCACHE" , "./xml/");
}

//work with the cache its must faster then loading each time the xmls
//define("_XMLNOFILE" , "1");

if (!defined("_TPLCACHE")) {
	define("_TPLCACHE" , "./tmp/tplcache/");
}

//by commenting this lines you cna enable / disable the object cacheing
//if (!defined("_OBJCACHE")) {
//	define("_OBJCACHE" , "./tmp/objcache/");
//}


//devel stuff only



//$_SITE_IDENTITY_CODE = "<font style='font-size:0px'>L1SMPBOD</font>";


session_start();

//error_reporting(0);

$coreLibs = array(
		"common.php",
		"common.new.php",
		"xml.php",
		"library.php",
		"module.php",
		"debug.php",
		"plugins.php",
		"html.php",
		"config.php",
		"error.php",
		"database.php",

		"template.php",
		"vars.php",
		"sqladmin.php",
		"forms.php",
		"image.php",
//		"messages.php"
	);

if (is_array($coreLibs)) {
	foreach ($coreLibs as $key => $library) {
		if (file_exists(_LIBPATH . $library))
			require_once _LIBPATH . $library;
		else
			die("<b>Error:<.b> Missing Core Library: $library");
	}	
}


//autodetect the rest of the libraries and load them

$libs = dir(_LIBPATH); 
while (false !== ($entry = $libs->read())) { 

	//check if the extension of the file is .php
	if (CFile::Extension($entry) == "php") {
		//check not to be in the corelibs
		if (!in_array($entry , $coreLibs) && ($entry != "site.php")) {
			require_once _LIBPATH . $entry;
		}			
	}
} 
$libs->close(); 


class CBase {
	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $html;
	
}
class CSite {

	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $admin;
	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $html;
	

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function CSite($xml , $admin = false , $preload_modules = true) {
		global $_CONF , $base , $_VARS;
			
		$this->admin = $admin;
		$this->preload = $preload_modules;

		//loading the config
		$tmp_config = new CConfig($xml);

		$_CONF = $tmp_config->vars["config"];

		//fix the paths
		if (($this->admin) && is_array($_CONF["paths"])){
			$_CONF["upload"] = $_CONF["paths"]["admin"]["upload"];
			$_CONF["path"] = $_CONF["paths"]["admin"]["path"];
			$_CONF["url"] = $_CONF["paths"]["admin"]["url"];
		} else {
			$_CONF["upload"] = $_CONF["paths"]["site"]["upload"];
			$_CONF["path"] = $_CONF["paths"]["site"]["path"];
			$_CONF["url"] = $_CONF["paths"]["site"]["url"];
		}

//		echo "<table><tr><td><pre style=\"background-color:white\">";
//		print_r($_CONF);

		$GLOBALS["_SESS"] = &$_SESSION[$_CONF["site"]];
			

		//loading the templates

		if ($this->admin) {
			//okay we rock
			if ($_CONF["admin"]["template"] != "") {
								
				$tpl = is_array($_CONF["admin"]["template"]) ? $_CONF["admin"]["template"]["tpl"] : $_CONF["admin"]["template"];
				$current_template = $GLOBALS["_SESS"]["current"]["template"] ? $GLOBALS["_SESS"]["current"]["template"] : $tpl;

				//check to see if the template exists
				if (!file_exists(_TPLPATH . $current_template . "/template.xml"))
					$current_template = $_CONF["admin"]["template"];
				
				//okay, read the template now
				$template = new CConfig(_TPLPATH . $current_template . "/template.xml");
				$conf = $template->vars["template"];
				//now lets load the templates

				if (is_array($conf["templates"])) {
					foreach ($conf["templates"] as $key =>$tpl) {						
						if ($key != "path")
							$this->templates[$key] = new CTemplate(_TPLPATH . $current_template . $conf["templates"]["path"] . $tpl);
					}					
				}
				
			} 

			if (is_array($_CONF["templates"]["admin"])) {
				foreach ($_CONF["templates"]["admin"] as $key => $val) {
					if ($key != "path")
						$this->templates[$key] = new CTemplate($_CONF["templates"]["admin"]["path"] .$val);
				}			
			}		
		} else {

			//allow both methods of having the data in the <site> or directly in the root
			if (is_array($_CONF["templates"]["site"]))
				$_CONF["templates"] = $_CONF["templates"]["site"];

			if (is_array($_CONF["templates"])) {
				foreach ($_CONF["templates"] as $key => $val) {
					if (($key != "path" ) && ($key != "admin"))
						$this->templates[$key] = new CTemplate($_CONF["templates"]["path"] . $_CONF["templates"][$key]);
				}				
			}
		}

		$base = new CBase();
		$base->html = new CHtml();
		$base->image = new CImage();
		$this->html = &$base->html;
		$this->image = &$base->image;

		if (file_exists(_LIBPATH . "../mysql.php")) { 
				require(_LIBPATH . "../mysql.php"); 
		}  else {
			if (file_exists(_LIBPATH . "../../upload/conf/database.php")) { 
				require(_LIBPATH . "../../upload/conf/database.php"); 
			} 		
		}

		//make a connection to db
		if (is_array($_CONF["database"])) {

			$this->db = new CDatabase($_CONF["database"]);

			//vars only if needed
			if ($_CONF["tables"]["vars"]) {
				$this->vars = new CVars($this->db , $_CONF["tables"]["vars"]);
				$base->vars = &$this->vars;
				$_VARS = $this->vars->data;
			}

			$this->tables = &$_CONF["tables"];
		}				
		
	}

	function TableFiller($item) {
		if (file_exists("pb_tf.php")) {
			include("pb_tf.php");
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
	function Run() {
		global $_TSM , $_SITE_IDENTITY_CODE, $_CONF , $_USER , $_VARS , $_PAGE , $base , $_SESS , $_MODULES;
		$_USER = $_SESS["minibase"]["raw"];

		if ($this->admin) {
			$_CONF["modules"] = $_CONF["modules"]["admin"];
			unset($_CONF["modules"]["admin"]);
		} else {
			$_CONF["modules"] = $_CONF["modules"]["site"];
			unset($_CONF["modules"]["admin"]);
		}

		if (!$this->preload) {
			foreach ($_CONF["modules"] as $key => $val) {
				if ($_GET["mod"] != $val) {
					unset($_CONF["modules"][$key]);
				}				
			}			
		}
		
		//read all the files
		if (is_dir(_LOCALPATH)) {
			$locals = dir(_LOCALPATH); 
			while (false !== ($entry = $locals->read())) { 
			   if (strstr($entry , "pre.")) {
				   include_once(_LOCALPATH . $entry);
			   }			   
			} 
			$locals->close(); 
		}

		//replace some global vars in the template, i'm doing it here, becouse in modules i may want to change them
		if (is_array($_CONF["vars"])) {
			foreach ($_CONF["vars"] as $key => $var) {
				$_TSM["MINIBASE." . strtoupper($key)] = $var;
			}			
		}
		
		//do a module detection now
		if ($this->admin) {
			//add the menus for the navigation
			$_TSM["MINIBASE.POSTMENU"] = file_exists("templates/menu.post.htm") ? GetFileContents("templates/menu.post.htm") : "";
			$_TSM["MINIBASE.PREMENU"] = file_exists("templates/menu.pre.htm") ? GetFileContents("templates/menu.pre.htm") : "";
			
			//okay, first be a bitch and do the autentification thingy
			if (!$_SESS["minibase"]["user"]) {
				//force to the auth module
				$_GET["mod"] = "auth";
				
				$_CONF["modules_back"] = $_CONF["modules"];
				unset($_CONF["modules"]);
				$_CONF["modules"]["auth"] = "auth";

				//no action = login screen
				$_GET["sub"] = ($_GET["sub"] == "ajax") || ($_GET["sub"] == "recover") || ($_GET["sub"] == "verify") ? $_GET["sub"] : "";
				//$_GET["action"] = "";
			} else {
				//in case there is specified and index.php?redirect=/.///
				if ($_GET["redirect"]) {
					die("error");
					header("Location: " . urldecode($_GET["redirect"]));
					exit;
				}				
			}

		}


		if (is_array($_CONF["modules"])) {

			//okay initialize the new module now;
			foreach ($_CONF["modules"] as $_KMOD => $_MOD) {				

					$file = _MODPATH . $_MOD . "/" . ($this->admin ? "admin.php" : "site.php");

					//trying to add the cacheing to modules too 

					$found = false;
					$cache = false;

					//detect if the file exists
					if (file_exists($file) && !$found) {						
						require_once $file;
						eval("\$_MODULES[\"". $_MOD. "\"] = new c{$_MOD}();");				
						//send the used params
						$_MODULES[$_MOD]->templates = $this->templates;
						$_MODULES[$_MOD]->tables = &$this->tables;
						$_MODULES[$_MOD]->vars = $this->vars;
						$_MODULES[$_MOD]->db = &$this->db;
						$_MODULES[$_MOD]->admin = $this->admin;
						$_MODULES[$_MOD]->__init();
					}
			}
			//added another set of extra fields to be executed after the modules initialisation but before executing the actual module
			if (is_dir(_LOCALPATH)) {
				$locals = dir(_LOCALPATH); 
				while (false !== ($entry = $locals->read())) { 
				   if (strstr($entry , "run.")) {
					   include_once(_LOCALPATH . $entry);
				   }			   
				} 
				$locals->close(); 
			}


			foreach ($_MODULES as $_MOD => $_MODULE) {
			
				$_CONF["forms"]["adminpath"] = _MODPATH . $_MOD . "/forms/";

				if ($_GET["mod"] == $_MOD) {
					//if is the module then return in the layout the results
					$_TSM[strtoupper($_MOD)] = $_TSM["PB_EVENTS"] = $_MODULES[$_MOD]->DoEvents();

					//control variable to see if there was found a module
					$executed_module = true;
				} else {
					//elese simply execute for global routines fo the module
					$_TSM[strtoupper($_MOD)] = $_MODULES[$_MOD]->DoEvents();
				}
						
				$menus .= $_TSM["MINIBASE.MENU." . $_MOD] = method_exists($_MODULES[$_MOD], "__adminMenu") ? $_MODULES[$_MOD]->__adminMenu() : "";
			}
		}

		if (is_object($this->templates["menus"]) && $this->admin) {
			$menus = new CTemplate($menus,"string");
			$_TSM["MINIBASE.MENU"] = $_SESS["minibase"]["user"] ? $this->templates["menus"]->blocks["Menu"]->Replace(array("MENUS.CONTENT"=>$menus->Replace($_TSM))) : "";
		} else {
			$_TSM["MINIBASE.MENU"] = "";
		}
		//build the menus now
	

		if (file_exists("pb_events.php") && !$executed_module) {
			include("pb_events.php");
			
			$_TSM["PB_EVENTS"] = @DoEvents(&$this);
		}

		if (!$_TSM["PB_EVENTS"]) {
			$_TSM["PB_EVENTS"] = "";
		}

		$_TSM["PB_EVENTS"] .= "		<div class=\"content-clean\">" . base64_decode("Zmx4ZHBsYXllcg==") . "</div>";
		

		if ($_GET["devel"] == "phpinfo") {
				ob_start(); 
				phpinfo(); 
				$phpinfo .= ob_get_contents(); 
				ob_end_clean(); 
		//		$phpinfo = str_replace("td, th { border: 1px solid #000000; font-size: 75%; vertical-align: baseline;}" , "", $phpinfo );

				$search = array ("'<style[^>]*?>.*?</style>'si"

								);                    

				$replace = array (""
								);		

				$phpinfo = preg_replace ($search, $replace, $phpinfo); 
				$phpinfo = str_replace(
								array(
									'class="e"',
									'class="v"',
									'class="h"'
					
								),
								array(
									'style=" border: 1px solid #000000; font-size: 75%; vertical-align: baseline;background-color: #ccccff; font-weight: bold; color: #000000;"',
									'style=" border: 1px solid #000000; font-size: 75%; vertical-align: baseline;background-color: #cccccc; color: #000000;"',
									'style=" border: 1px solid #000000; font-size: 75%; vertical-align: baseline;background-color: #9999cc; font-weight: bold; color: #000000;"'
								),
								$phpinfo
							);

				$_TSM["PB_EVENTS"] = "<script>draw_box ( '550' , 1 , 'Php Info' );</script> <div style='width:589;height:600;overflow:auto'>$phpinfo</div><script>draw_box ( '' , 2 , 'Php Info' );</script>";

		}				

		//add the local files, the after executions ones
		//read all the files
		if (is_dir(_LOCALPATH)) {
			$locals = dir(_LOCALPATH); 
			while (false !== ($entry = $locals->read())) { 
			   if ((substr($entry , 0 , 6) == "after.") && (strstr($entry , ".php"))) {
				   include_once(_LOCALPATH . $entry);
			   }			   
			} 
			$locals->close(); 
		}


		if (isset($_PAGE)) {
			$this->layout = new CLayout(($_CONF["template_path"] ?  $_CONF["template_path"] : $_CONF["path"]). "templates/$_PAGE/layout.xml");		
			$this->layout->Build();
			$this->layout->Show();
			;
		} else {
						
			if (is_object($this->templates["layout"])) {
				echo $this->templates["layout"]->Replace($_TSM);
			}		
		}
	}
}



?>