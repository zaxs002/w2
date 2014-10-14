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

/**
* description
*
* @library	
* @author	
* @since	
*/

if(!defined('UNZIP_CMD')) define('UNZIP_CMD','unzip -o @_SRC_@ -x -d  @_DST_@');

class CSYS{

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function _GetVar($data) {

		$__get = $_GET;
		if (is_array($data)) {
			//split the $_GET
			foreach ($data as $k => $v) {
				$__get[$k] = $v;
			}			
		}

		if (is_array($__get)) {
			foreach ($__get as $k => $v) {

				if (is_array($v)) {
					foreach ($v as $key => $val) {
						$vars[] = "{$k}[]={$val}";
					}					
				} else {
					if ((strtolower($k) == "returnurl") && strstr($v,"=")) {
						while (strstr($v,"="))
							$v = urlencode($v);											

						$v = urlencode($v);
					}
					$vars[] = "$k=$v";
				}
			}			
		}

		return $_SERVER["PHP_SELF"] . "?" . @implode("&" , $vars);
		
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
	function Str2Date($data , $format = "us" , $sep = "/") {

		switch ($data) {

			case "now_month":
				$date = time();
				return mktime(0,0,0,date("m"), 1, date("Y"));				
			break;

			case "now_month_end":
				return mktime(0,0,0,date("m"), 0, date("Y"));
			break;

			case "now":
				return time();
			break;

			default:

				if (strstr($data , $sep)) {
					$elements = explode($sep , $data);

					return $format == "us" ? 
								mktime(0,0,0, $elements[0],$elements[1],$elements[2]) :
								mktime(0,0,0, $elements[1],$elements[0],$elements[2]) ;		
				}

				if ((int)$data >= 1970) 
					return mktime(0,0,0,0,0,$data);
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
	function VarRequire($field) {
		return $_GET[$field] ? $_GET[$field] : $_POST[$field];
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
	function InRange($val , $min, $max) {
		return ($val >= $min) && ($val <= $max);
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
	function ExtractVars($data) {
		$vars = @explode("?" , $data);
		$vars = @explode("&" , $vars[1]);

		if (is_array($vars)) {
			foreach ($vars as $key => $val) {
				$tmp = explode("=" , $val);
				$_vars[$tmp[0]] = $tmp[1];
			}			
		}

		return $_vars;		
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
	function ProcessDate($data , $dates) {
		if (is_array($data)) {
			$count = true;
			foreach ($data as $key => $val) {
				$count = !$count;
				$data[$key]["__alternance"] = (int)$count;

				foreach ($dates as $k => $v) {
					if ($val[$k] > 1000) 
						$data[$key][$k] = date($v , $val[$k]);
					else
						$data[$key][$k] = "N/A";
				}				
			}			
		}
		return $data;
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
	function ProcessNotes($records , $field , $max , $stars) {

		if (is_array($records)) {
			foreach ($records as $key => $val) {				
				CSYS::ProcessNote ( &$records[$key] , $field , $max , $stars);
			}
		}

		return $records;
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
	function ProcessNote($val , $field , $max , $stars) {
		$stars_note = ($val[$field] * $stars) / $max;


		$int = number_format($stars_note , 1);
		$dec = number_format(($stars_note - $stars_note % 10) * 10 , 0);
		
		$i = 1;

		if ($int > 0) {
			for ($i = 1 ; $i <= $int ; $i++) {
				$val[$field. "_" . $i] = "2";
			}					
		}
		
		if ($dec < 2)
			$val[$field . "_" . $i] = "0";
		else if ($dec >= 7)
			$val[$field . "_" . $i] = "2";
		else
			$val[$field . "_" . $i] = "1";

		$i++;
		
		if ($i <= $stars) {
			for ($j = $i; $j <= $stars ; $j++ )
			$val[$field. "_" . $j] = "0";					
		}

		return $val;
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
	function nl2p($data) {
		$tmp = explode("\n" , $data);

		if (is_array($tmp)) {
			foreach ($tmp as $key => $val) {
				$tmp[$key] = "<p>" . trim($val) . "</p>";
			}
			
			return implode("" , $tmp);
		}
		
		return "<p>{$data}</p>";
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
	function rmDir($path) {
		  // Add trailing slash to $path if one is not there
		  if (substr($path, -1, 1) != "/") {
			  $path .= "/";
		  }
		  $normal_files = glob($path . "*");
		  $hidden_files = glob($path . "\.?*");
		  $all_files = array_merge($normal_files, $hidden_files);
		  foreach ($all_files as $file) {
			   # Skip pseudo links to current and parent dirs (./ and ../).
			   if (preg_match("/(\.|\.\.)$/", $file))
			   {
					   continue;
			   }
			  if (is_file($file) === TRUE) {
				  // Remove each file in this Directory
				  unlink($file);
			  }
			  else if (is_dir($file) === TRUE) {
				  // If this Directory contains a Subdirectory, run this Function on it
				  CSYS::rmDir($file);
			  }
		  }
		  // Remove Directory once Files have been removed (If Exists)
		  if (is_dir($path) === TRUE) {
			  rmdir($path);
		  }
	}
	

	
	function Unzip($zipFile,$zipDir) {
		$unzipCmd=UNZIP_CMD;
		$unzipCmd=str_replace('@_SRC_@',$zipFile,$unzipCmd);
		$unzipCmd=str_replace('@_DST_@',$zipDir,$unzipCmd);
		$res=-1; // any nonzero value
		$UnusedArrayResult=array();
		$UnusedStringResult=exec($unzipCmd,$UnusedArrayResult,$res);
		return ($res==0);
	}
// * * *  You DO NOT NEED the ZIP lib or M-ZIP to use this, but you will need the tool M-ZIP uses (unzip.exe or unzip for linux).  * * *
// Use it this way:
/*
$zipFile='/path/to/uploaded_file.zip';
$whereToUnzip='/path/to/writable/folder/';
$result=UnzipAllFiles($zipFile,$whereToUnzip);
if($result===FALSE) echo('FAILED');
else echo('SUCCESS');
*/
	
	
}

?>