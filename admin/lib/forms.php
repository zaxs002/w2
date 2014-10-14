<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2010 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: forms.php,v 0.0.1 03/03/2004 17:38:21 oxylus Exp $
	forms generation class
*/

//dependencies
require_once _LIBPATH . "library.php";
require_once _LIBPATH . "common.php";
require_once _LIBPATH . "template.php";
require_once _LIBPATH . "html.php";
require_once _LIBPATH . "config.php";
require_once _LIBPATH . "database.php";

//define ("_MSG_FORMS_UNCOMPLETE" , "Please fill in all required fields");
define ("_MSG_FORMS_UNCOMPLETE" , "Please verify the data is filled in correctly.");
define ("_MSG_FORMS_UNIQUE" , " already exists.");
define ("_MSG_FORMS_EXISTS" , " doesn't exists.");
define ("_MSG_FORMS_FILEEXISTS" , " doesn't exists.");
define ("_MSG_FORMS_WRONGSECURITY" , " Invalid security check.");


define ("_FORMS_SETTINGS_FIELD_IMAGE_UPLOAD" , "flash");			// html for standard html upload or flash for flash widget


define("_FORMS_ERROR_FILL" , "1");
define("_FORMS_ERROR_UNIQUE" , "2");
define("_FORMS_ERROR_CHECK" , "3");
define("_FORMS_ERROR_FILE" , "4");
define("_FORMS_ERROR_CONFIRM" , "5");
define("_FORMS_ERROR_EXISTS" , "6"); //not implemented yet, the opposite of unique=true

$form_months = array (1 => "January" , "February" , "March" , "April" , "May" , "June" , "July" , "August" , "September" , "October" , "November" , "December");
$form_months_ro = array (1 => "Ianuarie" , "Februarie" , "Martie" , "Aprilie" , "Mai" , "Iunie" , "Iulie" , "August" , "Septembrie" , "Octombrie" , "Noiembrie" , "Decembrie");

$form_days = array (0 => "Sunday" , "Monday" , "Tuesday" , "Wensday" , "Thursday" , "Friday" , "Saturday");

$form_errors = array(
						"NO_BACK_LINK" => "javascript:alert('No previous link detected');"
					 );

$form_RO_states = array(
							"AB" => "Alba",
							"AR" => "Arad",
							"AG" => "Arges",
							"BC" => "Bacau",
							"BH" => "Bihor",
							"BN" => "Bistrita-Nasaud",
							"BT" => "Botosani",
							"BR" => "Braila",
							"BV" => "Brasov",
							"B" => "Bucuresti",
							"BZ" => "Buzau",
							"CL" => "Calarasi",
							"CS" => "Caras Severin",
							"CJ" => "Cluj",
							"CT" => "Constanta",
							"CV" => "Covasna",
							"DB" => "Dambovita",
							"DJ" => "Dolj",
							"GL" => "Galati",
							"GR" => "Giurgiu",
							"GJ" => "Gorj",
							"HG" => "Harghita",
							"HD" => "Hunedoara",
							"IL" => "Ialomita",
							"IS" => "Iasi",
							"IF" => "Ilfov",
							"MM" => "Maramures",
							"MH" => "Mehedinti",
							"MR" => "Mures",
							"NT" => "Neamt",
							"OT" => "Olt",
							"PH" => "Prahova",
							"SJ" => "Salaj",
							"SM" => "Satu Mare",
							"SB" => "Sibiu",
							"SV" => "Suceava",
							"TE" => "Teleorman",
							"TM" => "Timis",
							"TL" => "Tulcea",
							"VL" => "Valcea",
							"VS" => "Vaslui",
							"VN" => "Vrancea"
						);

$form_CA_states = array(
							"Alberta" => "Alberta",
							"British" => "British",
							"Manitoba" => "Manitoba",
							"New Brunswick" => "New Brunswick",
							"Newfoundland" => "Newfoundland",
							"Northwest Territories" => "Northwest Territories",
							"Nova Scotia" => "Nova Scotia",
							"Nunavut" => "Nunavut",
							"Ontario" => "Ontario",
							"Prince Edward Island" => "Prince Edward Island",
							"Quebec" => "Quebec",
							"Saskatchewan" => "Saskatchewan",
							"Yukon" => "Yukon"
					);

$form_US_states = array (
							"AL" => "Alabama",
							"AK" => "Alaska",
							"AZ" => "Arizona",
							"AR" => "Arkansas",
							"CA" => "California",
							"CO" => "Colorado",
							"CT" => "Connecticut",
							"DE" => "Delaware",
							"DC" => "Dist. of Columbia",
							"FL" => "Florida",
							"GA" => "Georgia",
							"HI" => "Hawaii",
							"ID" => "Idaho",
							"IL" => "Illinois",
							"IN" => "Indiana",
							"IA" => "Iowa",
							"KS" => "Kansas",
							"KY" => "Kentucky",
							"LA" => "Louisiana",
							"ME" => "Maine",
							"MD" => "Maryland",
							"MA" => "Massachusetts",
							"MI" => "Michigan",
							"MN" => "Minnesota",
							"MS" => "Mississippi",
							"MO" => "Missouri",
							"MT" => "Montana",
							"NE" => "Nebraska",
							"NV" => "Nevada",
							"NH" => "New Hampshire",
							"NJ" => "New Jersey",
							"NM" => "New Mexico",
							"NY" => "New York",
							"NC" => "North Carolina",
							"ND" => "North Dakota",
							"OH" => "Ohio",
							"OK" => "Oklahoma",
							"OR" => "Oregon",
							"PA" => "Pennsylvania",
							"PR" => "Puerto Rico",
							"RI" => "Rhode Island",
							"SC" => "South Carolina",
							"SD" => "South Dakota",
							"TN" => "Tennessee",
							"TX" => "Texas",
							"UT" => "Utah",
							"VT" => "Vermont",
							"VA" => "Virginia",
							"WA" => "Washington",
							"WV" => "West Virginia",
							"WI" => "Wisconsin",
							"WY" => "Wyoming"
						);

$form_countries = array(
							"AF" => "Afghanistan",
							"AL" => "Albania",
							"DZ" => "Algeria",
							"AS" => "American Samoa",
							"AD" => "Andorra",
							"AO" => "Angola",
							"AQ" => "Antartica",
							"AG" => "Antiqua and Barbuda",
							"AM" => "Armenia",
							"AR" => "Argentina",
							"AU" => "Australia",
							"AT" => "Austria",
							"AZ" => "Azerbaijan",
							"BS" => "Bahamas, The",
							"BH" => "Bahrain",
							"BD" => "Bangladesh",
							"BB" => "Barbados",
							"BY" => "Belarus",
							"BE" => "Belgium",
							"BZ" => "Belize",
							"BJ" => "Benin",
							"BM" => "Bermuda",
							"BT" => "Bhutan",
							"BO" => "Bolivia",
							"BW" => "Botswana",
							"BV" => "Bouvet Island",
							"BR" => "Brazil",
							"BQ" => "British Antartic Territory",
							"IO" => "British Indian Ocean Territory",
							"SB" => "British Solomon Islands",
							"VG" => "British Virgin Islands",
							"BN" => "Brunei",
							"BG" => "Bulgaria",
							"MM" => "Burma",
							"BI" => "Burundi",
							"KH" => "Cambodia",
							"CM" => "Cameroon",
							"CA" => "Canada",
							"CT" => "Canton and Enderbury Islands",
							"CV" => "Cape Verde Islands",
							"KY" => "Cayman Islands",
							"CF" => "Central African Republic",
							"TD" => "Chad",
							"CL" => "Chile",
							"CN" => "China, People's Republic of",
							"CX" => "Christmas Island",
							"CC" => "Cocos (Keeling) Islands",
							"CO" => "Colombia",
							"KM" => "Comoro Islands",
							"CG" => "Congo",
							"CK" => "Cook Islands",
							"CR" => "Costa Rica",
							"HR" => "Croatia",
							"CU" => "Cuba",
							"CY" => "Cyprus",
							"CZ" => "Czech Republic",
							"DY" => "Dahomey",
							"DK" => "Denmark",
							"DJ" => "Djibouti",
							"DM" => "Dominica",
							"DO" => "Dominican Republic",
							"NQ" => "Dronning Maud Land",
							"EC" => "Ecuador",
							"EG" => "Egypt",
							"SV" => "El Salvador",
							"GQ" => "Equitorial Guinea",
							"ER" => "Eritrea",
							"EE" => "Estonia",
							"ET" => "Ethiopia",
							"FO" => "Faeroe Islands",
							"FK" => "Falkland Islands (Malvinas)",
							"FJ" => "Fiji",
							"FI" => "Finland",
							"FR" => "France",
							"GF" => "French Guiana",
							"PF" => "French Polynesia",
							"FQ" => "French South and Antartic Territory",
							"AI" => "French Afars and Issas",
							"GA" => "Gabon",
							"GM" => "Gambia",
							"GE" => "Georgia",
							"DE" => "Germany",
							"GH" => "Ghana",
							"GI" => "Gibraltar",
							"GR" => "Greece",
							"GL" => "Greenland",
							"GD" => "Grenada",
							"GP" => "Guadeloupe",
							"GU" => "Guam",
							"GT" => "Guatemala",
							"GN" => "Guinea",
							"GW" => "Guinea Bissaw",
							"GY" => "Guyana",
							"HT" => "Haiti",
							"HM" => "Heard and McDonald Islands",
							"HN" => "Honduras",
							"HK" => "Hong Kong",
							"HU" => "Hungary",
							"IS" => "Iceland",
							"IN" => "India",
							"ID" => "Indonesia",
							"IR" => "Iran",
							"IQ" => "Iraq",
							"IE" => "Ireland",
							"IL" => "Israel",
							"IT" => "Italy",
							"CI" => "Ivory Coast",
							"JM" => "Jamaica",
							"JP" => "Japan",
							"JT" => "Johnston Island",
							"JO" => "Jordan",
							"KZ" => "Kazakhstan",
							"KE" => "Kenya",
							"KH" => "Khmer Republic",
							"KP" => "Korea, Democratic People's Republic of",
							"KR" => "Korea, Republic of",
							"KW" => "Kuwait",
							"KG" => "Kyrgystan",
							"LA" => "Laos",
							"LV" => "Latvia",
							"LB" => "Lebanon",
							"LS" => "Lesotho",
							"LR" => "Liberia",
							"LY" => "Libya",
							"LI" => "Liechtenstein",
							"LT" => "Lithuania",
							"LU" => "Luxembourg",
							"MO" => "Macao",
							"MG" => "Madagascar",
							"MW" => "Malawi",
							"MY" => "Malaysia",
							"MV" => "Maldives",
							"ML" => "Mali",
							"MT" => "Malta",
							"MH" => "Marshall Islands",
							"MQ" => "Martinique",
							"MR" => "Mauritania",
							"MU" => "Mauritius",
							"MX" => "Mexico",
							"FM" => "Micronesia",
							"MI" => "Midway Islands",
							"MD" => "Moldova",
							"MC" => "Monaco",
							"MN" => "Mongolia",
							"MS" => "Montserrat",
							"MA" => "Morocco",
							"MZ" => "Mozambique",
							"MM" => "Myanmar (formerly Burma)",
							"NA" => "Namibia",
							"NR" => "Nauru",
							"NP" => "Nepal",
							"NL" => "Netherlands",
							"AN" => "Netherlands Antilles",
							"NT" => "Neutral Zone",
							"NC" => "New Caledonia",
							"NH" => "New Hebrides",
							"NZ" => "New Zealand",
							"NI" => "Nicaragua",
							"NE" => "Niger",
							"NG" => "Nigeria",
							"NU" => "Niue Island",
							"NF" => "Norfolk Island",
							"NO" => "Norway",
							"OM" => "Oman",
							"PC" => "Pacific Island Trust Territory",
							"PK" => "Pakistan",
							"PW" => "Palau",
							"PA" => "Panama",
							"PZ" => "Panama Canal Zone",
							"PG" => "Papua New Guinea",
							"PY" => "Paraguay",
							"PE" => "Peru",
							"PH" => "Philippines",
							"PN" => "Pitcairn Islands",
							"PL" => "Poland",
							"PT" => "Portugal",
							"TP" => "Portuguese Timor",
							"PR" => "Puerto Rico",
							"QA" => "Qatar",
							"RE" => "Reunion Island",
							"RO" => "Romania",
							"RU" => "Russia",
							"RW" => "Rwanda",
							"SH" => "St. Helena",
							"KN" => "St. Kitts-Nevis-Anguilla",
							"LC" => "St. Lucia",
							"PM" => "St. Pierre and Miquelon",
							"VC" => "St. Vincent",
							"SM" => "San Marino",
							"ST" => "Sao Tome and Principe",
							"SA" => "Saudi Arabia",
							"SN" => "Senegal",
							"SC" => "Seychelles",
							"SL" => "Sierra Leone",
							"SG" => "Singapore",
							"SK" => "Slovakia",
							"SI" => "Slovenia",
							"SO" => "Somalia",
							"ZA" => "South Africa, Republic of",
							"ES" => "Spain",
							"EH" => "Spanish Sahara",
							"LK" => "Sri Lanka",
							"SD" => "Sudan",
							"SR" => "Suriname",
							"SJ" => "Svalbard and Jan Mayen Islands",
							"SZ" => "Swaziland",
							"SE" => "Sweden",
							"CH" => "Switzerland",
							"SY" => "Syria",
							"TW" => "Taiwan",
							"TJ" => "Tajikistan",
							"TZ" => "Tanzania",
							"TH" => "Thailand",
							"TG" => "Togo",
							"TK" => "Tokelau Island",
							"TO" => "Tonga",
							"TT" => "Trinidad and Tobago",
							"TN" => "Tunisia",
							"TR" => "Turkey",
							"TM" => "Turkmenistan",
							"TC" => "Turks and Caicos Islands",
							"TV" => "Tuvalu",
							"UG" => "Uganda",
							"UA" => "Ukraine",
							"AE" => "United Arab Emirates",
							"GB" => "United Kingdom",
							"US" => "United States",
							"PU" => "U.S. Miscellaneous Pacific Islands",
							"VI" => "U.S. Virgin Islands",
							"HV" => "Upper Volta",
							"UY" => "Uruguay",
							"UZ" => "Uzbekistan",
							"VU" => "Vanuatu",
							"VA" => "Vatican City State (The Holy See)",
							"VE" => "Venezuela",
							"VN" => "Vietnam",
							"WK" => "Wake Island",
							"WF" => "Wallis and Futuna Islands",
							"WS" => "Western Samoa",
							"YE" => "Yemen",
							"YD" => "Yemen, Democratic",
							"YU" => "Yugoslavia",
							"ZR" => "Zaire",
							"ZM" => "Zambia",
							"ZW" => "Zimbabwe"
						);

$form_timezones = array(
						 "1" => "(UTC/GMT -12:00) Eniwetok, Kwajalein", 
						 "2" => "(UTC/GMT -11:00) Midway Island, Samoa", 
						 "3" => "(UTC/GMT -10:00) Hawaii", 
						 "4" => "(UTC/GMT -9:00) Alaska", 
						 "5" => "(UTC/GMT -8:00) Pacific Time (US & Canada); Tijuana", 
						 "6" => "(UTC/GMT -7:00) Arizona", 
						 "7" => "(UTC/GMT -7:00) Mountain Time (US & Canada)", 
						 "8" => "(UTC/GMT -6:00) Central America", 
						 "9" => "(UTC/GMT -6:00) Central Time (US & Canada)", 
						 "10" => "(UTC/GMT -6:00) Mexico City", 
						 "11" => "(UTC/GMT -6:00) Saskatchewan", 
						 "12" => "(UTC/GMT -5:00) Bogota, Lima, Quito", 
						 "13" => "(UTC/GMT -5:00) Eastern Time (US & Canada)", 
						 "14" => "(UTC/GMT -5:00) Indiana (East)", 
						 "15" => "(UTC/GMT -4:00) Atlantic Time (Canada)", 
						 "16" => "(UTC/GMT -4:00) Caracs, La Paz", 
						 "17" => "(UTC/GMT -4:00) Santiago", 
						 "18" => "(UTC/GMT -3:00) Brasilia", 
						 "19" => "(UTC/GMT -3:00) Buenos Aires, Georgetown", 
						 "20" => "(UTC/GMT -3:00) Greenland", 
						 "21" => "(UTC/GMT -3:30) Newfoundland", 
						 "22" => "(UTC/GMT -2:00) Mid-Atlantic", 
						 "23" => "(UTC/GMT -1:00) Azores", 
						 "24" => "(UTC/GMT -1:00) Cape Verde Is.", 
						 "25" => "(UTC/GMT 00:00) Casablanca, Monrovia", 
						 "26" => "(UTC/GMT 00:00) Greenwich Mean Time :  Dublin, Edinburgh, Lisbon, London", 
						 "27" => "(UTC/GMT 01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna", 
						 "28" => "(UTC/GMT 01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague", 
						 "29" => "(UTC/GMT 01:00) Brussels, Copenhagen, Madrid, Paris", 
						 "30" => "(UTC/GMT 01:00) Sarajevo, Skopje, Warsaw, Zagreb", 
						 "31" => "(UTC/GMT 01:00) West Central Africa", 
						 "32" => "(UTC/GMT 02:00) Athens, Istanbul, Minsk", 
						 "33" => "(UTC/GMT 02:00) Bucharest", 
						 "34" => "(UTC/GMT 02:00) Cairo", 
						 "35" => "(UTC/GMT 02:00) Harare, Pretoria", 
						 "36" => "(UTC/GMT 02:00) Helsinki, Riga, Tallinn", 
						 "37" => "(UTC/GMT 02:00) Jerusalem", 
						 "38" => "(UTC/GMT 02:00) Sofija", 
						 "39" => "(UTC/GMT 02:00) Vilnius", 
						 "40" => "(UTC/GMT 03:00) Baghdad", 
						 "41" => "(UTC/GMT 03:00) Kuwait, Riyadh", 
						 "42" => "(UTC/GMT 03:00) Moscow, St. Petersburg, Volgograd", 
						 "43" => "(UTC/GMT 03:00) Nairobi", 
						 "44" => "(UTC/GMT 03:30) Tehran", 
						 "45" => "(UTC/GMT 04:00) Abu Dhabi, Muscat", 
						 "46" => "(UTC/GMT 04:00) Baku, Tbilis, Yerevan", 
						 "47" => "(UTC/GMT 04:30) Kabul", 
						 "48" => "(UTC/GMT 05:00) Yekaterinburg", 
						 "49" => "(UTC/GMT 05:00) Islamabad, Karachi, Tashkent", 
						 "50" => "(UTC/GMT 05:30) Calcutta, Chennai, Mumbai, New Delhi", 
						 "51" => "(UTC/GMT 05:45) Kathmandu", 
						 "52" => "(UTC/GMT 06:00) Almaty, Novosibirsk", 
						 "53" => "(UTC/GMT 06:00) Astana, Dhaka", 
						 "54" => "(UTC/GMT 06:00) Sri Jayawardenepura", 
						 "55" => "(UTC/GMT 06:30) Rangoon", 
						 "56" => "(UTC/GMT 07:00) Bangkok, Hanoi, Jakarta", 
						 "57" => "(UTC/GMT 07:00) Krasnoyarsk", 
						 "58" => "(UTC/GMT 08:00) Beijing, Chongqing, Hong Kong, Urumqii", 
						 "59" => "(UTC/GMT 08:00) Irkutsk, Ulaan Bataar", 
						 "60" => "(UTC/GMT 08:00) Kuala Lumpur, Singapore", 
						 "61" => "(UTC/GMT 08:00) Perth", 
						 "62" => "(UTC/GMT 08:00) Taipei", 
						 "63" => "(UTC/GMT 09:00) Osaka, Sapporo, Tokoyo", 
						 "64" => "(UTC/GMT 09:00) Seoul", 
						 "65" => "(UTC/GMT 09:00) Yakutsk", 
						 "66" => "(UTC/GMT 09:30) Adelaide", 
						 "67" => "(UTC/GMT 09:30) Darwin", 
						 "68" => "(UTC/GMT 10:00) Brisbane", 
						 "69" => "(UTC/GMT 10:00) Canberra, Melbourne, Sydney", 
						 "70" => "(UTC/GMT 10:00) Guan, Port Moresby", 
						 "71" => "(UTC/GMT 10:00) Hobart", 
						 "72" => "(UTC/GMT 10:00) Vladivostok", 
						 "73" => "(UTC/GMT 11:00) Magadan, Solomon Is., New Caledonia", 
						 "74" => "(UTC/GMT 12:00) Aukland, Wellington", 
						 "75" => "(UTC/GMT 12:00) Fiji, Kamchatka, Marshal Is.", 
						 "76" => "(UTC/GMT 13:00) Nuku'alofa"
);
/**
* abstract library class
*
* @library	Forms Auto Generations and validations library
* @author	oxylus [Emanuel Giurgea <emanuel@oxylus.ro>]
* @since	PHPbase 0.0.1
*/

class CForm extends CLibrary{

	//some default settings
	var $_textareaCols = 30;
	var $_textareaRows = 4;

	var $_textboxSize = 20;
	var $_textboxMaxLength = "";

	var $textareaButtons = array (
				"1" => "'cut' ,  'copy' , 'paste' , 'separator' , 'undo' , 'redo' , 'separator' , 'removeformat' , 'toolbar' , 'bold' , 'italic' , 'underline' , 'strike' , 'superscript' , 'subscript' , 'insertorderedlist' , 'insertunorderedlist' , 'indent' , 'outdent' , 'inserthr'",
				"2" => "'font-family' , 'font-size' , 'justifyleft' ,  'justifycenter' , 'justifyright' , 'justifyfull' , 'separator' , 'link' , 'resource'"
			);

	var $__default = array ( 
					"show" => array (
								"phone" => array ("size" => "3,3,4"),
								"droplist" => array ("empty_msg" => "<i>N/A</i>"  , "empty_text" => "[ select ]", "empty_text_show" => "<i>N/A</i>"),
								"radio" => array ("empty_text" => "[ none ]" , "empty_text_show" => "<i>N/A</i>")
							  ),
					"list" => array(
								"fields" => array( "maxchars_text" => "[...]")
								)
					);

	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $db;

