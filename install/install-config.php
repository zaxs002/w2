<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies


require "lib/validate.php";

$conf = new CConfig($_POST["installData"] , "string" );
$conf_data = $conf->vars["data"];

$conf_file = "<?php

\$_CONF[\"database\"] = array(
	\"type\"		=> \"mysql\",		//database type, just mysql supported for the moment
	\"server\"	=> \"{$conf_data[mysql][server]}\",		//mysql server or socket file
	\"login\"		=> \"{$conf_data[mysql][username]}\",		//mysql username
	\"password\"	=> \"{$conf_data[mysql][password]}\",		//mysql password
	\"default\"	=> \"{$conf_data[mysql][database]}\",	//database name
);

?>";


//save the file
savefilecontents("../upload/conf/database.php" , $conf_file);
@chmod("../upload/conf/database.php" , 0777);


SetXMLMime();
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><data><status>ok</status><message><![CDATA[]]></message></data>";
?>
