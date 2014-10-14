<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: common.php,v 0.1.9 13/02/2003 22:36:15 kv9 Exp $
	common funcs
*/

/**
* common funcs
*
* @library	Common
* @author	OXYLUS [OXYLUS <devel@oxylus.ro>]
* @since	PHPbase 0.0.1
*/

	/**
	* description returns an array with filename base name and the extension
	*
	* @param filemane format
	*
	* @return array
	*
	* @access public
	*/
	function FileExt($filename) {

		//checking if the file have an extension
		if (!strstr($filename, "."))
			return array("0"=>$filename,"1"=>"");

		//peoceed to normal detection

		$filename = strrev($filename);

		$extpos = strpos($filename , ".");

		$file = strrev(substr($filename , $extpos + 1));
		$ext = strrev(substr($filename ,  0 , $extpos));
		
		return array("0"=>$file,"1"=>$ext);
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
function UploadFile($source, $destination , $name ="") {
	$name = $name ? $name : basename($source);
	$name = FileExt($name);
	$name[2]= $name[0];

	$counter = 0 ;
	while (file_exists( $destination . $name[0] . "." . $name[1] )) {
		$name[0] = $name[2] . $counter;
		$counter ++;
	}

	copy($source , $destination . $name[0] . "." . $name[1] );
	@chmod($destination . $name[0] . "." . $name[1] , 0777);
}

function UploadFileFromWeb($source, $destination , $name) {
	$name = FileExt($name);
	$name[2]= $name[0];

	$counter = 0 ;
	while (file_exists( $destination . $name[0] . "." . $name[1] )) {
		$name[0] = $name[2] . $counter;
		$counter ++;
	}

	SaveFileContents($destination . $name[0] . "." . $name[1] , $source);
	@chmod($destination . $name[0] . "." . $name[1] , 0777);
}


/**
* returns the contents of a file in a string
*
* @param string $file_name	name of file to be loaded
*
* @return string
*
* @acces public
*/
function GetFileContents($file_name) {

	//i dont know whats happenind	
	//Warning: fopen() [function.fopen]: Filename cannot be empty in /hosting/www/oxylus/oxylusflash.com/admin/lib/common.php on line 104

	if (!file_exists($file_name)) {
		return null;
	}

	if ($_SERVER["REMOTE_ADDR"] == "79.112.1.18") {
//		echo "<br>:" . $file_name;
	}

	
	//echo "<br>:" . $file_name;
 	$file = fopen($file_name,"r");
	
	//checking if the file was succesfuly opened
	if (!$file)
		return null;

	if (strstr($file_name,"://"))
		while (!feof($file))
			$result .= fread($file,1024);
	else
		$result = @fread($file,filesize($file_name));

	fclose($file);

	return $result;
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
function SaveFileContents($file_name,$content) {
//	echo $file_name;
	$file = fopen($file_name,"w");
	fwrite($file,$content);
	fclose($file);
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
/*function Debug($what,$pre = 1,$die = 0) {
	if (PB_DEBUG_EXT == 1) {
		if ($pre == 1)
			echo "<pre style=\"background-color:white;\">";

		print_r($what);

		if ($pre == 1)
			echo "</pre>";

		if ($die == 1)
			die;
	}
}
*/
/**
* description
*
* @param
*
* @return
*
* @access
*/
/*function SendMail($to,$from,$subject,$message,$to_name,$from_name) {	
	if ($to_name)
		$to = "$to_name <$to>";
	
	$headers  = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text; charset=iso-8859-1\n";
	if ($from_name) {
		$headers .= "From: $from_name <$from>\n";
		$headers .=	"Reply-To: $from_name <$from>\n";
	}
	else {
		$headers .= "From: $from\n";
		$headers .=	"Reply-To: $from\n";
	}

	$headers .=	"X-Mailer: PHP/" . phpversion();

	return mail($to, $subject, $message,$headers);		
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
function FillVars($var,$fields,$with) {
	$fields = explode (",",$fields);

	foreach ($fields as $field)
		if (!$var[$field])
			!$var[$field] = $with;

	return $var;
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
function CleanupString($string,$strip_tags = TRUE) {
	$string = addslashes(trim($string));

	if ($strip_tags)
		$string = strip_tags($string);

	return $string;
}

define("RX_EMAIL","^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$");
define("RX_CHARS","[a-z\ ]");
define("RX_DIGITS","[a-z0-9]"); 
define("RX_ALPHA","[^a-z0-9_]");
define("RX_ZIP","[0-9\-]"); 
define("RX_PHONE","[0-9\-\+\(\)]");

/**
* description
*
* @param
*
* @return
*
* @access
*/
function CheckString($string,$min,$max,$regexp = "",$rx_result = FALSE) {
	if (get_magic_quotes_gpc() == 0)
		$string = CleanupString($string);

	if ($regexp == RX_DIGITS) 
		$string == intval($string);

	if ( ( (int)$min == $min ) && ((int)$max == $max) ) {

		if (strlen($string) < $min)
			return 1;
		else
			if (($max != 0) && (strlen($string) > $max))
				return 2;
	}
	
	
	if ($regexp != "") {

			switch ($regexp) {

				case RX_CREDIT:
					$result = CreditCard::Valid($min, $string);					
					return $result ? 0 : 1;
				break;

				case RX_DATE:
					$end = CSYS::Str2Date($max);
					$start = CSYS::Str2Date($min);

					if (($string >= $start) && ($string <= $end))
						return 0;
					else
						return 1;
				break;


				case RX_DIGITS:
					return ($string == intval($string)) && (intval($string)!=0) ? 0 : 3; 
				break;

				case RX_EMAIL:
					$strict = true;
					$regex = $strict ? '/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' : '/^([*+!.&#$|\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i';
					if (preg_match($regex, trim($string), $matches))
					//	return array($matches[1], $matches[2]);
						return 0; //echo "2";//array($matches[1], $matches[2]);
					else 
						return 1;//echo "3";

//					die ("");


				break;

				default:
					if ($rx_result == eregi($regexp,$string))
						return 3;
				break;
			}		
	}
	return 0;
}

/**
* description
*
* @param
*
* @return
*
* @access
*///  FIRST_NAME:S:3:60,LAST_NAME:S...
function ValidateVars($source,$vars) {
	$vars = explode(",",$vars);

	foreach ($vars as $var) {
		list($name,$type,$min,$max) = explode(":",$var);

		switch ($type) {

			case "CC":
				$type = RX_CREDIT;
			break;

			case "D":
				$type = RX_DATE;
			break;

			case "S":
				$type = RX_CHARS;
				$rx_result = FALSE;
			break;

			case "I":
				$type = RX_DIGITS;
				$rx_result = false;
			break;

			case "E":
				$type = RX_EMAIL;
				$rx_result = FALSE;
			break;

			case "P":
				$type = RX_PHONE;
				$rx_result = TRUE;
			break;

			case "Z":
				$type = RX_ZIP;
				$rx_result = FALSE;
			break;

			case "A":
				$type = "";
			break;

			case "F":
				//experimental crap
				$type = RX_ALPHA;
				$rx_result = TRUE;
				//$source[strtolower($name)] = str_replace(" ", "" , $source[strtolower($name)] );
			break;
 
		}
		//var_dump($result);
		if (($result = CheckString($source[strtolower($name)],$min,$max,$type,$rx_result)) != 0)
			$errors[] = $name;
		
	}	

	return is_array($errors) ? $errors : 0;
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
function ResizeImage($source,$destination,$size) {
	if (PB_IMAGE_MAGICK == 1)
		system( PB_IMAGE_MAGICK_PATH . "convert $source -resize {$size}x{$size} $destination");
	else
		copy($source,$destination);
}

/**
* uses microtime() to return the current unix time w/ microseconds
*
* @return float the current unix time in the form of seconds.microseconds
*
* @access public
*/
function GetMicroTime() {
	list($usec,$sec) = explode(" ",microtime());

	return (float) $usec + (float) $sec;
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
function GetArrayPart($input,$from,$count) {
	$return = array();
	$max = count($input);

	for ($i = $from; $i < $from + $count; $i++ ) 
		if ($i<$max)
			$return[] = $input[$i];

	return $return;	
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
function ReplaceAllImagesPath($htmldata,$image_path) {
	$htmldata = stripslashes($htmldata);
	// replacing shit IE formating style
	$htmldata = str_replace("<IMG","<img",$htmldata);
	// esmth, i dont know why i'm doing
	preg_match_all("'<img.*?>'si",$htmldata,$images);

//<?//fucking edit plus

	foreach ($images[0] as $image)
		$htmldata = str_replace($image,ReplaceImagePath($image,$image_path),$htmldata);
	
	return $htmldata;//implode("\n",$html_out);
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
function ReplaceImagePath($image,$replace) {
	// removing tags
	$image = stripslashes($image);
	$image = str_replace("<","",$image);
	$image = str_replace(">","",$image);
	
	// exploging image in proprietes
	$image_arr = explode(" ",$image);
	for ($i = 0;$i < count($image_arr) ;$i++ ) {
		if (stristr($image_arr[$i],"src")) {
			// lets fuck it :]
			$image_arr[$i] = explode("=",$image_arr[$i]);
			// modifing the image path
			// fuck i hate doing this
			
			// replacing ',"
			$image_arr[$i][1] = str_replace("'","",$image_arr[$i][1]);
			$image_arr[$i][1] = str_replace("\"","",$image_arr[$i][1]);

			//getting only image name
			$image_arr[$i][1] = strrev(substr(strrev($image_arr[$i][1]),0,strpos(strrev($image_arr[$i][1]),"/")));

			// building the image back
			$image_arr[$i][1] = "\"" . $replace . $image_arr[$i][1] . "\"";
			$image_arr[$i] = implode ("=",$image_arr[$i]);
		}		
	}	
	// adding tags
	return "<" . implode(" ",$image_arr) . ">";
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
function DowloadAllImages($images,$path) {	
	foreach ($images as $image)
		@SaveFileContents($path ."/".ExtractFileNameFromPath($image),@implode("",@file($image)));	
}


function GetAllImagesPath($htmldata) {
	$htmldata = stripslashes($htmldata);
	// replacing shit IE formating style
	$htmldata = str_replace("<IMG","<img",$htmldata);
	// esmth, i dont know why i'm doing
	preg_match_all("'<img.*?>'si",$htmldata,$images);

//<?//fucking edit plus

	foreach ($images[0] as $image)
		$images_path[] = GetImageName($image);
	
	return $images_path;
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
function GetImagePath($image) {
	// removing tags
	$image = stripslashes($image);
	$image = str_replace("<","",$image);
	$image = str_replace(">","",$image);
	
	// exploging image in proprietes
	$image_arr = explode(" ",$image);
	for ($i = 0;$i < count($image_arr) ;$i++ ) {
		if (stristr($image_arr[$i],"src")) {
			// lets fuck it :]
			$image_arr[$i] = explode("=",$image_arr[$i]);
			// modifing the image path
			// fuck i hate doing this
			
			// replacing ',"
			$image_arr[$i][1] = str_replace("'","",$image_arr[$i][1]);
			$image_arr[$i][1] = str_replace("\"","",$image_arr[$i][1]);
	
			return strrev(substr(strrev($image_arr[$i][1]),0,strpos(strrev($image_arr[$i][1]),"/")));;
		}		
	}	
	// adding tags
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
function GetImageName($image) {
	// removing tags
	$image = stripslashes($image);
	$image = str_replace("<","",$image);
	$image = str_replace(">","",$image);
	
	// exploging image in proprietes
	$image_arr = explode(" ",$image);
	for ($i = 0;$i < count($image_arr) ;$i++ ) {
		if (stristr($image_arr[$i],"src")) {
			// lets fuck it :]
			$image_arr[$i] = explode("=",$image_arr[$i]);
			// modifing the image path
			// fuck i hate doing this
			
			// replacing ',"
			$image_arr[$i][1] = str_replace("'","",$image_arr[$i][1]);
			$image_arr[$i][1] = str_replace("\"","",$image_arr[$i][1]);

			return $image_arr[$i][1];
		}		
	}	
	// adding tags
	return "";
}

/**
* reinventing the wheel [badly]
*
* @param somthin
*
* @return erroneous
*
* @access denied
*/
function ExtractFileNameFromPath($file) {
	//return strrev(substr(strrev($file),0,strpos(strrev($file),"/")));

	// sau ai putea face asha. umpic mai smart ca mai sus dar tot stupid
	// daca le dai path fara slashes i.e. un filename prima returneaza "" asta taie primu char
	//return substr($file,strrpos($file,"/") + 1,strlen($file) - strrpos($file,"/"));

	// corect ar fi cred asha [observa smart usage`u de strRpos]
	//return substr($file,strrpos($file,"/") + (strstr($file,"/") ? 1 : 0),strlen($file) - strrpos($file,"/"));

	// sau putem folosi tactica `nute mai caca pe tine and rtfm' shi facem asha
	return basename($file);

	// har har :]]
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
function RemoveArraySlashes($array) {
	if ($array)		
		foreach ($array as $key => $item)
			if (is_array($item)) 
				$array[$key] = RemoveArraySlashes($item);
			else		
				$array[$key] = stripslashes($item);
	
	return $array;
}

function AddArraySlashes($array) {
	if ($array)		
		foreach ($array as $key => $item)
			if (is_array($item)) 
				$array[$key] = AddArraySlashes($item);
			else		
				$array[$key] = addslashes($item);
	
	return $array;
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
function Ahtmlentities($array) {
	if (is_array($array))		
		foreach ($array as $key => $item)
			if (is_array($item)) 
				$array[$key] = ahtmlentities($item);
			else		
				$array[$key] = htmlentities(stripslashes($item),ENT_COMPAT);
	else
		return htmlentities(stripslashes($array),ENT_COMPAT);
	
	return $array;
}

function AStripSlasshes($array) {
	if (is_array($array))		
		foreach ($array as $key => $item)
			if (is_array($item)) 
				$array[$key] = AStripSlasshes($item);
			else		
				$array[$key] = stripslashes($item);
	else
		return stripslashes($array);
	
	return $array;
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
function Ahtml_entity_decode($array) {
	if ($array)	
		foreach ($array as $key => $item)
			if (is_array($item))
				$array[$key] = ahtml_entity_decode($item);
			else		
				$array[$key] = html_entity_decode($item,ENT_COMPAT);
	
	return $array;
}


function array2xml ($name, $value, $indent = 1)
{
 $indentstring = "\t";
 for ($i = 0; $i < $indent; $i++)
 {
   $indentstring .= $indentstring;
 }
 if (!is_array($value))
 {
   $xml = $indentstring.'<'.$name.'>'.$value.'</'.$name.'>'."\n";
 }
 else
 {
   if($indent === 1)
   {
     $isindex = False;
   }
   else
   {
     $isindex = True;
     while (list ($idxkey, $idxval) = each ($value))
     {
       if ($idxkey !== (int)$idxkey)
       {
         $isindex = False;
       }
     }
   }

   reset($value);  
   while (list ($key, $val) = each ($value))
   {
     if($indent === 1)
     {
       $keyname = $name;
       $nextkey = $key;
     }
     elseif($isindex)
     {
       $keyname = $name;
       $nextkey = $name;
     }
     else
     {
       $keyname = $key;
       $nextkey = $key;
     }
     if (is_array($val))
     {
       $xml .= $indentstring.'<'.$keyname.'>'."\n";
       $xml .= array2xml ($nextkey, $val, $indent+1);
       $xml .= $indentstring.'</'.$keyname.'>'."\n";
     }
     else
     {
       $xml .= array2xml ($nextkey, $val, $indent);
     }
   }
 }
 return $xml;
}


function GetPhpContent($file) {
	if (file_exists($file) ) {
		$data = GetFileContents($file);

		//replacing special chars in content
		$data = str_replace("<?php","",$data);
		$data = str_replace("?>","",$data);

		return $data;
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
function KeyArray($array,$recurse = 0 , $count = 1) {
	if (is_array($array)) {
		foreach ($array as $key => $val) {
			$array[$key]["key"] = $count ++;

			if ($recurse) {
				foreach ($array[$key] as $k => $val)
					if (is_array($val)) {
						KeyArray($array[$key][$k] , $recurse , &$count);
					}													
			}			
		}		
	}

	return $count + 1;
}


function RandomWord( $passwordLength ) {
/*

	$password = "";
    for ($index = 1; $index <= $passwordLength; $index++) {
         // Pick random number between 1 and 62
         $randomNumber = rand(1, 62);
         // Select random character based on mapping.
         if ($randomNumber < 11)
              $password .= Chr($randomNumber + 48 - 1); // [ 1,10] => [0,9]
         else if ($randomNumber < 37)
              $password .= Chr($randomNumber + 65 - 10); // [11,36] => [A,Z]
         else
              $password .= Chr($randomNumber + 97 - 36); // [37,62] => [a,z]
    }
    return $password;
*/

	$pw = ''; //intialize to be blank
	$len = $passwordLength;
	for($i=0;$i<$len;$i++)
	{
	  switch(rand(1,3))
	  {
		case 1: $pw.=chr(rand(48,57));  break; //0-9
		case 2: $pw.=chr(rand(65,90));  break; //A-Z
		case 3: $pw.=chr(rand(97,122)); break; //a-z
	  }
	}
	return $pw;
}

function DeleteFolder($file) {
 if (file_exists($file)) {
   chmod($file,0777);
   if (is_dir($file)) {
     $handle = opendir($file); 
     while($filename = readdir($handle)) {
       if ($filename != "." && $filename != "..") {
         DeleteFolder($file."/".$filename);
       }
     }
     closedir($handle);
     rmdir($file);
   } else {
     unlink($file);
   }
 }
}

	function GenerateRecordID($array) {
		$max = 0;
		if (is_array($array)) {
			foreach ($array as $key => $val)
				$max = ($key > $max ? $key : $max);

			return $max + 1;
		}
		else return 1;
	}
 


/*****************************************************

Links cripting for admin

DO NOT TOUCH UNLKESS YOU KNOW WHAT YOU ARE DOING


*****************************************************/

/**
* description
*
* @param
*
* @return
*
* @access
*/
function CryptLink($link) {

	if (defined("PB_CRYPT_LINKS") && (PB_CRYPT_LINKS == 1)) {

		if (stristr($link,"javascript:")) {
/*			if (stristr($link,"window.location=")) {
				$pos = strpos($link , "window.location=");
				$js = substr($link , 0 , $pos + 17 );
				$final = substr($link , $pos + 17 );
				$final = substr($final, 0, strlen($final) - 1 );

				//well done ... crypt the link now
				$url = @explode("?" , $final);

				if (!is_array($url))
					$url[0] = $final;

				$tmp = str_replace( $url[0] . "?" , "" , $final);	
				$uri = urlencode(urlencode(base64_encode(str_rot13($tmp))));
				$link = $js . $url[0] . "?" . $uri . md5($uri) . "'";
			}
*/
		} else {
	
			$url = @explode("?" , $link);

			if (!is_array($url))
				$url[0] = $link;

			$tmp = str_replace( $url[0] . "?" , "" , $link);	
			$uri = urlencode(urlencode(base64_encode(str_rot13($tmp))));
			$link = $url[0] . "?" . $uri . md5($uri);
		}
	}	
	
	return $link;
}

/************************************************************************/
/* SOME PREINITIALISATION CRAP*/



if (defined("PB_CRYPT_LINKS") && (PB_CRYPT_LINKS == 1) ) {
	$key = key($_GET);

	if (is_array($_GET) && (count($_GET) == 1) && ($_GET[$key] == "")) {

		$tmp = $_SERVER["QUERY_STRING"];
		//do the md5 check
		$md5 = substr($tmp , -32);
		$tmp = substr($tmp , 0 , strlen($tmp) - 32);
		
		if ($md5 != md5($tmp)) {
			//header("index.php?action=badrequest");
			//exit;
			die("Please dont change the links!");
		}
		
		$tmp = str_rot13(base64_decode(urldecode(urldecode($tmp))));

		$tmp_array = @explode("&" , $tmp);
		$tmp_array = is_array($tmp_array) ? $tmp_array : array($tmp);

		if (is_array($tmp_array)) {
			foreach ($tmp_array as $key => $val) {
				$tmp2 = explode("=" , $val);
				$out[$tmp2[0]] = $tmp2[1];
			}				
		} else {
			$tmp2 = explode("=" , $tmp);
			$out[$tmp2[0]] = $tmp2[1];
		}

		$_GET = $out;
	}	
}

/***********************************************************************/


function ArrayReplace($what , $with , $array ) {
	if ($array)	
		foreach ($array as $key => $item) {
			if (is_array($item))
				$array[$key] = ArrayReplace($what , $with , $item);
			else		
				$array[$key] = str_replace($what , $with , $item);

			//replace the key too			
			if (strstr($key , $what)) {
				$array[str_replace($what, $with , $key)] = $array[$key];
				unset($array[$key]);
			}
		}
	
	return $array;
}

function stri_replace( $find, $replace, $string )
{
   $parts = explode( strtolower($find), strtolower($string) );
   $pos = 0;
   foreach( $parts as $key=>$part ){
       $parts[ $key ] = substr($string, $pos, strlen($part));
       $pos += strlen($part) + strlen($find);
       }
   return( join( $replace, $parts ) );
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
function GMTDate($format , $date) {
	global $_GMT;
	return date($format , $date - $_GMT);
}

function putcsv ($array, $deliminator=",") {
	$line = "";
	foreach($array as $val) {
		# remove any windows new lines, 
		# as they interfere with the parsing at the other end
		$val = str_replace("\r\n", "\n", $val);
		# if a deliminator char, a double quote char or a newline 
		# are in the field, add quotes
		if(ereg("[$deliminator\"\n\r]", $val)) {
			 $val = '"'.str_replace('"', '""', $val).'"';
		}#end if
		$line .= $val.$deliminator;
	}#end foreach
	# strip the last deliminator 
	$line = substr($line, 0, (strlen($deliminator) * -1));
	# add the newline 
	$line .= "\n";
	# we don't care if the file pointer is invalid, 
	# let fputs take care of it
	return $line;
}#end fputcsv()

if (!function_exists("fputcsv")) {

function fputcsv ($fp, $array, $deliminator=",") {
	return fputs($fp, putcsv($array,$delimitator));
}#end fputcsv()

}




/**
* description Check if the $_GET[sub] and $_GET[action] matches with the params
*
* @param  1. two or multiple string arguments , first is the sub, the rest are the actions
* @param  2. array and multiple string arguments, first the array with the subs, the rest the actions
* @param  3. two arrays , firs the array with the subs the second the array with the actions
*
* @return boolean
*
* @access public
*/

function is_subaction() {

	$params = func_get_args();
	
	//check to see the numbers of the arguments
	if (func_num_args() == 2) {

		//force the sub to be array
		if (!is_array($params[0]))
			$sub = array($params[0]);	
		else
			$sub = $params[0];

		//force the action to be array
		if (!is_array($params[1]))
			$action = array($params[1]);		
		else 
			$action = $params[1];


		//do a array search 
		return (bool) in_array($_GET["sub"] , $sub) && in_array($_GET["action"] , $action);;
	} 

	if (func_num_args() > 2) {
		//one sub and multiple actions
		
		$sub = $params[0];

		//force the sub to be array
		if (!is_array($sub))
			$sub = array("0" => $sub);	
		
		//remove the sub from the params list
		unset($params[0]);

		return (bool) in_array($_GET["sub"] , $sub ) && in_array($_GET["action"] , $params);
	}	
}




function striphtmltags ( $text ) {
	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript 
					"'<[\/\!]*?[^<>]*?>'si"           // Strip out html tags 
					);                    // evaluate as php 

	$replace = array ("", 
					 ""
					); 

	return preg_replace ($search, $replace, $text); 
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
function ArrayValueByKey($array, $key) {
	return $array[$key];
}


function FormatSize($file) {
   // First check if the file exists.
   if(is_file($file)) {	   
	   $size = filesize($file);
   } else
	   $size = $file;

   // Setup some common file size measurements.
   $kb = 1024;         // Kilobyte
   $mb = 1024 * $kb;   // Megabyte
   $gb = 1024 * $mb;   // Gigabyte
   $tb = 1024 * $gb;   // Terabyte
   // Get the file size in bytes.
   
   /* If it's less than a kb we just return the size, otherwise we keep going until
   the size is in the appropriate measurement range. */
   if($size < $kb) {
	   return $size." B";
   }
   else if($size < $mb) {
	   return round($size/$kb,2)." KB";
   }
   else if($size < $gb) {
	   return round($size/$mb,2)." MB";
   }
   else if($size < $tb) {
	   return round($size/$gb,2)." GB";
   }
   else {
	   return round($size/$tb,2)." TB";
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

function get_real_size($size=0) {
    /// Converts numbers like 10M into bytes
        if (!$size) {
            return 0;
        }
        $scan['MB'] = 1048576;
        $scan['Mb'] = 1048576;
        $scan['M'] = 1048576;
        $scan['m'] = 1048576;
        $scan['KB'] = 1024;
        $scan['Kb'] = 1024;
        $scan['K'] = 1024;
        $scan['k'] = 1024;

        while (list($key) = each($scan)) {
            if ((strlen($size)>strlen($key))&&(substr($size, strlen($size) - strlen($key))==$key)) {
                $size = substr($size, 0, strlen($size) - strlen($key)) * $scan[$key];
                break;
            }
        }
        return $size;
    } // end function


	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function URLRedirect($url , $type = "http") {

		$type = "http";
		
		if ($type == "http") {
			header("Location: " . $url);
			exit;
		} else {
			die(
				"<pre>Redirecting...<br>" . 
				"If your browser doesn’t refresh automatically within 10 seconds, please <a href='$url'>click here</a>." . 
				"</pre>" . 
				"<script> window.location='" . $url . "'; </script>"
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
	function URLAbsolutePage($page = "") {
			if ($page == "") 
				$page = basename($_SERVER["SCRIPT_NAME"]);
			
			return (strtoupper($_SERVER["HTTPS"]) == "on" ? "https://" :  "http://") . 
					$_SERVER["SERVER_NAME"] . 
					($_SERVER["SERVER_PORT"] != 80 ? ':' . $_SERVER["SERVER_PORT"] : '') .
					dirname($_SERVER["SCRIPT_NAME"]) . "/" . $page;
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
	function SendMail() {

		$params = AStripSlasshes(func_get_args());	
		//check to see the numbers of the arguments

		switch (func_num_args()) {
			case 1:
				$email = $params[0];
				$vars = array();
			break;

			case 2:
				$email = $params[0];
				$vars = $params[1];
			break;

			case 3:
				$to = $params[0];
				$email = $params[1];
				$vars = $params[2];
			break;

			case 4:
				$to = $params[0];
				$to_name = $params[1];
				$email = $params[2];
				$vars = $params[3];
			break;
		}
		
		if ($email["email_status"] == 1) {
			return true;
		}		
		
		$msg = new CTemplate(stripslashes($email["email_body"]) , "string");
		$msg = $msg->Replace($vars);

		$sub = new CTemplate(stripslashes($email["email_subject"]) , "string");
		$sub = $sub->Replace($vars);

		$email["email_from"] = new CTemplate(stripslashes($email["email_from"]) , "string");
		$email["email_from"] = $email["email_from"]->Replace($vars);

		$email["email_from_name"] = new CTemplate(stripslashes($email["email_from_name"]) , "string");
		$email["email_from_name"] = $email["email_from_name"]->Replace($vars);

		if (!$email["email_reply"]) 
			$email["email_reply"] = $email["email_from"];
		if (!$email["email_reply_name"]) 
			$email["email_reply_name"] = $email["email_from_name"];
		

		//prepare the headers
		$headers  = "MIME-Version: 1.0\r\n";

		if ($email["email_type"] == "html")
			$headers .= "Content-type: text/html\r\n";
		else
			$headers .= "Content-type: text/plain\r\n";
		
		

		//prepare the from fields
		if (!$email["email_hide_from"]) {
			$headers .= "From: {$email[email_from_name]}<{$email[email_from]}>\r\n";
			$headers .=	"Reply-To: {$email[email_reply_name]}<{$email[email_reply]}>\r\n";
		}

		$headers .= $email["headers"];
/*
		debug(array(
			"subject" => $sub,
			"body" => $msg , 
			"headers" => $headers
		));
*/
		
		if (!$email["email_hide_to"]) {
//			$headers .= "To: {$email[email_to_name]}<{$email[email_to]}>\r\n";
//echo $email["email_to"];
			return mail($email["email_to"] , $sub, $msg,$headers);		
		} else {
//			$headers .= "To: $to_name <$to>\r\n";
		}

		$headers .=	"X-Mailer: PHP/" . phpversion();
/*
		debug(array(
			"subject" => $sub,
			"body" => $msg , 
			"headers" => $headers
		));
*/
		return mail($to, $sub, $msg,$headers);				
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
	function TemplateReplace($string , $array) {
		$tmp = new CTemplate($string , "string");
		return $tmp->Replace($array);
	}
	

	/**
	* Function to find the day of a week in a year
	* @param integer $week The week number of the year
	* @param integer $year The year of the week we need to calculate on
	* @param string  $start_of_week The start day of the week you want returned
	*                Monday is the default Start Day of the Week in PHP. For 
	*                example you might want to get the date for the Sunday of wk 22
	* @return integer The unix timestamp of the date is returned
	*/
	function find_first_day_ofweek($week, $year, $start_of_week='sunday'){
		// Get the target week of the year with reference to the starting day of
		// the year
		$target_week = strtotime("$week week", strtotime("1 January $year"));
		// Get the date information for the day in question which
		// is "n" number of weeks from the start of the year
		$date_info = getdate($target_week);
		// Get the day of the week (integer value)
		$day_of_week = $date_info['wday'];
		// Make an adjustment for the start day of the week because in PHP the 
		// start day of the week is Monday
		switch (strtolower($start_of_week))	{
			case 'sunday':
				$adjusted_date = $day_of_week;
			break;
			case 'monday':
				$adjusted_date = $day_of_week-1;
			break;
			case 'tuesday':
				$adjusted_date = $day_of_week-2;
			break;
			case 'wednesday':
				$adjusted_date = $day_of_week-3;
			break;
			case 'thursday':
				$adjusted_date = $day_of_week-4;
			break;
			case 'friday':
				$adjusted_date = $day_of_week-5;
			break;
			case 'saturday':
				$adjusted_date = $day_of_week-6;
			break;
			default:
				$adjusted_date = $day_of_week-1;
			break;
		}
		// Get the first day of the weekday requested
		$first_day = strtotime("-$adjusted_date day",$target_week);
		//return date('l dS of F Y h:i:s A', $first_day);
		return $first_day;
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
	function explode_by_key($sep , $array) {
		$values = explode($sep,$array);
		if (is_array($values)) {
			foreach ($values as $key => $val) {
				$_values[trim($val)] = trim($val);
			}			
		}
		
		return $_values;
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
	function array_exists($value,$array) {
		if (is_array($array)) {
			foreach ($array as $key => $val) {
				if ($val == $value)
					return true;
			}			
		}
		
		return false;
	}
	

	function microtime_float() { 
		list($usec, $sec) = explode(" ", microtime()); 
		return ((float)$usec + (float)$sec); 
	} 	


	function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}


/*

History



Unreleased
	
	27/08/05 - is_subaction supports multiple params 
					1. two or multiple string arguments , first is the sub, the rest are the actions
					2. array and multiple string arguments, first the array with the subs, the rest the actions
					3. two arrays , firs the array with the subs the second the array with the actions

V0.0.1
	13 February 2003
		First version, as part of PHPBase Framework

*/

?>