	/**
	* description array with all functions to be executed in various posittions in cform
	*
	* @var type
	*
	* @access type
	*/
	var $functions;
	

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function CForm($template , $db , $tables , $form = "") {
		parent::CLibrary("CForm");

		//adding extra check if the file is a template or is a string		
		if (!is_object($template)) {	
			if (file_exists($template)) {
				$template = new CTemplate($template);
			}
		}

		//optionaly added $form
		if ($form != "")
			$this->form = $this->Process($form);
		
		$this->templates = $template;
		$this->db = $db;
		$this->tables = $tables;

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
	function __render($data , $vars = array()) {

		$this->tpl_vars = array_merge($vars , (array)$this->tpl_vars);

		$this->tpl_vars['&amp;'] = "&";

		if (is_array($this->tpl_vars )) {
			//inizialize a new template
			$tmp = new CTemplate($data , "string");

			return $tmp->Replace($this->tpl_vars);
		} else 
			return $data;
	}


	/**
	* description checking if the input is an array or an xml file 
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function Process($input) {
		if (is_array($input)) {
			return $input;
		} else {
			if (file_exists($input)) {
				$xml = new CConfig($input);				
				$xml->vars["form"]["xmlfile"] = $input ;

				return $xml->vars["form"];
			} else
				return null;			
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
	function ProcessLinks($link) {
		return CryptLink($link);
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
	function Validate($form  , $input) {

		global $_CONF;

		$form = CForm::Process($form);


		if (is_array($form["fields"])) {

			if ($input[$form["table_uid"]]) {
				$old_record = $this->db->QFetchArray("SELECT * FROM `" . $this->tables[$form["table"]] . "` WHERE `" . $form["table_uid"] . "`='" . $input[$form["table_uid"]] . "'" );
			}


			foreach ($form["fields"] as $key => $val) 					


				if (	
						($val["validate"] && $val["required"] && ($val["editable"] != "false")) || 
						($val["validate"] && !$val["required"] && ($val["editable"] != "false") && $input[$key]) 
				) {				

					if (
						($val["protected"] && $old_record[$val["protected"]]) || 
						($val["restricted"] && $this->__isRestricted($val["restricted"])) 
					) {
						//do nothing, this is a field which doesnt need to apear
					} else {					
						//prepare the field name
						$val["name"] = $val["name"] ? $val["name"] : $key;
						switch ($val["type"]) {

							case "ccard":
							case "creditcard":
								//group all the values
								$input[$val["name"]] = trim(@implode("" , $input[$val["name"] . "_arr"] ));
								$_valid_temp[] = strtoupper($val["name"]) . ":" . "I:16:16";
							break;

							case "date":
								$input[$val["name"]] = mktime(
															$input[$val["name"] . "_hour"],
															$input[$val["name"] . "_minute"],
															$input[$val["name"] . "_second"],
															$input[$val["name"] . "_month"],
															$input[$val["name"] . "_day"],
															$input[$val["name"] . "_year"]
														);
								
								//fix if the dates werent correct
								if ($input[$val["name"]] <= 0 )
									$input[$val["name"]] = 0;
								
								$_valid_temp[] = strtoupper($val["name"]) . ":" . $val["validate"];
							break;
							
							default:
								//check for exceptions
								if (stristr($val["validate"],"CC"))
									$val["validate"] = "CC:" . $input[$val["name"] . "_type"] . ":";
									

								$_valid_temp[] = strtoupper($val["name"]) . ":" . $val["validate"];
							break;

							case "phone":
								$_valid_temp[] = strtoupper($val["name"]) . ":" . "A:10:10";
								$input[$val["name"]] = trim(@implode("" , $input[$val["name"] . "_arr"] ));
							break;

							case "relation":
								unset($_valid_temp);
							break;

							case "droplist":
							case "radio":
							case "radiolist":
							case "checklist":
								if (is_array($input[$val["name"]])) {								
									$input[$val["name"]] = implode("," , $input[$val["name"]]);
								}
								$_valid_temp[] = strtoupper($val["name"]) . ":" . $val["validate"];
							break;

						}								
					}
				}

			if (is_array($_valid_temp) && count($_valid_temp)) {
				$validate = implode("," , $_valid_temp);
			}
						

		}				

		//validate the input fields
		$result = ValidateVars($input ,$validate);
		$vars = array();

		if (is_array($result)) {
		
			foreach ($result as $key => $val) {

				//get the name for the element
				$fld = trim(strtolower($val));

				//check if it was refered
				if ($form["fields"][$fld]["referer"])
					$fields["errors"][$form["fields"][$fld]["referer"]] = 1;
				
				$fields["errors"][$fld] = 1;
			}

			$fields["error"] = _MSG_FORMS_UNCOMPLETE;
			$fields["values"] = $input;

			$fields["errorCode"] = "1";


		} else {

			//proceed to complex validation for unique fields 
			if (is_array($form["fields"])) {

				
				foreach ($form["fields"] as $key => $val) {					

					$name = $val["name"] ? $val["name"] : $key ;

					if (($val["type"] == "file") && ($val["required"] == "true")) {
						if (!is_array($_FILES[$name]) || (is_array($_FILES[$name]) && $_FILES[$name]["error"])) {
							$fields["error"] = _MSG_FORMS_UNCOMPLETE;
							$fields["values"] = $input;
							$fields["errorCode"] = "1";
							$fields["errors"][$name] = 1;
						}
					}

					if ($val["unique"] == "true") {

						//check if this is an adding processor or editing one
						if ($input[$form["table_uid"]]) {
							$old_record = $this->db->QFetchArray("SELECT * FROM `" . $this->tables[$form["table"]] . "` WHERE `" . $form["table_uid"] . "`='" . $input[$form["table_uid"]] . "'" );
						}

						$data = $this->db->QFetchArray("SELECT `$name` FROM `" . $this->tables[$form["table"]] . "` WHERE `" . $name . "` = '" . $input[$name] . "'");

						if (((is_array($data) && is_array($old_record)) && ($data[$name] != $old_record[$name])) || (is_array($data) && !is_array($old_record))) {

							//preparing the message
							$fields["error"] = $val["unique_err"] ? $val["unique_err"] : $val["title"] . _MSG_FORMS_UNIQUE;
							$fields["errors"][$name] = 1;
							$fields["values"] = $input;
							$fields["errorCode"] = "2";

						}
					}

					if ($val["exists"] == "true") {

						//check if this is an adding processor or editing one
						if ($input[$form["table_uid"]]) {
							$old_record = $this->db->QFetchArray("SELECT * FROM `" . $this->tables[$form["table"]] . "` WHERE `" . $form["table_uid"] . "`='" . $input[$form["table_uid"]] . "'" );
						}

						$data = $this->db->QFetchArray("SELECT `$name` FROM `" . $this->tables[$form["table"]] . "` WHERE `" . $name . "` = '" . $input[$name] . "'");

						if (!is_array($data)) {
							//preparing the message
							$fields["error"] = $val["unique_err"] ? $val["unique_err"] : $val["title"] . _MSG_FORMS_EXISTS;
							$fields["errors"][$name] = 1;
							$fields["values"] = $input;
							$fields["errorCode"] = "6";

						}
					}

					if ($val["type"] == "checkIMG") {

						if ($_SESSION[$_CONF["site"]]["XML_verify_key"] != $_POST[$name]) {

							$fields["error"] = $fields["error"]  ? $fields["error"]  : _MSG_FORMS_WRONGSECURITY;
							$fields["errors"][$name] = 1;
							$fields["values"] = $input;
							$fields["errorCode"] = "3";

						}
						
					}
								
					// search to see if is a vvalid file path
					if ($val["fileexists"] == "true") {
						$name = $val["name"] ? $val["name"] : $key ;

						if (!is_file($input[$name])) {
							//preparing the message
							$fields["error"] = $val["fileexists_err"] ? $val["fileexists_err"] : $val["title"] . ": \"$input[$name]\"" . _MSG_FORMS_FILEEXISTS;
							$fields["errors"][$name] = 1;
							$fields["values"] = $input;
							$fields["errorCode"] = "4";
						}
						
					}

					//echo $input[$name . "_confirm"];

					

					// search to see if is a vvalid file path
					if (($input[$name] != $input[$name . "_confirm"]) && is_array($form["fields"][$name . "_confirm"])) {
						
						if ($input[$name] != $input[$name . "_confirm"]) {
							//preparing the message
							$fields["error"] = "Password and confirmation doesnt match.";
							$fields["errors"][$name] = 1;
							$fields["errors"][$name . "_confirm"] = 1;
							$fields["values"] = $input;
							$fields["errorCode"] = "5";
						}
						
					}

				}
					
			}
			
		}

		return is_array($fields) ? $fields : true;

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
	function __simple_list_load_Records($form , $page = null) {

		if (!is_array($items) && is_object($this->db) && count($this->tables)) {
	
			//if no items and no sql then build an sql query right here
			if (!is_array($form["sql"])) {	
				$form["sql"] = array(
					"vars" => array(
							"table" => array("type" => "table"),
							"page" => array("type" => "page"),
							"items" => array("type" => "form" , "var" => "items"),
							"order" => array("type" => "var" , "import" => $_GET["order"]),
							"order_mode" => array("type" => "var" , "import" => $_GET["order_mode"] && array_exists($_GET["order_mode"] , array("ASC" , "DESC" )) ? $_GET["order_mode"] : "ASC")
						)
				);

				$form["sql"]["query"] = "SELECT * FROM {TABLE} " . ($_GET["order"] ? "ORDER BY {ORDER} {ORDER_MODE}" : "") . " LIMIT {PAGE} , {ITEMS} ";
				$form["sql"]["count"] = array("table" => "{TABLE}" , "condition" => "");
			} else {
				//force the $order and order mode to be after the data from the $_GET
				if ($form["sql"]["vars"]["order"] && $_GET["order"])
					$form["sql"]["vars"]["order"]["import"] = $_GET["order"];

				if ($form["sql"]["vars"]["order_mode"] && $_GET["order_mode"])
					$form["sql"]["vars"]["order_mode"]["import"] = $_GET["order_mode"];
				
			}

			if (is_array($form["sql"])) {

				if (is_array($form["sql"]["vars"])) {

					foreach ($form["sql"]["vars"] as $key => $val) {
						//echeking if the default must be evaluated
						if ($val["action"] == "eval") {
							eval("\$val[\"import\"] = " . $val["default"] .";");
						}

						switch ($val["type"]) {
							case "eval":
								eval("\$sql_vars[\"$key\"] = " . $val["import"] . ";");
							break;

							case "var":
								$sql_vars[$key] = $val["import"];
							break;

							case "table":
								$sql_vars[$key] = $val["import"] ? $this->tables[$val["import"]] : $this->tables[$form["table"]];
								$__tables[] = $key;
							break;

							case "page":
								if ($page != null) {
									$sql_vars[$key] = $page;
								} else {								
									$sql_vars[$key] = ($_GET[($val["code"] ? $val["code"] : 'page')] -1 )* $form['items'];
								}
							break;

							case "form":
								$sql_vars[$key] = $form[$val["var"]];
							break;
						}										
					}

					foreach ($sql_vars as $key => $val) {							
						$this->templates->blocks["Temp"]->input = $val;							
						$sql_vars[$key] = $this->templates->blocks["Temp"]->Replace($sql_vars);
						$sql_vars[$key] = str_replace("]" , ">" , str_replace("[" , "<" , $sql_vars[$key]));
					}	
					
					//doing a double replace, in case there are unreplaced variable sfom "vars" type
					$this->templates->blocks["Temp"]->input = $form["sql"]["query"];
					$sql = $this->templates->blocks["Temp"]->Replace($sql_vars);

					//do a precheck for [] elements to be replaced with <>
					$sql = str_replace("]" , ">" , str_replace("[" , "<" , $sql));

					$items = $this->db->QFetchRowArray($sql);
					//$items = $this->Query						

					//processing the counting query
					if (is_array($form["sql"]["count"])) {

						//if no table is set then i use the default table'
						$form["sql"]["count"]["table"] = $form["sql"]["count"]["table"] ? $form["sql"]["count"]["table"] : $form["table"];

						foreach ($form["sql"]["count"] as $key => $val) {
							$this->templates->blocks["Temp"]->input = $val;							
							$form["sql"]["count"][$key] = $this->templates->blocks["Temp"]->Replace($sql_vars);
						}						

						$count = $this->db->RowCount($form["sql"]["count"]["table"] , $form["sql"]["count"]["condition"] , $form["sql"]["count"]["select"] , $form["sql"]["count"]["fields"] );
					}					
				}				
			}
		}

		$_GET["page"] = $_GET["page"] ? $_GET["page"] : 1;
		//auto index the element
		$start = $form["items"] * ($_GET["page"] ? $_GET["page"] - 1 : 0);

		$_old_count = $start + 1;

		if (is_array($items)) {
			foreach ($items as $key => $val) {
				$items[$key]["_count"] = ++$start;
				$items[$key]["original_count"] = $items[$key]["_count"] ;
			}			
		}		

		if (is_Array($items)) {
			return array(
				"items"	=> $items,
				"count"	=> $count
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
	function AjaxList($form , $items = "", $count = "", $extra = null , $search = false , $returnArray  = false) {
		global 
			$_CONF , 			
			$form_errors , 
			$_USER , 
			$form_countries, 
			$form_months,
			$form_US_states,
			$form_RO_states,
			$form_CA_states;

		if (is_array($form["order"]) && ($form["order"]["drag"] == "true") && !$this->__isRestricted($form["order"]["restricted"])) {
			$form["fields"]["button_reorder"] = array(
				"type"		=> "button",
				"width"		=> "20",
				"align"		=> "center",
				"button"	=> $form["order"]["button"] ? $form["order"]["button"]  : "reorder",
				"location"	=> "javascript:void(0);"
			);

		}		


		//add the extra button if order exists

		if (is_array($form["vars"])) {
			foreach ($form["vars"] as $key => $val) {
				//echeking if the default must be evaluated
				if ($val["action"] == "eval") {
					eval("\$val[\"import\"] = " . $val["default"] .";");
				}

				switch ($val["type"]) {
					case "eval":
						eval("\$tpl_vars[\"$key\"] = " . $val["import"] . ";");
					break;
					case "complex_eval":
						eval($val["import"]);
					break;

					case "var":
						$tpl_vars[$key] = $val["import"];
					break;
				}													
			}
		}
		//$tpl_vars = array_merge($tpl_vars);
		$global_vars = $this->GlobalVars($form);

		$records = $this->__simple_list_load_records($form);

		$items = $records["items"];
		$count = $records["count"];

		if ($returnArray == true) {
			return array(
						"items" => $items,
						"count" => $count
						);
		}

		if (!count($items)) {
			return "empty";
		}		


		//check if ordering field is acctivated disable the reordering
		if (is_array($form["order"])) {
			$form["header"]["nolinks"] = "true";
		}
		

//		debug($items);
		
		$_new_count = $start;

		$html = new CHtml();

		$form = $this->Process($form);

		$template = &$this->templates;

		//this sux, building the template
		if (is_array($form["fields"])) {

			//prepare the fields list
			if ($form["sql"]["vars"]["fields"] != "")
				$__fields = explode("," , $form["sql"]["vars"]["fields"]);
			else {
				//read the fields from the table
				if (is_array($__tables)  && is_object($this->db)) {
					$__fields = array();
					foreach ($__tables as $_k => $_v) {
						$__fields = array_merge((array)$__fields , (array)$this->db->GetTableFields($sql_vars[$_v]));
					}					
				}
			}

			$tmp_count = 0;
			foreach ($form["fields"] as $key => $val) {
				if (!($val["restricted"] && $this->__isRestricted($val["restricted"]))) {

					$tmp_count ++;

					$cell = array (
									"width" => $val["width"],
									"align" => $val["align"],
									"value" => "{" . strtoupper($key) . "}",
									"valign" => $val["valign"] ? $val["valign"] : "middle",
									"final" => !is_array($form["buttons"]) && ($tmp_count == count($form["fields"])) ? "Final" : "",
									"first" => $tmp_count == 1 ? "First" : "",
								);

					//add the alternance field here
					if ($form["valternance"] == "true") {
						$cell["_valternance"] = $this->_tmpVAlternance ? "2" : "";
						$this->_tmpVAlternance = $this->_tmpVAlternance ? 0 : 1;
					} else
						$cell["_valternance"]  = "";

					$data .= $template->blocks["ListCell"]->Replace (
								$cell
							  );

					if ($val["type"] == "multiple")
						$val["header"] = $template->blocks["SimpleListMultipleHeader"]->Replace(array(
											"name" => $val["field"],
											"start" => $_old_count,
											"end" => $_new_count
										));
					
					//prepare the title
					$__title = ($val["header"] ?  $val["header"]  : "<img width=0 height=1 border=0/>");

					if ($sql_vars["order"] == $key)
						$__sorting_mode = $_GET["order_mode"] == "ASC" ? "DESC" : "ASC";				
					else
						$__sorting_mode = "ASC";								


					//check if this forms allows the title to be sortable
					if ($form["header"]["nolinks"] == "true") {
						//unclickable link
						$__template = "ListTitle";
					} else {
						//if this field appears in the list of table firles show title with link
						if (is_array($__fields) && in_array($key , $__fields))
							$__template = "ListTitleLink";
						else
							//no link title
							$__template = "ListTitle";
					}

					
					$__tmp_title = array(
								"title" => $__title,
								"width" => $val["width"] ? " width=\"{$val[width]}\" " : "",
								"final" => !is_array($form["buttons"]) && ($tmp_count == count($form["fields"])) ? "Final" : "",
								"first" => $tmp_count == 1 ? "First" : "",
								"link" => CSYS::_GetVar(
												array( 
													"order" => $key , 
													"order_mode"=> $__sorting_mode
													)
											),
								"order" => $sql_vars["order"] == $key ? 
												$template->blocks["ListTitleLinkOrder"]->Replace(
													array(
														"order" => strtolower($__sorting_mode)
													)
												) : ""
							);

					if ($form["valternance"] == "true") {
						$__tmp_title["_valternance"] = $this->_tmpVAlternanceHeader ? "2" : "";
						$this->_tmpVAlternanceHeader = $this->_tmpVAlternanceHeader ? 0 : 1;
					} else
						$__tmp_title["_valternance"]  = "";

					
					//buildint the title header
					$titles .= $template->blocks[$__template]->Replace ( $__tmp_title );

				}
				
			}



			//adding one more title col in titles ( the one for buttons )
			if (is_array($form["buttons"])) {

# DEPRECATED
				$titles .= $template->blocks["ListTitle"]->Replace ( array(
									"title" => "&nbsp" , 
									"final" => "Final" , 
									"width" => $val["width"] ? " width=\"{$val[width]}\" " : ""
							));
				$row = $data . $template->blocks["ButtonsCell"]->output;
			} else
				$row = $data;
			
			//debug($form);

			$template->blocks["ListElement"]->input = $template->blocks["ListRow"]->Replace(array(
					"ROW"			=> $row,
					"class"			=> "FormSimpleListRow",
					"order_id"		=> is_array($order),
					"order_value"	=> "table_order_{" . strtoupper($form["table_uid"]) . "}"

			));			


			$titles = $template->blocks["ListRow"]->Replace(array(
					"ROW"			=> $titles ,
					"CLASS"			=> "FormSimpleListTitle",
					"order_value"	=> "",
				));

			//fuck i know this is stupid, but now i dont have other idees
			//if i see a variable <no heade> then i clear the template
			if ($form["header"]["titles"] == "false") {
				$titles = "";
			}			
		}
		
		
		
		$template->blocks["ListGroup"]->input = $template->blocks["ListGroupAjax"]->input;

		//prereplace the vars main template
		$template->blocks["ListGroup"]->input = $template->blocks["ListGroup"]->Replace($form);

//! TEST
		if (is_array($global_vars)) {
			$template->blocks["ListElement"]->input = $template->blocks["ListElement"]->Replace($global_vars);
			$template->blocks["Button"]->input = $template->blocks["Button"]->Replace($global_vars);
		}		

//! E:TEST
		//prereplace the pagination template

		if (is_array($_GET)) {
			foreach ($_GET as $key => $val) {
				if ($key != "page") {

					//check if the data from get isnt a complex array too.
					if (is_array($val)) {
						foreach ($val as $k => $v)
							$url[] = $key . "[$k]" . "=" . $v;
					} else {					
						if ($key == "returnurl") {
							$url[] = $key . "=" . urlencode($val);
						} else {					
							$url[] = $key . "=" . $val;
						}
					}
				}
			}
			
			$url = $_SERVER["SCRIPT_NAME"] . "?" . @implode("&" , $url) . "&";
		}

		$template->blocks["Page"]->input = $template->blocks["Page"]->Replace(array("BASE" => $url));
		
		$_GET["page"] = ($_GET["page"] ? $_GET["page"] : "1");

		$items = $this->__simple_list_process_items($form , $items);
		
		if ($form["items"]) {

			$return = CTemplateStatic::Replace(
				$html->Table( $template , "List" , $items),
				array(
					"paging" => CHTML::CustomPaging(
						$template , 
						"Paging",
						10 , 
						ceil($count / $form["items"]) , 
						$_GET["page"] , 
						$url . "&page={PAGE}"
					),
				)
			);

		} else {
			$return = $html->Table( $template , "List" , $items );			
		}

		if (is_array($this->functions["list"]["after"]))
			call_user_func($this->functions["list"]["after"],&$append);
		
		
		$this->templates->blocks["Temp"]->input = $return;

		return $this->__render($this->templates->blocks["Temp"]->input , array_merge((array)$global_vars,(array)$tpl_vars));
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
	function __simple_list_process_items($form , $items) {
		global $_CONF;

		$global_vars = $this->GlobalVars($form);

		$template = &$this->templates;

//preprocessing the items
		if (is_array($items)) {
			foreach ($items as $key => $val) {
				if (is_array($form["fields"])) {

					foreach ($form["fields"] as $k => $v) {
						if (!$v["name"])
							$v["name"] = $k;
						

						//this is for utf8 support, EXPERIMENTAL
						$items[$key][$k] = html_entity_decode($items[$key][$k] , ENT_QUOTES);

						switch ($v["type"]) {


							case "phone":

								if (!$v["size"])
									$v["size"] = $this->__default["show"]["phone"]["size"];

								$size = explode("," , $v["size"]);

								$items[$key]["original_" . $k] = $items[$key][$k];

								if (strlen($items[$key][$k]) <2)
									$items[$key][$k] = "<i>N/A</i>";
								else								
									$items[$key][$k] = substr($items[$key][$k],0,$size["0"]) . "-" . substr($items[$key][$k],$size["0"],$size["1"]) . "-" . substr($items[$key][$k],$size["1"],$size["2"]);
							break;

							case "rostates":
								$items[$key]["original_" . $k] = $items[$key][$k];
								$items[$key][$k] = $form_RO_states[$items[$key][$k]];
							break;


							case "states":
							case "usstates":
								$items[$key]["original_" . $k] = $items[$key][$k];
								$items[$key][$k] = $form_US_states[$items[$key][$k]];
							break;

							case "castates":
								$items[$key]["original_" . $k] = $items[$key][$k];
								$items[$key][$k] = $form_CA_states[$items[$key][$k]];
							break;

							case "countries":
								$items[$key]["original_" . $k] = $items[$key][$k];
								$items[$key][$k] = $form_countries[$items[$key][$k]];
							break;

							case "date":

								//save the value
								$items[$key]["original_" . $k] = $items[$key][$k];

#### STILL WORKING ON THIS
								if (isset($v["fields"])) {
									$supp_fields = array("month" , "year" , "month_str", "day");

									$_tmp_v = "";


									foreach ($supp_fields  as $__k => $__v) {
										switch ($__v) {
											case "month_str":
												$_tmp_v[$__v] = $form_months[$val[$k . "_month" ]];
											break;

											case "day":
												$_tmp_v[$__v] = sprintf("%02d" ,$val[$k . "_day" ]);
											break;
										}										
									}

									$items[$key][$k] = $v["fields"];
									foreach ($_tmp_v as $__k => $__v) {
										$items[$key][$k] = str_replace($__k , $__v , $items[$key][$k]);									
									}									
									
								} else {
								
									if (isset($val[$k . "_day" ]) && isset($val[$k . "_month" ]) && isset($val[$k . "_year" ]))  {

										$items[$key][$k] = 
															( $val[$k . "_month" ] ? sprintf("%02d" ,$val[$k . "_month" ])  : "--" ). "/" . 
															( $val[$k . "_day" ] ? sprintf("%02d" ,$val[$k . "_day" ]) : "--" ) . "/" .  
															( $val[$k . "_year" ] ? $val[$k . "_year" ] : "----" ) ;
									} else						
										//$field["value"] = $field["value"] > 0 ? @date($field["params"] , $field["value"]) : "not available";
										$items[$key][$k] = $items[$key][$k] > 0 ? @date($v["params"] , ($v["now"] == "true" ? time() : $items[$key][$k])) : "N/A";
								}

//								$items[$key][$k] = $items[$key][$k] > 0 ? @date($v["params"] , ($v["now"] == "true" ? time() : $items[$key][$k])) : "N/A";
							break;

							case "price":
								$items[$key]["original_" . $k] = $items[$key][$k];
								$items[$key][$k] = number_format($items[$key][$k],2);
							break;

							case "int":
								$items[$key][$k] = (int)$items[$key][$k];
							break;

							case "image":
								if (isset($items[$key][$k]) && $items[$key][$k]) {
									// if is the image then show it
									$items[$key][$k] = $template->blocks[$v["nolink"] == "true"  ? "imageshownolink" : "imageshow"]->Replace(
															array(
																"width" => $v["width"],
																"border" => $v["border"] ? $v["border"] : 0,
																"height" => $v["height"] ? "height='{$v[height]}' " : "",
																"src" => $v["link"] ? $v["link"] : (($v["absolute"] == "true" ? "" : $_CONF["url"] . $_CONF["upload"]) . $v["path"] . CTemplateStatic::Replace($v["file"]["default"] , $items[$key]) . ($v["file"]["field"] ? $items[$key][$v["file"]["field"]] : "") . $v["file"]["ext"]),
																"title" => $v["title"]
															)
														);

									
									
								} else {
									//else check if the default image exists
									
									if ($v["default"]) {
										$items[$key][$k] = $template->blocks["imageshownolink"]->Replace(
																array(
																	"width" => $v["width"],
																	"border" => $v["border"] ? $v["border"] : 0,
																	"height" => $v["height"] ? "height='{$v[height]}' " : "",
																	"src" => $_CONF["url"] . $_CONF["upload"] . $v["path"] . $v["default"],
																	"title" => $v["title"]
																)
															);
									} else 
										//if not simply return a space
										$items[$key][$k] = "&nbsp;";
								}
							break;



							case "relation":
								//cheking if there are static relations or dinamic relations
								$items[$key]["original_" . $k] = $items[$key][$k];
								
								if (is_array($v["options"])) {

									if (($v["multi"] == "true" )) {
										$_tmp = explode("," , $items[$key][$k]);
										$items[$key][$k] = array();
										foreach ($_tmp as $__k => $__v)
											$items[$key][$k][] = $v["options"][$__v];
										

										if (count($items[$key][$k]))
											//implode by ,
											$items[$key][$k] = implode($v["sep"] ? $v["sep"] : ", " , $items[$key][$k]);
										else
											$items[$key][$k] = "";
										
									} else	
									
										//ok, i have the static ones
										$items[$key][$k] = $v["options"][$items[$key][$k]] ? $v["options"][$items[$key][$k]] : "&nbsp;";	
								}
					
								if (is_array($v["relation"])) {
									//reading from database
									//MULTI ELEMENTS

									$tmp_table= explode("," , $v["relation"]["table"]);
									$rel_table = array();

									if (count($tmp_table)) {
										foreach ($tmp_table as $__k => $__table) {
											$rel_table[] = $this->tables[$__table];
										}

										$rel_table = implode(" , " , $rel_table);							
									} else 
										$rel_table = $this->tables[$v["relation"]["table"]];


									if ($v["multi"] == "true") {
										$record = "";
										$_tmp = explode("," , $items[$key][$k]);
										if (is_array($_tmp)) {
											//read the elements which arent already in the cache
											foreach ($_tmp as $__key => $__val) {
												if (!is_array($this->cache["list"][$v["name"]][$__val])) {
													$record[] = $this->cache["list"][$v["name"]][$__val] = $this->db->QFetchArray(
																"SELECT * FROM " . $rel_table . " WHERE `" . $v["relation"]["id"] . "`='" . $__val . "'"
															);

													
												} else 
													$record[] = $this->cache["list"][$v["name"]][$__val];
											}											

											//add all the elements to the existing
										}
									} else {
										//NON MULTI ELEMENTS
										//check if this isnt already inthe cache
										if (!is_array($record = $this->cache["list"][$v["name"]][$items[$key][$k]])) {

											$sql =	"SELECT * FROM " . $rel_table . " WHERE `" . $v["relation"]["id"] . "`='" . $items[$key][$k] . "'";

											$record =$this->db->QFetchArray( $sql );

											//save the record in some sort of cache
											if (!is_array($record)) {
												$this->cache["list"][$v["name"]][$items[$key][$k]] = array();
											} else
												$this->cache["list"][$v["name"]][$items[$key][$k]] = $record;											
										}
									}
									
									//build the label for multiple fields 

									if (is_array($v["relation"]["text"])) {
										$_tmp_text = "";

										foreach ($v["relation"]["text"] as $kkey => $vval)
											if (is_array($vval))
												$_tmp_text[] = $vval["preffix"] . $record[$vval["field"]] . $vval["suffix"];
											else
												$_tmp_text[] = $record[$vval];
										
										$items[$key][$k] = implode($v["relation"]["separator"] ? $v["relation"]["separator"] : " " , $_tmp_text);
									} else
										if (($v["multi"] == "true" ) && is_array($record)) {
											foreach ($record as $__k => $__v)
												$record[$__k] = $record[$__k][$v["relation"]["text"]];
											
											//implode by ,
											$items[$key][$k] = implode($v["sep"] ? $v["sep"] : ", " , $record);
											
										} else										
											//else return the single field
											$items[$key][$k] = $record[$v["relation"]["text"]];

								}	
								
								if ($items[$key][$k] == "")
									$items[$key][$k] = "N/A";
								
							break;

							case  "sql":
								$items[$key]["original_" . $k] = $items[$key][$k];
						
								if (is_array($v["sql"])) {
									$form_sql_vars = array();

									if (is_array($v["sql"]["vars"])) {
										foreach ($v["sql"]["vars"] as $_key => $_val) {
											//echeking if the default must be evaluated
											if ($_val["action"] == "eval") {
												eval("\$_val[\"import\"] = " . $_val["default"] .";");
											}

											switch ($_val["type"]) {
												case "eval":												
													eval("\$form_sql_vars[\"$_key\"] = " . $_val["import"] . ";");
												break;

												case "var":
													$form_sql_vars[$_key] = $_val["import"];
												break;

												case "page":
													$form_sql_vars[$_key] = ($_GET[($_val["code"] ? $_val["code"] : 'page')] -1 )* $form['items'];
												break;

												case "form":
													eval("\$form_sql_vars[\"$_key\"] = " . $form[$_val["var"]] . ";");
												break;

												case "table":
													$form_sql_vars[$_key] = $_val["import"] ? $this->tables[$_val["import"]] : $this->tables[$form["table"]];
												break;

												case "field":
													$form_sql_vars[$_key] = $items[$key][$_val["import"]];
												break;
											}													
										}

										foreach ($form_sql_vars as $_key => $_val) {							
											$this->templates->blocks["Temp"]->input = $_val;							
											$form_sql_vars[$_key] = $this->templates->blocks["Temp"]->Replace($form_sql_vars);
										}	

										//doing a double replace, in case there are unreplaced variable sfom "vars" type
										$this->templates->blocks["Temp"]->input = $v["sql"]["query"];
										$sql = $this->templates->blocks["Temp"]->Replace($form_sql_vars);

										//do a precheck for [] elements to be replaced with <>
										$sql = str_replace("]" , ">" , str_replace("[" , "<" , $sql));

										$record = $this->db->QFetchArray($sql);								

										$items[$key][$k] = $record[$v["sql"]["field"]] ? $record[$v["sql"]["field"]] : "N/A";
										$items[$key][$k] = $record[$v["sql"]["field"]] ? $record[$v["sql"]["field"]] : (isset($v["empty_msg"]) ? $v["empty_msg"] : "N/A");
									}							
								} else
									$items[$key][$k] = isset($v["empty_msg"]) ? $v["empty_msg"] : "N/A";
							break;

							case "button":
								//check to see if this button isnt a protected one

								//fix the url transformations from the buttons
								$v["nolink"] = "true";

								if ($v["protected"] && $items[$key][$v["protected"]]) {
									$items[$key][$k] = "&nbsp;";
								} else {
									
									//replace the location and the button in the template
									$tmp = $v;
									//chec for variables which might not be defined
									$tmp["onmouseout"] = $tmp["onmouseout"] ? $tmp["onmouseout"] : "";
									$tmp["onmouseover"] = $tmp["onmouseover"] ? $tmp["onmouseover"] : "";
									$tmp["onclick"] = $tmp["onclick"] ? $tmp["onclick"] : "";
									$tmp["title"] = $tmp["title"] ? $tmp["title"] : "";
									$tmp["target"] = $tmp["target"] ? $tmp["target"] : "";
									$button = new CTemplate($template->blocks["Button"]->Replace($tmp),"string");
									$button->input = $button->Replace($global_vars);
									$items[$key][$k] = $button->Replace($items[$key]);
								}
							break;

							case "multiple":
								$items[$key]["original_" . $k] = $items[$key][$k];
								// a control variable to know to add the data to end
								$found_multiple = true;	
								
								$_tmp_data = array();

								if ($v["checked"]) {

									if ($v["checked"] == "exact") {
										$_tmp_data["value"] = $v["value"];

										if ($items[$key][$v["field"]] == $v["value"])
											$_tmp_data["checked"] = "checked";
										else
											$_tmp_data["checked"] = "";

									} else {									
										$_tmp_data["value"] = $items[$key][$v["value"]];

										if ($items[$key][$v["field"]])
											$_tmp_data["checked"] = "checked";
										else
											$_tmp_data["checked"] = "";																			
									}
								} else {
									$_tmp_data["value"] = $items[$key][$v["value"]];
								}

								$items[$key][$k] = $template->blocks["SimpleListMultiple"]->Replace(array(
														"value" => $_tmp_data["value"],
														"checked" => $_tmp_data["checked"],
														"field" => $v["field"] , 
														"subfield" => $items[$key][$v["subfield"]],
														"name" => $v["field"],
														"_count" => $items[$key]["original_count"]
													));
							break;

							case "field":
								$items[$key]["original_" . $k] = $items[$key][$k];

								$items[$key][$k] = $template->blocks["SimpleListFieldInput"]->Replace(array(
														"value" => $items[$key][$v["field-value"]] , 
														"field" => $v["field-id"] , 
														"_count" => $items[$key]["original_count"],
														"size" => $v["field-size"],
														"align" => $v["field-align"] ? "align=\"{$v['field-align']}\"" : "",
														"id" => $items[$key][$v["field-id"]],
														"field-type" => $v["field-type"],	
														"field-sub" => $v["field-sub"] ? "[" . $v["field-sub"] . "]" : ""
													));
								
							break;

							case "eval":
								eval("\$items[\"\$key\"][\"\$k\"] = " . $v["value"]);							
							break;

							default:

								//if ($v["html"] != "true") 
									//$items[$key][$k] = htmlentities($items[$key][$k]);

								$items[$key][$k] = $items[$key][$k] ? $items[$key][$k] : ($v["default"] ? $v["default"] : "&nbsp;");
								
							break;
						}							

//!!!!!!!!!!!!!!!!!!!!!!						//
// might be a gix but as well may fuck everithing
						$items[$key][$k] = str_replace("&amp;","&",$items[$key][$k]);

						if ($v["maxchars"]) {
							$items[$key][$k] = substr($items[$key][$k],0,$v["maxchars"]) . (strlen($items[$key][$k]) > $v["maxchars"] ? ($v["maxchars_text"] ? $v["maxchars_text"] : $this->__default["list"]["fields"]["maxchars_text"]) : "");
						}
						

						//check for protection
						if ($v["protected"] && $items[$key][$v["protected"]]) {
							$items[$key][$k] = "&nbsp;";
						}					

						if (($v["html"] != "true") && !$v["link"]) {

//added the bbcode		
							if ($v["bbcode"] == "true") {
								$items[$key][$k] = CBBCode::Convert($items[$key][$k],"");							
							} else {
								if ($v["nolink"] != "true") {
									$items[$key][$k] = eregi_replace("([_a-z0-9\-\.]+)@([a-z0-9\-\.]+)\." . "(net|com|gov|mil|org|edu|int|biz|asia|info|name|pro|[A-Z]{2})". "($|[^a-z]{1})", "<a title=\"Click to open the mail client.\" href=\"mailto:\\1@\\2.\\3\">\\1@\\2.\\3</a>\\4", $items[$key][$k]);
									$items[$key][$k] = eregi_replace("(http|https|ftp)://([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)","<a href=\"\\1://\\2\" title=\"Click to open in new window.\" target=\"_blank\">\\2</a>", $items[$key][$k]);
								}
							}
						}

						$items[$key][$k] = $v["preffix"] . ( strtoupper($v["allownl"]) == "TRUE" ? nl2br($items[$key][$k]) : $items[$key][$k] ). $v["suffix"];

						//check to see if there is a tag set called link
						if ($v["link"]) {
							//okay, this field must be a link
							$tmp = new CTemplate( $this->templates->blocks["ListLink"]->Replace(array(
										"link" => $v["link"],
										"title" => $items[$key][$k]
									)) , "string");
							$tmp->input = $tmp->Replace($global_vars);

							//backup the original 
							if (!$items[$key]["original_" . $k])
								$items[$key]["original_" . $k] = $items[$key][$k];
							
							$items[$key][$k] = $tmp->Replace($items[$key]);
						
						
						}
						
						if ($v["nobr"] == "true") {
							$items[$key][$k] = "<nobr>" . $items[$key][$k] . "</nobr>";
						}					

						//format the font style apearing in the column
						// can be b,u,i meaning <b></b> , etc
						
						if ($v["font"]) {
							//bread the font selements
							$__fonts = @explode("," , $v["font"]);
							if (is_array($__fonts)) {
								$font__pre = "";
								$font__after = "";

								foreach ($__fonts as $__font) {
									$font__pre = $font__pre . "<$__font>";
									$font__after = "</$__font>" . $font__pre;
								}
								
								$items[$key][$k] = $font__pre . $items[$key][$k] . $font__after;
							}							
						}

						//format the color of the font for the text from the column, 
						//allows font color and background speared w/ :, can be only one too.
						if ($v["color"]) {
							$colors = @explode(":" , $v["color"]);
							if (count($colors) == 1)
								$style = "color: {$colors[0]}";
							else
								$style = "color: {$colors[0]};backgrond: {$colors[1]}";

							//add a span w/ color info
							$items[$key][$k] = "<span style=\"{$style}\">" . $items[$key][$k] . "</span>";							
						}												
						
					}
				}				

				//adding the fucking buttons
				if (is_array($form["buttons"])) {
					foreach ($form["buttons"] as $key2 => $val2) {

						if ($key2 != "set") {

							if ($val2["protected"] && $items[$key][$val2["protected"]]) {
							} else {

								//do a replace with the values from the item
								$this->templates->blocks["Temp"]->input = $val2["location"];						
								$this->templates->blocks["Temp"]->input = $this->templates->blocks["Temp"]->Replace($global_vars);
								$val2["location"] = $this->ProcessLinks($this->templates->blocks["Temp"]->Replace(array_merge($items[$key],$global_vars)));

								//do an extra replacement for space with %20
								$val2["location"] = str_replace(" ","%20" , $val2["location"]);
								$val2["title"] = $val2["title"];
								$val2["onmouseout"] = $val2["onmouseout"];
								$val2["onmouseover"] = $val2["onmouseover"];
								$val2["onclick"] = $val2["onclick"];
								$val2["target"] = $val2["target"];

								$items[$key]["buttons"] .=
										($form["buttons"]["set"]["buttonsvert"] == "true" ? "<tr><td height=3></td></tr><tr>" : "" ). 
										$template->blocks["Button"]->Replace($val2) . 
										($form["buttons"]["set"]["buttonsvert"] == "true" ? "</tr>" : "" );
							}
						}
					}
					
					//do a check for the cases when all buttons were protected
					if ( $items[$key]["buttons"] == "") {
						$items[$key]["buttons"] = "&nbsp;";
					}
					
				} else {
					$items[$key]["buttons"] = "";
				}

			//add the alternance field here
			if ($form["alternance"] == "true") {
				$items[$key]["_alternance"] = $this->_tmpAlternance ? "Alt" : "";
				$this->_tmpAlternance = $this->_tmpAlternance ? 0 : 1;
			} else
				$items[$key]["_alternance"] = "";

			}			
		}
		

		return $items;
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
	function SimpleList($form , $items = "", $count = "", $extra = null , $search = false , $returnArray  = false) {
		global 
			$_CONF , 			
			$form_errors , 
			$_USER , 
			$form_countries, 
			$form_months,
			$form_US_states,
			$form_RO_states,
			$form_CA_states;


		if (is_array($form["order"]) && ($form["order"]["drag"] == "true") && !$this->__isRestricted($form["order"]["restricted"])) {
			$form["fields"]["button_reorder"] = array(
				"type"		=> "button",
				"width"		=> "20",
				"align"		=> "center",
				"button"	=> $form["order"]["button"] ? $form["order"]["button"]  : "reorder",
				"location"	=> "javascript:void(0);"
			);
		} else {
			if (is_array($form["order"])) {
				unset($form["order"]);
			}
			
		}


		//add the extra button if order exists

		if (is_array($form["vars"])) {
			foreach ($form["vars"] as $key => $val) {
				//echeking if the default must be evaluated
				if ($val["action"] == "eval") {
					eval("\$val[\"import\"] = " . $val["default"] .";");
				}

				switch ($val["type"]) {
					case "eval":
						eval("\$tpl_vars[\"$key\"] = " . $val["import"] . ";");
					break;
					case "complex_eval":
						eval($val["import"]);
					break;

					case "var":
						$tpl_vars[$key] = $val["import"];
					break;
				}													
			}
		}
		//$tpl_vars = array_merge($tpl_vars);
		$global_vars = $this->GlobalVars($form);

		$records = $this->__simple_list_load_records($form);

		$items = $records["items"];
		$count = $records["count"];
		$has_paging = $records["count"] > count($records["items"]);
		

		if ($returnArray == true) {
			return array(
						"items" => $items,
						"count" => $count
						);
		}

		//check if ordering field is acctivated disable the reordering
		if (is_array($form["order"])) {
			$form["header"]["nolinks"] = "true";
		}
		

		$_new_count = $start;

		$html = new CHtml();

		$form = $this->Process($form);

		$template = &$this->templates;

		//this sux, building the template
		if (is_array($form["fields"])) {

			//prepare the fields list
			if ($form["sql"]["vars"]["fields"] != "")
				$__fields = explode("," , $form["sql"]["vars"]["fields"]);
			else {
				//read the fields from the table
				if (is_array($__tables)  && is_object($this->db)) {
					$__fields = array();
					foreach ($__tables as $_k => $_v) {
						$__fields = array_merge((array)$__fields , (array)$this->db->GetTableFields($sql_vars[$_v]));
					}					
				}
			}

			$tmp_count = 0;
			foreach ($form["fields"] as $key => $val) {
				if (!($val["restricted"] && $this->__isRestricted($val["restricted"]))) {

					$tmp_count ++;

					$cell = array (
									"width" => $val["width"],
									"align" => $val["align"],
									"value" => "{" . strtoupper($key) . "}",
									"valign" => $val["valign"] ? $val["valign"] : "middle",
									"final" => !is_array($form["buttons"]) && ($tmp_count == count($form["fields"])) ? "Final" : "",
									"first" => $tmp_count == 1 ? "First" : "",
								);

					//add the alternance field here
					if ($form["valternance"] == "true") {
						$cell["_valternance"] = $this->_tmpVAlternance ? "2" : "";
						$this->_tmpVAlternance = $this->_tmpVAlternance ? 0 : 1;
					} else
						$cell["_valternance"]  = "";

					$data .= $template->blocks["ListCell"]->Replace (
								$cell
							  );

					if ($val["type"] == "multiple")
						$val["header"] = $template->blocks["SimpleListMultipleHeader"]->Replace(array(
											"name" => $val["field"],
											"start" => $_old_count,
											"end" => $_new_count
										));
					
					//prepare the title
					$__title = ($val["header"] ?  $val["header"]  : "<img width=0 height=1 border=0/>");

					if ($sql_vars["order"] == $key)
						$__sorting_mode = $_GET["order_mode"] == "ASC" ? "DESC" : "ASC";				
					else
						$__sorting_mode = "ASC";								


					//check if this forms allows the title to be sortable
					if ($form["header"]["nolinks"] == "true") {
						//unclickable link
						$__template = "ListTitle";
					} else {
						//if this field appears in the list of table firles show title with link
						if (is_array($__fields) && in_array($key , $__fields))
							$__template = "ListTitleLink";
						else
							//no link title
							$__template = "ListTitle";
					}

					
					$__tmp_title = array(
								"title" => $__title,
								"width" => $val["width"] ? " width=\"{$val[width]}\" " : "",
								"final" => !is_array($form["buttons"]) && ($tmp_count == count($form["fields"])) ? "Final" : "",
								"first" => $tmp_count == 1 ? "First" : "",
								"link" => CSYS::_GetVar(
												array( 
													"order" => $key , 
													"order_mode"=> $__sorting_mode
													)
											),
								"order" => $sql_vars["order"] == $key ? 
												$template->blocks["ListTitleLinkOrder"]->Replace(
													array(
														"order" => strtolower($__sorting_mode)
													)
												) : ""
							);

					if ($form["valternance"] == "true") {
						$__tmp_title["_valternance"] = $this->_tmpVAlternanceHeader ? "2" : "";
						$this->_tmpVAlternanceHeader = $this->_tmpVAlternanceHeader ? 0 : 1;
					} else
						$__tmp_title["_valternance"]  = "";

					
					//buildint the title header
					$titles .= $template->blocks[$__template]->Replace ( $__tmp_title );

				}
				
			}



			//adding one more title col in titles ( the one for buttons )
			if (is_array($form["buttons"])) {

# DEPRECATED
				$titles .= $template->blocks["ListTitle"]->Replace ( array(
									"title" => "&nbsp" , 
									"final" => "Final" , 
									"width" => $val["width"] ? " width=\"{$val[width]}\" " : ""
							));
				$row = $data . $template->blocks["ButtonsCell"]->output;
			} else
				$row = $data;
			
			//debug($form);

			$template->blocks["ListElement"]->input = $template->blocks["ListRow"]->Replace(array(
					"ROW"			=> $row,
					"class"			=> "FormSimpleListRow",
					"order_id"		=> is_array($order),
					"order_value"	=> "table_order_{" . strtoupper($form["table_uid"]) . "}"

			));			


			$titles = $template->blocks["ListRow"]->Replace(array(
					"ROW"			=> $titles ,
					"CLASS"			=> "FormSimpleListTitle",
					"order_value"	=> "",
				));

			//fuck i know this is stupid, but now i dont have other idees
			//if i see a variable <no heade> then i clear the template
			if ($form["header"]["titles"] == "false") {
				$titles = "";
			}
			
		}
		
		//bulding the header buttons and search box
		if (is_array($form["header"]["buttons"])) {
			foreach ($form["header"]["buttons"] as $key => $val) {

				if (!($val["restricted"] && $this->__isRestricted($val["restricted"]))) {

					$val = array_merge($_GET , $val);

					$this->templates->blocks["Temp"]->input = $val["location"];
					$val["location"] = $this->templates->blocks["Temp"]->Replace($val);
					$val["location"] = CryptLink($val["location"]);
					$val["title"] = $val["title"];
					$val["onmouseout"] = $val["onmouseout"];
					$val["onmouseover"] = $val["onmouseover"];
					$val["onclick"] = $val["onclick"];
					$val["target"] = $val["target"];
					$header["buttons"] .= $template->blocks["Button"]->Replace($val);
				}
			}					
		}

		//fuck the search options, this is kinda buggy for this version, will be fixed in other
		if (is_array($form["header"]["search"])) {
			$form_search = $form["header"]["search"];

			//bulding the droplist options
			if (is_array($form_search["options"])) {

				foreach ($form_search["options"] as $key => $val) {
					$search_form[$key]["label"] = $val;
					$search_form[$key]["checked"] = $_GET[$form_search["variable"]] == $key ? " selected " : "";
					$search_form[$key]["tag"] = is_array($val) && $val["type"] == "group" ? "optgroup" : "option";
				}
				
				
				$search["droplist"] = $html->FormSelect(
											"what" , 
											$search_form ,
											$template,
											"Select" ,
											$_GET["what"],
											$search_form ,
											array(	
												"width" => "" ,
												"onchange" => ""
											)
									);				

				//building the form and the buttons
				//reading all varibals from $_GET excepting the $_GET["page"], and transform them in hidden fields
				if (is_array($_GET)) {
					$temp = $_GET;

					//force the action variable
					$temp[$this->forms["uridata"]["action"]] = $this->forms["uridata"]["search"];

					foreach ($temp as $key => $val) {
						if (!in_array($key , array( "page" , "what" , "search")))  {
							
							$search["fields"] .= $template->blocks["SearchField"]->Replace(array("name" => $key , "value" => $val));
						}						
					}					
				}

				//preparing the action, post the requests to the same file as curernt
				$search["action"] = $_SERVER["PHP_SELF"];
				$search["value"] = $_GET["search"];

				$header["search"] = $template->blocks["SearchForm"]->Replace($search);				
			}
		}

		//building the template
		if (is_array($form["header"])) {
			if (($form["collapse"]["automatic"] == "true")&&($form["border"] == "true")) {
				unset($form["collapse"]);
			}			
					
			if (is_array($form["collapse"]) && is_object($this->templates->blocks["ListCollapse"])) {
				$header["collapse"] = $this->templates->blocks["ListCollapse"]->Replace($form["collapse"]);
			} else
				$header["collapse"] = "";
			
			//cleanup the variables
			$header["buttons"] = $header["buttons"] ? $header["buttons"] : "";
			$header["search"] = $header["search"] ? $header["search"] : "";
			$header["subtitle"] = $form["subtitle"];

			//prepare the 
			$header = $template->blocks["ListHeader"]->Replace($header);

		} else
			$header = "";


		//process the paging here, i need the url for the ajax part
		if (is_array($_GET)) {
			foreach ($_GET as $key => $val) {
				if ($key != "page") {

					//check if the data from get isnt a complex array too.
					if (is_array($val)) {
						foreach ($val as $k => $v)
							$url[] = $key . "[$k]" . "=" . $v;
					} else {					
						if ($key == "returnurl") {
							$url[] = $key . "=" . urlencode($val);
						} else {					
							$url[] = $key . "=" . $val;
						}
					}
				}
			}
			
			$url = $_SERVER["SCRIPT_NAME"] . "?" . @implode("&" , $url) . "&";
		}


		
		$ajax_read_more_link = $url . "ajax=true&";
		
		$template->blocks["ListGroup"]->input = $template->blocks["ListGroup"]->Replace(array(
			"_HEADER" => $header , 
			"_TITLES" => $titles ,
			//adding the extra html
			"_HTML_PRE" => (is_array($form["html"]["pre"]) && ($form["html"]["pre"]["type"] == "extern")) ? GetFileContents(dirname($form["xmlfile"]) . "/" . $form["html"]["pre"]["file"]) : html_entity_decode($form["html"]["pre"]),
			"_HTML_MIDDLE" => (is_array($form["html"]["middle"]) && ($form["html"]["middle"]["type"] == "extern")) ? GetFileContents(dirname($form["xmlfile"]) . "/" . $form["html"]["middle"]["file"]) : html_entity_decode($form["html"]["middle"]),
			"_PRE_TABS" => $this->DrawTabs($form["tabs"]),

			"_HTML_AFTER" => (is_array($form["html"]["after"]) && ($form["html"]["after"]["type"] == "extern")) ? GetFileContents(dirname($form["xmlfile"]) . "/" . $form["html"]["after"]["file"]) : html_entity_decode($form["html"]["after"]),

			"PRE" => $extra["pre"],
			"AFTER" => $extra["after"],

			"COLLAPSE_ID" => $form["collapse"]["id"],
			"COLLAPSE_INIT" => is_array($form["collapse"]) && is_object($this->templates->blocks["ListCollapseInit"]) ? $this->templates->blocks["ListCollapseInit"]->Replace($form["collapse"]) : "",

			//add the id who activates the drag and drop field
			"order_id"	=> is_array($form["order"]) ? "OXBFormSort" : "",


			"more_records"	=> is_array($form["order"]) && $has_paging ? $this->templates->blocks["ListMoreRecords"]->Replace(
				array(
					"cols_count"	=> count($form["fields"]),
					"ajax_link"		=> $ajax_read_more_link
				)

			): "",


			//do the colspan nicely 
			"cols_count"	=> count($form["fields"]),

		));
/*
		} else {
			//cleanup the vars
			$form["_HEADER"] = "";
			$form["_TITLES"] = "";
			$form["_HTML_PRE"] = "";
			$form["_HTML_AFTER"] = "";
			$form["pre"] = $form["after"] = "";
			$form["_pre_tabs"] = $this->DrawTabs($form["tabs"]);

		}
*/
		//prereplace the vars main template
		$template->blocks["ListGroup"]->input = $template->blocks["ListGroup"]->Replace($form);

//! TEST
		if (is_array($global_vars)) {
			$template->blocks["ListElement"]->input = $template->blocks["ListElement"]->Replace($global_vars);
			$template->blocks["Button"]->input = $template->blocks["Button"]->Replace($global_vars);
		}		

//! E:TEST
		//prereplace the pagination template

		$template->blocks["Page"]->input = $template->blocks["Page"]->Replace(array("BASE" => $url));
		
		$_GET["page"] = ($_GET["page"] ? $_GET["page"] : "1");

		$items = $this->__simple_list_process_items($form , $items);
		
		if ($form["items"]) {

			$return = CTemplateStatic::Replace(
				$html->Table( $template , "List" , $items),
				array(
					"paging" => CHTML::CustomPaging(
						$template , 
						"Paging",
						10 , 
						ceil($count / $form["items"]) , 
						$_GET["page"] , 
						$url . "&page={PAGE}"
					),
				)
			);

		} else {
			$return = $html->Table( $template , "List" , $items );			
		}

		//crap, append some extra elements to this form, in case, fuck, i dont know how to handle if there will be 2 pagging functions.

		if (is_array($this->functions["list"]["after"]))
			call_user_func($this->functions["list"]["after"],&$append);

		//clearing the extra value
		if (!$append) {
			$append = "";
		}
		
		//adding the border

		//doing a small trick before adding the border
		if ($form["border"] != "true") {
			//overwrite the border template with the content one
			$border = new CTemplate($return , "string");
		} else {
			$border = &$this->templates->blocks["Border"];
		}
		
		$return = $border->Replace( 
					array(
						"_TEMPLATE_DATA" => $return , 
						"WIDTH" => $form["width"], 
						"TITLE" => $form["title"] , 
						"EXTRA" => $append
					));
		
		$this->templates->blocks["Temp"]->input = $return;

		// do a check for the cases when is required a form
		if ($form["formtag"] == "true") {

			$form["id"] = $form["id"] ? " id=\"" . $form["id"] . "\" " : "";
			$form["encoding"] = $form["encoding"] ? $form["encoding"] : "";
			$form["method"] = $form["method"] ? $form["method"] : "post";
			$form["_template_data"] = $this->templates->blocks["Temp"]->input;
			$this->templates->blocks["Temp"]->input = $this->templates->blocks["Action"]->Replace( $form );
		}

		//debug($global_vars);

		return $this->__render($this->templates->blocks["Temp"]->input , array_merge((array)$global_vars,(array)$tpl_vars));
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
	function InsertField( $params ) {
		//for the momment it dont support complex fields like referers, and multiple

		//preparing the input vars
		$form["fields"]["temp"] = $params;
		$values["values"][$params["name"]] = $params["value"] ;

		//draw the element
		return $this->DrawElement ( $form , "temp" , $values ); 
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
	function DrawElement( $form , $_field , $values , $draw_referer = 0 ) {

		global $_SESS , 
				$_CONF,
				$form_RO_states,
				$form_US_states,
				$form_CA_states,
				$form_countries , 
				$form_timezones , 
			
				$_VARS , 
				$_USER , 
				$base , 
				$_TSM , 
				$_SESS , 
				$form_months;



		$field = $form["fields"][$_field];
		
		$field["_end_char"] = $field["title"] ? ":" : "";



		//add a special type
		if ($field["type"] == "after_save") {
			$form["fields"][$_field] = $field = array(	
						"type" => "droplist",
						"name" => "after_save",
						"default" => "\$_GET[after_save];",
						"action" => "eval",
						"title" =>  "After save",
						"options" => array(
											"0" => "return to previous page",
											"1" => "add a new record"
										)													
					);
		}
		



		//doing a precheck in case there are referers or multiples to elements which arent in xml
		if (!is_array($field))
			return "";		

		if (!$field["type"]) {
			return "";
		}

		if (is_string($field["default"])) {			
			if ((substr($field["default"],0,5) == "eval:")) {
				$field["action"] = "eval";
				$field["default"] = substr($field["default"],5);
			}
		}
		
		
		
		
		//a temporary solution for name loosing
		$field["name"] = $_field;

		if (!isset($values["values"][$field["name"]])) {		
			switch ($field["action"]) {
				case "eval":
					if (isset($field["default"]))
						eval("\$field[\"value\"] = " . $field["default"] . ";");
				break;

				case "complex_eval":
					if (isset($field["default"]))
						eval($field["default"]);
				break;

				case "value":
					$field["value"] = $values["values"][$field["default"]];
				break;

				default:
					$field["value"]	= $field["default"];
				break;
			}
		} else {
			
			$field["value"] = $values["values"][$field["name"]];
		}

		//somtimes i may want to force a specific value nomatter of what is already set
		if (isset($field["forcevalue"])) {
			switch ($field["action"]) {
				case "eval":
//					echo $field["forcevalue"];
					eval("\$field[\"value\"] = " . $field["forcevalue"] . ";");
				break;

				default:
					$field["value"] = $field["forcevalue"];
				break;
			}

		}
		

//!!!!!!!!!!!!!!!!!!!!!!						//
// might be a gix but as well may fuck everithing
//			$field["value"] = "test";str_replace("&amp;","&",$field["value"]);


		//load data from external files
		if ((($field["type"] != "image")&&($field["type"] != "upload")) && is_array($field["file"]) && !($values["values"][$field["name"]]) && file_exists($_CONF["path"] . $_CONF["upload"] . $field["file"]["path"] . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"])) {
			$field["value"] = GetFileContents($_CONF["path"] . $_CONF["upload"] . $field["file"]["path"] . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"]);
		}		

		//prepare the description for fields
		if (is_array($field["description"])) {
			switch ($field["description"]["type"]) {
				case "file":
					$_description = GetFileContents(dirname($form["xmlfile"]) . "/" . $field["description"]["file"]);
					if ($field["description"]["html"] != "true") {
						$_description = htmlspecialchars($_description);
					}
					
				break;
			}

			$field["description"] = $_description;			
		} else {
			if (isset($field["description"]))		
				$field["description"] = nl2br((str_replace("]" , ">" , str_replace("[" , "<" , $field["description"]))));
		}
		

		//strip the slashes from the value
//		$field["value"] = stripslashes($field["value"]);
			
		//checking if this file is a referer, and if i have to show the referers at this point
		if (! $draw_referer && (($field["referer"]) || ($field["multiple"] == "true")))
			return "";

		//parse the field for special events, onkeyup, down etc...
		$this->__private__handlers(&$field);

		//parse the fields form editable=false
		if ($field["editable"] == "false") {
			switch ($field["type"]) {
				case "textbox":
				case "textarea":					
					$field["type"] = "text";
					$field["required"] = $field["unique"] = $field["validate"];
					unset($field["description"]);
				break;
			}
		}
		

		//drawing the form elements
		switch ($field["type"]) {

			case "checkIMG"	:
				$field["required"] = "true";
				$field["validate"] = "A:8:8";
				$current_field = $this->templates->blocks["imgCheck"]->Replace($field);				
			break;

			case "phone":
				$current_field = $this->__field__phone( &$field , &$values ) ;
			break;

			case "textarea":
				$current_field = $this->__field__textarea(&$field , &$values );				
			break;

			case "file":				
				$current_field = $this->__field__file(&$field , &$values);				
			break;

			case "colorpicker":
			case "password":
			case "textbox":
				$current_field = $this->__field__textbox(&$field , &$values);				
			break;

			case "sql":
				$this->__field__sql(&$field , &$values );
			case "text":

//				$field["value"] = $field["html"] == "true" ? $field["value"] : nl2br(htmlentities($field["value"]));
				$current_field = $this->__field__text(&$field , &$values);
			break;

			case "hidden":
				$current_field = $this->__field__hidden(&$field , &$values );

				$current_field_extra = "";
			break;

			case "button":			
				$current_field = $this->__field__button(&$field , &$values);
			break;

			case "checkbox":			
				$current_field = $this->__field__checkbox(&$field , &$values);
			break;

			case "radiolist":
			case "radio":
				$field["radio"] = "true";		
				$field["type"] = "radio";

				if (!isset($field["empty_text"]))
					$field["empty_text"] = $this->__default["show"]["radio"]["empty_text" . ($field["editable"] == "false" ? "_show" : "")];							

			
			case "checklist":
				if ($field["type"] == "checklist") {
					$field["checkbox"] = "true";
					$field["radio"] = "";
					$field["empty"] = "";
					$field["multi"] = "true";
				}
				
			case "relation":
				if ($field["type"] == "relation")
					$field["editable"] = "false";

			case "double":			
			case "doubleselect":			
				if ( ($field["type"] == "doubleselect") || ($field["type"] == "double")) {
					$field["double"] = "true";
					$field["multi"] = "true";
				}
			case "USstates":								
			case "usstates":								
			case "droplist":				
			case "countries":
			case "CAstates":
			case "castates":
			case "ROstates":			
			case "timezone":			
			case "timezones":			
			case "rostates":						
				$current_field = $this->__field__droplist(&$field , &$values );
			break;

			case "upload":
			case "image":
				switch (_FORMS_SETTINGS_FIELD_IMAGE_UPLOAD) {
					case "html":
						$current_field = $this->__field__image_html(&$field , &$values );
					break;

					case "flash":
						$current_field = $this->__field__image(&$field , &$values );
					break;					
				}
								
				
			break;

			case "comment":
				$current_field = $this->__field__comment(&$field , &$values , $form);
			break;

			case "date":
				$current_field = $this->__field__date(&$field , &$values );
			break;

			case "multiple":
				//cheking for multiple ellements
				
				if (is_array($field["multiple"])) {
					foreach ($field["multiple"] as $key => $val) {
						$current_field .= $this->DrawElement($form , $key , $values , 1);
					}					
				}
			break;


			case "ccard":				
			case "creditcard":
				$current_field = $this->__field__creditcard(&$field , &$values);							
			break;

			case "namesort":
				$current_field = $this->__field__namesort(&$field , &$values );							
			break;

			case "calendar":
				$current_field = $this->__field__calendar(&$field , &$values);
			break;


		}

		//if the field hs description then i add the valign code
		$current_field_extra = $field["valign"] && !$field["hidden"]? $this->templates->blocks["TopAlign"]->output : ""; 


		//add the link if exists
		if ($field["link"]) {

			$tmp_tpl = new Ctemplate( '<a href="' . $field["link"] . '">'  . $current_field . '</a>'  , "string");
			$current_field = $tmp_tpl->Replace($values["values"]);
		}
				

		if ($field["hidden"] != "true") {

			if (is_array($field["help"])) {

				$element["_helptopic"] = $this->templates->blocks["ElementHelpTopic"]->Replace(array(
						"location" => ($field["help"]["location"] == "module" ? dirname($form["xmlfile"]) . "/" : "") . $field["help"]["file"]
					));
			} else 
				$element["_helptopic"] = "";
			
			//checking if this element isnt a referer
			if (!isset($field["referer"])) {

				//building the element structure ( title, description, etc )				
				$element["title"] = $field["title"];
				//add the id used for javascript thingx
				$element["name"] = str_replace("[]" , "" , $field["name"]);

				$element["_end_char"] = $field["title"] ? ":" : "";
				$element["align"] = $field["align"] ? $field["align"] : "left";
				
				//replacing ]n with <br> in descriptions
				$field["description"] = $field["description"];
				$element["_description"] = $field["description"] ? $this->templates->blocks["Description"]->Replace($field) : "";
				$element["_description_rowspan"] = $field["description"] ? $this->templates->blocks["DescriptionRowspan"]->output : "";
				
				$element["_element"] = $current_field;

				//cheking if this element has referers

				if (!is_array($field["referers"]) && isset($field["referers"])) {
					$tmp = explode("," , $field["referers"]);
					if (is_array($tmp)) {
						$field["referers"] = array();
						foreach ($tmp as $_tmp => $referer) {
							$field["referers"][$referer] = "true";
							//alter the form too
							$form["fields"][$field["name"]]["referers"][$referer] = "true";							
						}						
					}					
				}
				
				
				if (is_array($field["referers"])) {
					$_cnt = 0;
					foreach ($field["referers"] as $key => $val) {

						//also alter the fields which are used as referers
						if (is_array($form["fields"][$key])) {
							$form["fields"][$key]["referer"] = $field["name"];
						}

						$element["_element"] .= ($_cnt == 0 ? "" : '<td width="5"><img width=5 height=0></td>') . '<td>' . $this->DrawElement($form , $key , $values , 1) . "</td>";
						$_cnt ++;
					}

					$element["_element"] = '<table cellspacing="0" cellpadding="0"><tr><td>' . $element["_element"] . "</tr></table>";
				}

				//adding the preffix and suffix
				$element["_suffix"] = $field["suffix"];
				$element["_preffix"] = $field["preffix"];
								
				$element["_extra"] = $current_field_extra;
				$element["_extra_code"] = $field["_extra_code"];

				$element["_required"] = $field["required"] == "true" ? trim($this->templates->blocks["RequiredMark"]->output) : "";
				$element["_required_error"] = $values["errors"][str_replace("[]" , "" , $field["name"])] ? trim($this->templates->blocks["Required"]->output) : "";




				
				//alternante style for each element
				if ($form["alternance"] == "true") {
					$this->_tmpAlternance = $this->_tmpAlternance ? 0 : 1;
					$element["_alternance"] = $this->_tmpAlternance ? "Alt" : "";
				} else 
					$element["_alternance"] = "";

				//do a check and reverse the alternance
				if (($form["alternance_comment"]=="false") && ($field["type"] == "comment")) {
					$this->_tmpAlternance = $this->_tmpAlternance ? 0 : 1;
					$element["_alternance"] = $this->_tmpAlternance ? "Alt" : "";
				}


				if (($field["multiple"] == "true") && $draw_referer ){
						return $this->templates->blocks["ElementMultipleBody"]->Replace($element);
				}

				if ($field["type"] == "multiple") {
					if ($form["alternance"] == "true") {
						$this->_tmpAlternance = $this->_tmpAlternance ? 0 : 1;
						$vars["_alternance"] = $this->templates->blocks["Alternance" . $this->_tmpAlternance]->output;

						$this->templates->blocks["Temp"]->input = $this->templates->blocks["ElementMultiple"]->Replace($element);
						return $this->templates->blocks["Temp"]->Replace($vars);
					} else					
						return $this->templates->blocks["ElementMultiple"]->Replace($element);
				}

							

				if ($field["extend"] != "true") {


						switch ($field["type"]) {
							case "subtitle":
								return $this->templates->blocks["Subtitle"]->Replace($element);
							break;

							case "comment":
								return $current_field;
							break;

							default:
								return $this->templates->blocks["Element"]->Replace($element);
							break;
						}
				} else {
					//change since version 0.7,
					//added the title block separed then the main one

					if (is_object($this->templates->blocks["ExtendElementTitle"])) {
						if ($element["title"])
							$element["element_title"] = $this->templates->blocks["ExtendElementTitle"]->Replace($element);
						else
							$element["element_title"] = "";
					} else {
						$element["element_title"] = "";
					}
					

					return $this->templates->blocks["ExtendElement"]->Replace($element);
				}
			} else {
				//adding the preffix and suffix
				$element["_suffix"] = $field["suffix"];
				$element["_preffix"] = $field["preffix"];
				$element["_element"] = $current_field;
	
				//if the element is only a referer return only the form
				return $draw_referer ? $this->templates->blocks["ElementReferer"]->Replace($element): "";
			}

		} else {
			return $current_field;
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
	function DrawTabsRow($tabs , $first = 0) {
		global $base;
		if (is_array($tabs)) {


			$count = 1;
			$active = false;

			//restriction checker
			foreach ($tabs as $key => $val) {
				if ($val["restricted"] && $this->__isRestricted($val["restricted"])) {
					//remove the tab
					unset($tabs[$key]);
				}
			}

			foreach ($tabs as $key => $val) {
				if ($active == true) {
					$active = false;
					$tabs[$key]["afteractive"] = "true";
				} else
					$tabs[$key]["afteractive"] = "false";

				$tabs[$key]["last"] = ($count == count($tabs) ? "true" : "false");
				$tabs[$key]["active"] = $val["active"] == "true" ? "true" : "false";
				$tabs[$key]["width"] = $val["width"] ? $val["width"] : "50";
				$tabs[$key]["icon"] = $val["icon"];
				$tabs[$key]["onmouseover"] = $val["onmouseover"];
				$tabs[$key]["onmouseout"] = $val["onmouseout"];
				$tabs[$key]["id"] = $key;
				$tabs[$key]["link"] = $val["link"];
				$tabs[$key]["firstrow"] = $first == 0 ? "true" : "false";

				if ($val["active"] == "true")
					$active = true;			

				$count ++;
			}			
			return $base->html->Table($this->templates,"Tabs",$tabs);
		} else
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
	function DrawTabs($tabs) {
		global $base;
		if (is_array($tabs)) {
			if (is_array($tabs["groups"])) {
				$count = 0;
				foreach ($tabs["groups"] as $key => $val) {
					$return .= $this->DrawTabsRow($val , $count);			
					$count ++;
				}				

				return $return;
			} else 
				return $this->DrawTabsRow($tabs);		
		} else
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
	function Show($form = array(), $values = array()  , $extra = array()) {
		global $_CONF , $_USER, $_SESS, $form_errors;

		if (is_array($form))
			$form = $this->Process($form);
		else 
			$form = $this->form;
		
		//values structure
		/*
			<values>
				<error>Field already exists</error>

				<fields>
					<name>jon doe</name>
					<address>eartch </earth>
					...

				</fields>
			</values>
		*/

		if (is_array($form["vars"])) {
			foreach ($form["vars"] as $key => $val) {
				//echeking if the default must be evaluated
				if ($val["action"] == "eval") {
					eval("\$val[\"import\"] = " . $val["default"] .";");
				}
				
				switch ($val["type"]) {
					case "eval":
						eval("\$tpl_vars[\"$key\"] = " . $val["import"] . ";");
					break;

					case "value":
						$tpl_vars[$key] = $values["values"][$val["import"]];
					break;

					case "complex_eval":
						eval($val["import"]);
					break;

					case "var":
						$tpl_vars[$key] = $val["import"];
					break;
				}													
			}
		}

		// force the alternance to be allsways on
//		$form["alternance"] = "true";

		$tpl_vars = array_merge((array)$tpl_vars , $globalvars = $this->GlobalVars($form));

		//add a new form element for the return to previous page
		if (!is_array($form["fields"]["returnurl"]) && ($tpl_vars["self.previous"] != ""))
			$form["fields"]["returnurl"] = array(
													"type" => "hidden",
													"default" => $globalvars["self.previous_enc"]
												);

		if (is_array($form["fields"])) {
			foreach ($form["fields"] as $key => $field) {

				//checking for <code> field
				if (!$field["name"])
					$form["fields"][$key]["name"] = $key;

				if ($field["protected"] && $values["values"][$field["protected"]] && ($field["showprotected"] == "true")) {
					
					//do some forms replacement
					$form["fields"][$key]["type"] = "text";
					$form["fields"][$key]["validate"] = "";
					$form["fields"][$key]["required"] = "";
					$form["fields"][$key]["unique"] = "";
					$form["fields"][$key]["description"] = "";

					unset($field["protected"]);
				}
				

				//check to see if it isnt a protected field, usefull for admin
				if ($field["protected"] && $values["values"][$field["protected"]] || ($field["restricted"] && $this->__isRestricted($field["restricted"]))) {
				} else {				
			
					//empty some variable for each field
					$element = array();
					$current_field_extra = "";
					$current_field = "";

					//do a precheck for values, to load it from _POST, _GET _SESSION _FILE _COOKIE
					if (!@isset($values["values"][$field["name"]]) && @isset($GLOBALS[$field["get"]][$field["name"]]))  {
						$values["values"][$field["name"]] = $GLOBALS[$field["get"]][$field["name"]];
					}

					if (isset($extra["fields"][$key]))
						$form["fields"][$key]["_extra_code"] = $extra["fields"][$key];
					else					
						$form["fields"][$key]["_extra_code"] = "";
					$form["_template_data"] .= $this->DrawElement($form , $key, &$values);
				}
			}
		} else
			$form["_template_data"] = "";

		//adding the fucking buttons
		if (is_array($form["buttons"])) {

			foreach ($form["buttons"] as $key => $val)
				//checking not to be a setting group

				if (($key != "set") && (!($val["protected"] && $values["values"][$val["protected"]]))) {

					//making a small trick to replace some vars in links, i hate this
					$this->templates->blocks["Temp"]->input = $val["location"];
					//replacing the values
					//also replaging the global variables defined for templates
					$this->templates->blocks["Temp"]->input = $this->templates->blocks["Temp"]->Replace($tpl_vars);

					$val["location"] = $this->templates->blocks["Temp"]->Replace($values["values"]);
					$val["location"] = CryptLink($val["location"]);
					$val["onmouseout"] = $val["onmouseout"];
					$val["onmouseover"] = $val["onmouseover"];
					$val["onclick"] = $val["onclick"];
					$val["title"] = $val["title"];
					$val["target"] = $val["target"];
					$buttons .= $this->templates->blocks["Button"]->Replace($val);
				}

			if (	
					(($form["buttons"]["set"]["header"] == "true") && (count($form["buttons"])>1) ) 
					|| $form["subtitle"]) {

				$form["_header_buttons"] = $this->templates->blocks["HeaderButtons"]->Replace(array(
						"SUBTITLE" => ($form["subtitle"] ? $form["subtitle"] : "&nbsp;") , 
						"BUTTONS" => $form["buttons"]["set"]["header"] == "true" ? $buttons : "&nbsp" 
					)
				); 
			} else $form["_header_buttons"] = "";

			$form["_footer_buttons"] = $form["buttons"]["set"]["footer"] == "true" ? $this->templates->blocks["FooterButtons"]->Replace(array("BUTTONS" => $buttons)) : "";
		} else {
			$form["_header_buttons"] = $form["_footer_buttons"] = "";
			if (strlen($form["subtitle"])) {
				$form["_header_buttons"] =  $this->templates->blocks["HeaderButtons"]->Replace(array(
						"SUBTITLE" => ($form["subtitle"] ? $form["subtitle"] : "&nbsp;") , 
						"BUTTONS" => "&nbsp" ));
			}
			//return empty variable
				
		}

		//check and add the error message
		if ($values["error"])
			$form["_error"] = $this->templates->blocks["Error"]->Replace(array("error" => $values["error"] ));		
		else
			$form["_error"] = "";

		//adduing the javascript to form
		$form["_pre_javascript"] = $form["javascript"]["pre"] ? "<script language=\"Javascript\">" . $form["javascript"]["pre"] . "</script>" : "";
		$form["_after_javascript"] = $form["javascript"]["after"] ? "<script language=\"Javascript\">" . $form["javascript"]["after"] . "</script>" : "";
		
		//adding the extra html
		$form["_pre_tabs"] = $this->DrawTabs($form["tabs"]);
		$form["_pre_html"] = (is_array($form["html"]["pre"]) && ($form["html"]["pre"]["type"] == "extern")) ? GetFileContents(dirname($form["xmlfile"]) . "/" . $form["html"]["pre"]["file"]) : html_entity_decode($form["html"]["pre"]);
		$form["_middle_html"] = (is_array($form["html"]["middle"]) && ($form["html"]["middle"]["type"] == "extern")) ? GetFileContents(dirname($form["xmlfile"]) . "/" . $form["html"]["middle"]["file"]) : html_entity_decode($form["html"]["middle"]);
		$form["_after_html"] = (is_array($form["html"]["after"]) && ($form["html"]["after"]["type"] == "extern")) ? GetFileContents(dirname($form["xmlfile"]) . "/" . $form["html"]["after"]["file"]) : html_entity_decode($form["html"]["after"]);

		//adding the pre extra and after extra
		$form["_pre_form"] = $extra["pre"];
		$form["_after_form"] = $extra["after"];

		//preprocess the post form
		//replace the form vars in the form action
		$this->templates->blocks["Temp"]->input = $form["action"];
		$form["action"] = CryptLink($this->templates->blocks["Temp"]->Replace($tpl_vars));

		//drawing the form
		$form["_template_data"] = $form["_template_data"] == "" ? "" : $form["_template_data"];
		$form["_template_data"] = $this->templates->blocks["Form"]->Replace($form);

		//adding the border
		if ($form["border"] == "true") {
			$form["_template_data"] = $this->templates->blocks["Border"]->Replace( $form );
		}

// no need to check this, i'll have the tpl vars all the time
//		if (is_array($form["vars"])) {
			//doing a double replace, in case there are unreplaced variable sfom "vars" type
			$this->templates->blocks["Temp"]->input = $form["_template_data"];
			$form["_template_data"] = $this->templates->blocks["Temp"]->Replace($tpl_vars);
//		}
		
		//adding the <form tag
		if ($form["formtag"] == "true") {
			$form["id"] = $form["id"] ? " id=\"" . $form["id"] . "\" " : "";
			$form["encoding"] = $form["encoding"] ? $form["encoding"] : "";
			$form["method"] = $form["method"] ? $form["method"] : "post";
			$form["_template_data"] = $this->templates->blocks["Action"]->Replace( $form );
		}

		return $this->__render($form["_template_data"] , $tpl_vars);
		
	}

	/**
	* description defines the list of the global vars
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function GlobalVars($form = array(), $_FROM = array()) {
		global $_CONF;

		// if no from was passed then get all the vars from get
		if (!count($_FROM))
			$_FROM = &$_GET;
		
		if ($_GET["returnurl"])
			$private_return = $_GET["returnurl"];

		if ($_GET["returnURL"])
			$private_return = $_GET["returnURL"];

		if ($_POST["returnurl"])
			$private_return = $_POST["returnurl"];

		$return_enc = urlencode($private_return);
		$return_dec = urldecode($private_return);

		//do a check to be sure the decoded its valid
		
		$repl_count = 1;
		if ((substr($return_dec,0,1) != "/") && (strlen($return_dec) > 3))
			while ( (substr($return_dec,0,1) != "/") && ($repl_count < 10 )) {
				$return_dec = urldecode($return_dec);
				$repl_count ++;
			}

		//do another check
		if (strstr($return_enc  , '/'))
			$return_enc = urlencode($return_enc);


		$return = array (
			"self.conf.url" => $_CONF["url"],
			//script file name
			"self.file" => $_SERVER["PHP_SELF"],
			//the mod prepared for url
			"self.mod" => $_FROM['mod'] ? 'mod=' . $_FROM['mod'] . '&' : '',
			//the sub prepared for url
			"self.sub" => $_FROM['sub'] ? 'sub=' . $_FROM['sub'] . '' : '',
			//the action prepared for url
			"self.action" => $_FROM['action'] ? 'action=' . $_FROM['action'] . '' : '',

			//mod value, got from get
			"self.var.mod" => $_FROM['mod'],
			//sub value, got from get
			"self.var.sub" => $_FROM['sub'],
			//action value, got from get
			"self.var.action" => $_FROM['action'],

			//record id from database
			"self.uid" => $form["table_uid"],
			//record id from database encoded with {} to b replaced
			"self.uidvar" => '{' . strtoupper($form["table_uid"]) . '}',
			
			//link with module and sub defined
			"self.link" => $_SERVER["PHP_SELF"] . "?" . ($_FROM['mod'] ? 'mod=' . $_FROM['mod'] . '&' : '') . ($_FROM['sub'] ? 'sub=' . $_FROM['sub'] . '&' : ''),
			//link with the record id
			"self.linkuid" => $_SERVER["PHP_SELF"] . "?" . ($_FROM['mod'] ? 'mod=' . $_FROM['mod'] . '&' : '') . ($_FROM['sub'] ? 'sub=' . $_FROM['sub'] . '&' : '') . $form["table_uid"] . "=" . '{' . strtoupper($form["table_uid"]) . '}',
			//address of the current page
			"self.location" => urlencode(urlencode($_SERVER["REQUEST_URI"])),

			//the title to apear in the box, depends of the action, edit or delete
			"self.title" => !$_FROM[$form["table_uid"]] || $_POST[$form["table_uid"]] ? "Add New " : "Edit ",

			//previus detected page ( link )
			"self.previous" => $private_return ? $return_dec : $form_errors["NO_BACK_LINK"],
			//previous detected page encoded link
			"self.previous_enc" => $private_return ? $return_enc : $form_errors["NO_BACK_LINK"],
				
			//ALIAS TO THE SELF ONES, DEPRECATED
			"private.get_mod" => $_FROM["mod"],
			"private.get_sub" => $_FROM["sub"],
			"private.get_action" => $_FROM["action"],
			"private.table_uid" => $form["table_uid"],
			"private.value_uid" => '{' . strtoupper($form["table_uid"]) . "}",

			//the title to apear in the editable boxes
			"private.form_action_title" => !$_FROM[$form["table_uid"]] || $_POST[$form["table_uid"]] ? "Add New " : "Edit ",

			//previus detected page ( link )
			"private.form_previous_page" => $private_return ? $return_dec : $form_errors["NO_BACK_LINK"],
			//previous detected page encoded link
			"private.form_previous_page_enc" => $private_return ? $return_enc : $form_errors["NO_BACK_LINK"],

			//DEPRECATED, will be removed in future versions
			"current_page" => urlencode(urlencode($_SERVER["REQUEST_URI"]))
		);

		if (is_array($_GET)) { 
			foreach ($_GET as $key => $val) { 
				$return["global.get." . strtolower($key)] = $val; 
			} 
		} 


		//autogenerate the reorder link if not exists

		if (!$form["urilinks"]["ajax.reorder-records"]) {

			//try to generate it from the storing link

			$form["urilinks"]["ajax.reorder-records"] = "{SELF.LINK}&action=ajax.reorder-records";
		}
		

		//ajax.reorder-records

		//add the url links
		if (is_array($form["urilinks"])) {
			foreach ($form["urilinks"] as $key => $val) {
				$return["self.uri.$key"] = $val;
			}			
		}

		//add the url links
		if (is_array($form["uridata"])) {
			foreach ($form["uridata"] as $key => $val) {
				$return["self.action.$key"] = $form["uridata"]["action"] . "=" . $val;
				$return["self.linkuid.$key"] = $return["self.linkuid"] . "&" . $return["self.action.$key"];
				$return["self.link.$key"] = $return["self.link"] . "&" . $return["self.action.$key"];
			}			
		}		


		//do a replace for the variables which are inside this variable
		//this is usefull whtn the generated variable looks like index.php?{SELF.MOD}...
		
		//use a temporary template, i hope this wont go to slow
		$tmp = new CTemplate("");
		foreach ($return as $key => $val) {
			$tmp->input = $val;
			$return[$key] = $tmp->Replace($return);
		}
		

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
	function __private__handlers($field) {
		$events = array( 
					"tabindex" , 
					"accesskey" , 
					"onfocus" , 
					"onblur" , 
					"onselect" , 
					"onchange" , 
					"onclick" , 
					"ondblclick" , 
					"onmousedown" , 
					"onmouseup" , 
					"onmouseover" , 
					"onmousemove" , 
					"onmouseout" , 
					"onkeypress" , 
					"onkeydown" , 
					"onkeyup"
		);

		//check to see if find any existence of events in the field

		foreach ($events as $key => $val) {
			if (array_key_exists($val , $field))
				$final[] = " {$val}=\"" . $field[$val] ."\" ";
		}

		if (is_array($final))
			$field["handlers"] = implode("" , $final);		
		else
			$field["handlers"] = "";
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
	function __private__showonly(
						$form = array(),
						$set = array ( 
										"description" => TRUE,
										"comments" => TRUE
									)
						) {
		
		//if (!count($form)) 
		//	$form = $this->form;

		$form = CForm::Process($form);
		
		if (is_array($form["fields"])) {
			foreach ($form["fields"] as $key => $val) {

				//remove some of the fields
				unset($form["fields"][$key]["required"]);
				unset($form["fields"][$key]["validate"]);				

				if (($set["description"] == TRUE) && ($val["type"] != "comment" ))
					unset($form["fields"][$key]["description"]);

				//set the field editable
				$form["fields"][$key]["editable"] = "false";

				switch ($val["type"]) {
					case "textbox":
					case "textarea":
						$form["fields"][$key]["type"] = "text";
					break;
					
					case "password":
						$form["fields"][$key]["type"] = "text";
						$form["fields"][$key]["forcevalue"] = "**********";
					break;

					case "comment":
						if ($set["comments"] == TRUE) 
							unset($form["fields"][$key]);
					break;

					case "after_save":
						unset($form["fields"][$key]);
					break;
				}
			}	
		}

		return $form;
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
	function __private_generate_field($val) {
			return array(
						"type" => $val["item_type"],
						"title" => $val["item_set_title"] ? "" : $val["item_title"],
						"description" => $val["item_description"],

						"size" => $val["item_type"] == "textbox" ? $val["item_size_cols"] : ($val["item_type"] == "textarea" ? $val["item_size_cols"] . ":" . $val["item_size_rows"] : ""),

						"options" => $val["options"],
						"padding" => $val["item_type"] == "comment"  ? "20" : "",

						"empty" => $val["item_type"] == in_array($val["item_type"] , array("droplist" , "radiolist" , "checklist" , "usstates" , "rostates" , "castates")) ? "true" : "",
						"required" => $val["item_required"] ? "true" : "",
						"validate" => strtoupper($val["item_required_type"]) . ":" . $val["item_required_size_min"] . ":" . $val["item_required_size_max"],

						"preffix" => $val["item_set_preffix"],
						"suffix" => $val["item_set_suffix"],		

						"checked" => $val["item_type"] == "checkbox" ? "1" : "",

						//show the value only if is a details view
//															"value" => $__answer ? $__values[$val["item_id"]] : "",

						"label" => $val["item_set_label"],
						"empty" => $val["item_set_radio_empty"] ? "true" : "",
						"newline" => $val["item_set_radio_line"] ? "true" : "false"

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
	function __private_tree($records , $parent , $record_id , $parent_field , $separator , $level = 0 , $full = array() , $location = array()) {

		if ($level && ($full["full"]!="true")) {
			for ($i = 1; $i<= $level; $i++) {
				$sep .= $separator;				
			}			
		}
		
		if (is_array($records)) {
			foreach ($records as $key => $val) {
				if ($val[$parent_field] == $parent) {
					$val["separator"] = $sep;
					if ($full["full"] == "true") {
						//$location[]  = $val[$full["field"]];
						
						$tmp = $location;
						$tmp[] = $val[$full["field"]];

						$val[$full["field"]] = implode($separator , $tmp);

						
					}

					$_records[] = $val;					
					$_records = array_merge((array)$_records , (array)CForm::__private_tree($records , $val[$record_id] ,$record_id , $parent_field , $separator , $level+1 , $full , $tmp));
				}				
			}			
		}

		
		if ($level == 0) {
//			debug($_records,1);
		}
		
				
		return $_records;
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
	function ProcessVariables($form , $input) {
		$form = CForm::Process($form);

		if (is_array($form["fields"])) {
			foreach ($form["fields"] as $key => $val) {
				switch ($val["type"]) {
					case "ccard":
					case "creditcard":
					case "phone":
						
						if (is_array($input[$key . "_arr"])) {
							$input[$key] = trim(implode("" , $input[$key . "_arr"] ));
						}						
					break;							

					case "checkbox":
						$input[$key] = $input[$key] ? $input[$key]  : "0";
					break;

					case "date":
						$__date = mktime($input[$key . "_hour"] , $input[$key . "_min"] , $input[$key . "_sec"] , $input[$key . "_month"] , $input[$key . "_day"] , $input[$key . "_year"]);
						if ($__date > 1000) {
							$input[$key] = $__date;
						} else 
							$input[$key] = 0;
					break;

					case "checklist":
						$val["multi"] = "true";

						if (is_array($input[$key]))						
							$input[$key] = implode("," , $input[$key]);
						else
							$input[$key] = "";
					break;

					case "droplist":
					case "radiolist":
					case "double":
					case "doubleselect":
					case "countries":
					case "usstates":
					case "states":
					case "rostates":
					case "castates":

						if (is_array($input[$key]))						
							$input[$key] = implode("," , $input[$key]);

						/* DEPRECATED
							if ($val["subtype"] == "multiple") {

								//detect the fields which should be available for this field
								if (is_array($_POST)) {
									
									foreach ($_POST as $k => $v) {
										if (strstr($k , $key . "_option_")) {
											$option[] = $v;
										}										
									}						
									//ok, now build the result
									if (is_array($option)) {
										$_POST[$key] = implode($val["tree"]["db_separator"],$option);
									} else {
										$_POST[$key] = "";
									}
								} else {
									
								}
							}
						*/
					break;

					case "calendar":
						//check if isnt timestamp
						if ((strlen($input[$key]) == 10) && (((int)$input[$key] == $input[$key]) && ($input[$key] > 1000))) {
										
						} else {
										
							if (isset($input[$key])) {

								//check if this is a string
								if (strlen($input[$key]) == 10) {
									$tmp["m"] = substr($input[$key],0,2);
									$tmp["d"] = substr($input[$key],3,2);
									$tmp["y"] = substr($input[$key],6,4);
								}

								if ((strlen($input[$key]) == 16) && ($val["calendar"]["time"] == "true")) {
									$tmp["m"] = substr($input[$key],0,2);
									$tmp["d"] = substr($input[$key],3,2);
									$tmp["y"] = substr($input[$key],6,4);

									$tmp["h"] = substr($input[$key],11,2);
									$tmp["i"] = substr($input[$key],14,2);
								}
								

								if (is_array($tmp) && count($tmp)) {

									//check for european date style
									if ($_CONF["settings"]["locale"] == "eu"){
										$tmp["_"] = $tmp["m"];
										$tmp["m"] = $tmp["d"];
										$tmp["d"] = $tmp["_"];
									}

									//generate the time based on m/d/Y
									if (count($tmp) == 3) {
										$input[$key] = mktime(0 , 0 , 0 , $tmp["m"] , $tmp["d"] , $tmp["y"]);
									}

									//generate the time based on m/d/y h.m
									if (count($tmp) == 5) {
										$input[$key] = mktime($tmp["h"] , $tmp["i"] , 0 , $tmp["m"] , $tmp["d"] , $tmp["y"]);
									}									
								}
							}
						}
						


						if ($input[$key] < 1000)
							$input[$key] = 0;

						if ($input[$key]) {

							$input[$key . "_hour"]  = date("H" , $input[$key]); 
							$input[$key . "_min"]	= date("i" , $input[$key]);
							$input[$key . "_sec"]	= date("s" , $input[$key]);
							$input[$key . "_month"] = date("m" , $input[$key]);
							$input[$key . "_day"]	= date("d" , $input[$key]);
							$input[$key . "_year"]  = date("Y" , $input[$key]);

						}
						
					break;
				}
			}
		}
		return $input;
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
	function __isRestricted($data) {
		global $_MODULES;

		if (strpos($data , "eval:") === 0) {
			eval("\$result = " . substr($data , 5) );			
			return $result;
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
	function ProcessItems($items , $relations) {
		if (is_array($items)) {
			foreach ($items as $key => $val) {
				$items[$key] = CForm::ProcessItem($val , $relations);
			}
			
		}

		return $items;
		
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
	function ProcessItem($item , $relations) {
		if (is_array($item)) {
			foreach ($item as $k => $v) {
			
				if ($relations[$k]) {
					$relation = $relations[$k];

					//detect the type of the relation
					switch ($relation["type"]) {
						case "date":
							if ($v) 
								$item[$k] = date($relation["params"] , $v);
							else
								$item[$k] = $relation["default"] ?  $relation["default"] : "N/A";
						break;

						case "price":
							$item[$k] = number_format($item[$k],2);
						break;

						case "options":
							$item[$k] = $relation["options"][$v];
						break;

						case "bbcode":
							$bbc = new CBBCode();
							if ($relation["tpl"]) {
								$bbc->language_tpl = $relation["tpl"];
							}		
							$item[$k] = $bbc->Convert($v , $relation["lang"]["default"]);
						break;
					}

					if ($relation["maxchars"]) {
						if (strlen($item[$k]) > $relation["maxchars"]) {
							$item[$k] = substr($item[$k] , 0 , $relation["maxchars"] ) . "...";
						}
					}
					
				}
			}
		}

		return $item;
	}


	/* FIELDS DEFINITIONS */

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function __field__droplist($field , $values) {
		global 
			$form_US_states,
			$form_RO_states,
			$form_CA_states,
			$form_countries,
			$form_timezones;


		if ($field["newline"] == "false") {
			$field["line_bottom"] = "";
			$field["line_top"] = "";
		} else {
			
			$field["line_bottom"] = $this->templates->blocks["CheckBoxOption_line_bottom"]->output;
			$field["line_top"] = $this->templates->blocks["CheckBoxOption_line_top"]->output;
		}
		

		if (!isset($field["emptymsg"]))
			$field["emptymsg"] = $this->__default["show"]["droplist"]["empty_text" . ($field["editable"] == "false" ? "_show" : "")];

		if (!isset($field["empty_text"]))
			$field["empty_text"] = $this->__default["show"]["droplist"]["empty_text" . ($field["editable"] == "false" ? "_show" : "") ];

		//select multiple values for the complex selects
		if (($field["multi"]||$field["double"]) && !is_array($field["value"]))
			$field["value"] = explode("," , $field["value"]);

		$values["values"]["original_" . $field["name"]] = $field["value"];			

		switch ($field["type"]) {
			case "USstates":
			case "states":
			case "usstates":
				$field["options"] = $form_US_states;
			break;
			
			case "ROstates":
			case "rostates":
				$field["options"] = $form_RO_states;
			break;

			case "CAstates":
			case "castates":
				$field["options"] = $form_CA_states;
			break;

			case "countries":
				$field["options"] = $form_countries;
			break;

			case "relation":
				$field["editable"] = "false";
			break;

			case "timezones":
			case "timezone":
				$field["options"] = $form_timezones;
			break;
		}

		//if is set use text then dont use the small names INSTED of CA use CANADA
		if (($field["usetext"] == "true") && (is_array($field["options"]))) {
			foreach ($field["options"] as $key => $val){
				unset($field["options"][$key]);
				$field["options"][$val] = $val;						
			}
				//$_field["options"][$val] = $val; 
			
			//$field["options"] = $_field["options"];
		}

		//if editable false change the type in relation ( non editable )
		if ($field["editable"] == "false")
			$field["type"] = "relation";				
		
		//clearign vals
		$temp_options = "";

		//check if the options are generated dinamic
		if (is_array($field["dynamic"])) {
			
			if ($field["dynamic"]["from_type"] == "eval") {
				eval( "\$field[\"dynamic\"][\"from\"] = " . $field["dynamic"]["from"] . ";");
			}

			if ($field["dynamic"]["from"] > $field["dynamic"]["to"])
				for ($i = $field["dynamic"]["from"]; $i>= $field["dynamic"]["to"]; $i-- ) {
					$field["options"][$i] = $field["dynamic"]["width"] ? sprintf("%0" . $field["dynamic"]["width"] . "d", $i) : $i;						
				}					
			else 					
				for ($i = $field["dynamic"]["from"]; $i<=$field["dynamic"]["to"]; $i++ ) {
					$field["options"][$i] = $field["dynamic"]["width"] ? sprintf("%0" . $field["dynamic"]["width"] . "d", $i) : $i;						
				}					
		}

###
		if (is_array($field["relation"])) {
			if (is_array($field["relation"]["sql"])) {
		

				if (is_array($field["relation"]["sql"]["vars"])) {
					
					$form_sql_vars = array();

					foreach ($field["relation"]["sql"]["vars"] as $key => $val) {
						//echeking if the default must be evaluated
						if ($val["action"] == "eval") {
							eval("\$val[\"import\"] = " . $val["default"] .";");
						}

						switch ($val["type"]) {
							case "eval":
								eval("\$form_sql_vars[\"$key\"] = " . $val["import"] . ";");
							break;

							case "var":
								$form_sql_vars[$key] = $val["import"];
							break;

							case "table":
								$form_sql_vars[$key] = $val["import"] ? $this->tables[$val["import"]] : $this->tables[$form["table"]];
							break;

							case "page":
								$form_sql_vars[$key] = ($_GET[($val["code"] ? $val["code"] : 'page')] -1 )* $form['items'];
							break;

							case "form":
								eval("\$form_sql_vars[\"$key\"] = " . $form[$val["var"]] . ";");
							break;
						}													
					}

					foreach ($form_sql_vars as $key => $val) {							
						$this->templates->blocks["Temp"]->input = $val;							
						$form_sql_vars[$key] = $this->templates->blocks["Temp"]->Replace($form_sql_vars);
					}	

					//doing a double replace, in case there are unreplaced variable sfom "vars" type
					$this->templates->blocks["Temp"]->input = $field["relation"]["sql"]["query"];
					$sql = $this->templates->blocks["Temp"]->Replace($form_sql_vars);

					//do a precheck for [] elements to be replaced with <>
					$sql = str_replace("]" , ">" , str_replace("[" , "<" , $sql));

					$records = $this->db->QFetchRowArray($sql);								
				} else {
					$records = $this->db->QFetchRowArray($field["relation"]["sql"]["query"]);								

				}

			} else {


				//check to eval the condition if requred
				if (is_array($field["relation"]["condition"]) && ($field["relation"]["condition"]["eval"] == "true")) {
					eval("\$field[\"relation\"][\"condition\"] = " . $field["relation"]["condition"]["import"]);
				}

				$tmp_table= explode("," , $field["relation"]["table"]);

				if (count($tmp_table)) {
					foreach ($tmp_table as $__k => $__table) {
						$rel_table[] = $this->tables[$__table];
					}

					$rel_table = implode(" , " , $rel_table);							
				} else 
					$rel_table = $this->tables[$field["relation"]["table"]];

				$sql =	"SELECT * FROM " . $rel_table . " " . 
						($field["relation"]["condition"] ? " WHERE (" . $field["relation"]["condition"] . ") " : "" ) . 
						($field["relation"]["order"] ? " ORDER BY " . $field["relation"]["order"] . " " . 
						($field["relation"]["ordermode"] ? $field["relation"]["ordermode"] : "") : "" );


				$records =$this->db->QFetchRowArray( $sql );

			}

			if (is_array($records)) {

			// prepare the tree type
				if (($field["editable"] != "false") && is_array($records) && is_array($field["tree"])) {
					$records = CForm::__private_tree(
							$records , 
							$field["tree"]["first"] ? $field["tree"]["first"] : 0 , 
							$field["relation"]["id"] , 
							$field["tree"]["parent"] , 
							$field["tree"]["separator"] , 
							0, 
							array ( 
								"full" => $field["tree"]["full"]  , 
								"field" => $field["tree"]["field"] 
							)
							
					);							
				}


				if (is_array($records)) {

					foreach ($records as $key => $val) {
						if (is_array($field["relation"]["text"])) {
							$_tmp_text = array();

							foreach ($field["relation"]["text"] as $kkey => $vval)
								if (is_array($vval))
									$_tmp_text[] = $vval["preffix"] . $val[$vval["field"]] . $vval["suffix"];
								else
									$_tmp_text[] = $val[$vval];

							$field["options"][$val[$field["relation"]["id"]]] = $val["separator"] . implode($field["relation"]["separator"] ? $field["relation"]["separator"] : " " , $_tmp_text);

						} else							
							$field["options"][$val[$field["relation"]["id"]]] = $val["separator"] . $val[$field["relation"]["text"]];
					}						

				}
				
			}					



		}

		//prepare the templates list
		if ($field["radio"] == "true") {
			$template = "Radio";
			$checked = " checked=\"checked\" ";
		} else {
			if ($field["checkbox"] == "true") {				
				$template = "CheckBox";
				$checked = " checked=\"checked\" ";
			} else {
				if ($field["double"] == "true") {

					if ($field["small"] == "true") {
						$template = "DoubleSmall";
						$checked = true;
					} else {
						$template = "Double";
						$checked = true;
					}
				} else {						
					$template = "Select";
					$checked = " selected=\"selected\" ";
				}
			}
		}
###
		//add the enpty option
		if ($field["empty"] == "true") {
			if ($field["editable"] == "false")
				$__empty = $field["empty_text"] ? $field["empty_text"] : "<i>N/A</i>";
			else
				$__empty = $field["empty_text"] ? $field["empty_text"] : " [ select ] ";
			
			$field["options"] = array("" => $__empty) + (is_array($field["options"]) ? $field["options"] : array() );
		}

####


		if (is_array($field["options"])) {

			//if the field admists multiple values then add the array simbol
			if ($field["multi"] && ($field["editable"] != "false")) 
				$field["name"] .= "[]";


			//building the select from options
			foreach ($field["options"] as $key => $val) {

				//hm ... support for noeditable fields, will apear as text
				if ($field["editable"] == "false") {					
						if ($field["multi"]) {									
							//change the structure of current fields make it array, and use it for later recognition
							
							if (in_array($key , $values["values"]["original_" . $field["name"]] )) 
								$current_field[] = $val;

						} else {								
							if (($key == $values["values"][$field["name"]]) && (strlen($key) == strlen($values["values"][$field["name"]])) ) {
								$found = 1;

								$field["value"] = $val;

								$this->templates->blocks["text"]->Replace($field , false);
								$current_field = $this->templates->blocks["text"]->EmptyVars();	
							}
						}

				} else {					

					//checking if is a complex option or a simple one
					if (is_array($val)) {
						$label = $val["value"];
						$disabled = $val["disabled"] == "true" ? " disabled " : "";
					} else {
						$label = $val;
						$disabled = "";
					}

					if (is_array($field["value"]))
						$selected = in_array($key , $field["value"])  ? $checked : "" ? $checked : "";
					else {																 
						$selected = (($key == $field["value"]) && (strlen($key) == strlen($field["value"])) ? $checked : "");
					}
					
					
					if (($field["double"] == "true") && $selected) {
						$temp_options2 .= $this->templates->blocks["{$template}Option" . (is_array($val) && $val["type"] == "group" ? "Group" : "")]->Replace(
											array(	
												"value" => $key,
												"label" => $label,
												"checked" => $selected,
												"disabled" => $disabled,
												"name" => $field["name"],
												"line_top" => $field["line_top"],
												"line_bottom" => $field["line_bottom"]
											)
										  );
						$temp_options3[] = $key;
					}
					
												
					$temp_options .= $this->templates->blocks["{$template}Option" . (is_array($val) && $val["type"] == "group" ? "Group" : "")]->Replace(
										array(	
											"value" => $key,
											"label" => $label,
											"checked" => $selected,
											"disabled" => $disabled,
											"name" => $field["name"],
											"line_top" => $field["line_top"],
											"line_bottom" => $field["line_bottom"]
										)
									  );
				}
			}														

//					debug($current_field);

			//if is array then it is an no editable and multi true
			if (is_array($current_field)) {
				$current_field = implode(", " , $current_field );
				//mark as found
				$found = 1;
			}
			
		}

		if ($field["editable"] != "false") {

			//prepare the fields

			if (!isset($field["emptymsg"]))
				$field["emptymsg"] = $this->__default["show"]["droplist"]["emptytext"];

			$field["options"] = $temp_options;

			if (($field["double"] == "true")) {
				$field["options2"] = $temp_options2;
				$field["values"] = is_array($temp_options3) ? implode("," , $temp_options3) : "";
			}
			
			$field["size"] = $field["size"] ? $field["size"] : "1";
			$field["multiple"] = $field["multi"] ? " multiple=\"multiple\" " : "";
			$field["width"] = $field["width"] ? "style=\"width:{$field[width]}px\";" : "";
			$field["disabled"] = $field["disabled"] == "true" ? " disabled " : "";					

			if ($temp_options != "")
				$current_field = $this->templates->blocks[$template]->Replace($field);
			else 
				//else return a message, customizable from xml
				$current_field = $field["emptymsg"];
		} else {

			if (!(($current_field != "")&& $found)) {
				//else return a message, customizable from xml
				$current_field = $field["emptymsg"];
			}
		}

		return $current_field;
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
	function __field__image($field , $values) {

		global $_CONF;

		if ($field["type"] == "upload") {
			$file = true;
		}
		

		if ($field["force_values"]) {
			$values["values"][$field["name"] . "_file"] = $field["force_values"]["file"];
			$values["values"][$field["file"]["field"]] = $field["force_values"]["field"];
			$values["values"][$field["name"]] = $field["force_values"]["value"];
		}
		if ($field["editable"] != "false") {
			
			$field["file_name"] = $values["values"][$field["name"] . "_file"];
/*???*/				$field["target"] = $field["target"] == "self" ? "" : "target=\"_new\"" ;

			//add the cropping details
			$field["crop_width"] = $field["crop_height"] = "0";
			if (is_array($field["thumbnails"]["resize"])) {
				$field["crop_width"] = (int)$field["thumbnails"]["resize"]["width"];
				$field["crop_height"] = (int)$field["thumbnails"]["resize"]["height"];
			} else {
				if ($field["process"]) {
					$field["crop_width"] = (int)$field["process"]["width"];
					$field["crop_height"] = (int)$field["process"]["height"];
				} 
			}

			//it is an image
			$tmp_file_path = $_CONF["path"] . $_CONF["upload"] . ($field["path"] ? $field["path"] : $field["file"]["path"]) . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"];
			$tmp_file_url = $_CONF["url"] . $_CONF["upload"] . ($field["path"] ? $field["path"] : $field["file"]["path"]) . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"];

			$tmp_file_path = str_replace("/./" , "/" , $tmp_file_path);
			$tmp_file_url = str_replace("/./" , "/" , $tmp_file_url);

			if (file_exists($tmp_file_path) && is_file($tmp_file_path)) {
				$field["src"] = $tmp_file_url . ($file ? "" : "?" . time());
			} else
				$field["src"] = "";
		
			//check if the savinf gor returned and error and keep the file
			$field["previous_file"] = "";
			$field["previous_file_name"] = "";

			if ($values["values"][$field["name"] . "_temp"]) {
				$tmp_file_previous_path = $_CONF["path"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"];
				$tmp_file_previous_url = $_CONF["url"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"];

				if (is_file($_CONF["path"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"])) {

					$tmp_file_previous_path = str_replace("/./" , "/" , $tmp_file_previous_path);
					$tmp_file_previous_url = str_replace("/./" , "/" , $tmp_file_previous_url);

					$field["previous_file"] = $tmp_file_previous_url;
					$field["previous_file_name"] = $values["values"][$field["name"] . "_temp_file"];
				}
			}

			if ($values["values"][$field["name"] . "_crop_oxbc"]) {
				$tmp_img = explode(":" , $values["values"][$field["name"] . "_crop_oxbc"]);
				$field["prev_x"] = $tmp_img[2];
				$field["prev_y"] = $tmp_img[3];
				$field["prev_w"] = $tmp_img[4];
				$field["prev_h"] = $tmp_img[5];
			} else 
				$field["prev_x"] = $field["prev_y"] = $field["prev_w"] =  $field["prev_h"] = '';


			//add the filename
			$field["file_name"] = $values["values"][$field["name"] . "_file"];
			$field["crop_oxbc"] = $values["values"][$field["name"] . "_crop_oxbc"];

			//add the max size supported by php
			$field["max_size"] = return_bytes(ini_get('post_max_size'));


			$image["editable"] = $this->templates->blocks[$file ? "uploadedit" : "imageedit"]->Replace($field);
		}	
//				DEBUG($values["values"]);

		if ($file) {
			if (is_file($_CONF["path"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"])) {

				//show the fucking image
				$image["preview"] = $this->templates->blocks["fileshow"]->Replace(
										array(
											"name" => $_CONF["url"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_file"],
											"src" => $_CONF["url"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"] ,
											"target" => $field["target"] == "self" ? "" : "target=\"_new\"" 
										)
									);

			} else {
				$file_name = $_CONF["path"] . $_CONF["upload"] . ($field["path"] ? $field["path"] : $field["file"]["path"]) . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"];
				$file_url = $_CONF["url"] . $_CONF["upload"] . ($field["path"] ? $field["path"] : $field["file"]["path"]) . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"];

				if (/*$values["values"][$field["name"]] && */file_exists($file_name)) {
					$image["preview"] = $this->templates->blocks["fileshow"]->Replace(
											array(
												"name" => $values["values"][$field["name"] . "_file"] ? $values["values"][$field["name"] . "_file"]  : $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"],
												"src" => $file_url,
												"target" => $field["target"] == "self" ? "" : "target=\"_new\"" 
											)
										);
				} else 
					$image["preview"] = $field["error"] ? $field["error"] : "No file uploaded.";
			}

		} else {
		
			if (is_file($_CONF["path"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"])) {

				//show the fucking image
				$image["preview"] = $this->templates->blocks["imageshow"]->Replace(
										array(
											"width" => $field["adminwidth"],
											"height" => $field["adminheight"] ? ' height="' . $field["adminheight"] . '"' : "",
											"border" => $field["border"] ? $field["border"] : 0,
											"src" => $_CONF["url"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"] 
										)
									);

			} else {
				//hm ... making a small trick to keep the image even if that was an failed adding,
				//this sux becouse if the add process is not completed then i get crap in the temp folder.					
				if ($values["values"][$field["name"]] && file_exists($_CONF["path"] . $_CONF["upload"] . $field["path"] . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"])) {
					$image["preview"] = $this->templates->blocks["imageshow"]->Replace(
											array(
												"width" => $field["adminwidth"],
												"height" => $field["adminheight"] ? ' height="' . $field["adminheight"] . '"' : "",
												"border" => $field["border"] ? $field["border"] : 0,
												"src" => $_CONF["url"] . $_CONF["upload"] . $field["path"] . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"]
											)
										);

				} else {

					//checking if there exists a default image
					if ($field["default"]) {
						$image["preview"] = $this->templates->blocks["imageshownolink"]->Replace(
												array(
													"width" => $field["adminwidth"],
													"height" => $field["adminheight"] ? ' height="' . $field["adminheight"] . '"' : "",
													"border" => $field["border"] ? $field["border"] : 0,
													"src" => $_CONF["url"] . $_CONF["upload"] . $field["path"] . $field["default"]
												)
											);
					} else
						//return an error from xml
						$image["preview"] = $field["error"] ? $field["error"] : "No image curently available.";
				}
			}
		}


		if ($field["editable"] != "false"){
			$image["preview"] = "";
		}

		$image["temp"] = $values["values"][$field["name"] . "_temp"];
		$image["error"] = $field["error"];
		$image["name"] = $field["name"];


		//check if the new image object with javascript works
		if (($file == FALSE)  && ($field["editable"] == "true") && is_object($this->templates->blocks["image2"])) {
			$this->templates->blocks["image2"]->Replace($image , false);
			$current_field = $this->templates->blocks["image2"]->EmptyVars();													
		} else {

			//use the original obkect
			$this->templates->blocks["image"]->Replace($image , false);
			$current_field = $this->templates->blocks["image"]->EmptyVars();							
		}

		return $current_field;
	}
	

	function __field__image_html($field , $values) {

		global $_CONF;

		if ($field["type"] == "upload") {
			$file = true;
		}
		

		if ($field["force_values"]) {
			$values["values"][$field["name"] . "_file"] = $field["force_values"]["file"];
			$values["values"][$field["file"]["field"]] = $field["force_values"]["field"];
			$values["values"][$field["name"]] = $field["force_values"]["value"];
		}
		if ($field["editable"] != "false") {
			
			//adding the editable area to form
			$field["web_checked"] = $values["values"][$field["name"] . "_radio_type"] ? "checked" : "";
			$field["client_checked"] = $values["values"][$field["name"] . "_radio_type"] ? "" : "checked";
			$field["web_link"] = $values["values"][$field["name"] . "_upload_web"] ? $values["values"][$field["name"] . "_upload_web"] : "http://";
			$field["file_name"] = $values["values"][$field["name"] . "_file"];
/*???*/				$field["target"] = $field["target"] == "self" ? "" : "target=\"_new\"" ;

			$field["rem_disabled"] = $values["values"][$field["name"] . "_temp"] || $values["values"][$field["name"] . "_temp"] || $values["values"][$field["name"]] ? "" : "disabled";					

			$image["editable"] = $this->templates->blocks[$file ? "uploadedit_html" : "imageedit_html"]->Replace($field);
		}	
//				DEBUG($values["values"]);

		if ($file) {
			if (is_file($_CONF["path"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"])) {

				//show the fucking image
				$image["preview"] = $this->templates->blocks["fileshow"]->Replace(
										array(
											"name" => $_CONF["url"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_file"],
											"src" => $_CONF["url"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"] ,
											"target" => $field["target"] == "self" ? "" : "target=\"_new\"" 
										)
									);

			} else {
				$file_name = $_CONF["path"] . $_CONF["upload"] . ($field["path"] ? $field["path"] : $field["file"]["path"]) . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"];
				$file_url = $_CONF["url"] . $_CONF["upload"] . ($field["path"] ? $field["path"] : $field["file"]["path"]) . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"];

				if (/*$values["values"][$field["name"]] && */file_exists($file_name)) {
					$image["preview"] = $this->templates->blocks["fileshow"]->Replace(
											array(
												"name" => $values["values"][$field["name"] . "_file"] ? $values["values"][$field["name"] . "_file"]  : $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"],
												"src" => $file_url,
												"target" => $field["target"] == "self" ? "" : "target=\"_new\"" 
											)
										);
				} else 
					$image["preview"] = $field["error"] ? $field["error"] : "No file uploaded.";
			}

		} else {
		
			if (is_file($_CONF["path"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"])) {

				//show the fucking image
				$image["preview"] = $this->templates->blocks["imageshow"]->Replace(
										array(
											"width" => $field["adminwidth"],
											"height" => $field["adminheight"] ? ' height="' . $field["adminheight"] . '"' : "",
											"border" => $field["border"] ? $field["border"] : 0,
											"src" => $_CONF["url"] . $_CONF["upload"] . "tmp/" . $values["values"][$field["name"] . "_temp"] 
										)
									);

			} else {
				//hm ... making a small trick to keep the image even if that was an failed adding,
				//this sux becouse if the add process is not completed then i get crap in the temp folder.					
				if ($values["values"][$field["name"]] && file_exists($_CONF["path"] . $_CONF["upload"] . $field["path"] . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"])) {
					$image["preview"] = $this->templates->blocks["imageshow"]->Replace(
											array(
												"width" => $field["adminwidth"],
												"height" => $field["adminheight"] ? ' height="' . $field["adminheight"] . '"' : "",
												"border" => $field["border"] ? $field["border"] : 0,
												"src" => $_CONF["url"] . $_CONF["upload"] . $field["path"] . $field["file"]["default"] . $values["values"][$field["file"]["field"]] . $field["file"]["ext"]
											)
										);

				} else {

					//checking if there exists a default image
					if ($field["default"]) {
						$image["preview"] = $this->templates->blocks["imageshownolink"]->Replace(
												array(
													"width" => $field["adminwidth"],
													"height" => $field["adminheight"] ? ' height="' . $field["adminheight"] . '"' : "",
													"border" => $field["border"] ? $field["border"] : 0,
													"src" => $_CONF["url"] . $_CONF["upload"] . $field["path"] . $field["default"]
												)
											);
					} else
						//return an error from xml
						$image["preview"] = $field["error"] ? $field["error"] : "No image curently available.";
				}
			}
		}

		$image["temp"] = $values["values"][$field["name"] . "_temp"];
		$image["error"] = $field["error"];
		$image["name"] = $field["name"];


		//check if the new image object with javascript works
		if (($file == FALSE)  && ($field["editable"] == "true") && is_object($this->templates->blocks["image2"])) {
			$this->templates->blocks["image2"]->Replace($image , false);
			$current_field = $this->templates->blocks["image2"]->EmptyVars();													
		} else {

			//use the original obkect
			$this->templates->blocks["image"]->Replace($image , false);
			$current_field = $this->templates->blocks["image"]->EmptyVars();							
		}

		return $current_field;
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
	function __field__phone($field , $values) {
		if (!$field["size"])
			$field["size"] = $this->__default["show"]["phone"]["size"];

		$size = explode("," , $field["size"]);

		$field["size_1"] = (int) $size[0];
		$field["size_2"] = (int) $size[1];
		$field["size_3"] = (int) $size[2];

		//check ig the values werent stored yet and the array still exits
		if (is_array($values["values"][$field["name"] . "_arr"])) {
			$_val = &$values["values"][$field["name"] . "_arr"];
			//if yes then use the values from that arrya
			$field["value_1"] = $_val[0];
			$field["value_2"] = $_val[1];
			$field["value_3"] = $_val[2];
		} else {			
			//else extract blocks from the array w/ the values
			$field["value_1"] = $field["value"] ? substr($field["value"],0,$field["size_1"]) : "";
			$field["value_2"] = $field["value"] ? substr($field["value"],$field["size_1"],$field["size_2"]) : "";
			$field["value_3"] = $field["value"] ? substr($field["value"],(int)($field["size_1"] + $field["size_2"])) : "";
		}

		//return the template depending of editable status, show or edit.
		$current_field = $this->templates->blocks[$field["editable"] == "false" ? "phoneshow" : "phone"]->Replace($field);				

		return $current_field;
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
	function __field__textarea( $field , $values) {
		global $_TSM;

		if (is_array($temp = @explode(":" , $field["size"]))) {
			//size from xml
			$field["_cols"] = $temp["0"];
			$field["_rows"] = $temp["1"];
		} else {
			//preset size
			$field["_cols"] = $this->_textareaCols;
			$field["_rows"] = $this->_textareaRows;
		}

		if ($field["readonly"] == "true")
			$field["readonly"] = " readonly ";
		else
			$field["readonly"] = "";

		//uhm ... this is a crappy part becouse i have to integrate the html editor here so ...
		if ($field["html"] == "true") {
			//checking if the editor.js was loaded until now
			if ($_GLOBALS["cform_editor_loaded"] != true) {
				$current_field = $this->templates->blocks["htmlareainit"]->output;
				$_GLOBALS["cform_editor_loaded"] = true;
			}

			$field["value"] = stripslashes($field["value"]);
			$_TSM["FORMS.PRIVATE.ONLOAD"] .= $this->templates->blocks["htmlareaonload"]->Replace($field);
			$current_field .= $this->templates->blocks["htmlarea"]->Replace($field);
		} else {				
			//$field["value"] = $field["denyhtml"] ? $field["value"] : htmlentities($field["value"]);
			//prepare some optional width value

			if ($field["width"]) {
				$field["style"] = " style=\"width:{$field[width]}\" ";
			}
			
			$current_field = $this->templates->blocks["textarea"]->Replace($field);
			//$current_field = $this->templates->blocks["textarea"]->EmptyVars();
		}

		return $current_field;
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
	function __field__textbox( $field , $values) {

		//check if the size for textbox is defined
		if ($field["size"]) {

			//autodetect if the size value contaigns the maxlength too
			if (is_array($temp = @explode(":" , $field["size"]))) {								

				$field["_size"] = $temp["0"];
				$field["_maxlength"] = $temp["1"];

			} else {

				//else the size field is the size of textbox
				$field["_size"] = $field["size"];
				$field["_maxlength"] = $this->_textboxMaxLength;
			}

		} else {

			//check if there is defined any withd value
			if ($field["width"]) {
			} else {
				//get the default values

				$field["_size"] = $this->_textboxSize;
				$field["_maxlength"] = $this->_textboxMaxLength;
			}

							
		}

		//prepare the html entities for the nonhtml forms.
		if ($field["html"] != "true")
			//$field["value"] = htmlentities($field["value"]);
		

		if (!isset($values["values"][$field["name"] . "_confirm"]))				
			$values["values"][$field["name"] . "_confirm"] = $field["value"];

		if ($field["align"])
			$field["style"][] = "text-align:{$field[align]}";

		if ($field["readonly"] == "true")
			$field["readonly"] = " readonly ";
		else
			$field["readonly"] = "";

		//add the show element
		if ($field["type"] == "password") {
			if ($field["show"] == "true")
				$field["show"] = is_object($this->templates->blocks["password_show"]) ? $this->templates->blocks["password_show"]->Replace($field) : "";
			else
				$field["show"] = "";
		}

		if (is_array($field["style"]))
			$field["style"] = ' style="' . implode(";" , $field["style"]) . '" ';
		else
			$field["style"] = "";

		//replace the " with the html code for that else it will wont appear
		$field["value"] = str_replace("\"" , "&quot;" , $field["value"]);
		
		$current_field = $this->templates->blocks[$field["type"]]->Replace($field);
		//$current_field = $this->templates->blocks[$field["type"]]->EmptyVars();	

		return $current_field;
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
	function __field__file($field , $values) {
		$field["file"] = $values["values"][$field["name"]];
		$this->templates->blocks["file"]->Replace($field , false);
		$current_field = $this->templates->blocks["file"]->EmptyVars();	

		return $current_field;
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
	function __field__sql($field , $values) {

		if (is_array($field["sql"])) {
			$form_sql_vars = array();

			if (is_array($field["sql"]["vars"])) {
				foreach ($field["sql"]["vars"] as $_key => $_val) {
					//echeking if the default must be evaluated
					if ($_val["action"] == "eval") {
						eval("\$_val[\"import\"] = " . $_val["default"] .";");
					}

					switch ($_val["type"]) {
						case "eval":
							eval("\$form_sql_vars[\"$_key\"] = " . $_val["import"] . ";");
						break;

						case "var":
							$form_sql_vars[$_key] = $_val["import"];
						break;

						case "page":
							$form_sql_vars[$_key] = ($_GET[($_val["code"] ? $_val["code"] : 'page')] -1 )* $form['items'];
						break;

						case "form":
							eval("\$form_sql_vars[\"$_key\"] = " . $form[$_val["var"]] . ";");
						break;

						case "field":
							$form_sql_vars[$_key] = $items[$key][$_val["import"]];
						break;
					}													
				}

				foreach ($form_sql_vars as $_key => $_val) {							
					$this->templates->blocks["Temp"]->input = $_val;							
					$form_sql_vars[$_key] = $this->templates->blocks["Temp"]->Replace($form_sql_vars);
				}	

				//doing a double replace, in case there are unreplaced variable sfom "vars" type
				$this->templates->blocks["Temp"]->input = $field["sql"]["query"];
				$sql = $this->templates->blocks["Temp"]->Replace($form_sql_vars);

				//do a precheck for [] elements to be replaced with <>
				$sql = str_replace("]" , ">" , str_replace("[" , "<" , $sql));

				$record = $this->db->QFetchArray($sql);								

				$field["value"] = $record[$field["sql"]["field"]];
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
	function __field__text($field , $values) {

		if ($field["html"] != "true") {
			//$field["value"] = htmlentities($field["value"]);
			$field["value"] = eregi_replace("([_a-z0-9\-\.]+)@([a-z0-9\-\.]+)\." . "(net|com|gov|mil|org|edu|int|biz|info|name|pro|[A-Z]{2})". "($|[^a-z]{1})", "<a title=\"Click to open the mail client.\" href=\"mailto:\\1@\\2.\\3\">\\1@\\2.\\3</a>\\4", $field["value"]);
			$field["value"] = eregi_replace("(http|https|ftp)://([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)","<a href=\"\\1://\\2\" title=\"Click to open in new window.\" target=\"_blank\">\\2</a>", $field["value"]);

			$field["value"] = nl2br($field["value"]);
		}
		
		if ($field["html"] != "true") {
		}

		if ($field["html_entities_decode"] == "true")
			$field["value"] = html_entity_decode($field["value"]);

		if ($field["maxchars"]) {
			$field["value"] = substr($field["value"],0,$field["maxchars"]) . (strlen($field["value"]) > $field["maxchars"] ? ($field["maxchars_text"] ? $field["maxchars_text"] : $this->__default["list"]["fields"]["maxchars_text"]) : "");
		}


		$field["action"] = $field["subtype"] ? $field["subtype"] : $field["action"];

		switch ($field["action"]) {
			case "date":
				if (isset($values["values"][$field["name"] . "_day" ]) && isset($values["values"][$field["name"] . "_month" ]) && isset($values["values"][$field["name"] . "_year" ])) 
					$field["value"] = 
										( $values["values"][$field["name"] . "_month" ] ? sprintf("%02d" ,$values["values"][$field["name"] . "_month" ])  : "--" ). "." . 
										( $values["values"][$field["name"] . "_day" ] ? sprintf("%02d" ,$values["values"][$field["name"] . "_day" ]) : "--" ) . "." .  
										( $values["values"][$field["name"] . "_year" ] ? $values["values"][$field["name"] . "_year" ] : "----" ) ;
				else						
					$field["value"] = $field["value"] > 0 ? @date($field["params"] , $field["value"]) : "not available";
			break;

			case "price":
				$field["value"] = number_format($field["value"] , 2);
			break;
		}

//WARNING THIS IS IN TESTING MODE SO IF ANYTHING WILL GO WRONG IT WILL DISPEAR				
		//do some special tricks, to transform the links and the email addresses in urls
//				if ($field["linkstransform"] == "true") {
		//check if there is any html content around

//				}



		//format the text
		switch ($field["font"]) {

			case "normal":
			break;

			default:
				$field["value"] = "" . $field["value"] . "";
			break;
		}


		if ($field["nobr"] == "true") 
			$field["value"] = "<nobr>{$field[value]}</nobr>";

		$current_field = $this->templates->blocks["text"]->Replace($field , false);
		//$current_field = $this->templates->blocks["text"]->EmptyVars();	

		return $current_field;
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
	function __field__hidden($field , $values) {
		//fix a small bug, if the hidden!= true then the elemet is drow like normal element.
		$field["hidden"] = "true";

		$current_field = $this->templates->blocks["hidden"]->Replace($field , false);

		return $current_field;
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
	function __field__button($field , $values) {
		$field["target"] = $field["target"];
		$field["title"] = $field["title"];

		$field["onmouseover"] = $field["onmouseover"];
		$field["onmouseout"] = $field["onmouseout"];
		$field["onclick"] = $field["onclick"];

		$field["id"] = $field["id"];
		$current_field = $this->templates->blocks["button"]->Replace($field , false);
		//$this->templates->blocks["button"]->EmptyVars();							

		return $current_field;
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
	function __field__checkbox($field , $values) {
		$_value = $field["checked"];
		$field["checked"] = $field["value"] == $field["checked"] ? " checked=\"checked\" " : "";
		$field["value"] = $_value;

		$field["check"] = $field["checked"] ? "on" : "off";

		//prepare the label 
		if (strstr($field["label"] , "|")) {
			$tmp = explode("|" , $field["label"]);
			$field["label"] = $tmp[0];					

			if ($field["editable"] == "false")
				$new = true;
		}
		

		

		if ($new == true) {
			if ($field["editable"] == "false") {
				$field["value"] = $field["check"] == "on" ? $tmp[0] : $tmp[1];
				$current_field = $this->templates->blocks["text"]->Replace($field , false);
			}
		} else {
		
				$this->templates->blocks["checkbox" . ($field["editable"] == "false" ? "_show" : "")]->Replace($field , false);
				$current_field = $this->templates->blocks["checkbox" . ($field["editable"] == "false" ? "_show" : "")]->EmptyVars();							
		}

		return $current_field;

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
	function __field__comment($field , $values , $form) {
		global $_CONF;

		//changed the way it handles the comments
		if ($field["value"]) {
			$field["description"] = nl2br($field["value"]);
		}				

		if ($field["subtype"] == "extern") {
			$field["description"] = GetFileContents(dirname($form["xmlfile"]) . "/" . $field["file"]);
		} else {
		
			$field["description"] = preg_replace( 
							array( '(\[)' , '(\])' ),
							array( "<" , ">" ),
							$field["description"]
						);
		}
		//save the input 
		$old = $this->templates->blocks["Comment"]->input ;

		//do the replaces
		
		$this->templates->blocks["Comment"]->input = $this->templates->blocks["Comment"]->Replace(array(
																									"COMMENT" => $field["description"],
																									"PADDING" => $field["padding"] ? $field["padding"] : "0",
																									"ALIGN" => $field["align"]
																									));								
		$this->templates->blocks["Comment"]->input = $this->templates->blocks["Comment"]->Replace($values["values"]);
		$this->templates->blocks["Comment"]->input = $this->templates->blocks["Comment"]->Replace($_GET);
		$current_field = $this->templates->blocks["Comment"]->Replace($_POST);

		//restore the template 
		$this->templates->blocks["Comment"]->input = $old;
			
		return $current_field;
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
	function __field__date($field , $values) {

		if (($field["now"] == "true") && !$field["value"]) {
			$field["value"] = time();
		}
#### FIX ME IF NO SEPARATE DATES IT WONR WORK, NEED TO CREATE THEM FROM THE MAIN DATE IF DOESNT EXIST				
		if ($field["editable"] == "false") {

			$val = &$values["values"];					
			$k = $field["name"];

## not sure if this is okay
			if (!isset($val[$k])) {
				$val[$k] = $field["value"];
			}
			

			if (is_string($field["fields"])) {
				$supp_fields = array("month" , "year" , "month_str", "day");

				$_tmp_v = "";


				foreach ($supp_fields  as $__k => $__v) {
					switch ($__v) {
						case "month_str":
							$_tmp_v[$__v] = $form_months[$val[$k . "_month" ]];
						break;

						case "day":
							$_tmp_v[$__v] = sprintf("%02d" ,$val[$k . "_day" ]);
						break;

						case "year":
							$_tmp_v[$__v] = sprintf("%02d" ,$val[$k . "_year" ]);
						break;
					}										
				}

				$current_field = $field["fields"];
				foreach ($_tmp_v as $__k => $__v) {
					$current_field = str_replace($__k , $__v , $current_field);									
				}									

			} else {

				if (isset($val[$k . "_month" ]) && isset($val[$k . "_day" ]) && isset($val[$k . "_year" ])) {
					$current_field = 
										( $val[$k . "_month" ] ? sprintf("%02d" ,$val[$k . "_month" ])  : "--" ). "/" . 
										( $val[$k . "_day" ] ? sprintf("%02d" ,$val[$k . "_day" ]) : "--" ) . "/" .  
										( $val[$k . "_year" ] ? $val[$k . "_year" ] : "----" )  . "&nbsp;&nbsp;" . 
					
										($val[$k . "_hour"] && $val[$k . "_minute"]  ? $val[$k . "_hour"] . ":" . $val[$k . "_minute"] : "");
				} else {
					$current_field = $val[$k] > 1000 ? date(($field["params"] ? $field["params"] : "m/d/Y") , $val[$k]) : "not available";
				}				
			}
		} else {			
			if (is_array($field["fields"])) {

				$html = new CHtml;

				//do some variables cleaning
				if (is_array($years))
					unset($years);
				if (is_array($days))
					unset($days);
				if (is_array($months))
					unset($months);
			
				$date_vals = &$values["values"][$field["name"]];
				//try to do a small trick with default values
				if (($date_vals < 1000) && isset($field["value"])) {
					$date_vals = $field["value"];
				}
				
				if (($date_vals > 1000) || (isset($values["values"][$field["name"] ."_year"]) || isset($values["values"][$field["name"] ."_month"]) || isset($values["values"][$field["name"] ."_day"]))) {

					//setting the previous values
					$year_selected = isset($values["values"][$field["name"] ."_year"]) ? $values["values"][$field["name"] ."_year"] : @date("Y" , $date_vals );
					$month_selected = isset($values["values"][$field["name"] ."_month"]) ? $values["values"][$field["name"] ."_month"] : @date("n" , $date_vals );
					$day_selected = isset($values["values"][$field["name"] ."_day"]) ? $values["values"][$field["name"] ."_day"] : @date("j" , $date_vals );

					//crap, adding the time values too
					$hour_selected = isset($values["values"][$field["name"] ."_hour"]) ? $values["values"][$field["name"] ."_hour"] : @date("G" , $date_vals );
					$minute_selected = isset($values["values"][$field["name"] ."_minute"]) ? $values["values"][$field["name"] ."_minute"] : @date("i" , $date_vals );
					$second_selected = isset($values["values"][$field["name"] ."_second"]) ? $values["values"][$field["name"] ."_second"] : @date("s" , $date_vals );

				} else {

					$fld = $field["fields"];

					//setting the default value 						
					$year_selected = $fld["year"]["default"] == "now" ? date("Y") : $fld["year"]["default"];
					$month_selected = $fld["month"]["default"] == "now" ? date("n") : $fld["month"]["default"];
					$day_selected = $fld["day"]["default"] == "now" ? date("j") : $fld["day"]["default"];

					//crap, adding the time values too
					$hour_selected = $fld["hour"]["default"] == "now" ? date("G") : $fld["hour"]["default"];
					$minute_selected = $fld["minute"]["default"] == "now" ? date("i") : $fld["minute"]["default"];
					$second_selected = $fld["second"]["default"] == "now" ? date("s") : $fld["second"]["default"];						
				}						

				if ($field["calendar"] == true) {
					$current_field = $this->templates->blocks["Calendar"]->Replace(array(
						"name" => $field["name"],
						"value" => mktime(1,1,1,$month_selected, $day_selected , $year_selected),//$field["value"],
						"value_day" => $day_selected,
						"value_month" => $month_selected,
						"value_year" => $year_selected,
						"form" => $form["name"]
					));
				} else {
				
					foreach ($field["fields"] as $key => $val) {
						switch ($key) {
							case "year":
								if ($field["fields"]["year"]["empty"] == "true") {
									$years[0] = "--" ;
								}
								
								for ($i = $field["fields"]["year"]["from"] ; $i <= $field["fields"]["year"]["to"] ; $i++ )
									$years[$i] = $i;									

								$current_field .= $html->FormSelect(
																		$field["name"]."_year" , 
																		$years , 
																		$this->templates , 
																		"DateSelect", 
																		$year_selected , 
																		array() , 
																		array("DISABLED" => ($field["fields"]["year"]["editable"] == "false") ? "DISABLED" : "")									
																	);

								$current_field .= $val["separator"];
							break;

							case "day":
								if ($field["fields"]["day"]["empty"] == "true") {
									$days[0] = "--" ;
								}

								for ($i = 1 ; $i <= 31 ; $i++ )
									$days[$i] = sprintf("%02d",$i);

								$current_field .= $html->FormSelect(
																		$field["name"]."_day" , 
																		$days , 
																		$this->templates , 
																		"DateSelect", 
																		$day_selected,
																		array() , 
																		array("DISABLED" => ($field["fields"]["day"]["editable"] == "false") ? "DISABLED" : "")
																	);
								$current_field .= $val["separator"];
							break;

							case "month":
								if (($field["fields"]["month"]["empty"] == "true"))  {
									$months[0] = "--" ;
								}

								//importing the months from global
								global $form_months;

								if (is_array($months))
									$formmonths = array_merge($months, $form_months);
								else
									$formmonths = $form_months;

								//ehcking if the dates must apear like strings or numbers
								$current_field .= $html->FormSelect(
																		$field["name"]."_month" , 
																		$formmonths, 
																		$this->templates , 
																		"DateSelect", 
																		$month_selected,
																		array() , 
																		array("DISABLED" => ($field["fields"]["month"]["editable"] == "false") ? "DISABLED" : "")
																	);

								$current_field .= $val["separator"];
							break;

							case "hour":
								for ($i = 0; $i <= 23; $i++ )
									$hours[$i] = sprintf("%02d",$i);;									

								$current_field .= $html->FormSelect(
																		$field["name"]."_hour" , 
																		$hours , 
																		$this->templates , 
																		"DateSelect", 
																		$hour_selected , 
																		array() , 
																		array("DISABLED" => ($field["fields"]["hour"]["editable"] == "false") ? "DISABLED" : "")									
																	);

								$current_field .= $val["separator"];
							break;

							case "minute":
								for ($i = 0; $i <= 59; $i++ )
									$minutes[$i] = sprintf("%02d",$i);;									

								$current_field .= $html->FormSelect(
																		$field["name"]."_minute" , 
																		$minutes , 
																		$this->templates , 
																		"DateSelect", 
																		$minute_selected , 
																		array() , 
																		array("DISABLED" => ($field["fields"]["minute"]["editable"] == "false") ? "DISABLED" : "")									
																	);

								$current_field .= $val["separator"];
							break;

							case "second":
								for ($i = 0; $i <= 59; $i++ )
									$seconds[$i] = sprintf("%02d",$i);;									

								$current_field .= $html->FormSelect(
																		$field["name"]."_second" , 
																		$seconds , 
																		$this->templates , 
																		"DateSelect", 
																		$second_selected , 
																		array() , 
																		array("DISABLED" => ($field["fields"]["minute"]["editable"] == "false") ? "DISABLED" : "")									
																	);

								$current_field .= $val["separator"];
							break;

						}						
					}					
				}
			}				
		}

		return $current_field;
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
	function __field__creditcard($field , $values) {
		//crap prepare the values
		if (is_array($values["values"][$field["name"] . "_arr"])) {
			//okay, here are the data
			$field["value_group_1"] = $values["values"][$field["name"] . "_arr"]["1"];
			$field["value_group_2"] = $values["values"][$field["name"] . "_arr"]["2"];
			$field["value_group_3"] = $values["values"][$field["name"] . "_arr"]["3"];
			$field["value_group_4"] = $values["values"][$field["name"] . "_arr"]["4"];
		} else {

			switch ($field["show"]) {

				case "blank":
					$field["value_group_1"] = ""; 
					$field["value_group_2"] = "";
					$field["value_group_3"] = "";
					$field["value_group_4"] = "";
				break;

				case "none":
					$field["value_group_1"] = $field["editable"] == "false" ? "xxxx" : "";
					$field["value_group_2"] = $field["editable"] == "false" ? "xxxx" : "";
					$field["value_group_3"] = $field["editable"] == "false" ? "xxxx" : "";
					$field["value_group_4"] = $field["editable"] == "false" ? "xxxx" : "";
				break;

				case "last":
					$field["value_group_1"] = $field["editable"] == "false" ? "xxxx" : "";
					$field["value_group_2"] = $field["editable"] == "false" ? "xxxx" : "";
					$field["value_group_3"] = $field["editable"] == "false" ? "xxxx" : "";
					$field["value_group_4"] = substr($field["value"],12,4);
				break;

				default:
					$field["value_group_1"] = substr($field["value"],0,4) ;
					$field["value_group_2"] = substr($field["value"],4,4);
					$field["value_group_3"] = substr($field["value"],8,4);
					$field["value_group_4"] = substr($field["value"],12,4);
				break;
			}
			
		}
		
		$this->templates->blocks[$field["editable"] == "false" ? "cc_show" : "cc"]->Replace($field , false);
		$current_field = $this->templates->blocks[$field["editable"] == "false" ? "cc_show" : "cc"]->EmptyVars();
		return $current_field;
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
	function __field__namesort(&$field , &$values) {
		global $base;

		switch ($field["content"]) {
			case "alphanumeric":
			case "digits":
				for ($i = 0; $i<= 9; $i++) {
					$content[] = array("name" => $i , "link" => "javascript:document.forms[" . ($form["name"] ? "'" .$form["name"] . "'": '0') . "].{$field[name]}.value='" . $i. "'");							
				}

				if ($field["content"] == "digits")						
					break;
				
			case "letters":
				//65
				for ($i = 65; $i<= 90; $i++) {
					$content[] = array("name" => chr($i) , "link" => "javascript:document.forms[" . ($form["name"] ? "'" .$form["name"] . "'": '0') . "].{$field[name]}.value='" . chr($i). "'");							
				}
			break;
		}

		if (is_array($content)) {
			$current_field = $base->html->table(
					$this->templates,
					"namesort",
					$content
				);
		}
		return $current_field;
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
	function __field__calendar($field , $values) {

		$calendar_fields = array(
				"inputField" => '"field_' . $field["name"] . '"',
				"ifFormat" => '"{DATE}"' ,
				"date" => '{DATE}' ,
				"button" => '"field_' . $field["name"] . '_trigger"',
				"align" => '"Br"',
				"singleClick" => 'true',
				"range" => "[" . date("Y") . "," . (date("Y") + 10). "]",
				"boxsize" => "10"
		);


		//check for variables from client
		if ($field["calendar"]["time"] == "true") {
			$calendar_fields["showsTime"] = "true";
			$calendar_fields["ifFormat"] = "'{DATE} %H:%M'";
			$calendar_fields["date"] = "{DATE} H:i";
			$calendar_fields["boxsize"] = 16;
		}

		if ($field["calendar"]["range"]) {
			$tmp = explode(":" , $field["calendar"]["range"]);
			$calendar_fields["range"] = "[" . trim($tmp[0]) . "," . trim($tmp[1]) . "]";
		}

		if ($_CONF["settings"]["locale"] == "eu"){
			$calendar_fields["ifFormat"] = str_replace("{DATE}" , '%d/%m/%Y' , $calendar_fields["ifFormat"]);
			$calendar_fields["date"] = str_replace("{DATE}" , 'd/m/Y' , $calendar_fields["date"]);
		} else {
			$calendar_fields["ifFormat"] = str_replace("{DATE}" , '%m/%d/%Y' , $calendar_fields["ifFormat"]);
			$calendar_fields["date"] = str_replace("{DATE}" , 'm/d/Y' , $calendar_fields["date"]);
		}

		if ($field["calendar"]["style"])
			$calendar_fields["style"] =  $field["calendar"]["style"];

		if ($field["value"] > 1000)
			$field["value"] = date($calendar_fields["date"] , $field["value"]);
		else
			$field["value"] = "";


		if ($field["editable"] == "false") {
			$current_field = $this->templates->blocks["text"]->Replace($field);
		} else {				
			$size = $calendar_fields["boxsize"];
			unset($calendar_fields["boxsize"]);
			unset($calendar_fields["date"]);
			//process the calendar_fields
			$tmp = array();
			foreach ($calendar_fields as $c_key => $c_val) {
				$tmp[] = "\t\t" . $c_key . ":" . $c_val;
			}
							
			$current_field = $this->templates->blocks["calendar"]->Replace(
					array_merge(
						$field ,
						array(
							"_params" => implode(",\n" , $tmp),
							"boxsize" => $size
						)
					),
					FALSE
			);
		}
		return $current_field;
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
	function __private_uploads_pre($field , $_fields = array()) {
		global $_CONF , $base;

		$key = $field["name"];
		$val = $field;

		//checking how choosed the client to set the image
		switch ($_POST[$key . "_radio_type"]) {
			case 0:
				//checking if the client specified any image type
				if (is_array($_FILES[$key . "_upload_client"]) && is_uploaded_file($_FILES[$key . "_upload_client"]["tmp_name"])) {									
					$img = &$_FILES[$key . "_upload_client"];

					//generate the extension
					$_POST[$key . "_ext"] = FileExt($_POST[$key . "_temp_file"]);

					//temporary upload the file in images/upload/tmp/
					$name = $_POST[$key . "_temp"] != "" ? $_POST[$key . "_temp"] : $key . $val["file"]["default"] . time() . $val["file"]["ext"];	

					// generate the tn image

					if ($val["process"]) {
						$base->image->Resize(
												$img["tmp_name"] ,
												//$_CONF["path"] . $_CONF["upload"] . "tmp/" . $name ,
												$_CONF["path"] . $_CONF["upload"] . "tmp/" . $name,
												$val["process"]["width"], strtoupper($val["process"]["force"]) , 
												null , 
												null , 
												null, 
												null , 
												$val["process"]["quality"] ? $val["process"]["quality"] : null , 
												null, 
												$val["process"]["watermark"],
												$val["process"]["height"]
											);
					} else 
						//dont use move uploaded file becouse will erase it and wont be available fro processing											
						@copy($img["tmp_name"] , $_CONF["path"] . $_CONF["upload"] . "tmp/" . $name );

					$_file_name = $img["tmp_name"];

					/*DEPRECATED*/
					if ($val["tn"]["generate"] == "true") {
						$base->image->Resize(
												$img["tmp_name"] ,
												$_CONF["path"] . $_CONF["upload"] . "tmp/" . $val["tn"]["preffix"] . $name ,
												$val["tn"]["width"]
											);
						$_POST["tn_" . $key] = "1";
					}
					
					//setting read/delete/save permission for all users, usefull if the httpd is working as normal user ( most cases )
					chmod ($_CONF["path"] . $_CONF["upload"] . "tmp/" . $name , 0777);
//										die;
					//setting the temp variable
					$_fields["values"][$key . "_temp"] = $name;
					$_POST[$key . "_temp"] = $name;
					//$_POST[$key . "_file"] = $_FILES[$key . "_upload_client"]["name"];
					$_POST[$key] = "1";										

					@$size = getimagesize($_CONF["path"] . $_CONF["upload"] . "tmp/" . $name);

					if (is_array($size)) {
						$_POST[$key . "_width"] = $size[0];
						$_POST[$key . "_height"] = $size[1];
					}


				}								
			break;

			case "1":
				//fuck, the guy wants to download a fucking image

				if ($_POST[$key . "_upload_web"] != "http://") {										
					//i have to be very carefully here, if the image is not a valid link, then 
					//everithing get messed.
					$image = @GetFileContents($_POST[$key . "_upload_web"]);
					
					$name = $_POST[$key . "_temp"] != "" ? $_POST[$key . "_temp"] : $key . $val["file"]["default"] . time() . $val["file"]["ext"];

					SaveFileContents( $_CONF["path"] . $_CONF["upload"] . "tmp/" . $name , $image);
					chmod ($_CONF["path"] . $_CONF["upload"] . "tmp/" . $name , 0777);

					if ($val["process"]) {
						$base->image->Resize(
												$_CONF["path"] . $_CONF["upload"] . "tmp/" . $name ,
												$_CONF["path"] . $_CONF["upload"] . "tmp/" . $name . "resize" ,
												$val["process"]["width"],
												strtoupper($val["process"]["force"])
											);
						unlink($_CONF["path"] . $_CONF["upload"] . "tmp/" . $name);
						rename($_CONF["path"] . $_CONF["upload"] . "tmp/" . $name . "resize" , $_CONF["path"] . $_CONF["upload"] . "tmp/" . $name);

					}


					
					$_file_name = $_CONF["path"] . $_CONF["upload"] . "tmp/" . $name ;


					// generate the tn image
					if ($val["tn"]["generate"] == "true") {
						@$base->image->Resize(
												$_CONF["path"] . $_CONF["upload"] . "tmp/" . $name ,
												$_CONF["path"] . $_CONF["upload"] . "tmp/" . $val["tn"]["preffix"] . $name ,
												$val["tn"]["width"]
											);

						$_POST["tn_" . $key] = "1";
					}



					//setting the temp variable
					$_fields["values"][$key . "_temp"] = $name;
					$_POST[$key . "_temp"] = $name;
					//$_POST[$key . "_file"] = basename($_POST[$key . "_upload_web"]);
					$_POST[$key] = "1";

					@$size = getimagesize($_CONF["path"] . $_CONF["upload"] . "tmp/" . $name);

					if (is_array($size)) {
						$_POST[$key . "_width"] = $size[0];
						$_POST[$key . "_height"] = $size[1];
					}

				}

			break;

			case "-1":
//									echo "<pre style=\"background-color:white\">";
//									print_r($_POST);
//									die;
				//trying to remove the tmp image is exists
				if (file_exists($_CONF["path"] . $_CONF["upload"] . "tmp/" . $_POST[$key . "_temp"]) && is_file($_CONF["path"] . $_CONF["upload"] . "tmp/" . $_POST[$key . "_temp"]))
					@unlink($_CONF["path"] . $_CONF["upload"] . "tmp/" . $_POST[$key . "_temp"]);										
				//removing the original image too if exists
				else
					@unlink($_CONF["path"] . $_CONF["upload"] . $val["path"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"]);

				$_fields["values"][$key . "_radio_type"] = 0;

				$_POST[$key] = 0;
				$_fields["values"][$key . "_temp"] = "";
				$_POST[$key . "_temp"] = "";
				//$_POST[$key . "_file"] = "";
			break;

		}

		if ($field["type"] == "image") {
		
			//hm ... checking if that IS A REAL IMAGE
			if ($_POST[$key . "_temp"] && !$file) {
				
				$img = @GetImageSize($_CONF["path"] . $_CONF["upload"] . "tmp/" . $_POST[$key . "_temp"]);

				if (!is_array($img)) {

					//removing the image, maybe in future return the fucker a proper answer
					//echo "MOHHHHH";
					@unlink($_CONF["path"] . $_CONF["upload"] . "tmp/" . $_POST[$key . "_temp"]);
					$_POST[$key . "_temp"] = "";
					$_POST[$key] = 0;
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
	function __private_uploads_after($field) {
		global $base, $_CONF;

		$val = $field;
		$key = $field["name"];

		//process for cropping			
		$crop = $_POST[$key . "_crop_oxbc"];

		if ($crop) {		

			$tmp_img = explode(":" , $crop);

			$width = $tmp_img[0];
			$height = $tmp_img[1];

			$x = $tmp_img[2];
			$y = $tmp_img[3];

			$c_width = $tmp_img[4];
			$c_height = $tmp_img[5];

			$source = $tmp_img[6];

			$image_data = getImageSize($source);

			$image = new CImage();


			//check if the image isnt set to be proportional
			if (!$width && !$height) {
				$width = $c_width;
				$height = $c_height;
			}
				
			//if the image its at the correct size, dont touch it
			if (($image_data[0] == $c_width) && ($image_data[1] == $c_height) && ($width == $c_width ) && ($height == $c_height)) {

			} else {
				//check if i need to resize just based on one dimension
				if ($width || $height) {

					if (!$width && $height) {
						$width = $c_width * ($height / $c_height );
					} else {

						//check if no height
						if ($width && !$height) {
							$height = $c_height * ($width / $c_width );
						}
					}

				} else {

					// i have no width or crop so i need to generate them
					$width = $c_width;
					$height = $c_height;
				}
							
				$image->CCrop(
					$source,
					$source . ".jpg", 
					$width,
					$height,
					$x,
					$y,
					$c_width,
					$c_height
				);


				unlink($source);
				rename($source . ".jpg" , $source);
			}

		}

		$source = $_CONF["path"] . $_CONF["upload"] . "tmp/" . $_POST[$key . "_temp"];
		$destination = $_CONF["path"] . $_CONF["upload"] . $val["path"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"];


		if (!is_file($source))
			return false;


		if ($_POST[$key . "_temp"]) {
			$_POST[$key . "_file"] = $_POST[$key . "_temp_file"];
		}
		
		
		//moving the image stored in temp variable
		//check if the file already exists
		if (is_file($destination)) {
			@unlink($destination);
		}

		@copy(
			$source ,
			$destination
		);	

		//check the permission
		@chmod ($destination , 0777);

			// generate the tn image
			if ($val["tn"]["generate"] == "true") {
				@rename(
					$_CONF["path"] . $_CONF["upload"] . "tmp/" . $val["tn"]["preffix"] . $_POST[$key . "_temp"] ,
					$_CONF["path"] . $_CONF["upload"] . $val["path"] . $val["tn"]["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"]
					);	

			}
		
		if (is_array($val["thumbnails"])) {
			foreach ($val["thumbnails"] as $__k => $__thumbnail) {											

				@unlink($_CONF["path"] . $_CONF["upload"] . $val["path"] . $__thumbnail["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"]);											

				if ($__thumbnail["crop"] == "true") {

					//check if i have sizes for resizing
					if (!$__thumbnail["width"] && !$__thumbnail["height"]) {
						@copy(
							$source ,
							$_CONF["path"] . $_CONF["upload"] . $val["path"] . $__thumbnail["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"]
						);	
					} else {					
						@$base->image->Crop(
							$source,
							$_CONF["path"] . $_CONF["upload"] . $val["path"] . $__thumbnail["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"],
							$__thumbnail["width"], 
							null, 
							null, 
							null, 
							null, 
							null,
							null,
							$__thumbnail["quality"] ? $__thumbnail["quality"] : null , 
							$__thumbnail["watermark"],
							$__thumbnail["height"]
						);
					}

					chmod($_CONF["path"] . $_CONF["upload"] . $val["path"] . $__thumbnail["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"] , 0777);

				} else {

					//check if i have sizes for resizing
					if (!$__thumbnail["width"] && !$__thumbnail["height"]) {
						copy(
							$source ,
							$_CONF["path"] . $_CONF["upload"] . $val["path"] . $__thumbnail["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"]
						);	
					} else {					

						@$base->image->Resize(
							$source ,
							$_CONF["path"] . $_CONF["upload"] . $val["path"] . $__thumbnail["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"],
							$__thumbnail["width"], 
							null, 
							null, 
							null, 
							null, 
							null,
							null,
							$__thumbnail["quality"] ? $__thumbnail["quality"] : null , 
							$__thumbnail["watermark"],
							$__thumbnail["height"]
						);
					}

					chmod($_CONF["path"] . $_CONF["upload"] . $val["path"] . $__thumbnail["preffix"] . $val["file"]["default"] . $_POST[$val["file"]["field"]] . $val["file"]["ext"] , 0777);
				}
			}
		}
		//setting the image as true			
		//remove the tmp image
		@unlink($source);


		$_POST[$key] = 1;
		return true;
	}
	
}

/*

History
v0.1
		Added support for flash cropper
		Added support for flash uploader
		Moved all elements in its own function
		Removed the decodeentities from description for form->editelement
v0.0.13
	Unreleased
		Added multiple tables for relation type from simple list and drawelement		
		Changed DrawElement its now split in functions for each element type		
	

v0.0.12
	Monday 02 June 2008
		Added doubleselect or double=true to droplist element
		Added exists=true to validate forms, opposite of the unique=true
		Added errors code to the validate errorCode = 1..5 and the defined constants
		Added type="calendar" to SimpleForm(); 
				<cal default="eval:time();" type="calendar" title="Publish Date">
					<calendar
						time="true"
						align="Bl"
						range="from:to"
						style="us|eu"
						
						[..] all params supported by the calendar
					/>
				</cal>
		Added eval:php function to the default="eval:time()"
		Added ProcessItems function
		Added crop=true to thumbnails, requieres the last library of images.
		Added support for simplelist->relation->multi=true when values are from <options>
		Added support for usstates / states / castates and rostates 
		Added support for multiple records in categories / (ro|ca|us states)
		Changed store record to use CForm:ProcessVariables
		Full php 5 compatible

#EXPERIMENTAL
		Changed the htmlentties in text elements and simple list in order to show the special chars romanian , french etc. so now if you have
		<p> inside the field it will be parsed as html it wont appear the code anymore.
#

		Fixed recognition of empty=true and value=0 for droplists and related
		Fixed droplists with multilevel for php5
		Fixed Calendar default date if not valid
		Fixed automatic url genration for text fields in details mode
		Fixed variables transmision over the search pages
		Fixed sql cacheing for simple list
		Deprecated alternance=true for editable forms, its my default now

v0.0.11
	Wensday 1 August 2007

### BUG PHONE VALID ISNT WORKING RIGHT I:X:X now is A:X:X
		Added restricted="eval:.." to form edit, tabs, simplelist for dinamicaly limitations.
		Added referers="field1,field2" as an alias to <referers>.... to Form. also the refereed fields are automaticaly be marked as been refered.
		Added timezones field for show.
		Added multi=true for relation fields to SimpleList
		Added nolinks=true to SimpleList <header> 
		Added nobr=true for text fields in show form
		Added "self.conf.url" to CForm::GlobalVars()
		Added IN ( similar for WHERE x in () for seach/sql_fields )
		Added storeredirect=STOREDETAILS it will redirec to details page for add and edit.
		Added simplelist-type="image" tooltip text title=""
		Added alternance and valternance to simplelist
		Added $this->_set_nochecks to sql admin for the cases when i update a few fields and i dont want he checkboxes to be reseted ( must be set from the php only )
		Added height to <image / <process, if height isnt then will be ignored

		Changed simplelist <header> if no se the gray part wont appear
		Changed simplelist <image to acced othe links then enlarge image ones
		
		Fixed image height and adminheight, if exists the image will be force to the certain height if not the proportion will be kept
		Fixed checkbox when in displaymode added both values label="<true_val>|<false_val>"
		Fixed type="usstates" , empty droplist
		Fixed IN_SET if no value specified it wont appears
		Fixed template problem for php5 for the search sections
		Fixed various array_merge warnings for php5
		Fixed simplelist->relation cache to avoid douplicate queries.
		Fixed various imcompatibilities with php5.1
		Fixed alternance="true" for DrawElement()
		Fixed droplist default text in noneditable mode.
		Fixed Search Header, acceptsn emtpy headers now to be transmited simplelist		
		Fixed validatevars for imgCHECK element.
		Fixed showing error for validate routing for mutiple droplist.
		Fixed an older date fix for mktime
		Fixed $extra[<D|a|e>]["fields"]...
		Fixed appearing of the default image in simple list.
		Fixed SHOW::<section> to remove the after_save field

		NOTE changed the header to match to OX and current year

v0.0.10
	Wensday 8 November 2006 
		Added IN_SET ( for seach/sql_fields alias to FIND_IN_SET - sql function )
		Added maxchars_text to SimpleList fields
		Added color="fg:bg" to SimpleList fields
		Added font="b,u,i" BOLD, UNDERLINE, ITALIC
		Added ordering to all columns in simple list
		Added radio w/ alias radiolist for droplist
		Added checklist for droplists w/ multi = true
		Added ID to button
		Added editable = false to all types
		Added phone field (xxx-xxx-xxxx) to show form, sql, admin, validate, size="box1size,box2size,box3size"
		Added html_entities_decode attribute to text tag
		Added onclick='' to checkbox
		Added editable=false to checkbox
		Added nolink=true to simpllist/image to remove the link from the image. Also added border=x
**		Added multi='true', default='select1,select2' size='xrows' for multiple selects
		Added all javascript events to all elements

**		Fixed multi=true for checlist in sqladmin
		Fixed ProcessVars _arr when nonarray vars passed then dont process it
		Fixed empty options
		Fixed password confirmation in CFORM::Validate()
		Fixed loose of original value in simplelist when link= is used
		Fixed phone showing when phone_arr isnt array
		Fixed sqladmin returnurl when the variable contaigns no / char.
	
		Changed refered elements, referer="true" became referer="refering_field", needed for validation
		Changed simple list query type. When empty build an <sql> group and execute as requested.
		Changed validate="" if the field is filled and validate exists it will be validated even if required=false

		Rewrited the droplist and related subroutine
		Removed subtypes from droplist

v0.0.9
	Tuesday 3 January 2006 
		Removed the showpassword button from password type and added show="true" for showing it
		Changed droplists <dynamic> to support descendendt numbers 2005-1900
		Changed the description for the fields from editable pages to support content from external files, html or not.
		Added checkIMG tag ( enter the text from image in the box to can submit the form ) it works w/ local/after.forms.private.php
		Added nobr=true attribute to the simple list fields
		Added romanian states as ROstates, editable=false and usetext to use the text instead of the shornames for droplists
		Added new class CFormSettings, usefull for the settings elements.
		Added more usefulll variables to globalvars self.linkuid.add/delete...edc delete in section.xml for each $_GET[sub],
			self.action, and doing variables replaces in the global vars too
		Added after_save tag usefull when you need to add many records, avoids click every time on "add"
		Added default tag for simplelist fields (LATER MAKE IT COMPLEX ( eval etc )) 
		Added support for comment elements to get the text from the $values is is set.
		Added urilink in the main sqladmin xml file.
		Added <help file="help/cvv2.html" location="module" type="popup"/> ( popup w/ help for form fields )
		Remove the buttons from the html editor no need of it as far, will be redone in future
		Fixed the mysql error when no tables and db are passed to the object
		Fixed the returnurl when the variable wasnt in lower case for Editable forms.
		Fixed the variable name from vars when the name was the same with the ones from the fields
		Fixed align atribute for the comment elements
		Fixed sqladmin move_uploaded_files to copy.
		TO ADD ident to collapse

v0.0.7
	Saturday 3 September 2005
		Added link feature to simplelist fields.
		Added new preexisted variables, organized them in one function instead of all over the code:
			self.file, self.mod, self.sub, self.action, self.var.mod, self.var.sub, self.var.action, self.uid, 
			self.uidvar, self.link, self.linkuid, self.location, self.title, self.previous, self.previous_enc
		Changed the extended element not to show the title when it is missind, template altration too
		Added SIMPLE LIST: sql->vars->table type supports the import param, to get other tables from $this->tables
		Added date / editable = false, it already knows about the params m/d/Y if not set the user ones.	
		Fixed date apearing when the main field was empty and the _month _day _year exists
		Fixed the checkbox autofill
		Fixed the subtitle apearance when no buttons are defined in Edit Form
		Various bug fixes

v0.0.6
	Sunday 3 May 2005 ( one of the most important days :) )
		Added collapse option for simple list
		Added Canada states CAstates type.
		Added denyhtml to textarea, not to htmlentities the text from it.
		Added storeredirect=ADDDETAILS, when a new field is added to db, then the browser is redirected to the record details instead of HTTP_REFERER, this is usefull for the cases when
			you add a record, then you have to add some subrecord to that, and insted of ADD->STORE->LIST->DETAILS will be ADD->STORE->DETAILS. Smmother navigation.
		Added protected="table_field" for list buttons and for FormFields, if 1 then the fields will not apear, if showprotected=true then the fields will apear as text, not editable.
		Added complex_eval type, the return isnt put in the $tpl_var, so now we can have complex phpcode there :) >:)
		Added easy navigation variables, autogeneration of returnurl input field, PRIVATE.prev page and PRIVATE. action title varibales.
		Added align option for text fields
		Added allownl=true in simple list header
		Added [html][pre] to form generator
		Added comment tag in forms
		Added fileexists=true to Validate
		Added option to load/save the values from/to text files
		Added editable=flase to date field
		Added default value to text field
		Added <vars> to Simple list
		Added time to date field
		Added eval in all default values
		Added state field
		Added countries field
		Added pre and after for Simple List
		Added upload fild, extended the image field
		Added price action to text field in edit forms
		Added page type for sql vars in simple list
		Added form type for sql vars in simple list
		Added support for tree droplist in relation field ( not editable one )
		Added CURRENT_PAGE variable in simple list pages
		Added confirmation page for deleting items when rconfirm=true title and description are the variables

		Changed [html] to support extern files
		Fixed paging return url, when jumping from page to page the url encode was lost
		Fixed the slash problem in the database, now handling the slashed directly from the database
		Fixed global vars replacing in links
		Fixed the uniq=true in edit mode
		Fixed the path in CSQLAdmin path
		Fixed buttons values ( now checking if value="true" instead of is_set($value) )
		Fixed pagging count
		Fixed Comment field templates lossing
		Fixed vars replacing in form acction
		Fixed saving/reading external files content
		Fixed the template global vars in simple list
		Fixed tree droplists / saving and showing
		Fixed date incompatibility with Windows OS
		Fixed server_referer when the browser is redirected using javascript ( in delete operations )
		

		Various bug fixes

v0.0.5
	Saturday 1 May 2004
		Added alternance to drawelement function
		Added <subtitle> to Simple List, it apears on the bar wiht the buttons and search box
		Added extra content after each element $extra["fields"]["field_name"] in CForm and $extra["edit|add|details"]["fields"]["field_name"] in CSQLAdmin
		Added extra content to pre and after form content $extra["pre|after"] in CForm and $extra["edit|add|details"]["pre|after"] in CSQLAdmin
		Added <html tag to textarea and a first alhpa of html editor.
		Added support to configure the buttons to apear in html editor
		Added suffix and preffix to SimpleList elements.
		Added subtitle element.
		Added html|pre|and after form in Show
		Added html|pre|and after form in SimpleList
		Added javascript|pre|after in Show
		Added "disabled" option to droplist's options
		Added relation type and editable=false to droplists
		Fixed the buttons variables if no <buttons tag exists
		Fixed the SimpleList is the <items is missing
		Fixed the problem when is a referer or multiple to an element which doesnt exist
		Fixed the preffix and suffix order in DrawElement		
		Fixed the images field, for uploading
		Fixed tn generation.

v0.0.4
	Monday 29 March 2004
		Added referer option to elements, now you can have more then one "input" on the same element
		Added multiple option to elements
		Added the <condition ,<order and <ordermode tags to droplist/relations, to select only a custom number of records from db
		Added the preffix and suffix to fields $ [___] (USD)
		Added PRE and AFTER form javascript code
		Added ONCHANGE to droplist
		Added elements count _COUNT to list form
		Added options to list form, future will be added the relations
		Description gets a html_entity_decode before showing
		Changed the saving part to detect if the <table_uid> is set = edit else = add
				
v0.0.3
	Wensday 24 March 2004
		Moved SimpleList from sqladmin in forms class
		Added image element to SimpleList
		Added date element to SimpleList	
		Instead of $form array the data can be a path to a xml file
		The template is passed to sql admin, no longer loading from generic_form

v0.0.2
	Tuesday 16 March 2004
		Fixed, add/edit SQL query.

	Sunday 14 March 2004
		Added search support for list section.
		Added header titles to list section.
		Fixed the buttons apearance in list. ( they dont apear broken anymore )
		Added upload/resize/efects image form to forms library, FUCK loosing the image if the forms isnt complety
		validated from first time.
		Added html editor to forms library.		
		Fixed the image loosing when the form wasnt validated.
		Added the download from web image.

v0.0.1
	Wensday 3 March 2004 
		First version with basic options, edit, list, add.

*/

/*


FIELD STRUCTURE // edit/add/details


//forms, crappy, but this is the only file to remember how this crap works.

<form> //all files must start and end with this tag	

	//		<msg field="link_id" field-type="textbox" field-sub="link_order" field-id="link_id" field-value="link_order" align="center" field-size="35" field-align="right" header="Order" width="40" type="field"/>


		<check type="checkIMG" src="register.php?security" required="true" validate="A:8:8">
			<title>Security Code</title>
			<description>Enter the text from the image in the box bellow. The text is CASE SENSITIVE.</description>
		</check>



	//for simple list
	<collapse enable="true" id="project_milestones" default="false" cookie="true"/>

	<title></title> //the title of the form, it ususaly apear in the top of the html table.
	<action></action> // the link where the data will be posted
			  //specials type = add , new data is ready to be added, edit = its a simple edit operation

	<name></name>	  // the name of the html form <form name="..."
	<widht><width>	  // the width of the form ( the html block )

	<formtag><formtag> // if true then the <form action ... will be added
	<border></border>  // if true then the border , which contaign the title and the <form tag

	
	<buttons> //define what buttons to apear in form, and where
		<set>
			<footer></footer> //if true then all buttons will apear in footer
			<header></header> //if true then all buttons will apear in header
					  // if both are set then the buttons apears in both places	
		</set>
		
		<button>
			<onclick></onclick> // javascript content which to be execudet at onclick event
			<button></button>   // the name of the button, i dont acctualu see the point to havbe the same as tag
					    // the image with the name button_{button}.gif will be showed for it, this depending
					    // of the javascript code which draws the button.
			<location></location> // where to go when the button is pressed, like <a href="location" ...
		</button>
		[...]
		// the rest of the buttons
	</buttons>

	<fields> // the list of the fields which will apear on page

		<field_name>	//the name of the fields exactly how it is in the database
			<name></name>  // in case you want to use the same tag for all fields <field ... you have to specify the 
				       // name of the field ( drom the database table))
			<type></type>  // what type the field is, avaible types listed bellow
					  hidden, - the field will not apear visual, will be just a hidden input
					  textbox
					  droplist
					  image
					  droplist
					  checkbox
					  html
					  textarea
					  radio
					  text
					  button

			<alternance>true</alternance> //alternate 2 colors for table rows

			<size></size> // the size of the field, it can have diferent semnifications depending of the field type
					X:Y and the type is textarea means the cols="x" and rows="y"
					S:M and type type is textbos means the size="s" and maxlength="m"

			<unique></unique> // if is true then the the database will be searched for duplicate names
			<unique_err></unique_err> // what error to be displayed to user in case there are duplicates

			<referer></referer> //if true then the field will apear in combination with other field, the title and 
					      the description will be ignored then, still having problems at validation
					      ex: Name: [________] [_______]
			
			<required></required> // if is true, then the field will be required
			<validate>A:3:20</validate> // the validation formula which will be used
						       A = the type, can be A, Z, I, ... see the common,php for all 
						       3 = the min allower chars
						       20 = the maximum number of chars allowed

						       NOTE: even if required is false, if any text is presend the it twill be validated

			<title></title> // the title of the field which will apearin the left part: Your Name: [_______]
			<description></description> // optional description/hint for this field
			<help 
					file="help/cvv2.html"  // the location of the file 
					location="module|site"  // location relative to module location or not
					type="popup|over"	// what to happen when you click on the ? button , popup or overlib
			/>

			<default></default> // default value
			<forcevalue></forcevalue> // will set this value no matter if other exists
			<action>
				eval,	// executes the default as phpcode and output is put in field value
				price,	// formats the value as a price XX.xx
				int		// formats the value as a integer number
			</action>

			// textarea ONLY
			<html>true</html> // shows a html editor instead oof a textarea, works on Mozilla and Internet Explorere too

			<buttons>		//defines the list of the buttons to apear in html editor. Please take care at ''
				<toolbarX>'button1','button2'..  
			</buttons>
			
			// DROPLIST ONLY

			subtype="tree" parentfield="cat_parent"

			<options>   // block avaible for droplists only, this is for building a droplist using static values from xml
				<option name="1"></option> // in html will apear like <option value="1"></option>
			</options>

			<dinamyc from="100" to="200" width="2" />

			<relation>
				<sql>
					<vars>
						<var import="..." type="eval|var|page|form" />
					</vars>
					<query>SELECT * FROM {TABLE} ....</query>
				</sql>

				<table></table> // the table from database which will be queried
				<id></id> // the field values which will be used for <option value="...."
				<text>code,name</text> // the fields which will be used for the option text, they are fields from table, 
							  thre can be more then one separed with comma, in the text will apeare separed with the
							  charachtest specified in <separator></separator> tags
				<text>
					<field>field_name</field>
					<field field="table_field" preffix="{" suffix="}" />
				</text>

				<separator></separator>
				<condition>`field`='1'</condition> // the were clause which will be used in sql query
				<order>field</order>	//the result will be ordered after 'field' ...
				<ordermode>ASC|DESC</ordermode> //ascending or descending
			</relation>

			<empty></empty> // a set if the droplist to have fullfiled or to have a [slect] option on the first row
			<emptyMSG></emptyMSG> // an optional text which will apear if no options or no relations were found, instead of droplist element

			// <-- END


					
	</fields>				
*/


?>