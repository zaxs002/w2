<?php
###################################################################################
#
# XML Library, by Keith Devens, version 1.2b
# http://keithdevens.com/software/phpxml
#
# This code is Open Source, released under terms similar to the Artistic License.
# Read the license at http://keithdevens.com/software/license
#
###################################################################################

###################################################################################
# XML_unserialize: takes raw XML as a parameter (a string)
# and returns an equivalent PHP data structure
###################################################################################
function & XML_unserialize(&$xml){
	$xml_parser = &new XML();
	$data = &$xml_parser->parse($xml);
	$xml_parser->destruct();
	return $data;
}
###################################################################################
# XML_serialize: serializes any PHP data structure into XML
# Takes one parameter: the data to serialize. Must be an array.
###################################################################################
function & XML_serialize(&$data, $level = 0, $prior_key = NULL){
	if($level == 0){ ob_start(); echo '<?xml version="1.0" ?>',"\n"; }
	while(list($key, $value) = each($data))
		if(!strpos($key, ' attr')) #if it's not an attribute
			#we don't treat attributes by themselves, so for an empty element
				# that has attributes you still need to set the element to NULL

			if(is_array($value) and array_key_exists(0, $value)){
				XML_serialize($value, $level, $key);
			}else{
				$tag = $prior_key ? $prior_key : $key;
				echo str_repeat("\t", $level),'<',$tag;
				if(array_key_exists("$key attr", $data)){ #if there's an attribute for this element
					while(list($attr_name, $attr_value) = each($data["$key attr"]))
						echo ' ',$attr_name,'="',htmlspecialchars($attr_value),'"';
					reset($data["$key attr"]);
				}

				if(is_null($value)) echo " />\n";
				elseif(!is_array($value)) echo '>',htmlspecialchars($value),"</$tag>\n";
				else echo ">\n",XML_serialize($value, $level+1),str_repeat("\t", $level),"</$tag>\n";
			}
	reset($data);
	if($level == 0){ $str = &ob_get_contents(); ob_end_clean(); return $str; }
}
###################################################################################
# XML class: utility class to be used with PHP's XML handling functions
###################################################################################
class XML{
	var $parser;   #a reference to the XML parser
	var $document; #the entire XML structure built up so far
	var $parent;   #a pointer to the current parent - the parent will be an array
	var $stack;    #a stack of the most recent parent at each nesting level
	var $last_opened_tag; #keeps track of the last tag opened.

	function XML(){
 		$this->parser = &xml_parser_create();
		xml_parser_set_option(&$this->parser, XML_OPTION_CASE_FOLDING, false);
		xml_set_object(&$this->parser, &$this);
		xml_set_element_handler(&$this->parser, 'open','close');
		xml_set_character_data_handler(&$this->parser, 'data');
	}
	function destruct(){ xml_parser_free(&$this->parser); }
	function & parse(&$data){
		$this->document = array();
		$this->stack    = array();
		$this->parent   = &$this->document;
		return xml_parse(&$this->parser, &$data, true) ? $this->document : NULL;
	}
	function open(&$parser, $tag, $attributes){
		$this->data = ''; #stores temporary cdata
		$this->last_opened_tag = $tag;
		if(is_array($this->parent) and array_key_exists($tag,$this->parent)){ #if you've seen this tag before
			if(is_array($this->parent[$tag]) and array_key_exists(0,$this->parent[$tag])){ #if the keys are numeric
				#this is the third or later instance of $tag we've come across
				$key = count_numeric_items($this->parent[$tag]);
			}else{
				#this is the second instance of $tag that we've seen. shift around
				if(array_key_exists("$tag attr",$this->parent)){
					$arr = array('0 attr'=>&$this->parent["$tag attr"], &$this->parent[$tag]);
					unset($this->parent["$tag attr"]);
				}else{					
					$arr = array(&$this->parent[$tag]);
				}

				$this->parent[$tag] = &$arr;
				$key = 1;
			}
			$this->parent = &$this->parent[$tag];
		}else{
			$key = $tag;
			if (isset($attributes["name"])) {
				$key = $attributes["name"];
				unset($attributes["name"]);

				if (!count($attributes)) {
					unset($attributes);
				}
				
			}
		}
		if($attributes) { 
			$this->parent["$key attr"] = $attributes;
		}
		$this->parent  = &$this->parent[$key];
		$this->stack[] = &$this->parent;
	}
	function data(&$parser, $data){
		if($this->last_opened_tag != NULL) #you don't need to store whitespace in between tags
			$this->data .= $data;
	}
	function close(&$parser, $tag){
		if($this->last_opened_tag == $tag){
			$this->parent = $this->data;
			$this->last_opened_tag = NULL;
		}
		array_pop($this->stack);
		if($this->stack) $this->parent = &$this->stack[count($this->stack)-1];
	}
}
function count_numeric_items(&$array){
	return is_array($array) ? count(array_filter(array_keys($array), 'is_numeric')) : 0;
}

//okay, make my own cconfig using thisone 

/**
* description
*
* @library	
* @author	
* @since	
*/
class CConfig {
	function CConfig($file , $lowtags = true) {

		$found = false;
		$cache = false;
		clearstatcache();

		//check if i can use the xml cacheing
		if (defined("_XMLCACHE") && (is_writable(_XMLCACHE) || defined("_XMLNOFILE")) ) {			
			//great, checking if there is a file with the name of mine
			$cache = true;
			
			//echo "<BR>file:" . filectime($file) . ":" . fileatime($file) . ":  $file";
			//build the presumed filename
			$filename = "XML" . str_replace("/" , "-" , $file) . ( defined("_XMLNOFILE") ? "" :  "-" . filectime($file)) . "";

			if (file_exists(_XMLCACHE . $filename)) {
				//found the file, so i can load it
				$this->vars = unserialize(GetFileContents(_XMLCACHE . $filename));
				$found = true;
			}			
		}
		
		if (!$found ) {
			if (is_file($file) || stristr($file , "://"))
				$content = GetFileContents($file);
			else 
				$content = $file;

			$this->content = str_replace("&","[amp]",$content);
			$this->data = XML_unserialize($this->content);
			$this->vars = ArrayReplace("[amp]" , "&" , $this->ParseOld($this->data) );

			if ($lowtags) 
				$this->vars = $this->LowTags($this->vars);
						
			//now try to cache this file for future use
			if ($cache && is_writable(_XMLCACHE)) {
				SaveFileContents(_XMLCACHE . $filename , serialize($this->vars));
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
	function LowTags($array) {
		if (is_array($array)) {
			foreach ($array as $key => $val) {
				if ($key != strtolower($key)) {
					$array[strtolower($key)] = $val;
					unset($array[$key]);
					$key = strtolower($key);
				}
				
				if (is_array($val)) {
					$array[$key] = $this->LowTags($val);
				}			
			}			
		}
		
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
	function ParseOld($array) {
		if (is_array($array)) {
			foreach ($array as $key => $val) {
				if (is_array($array[$key . " attr"]) && !is_array($val)) {
					$array[$key] = $array[$key . " attr"];
					unset($array[$key . " attr"]);
				}

				if (is_array($array[$key . " attr"]) && is_array($val)) {
					$array[$key] = array_merge($array[$key . " attr"], $val);
					unset($array[$key . " attr"]);
				}
				
				
			}	
			
			foreach ($array as $key => $val) {
				if (is_array($val)) {
					$array[$key] = $this->ParseOld($val);
				}				
			}
			
		} 
		
		return $array;
		
	}
}


//$data = new CConfig("site.xml");


?>