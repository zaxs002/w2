<?php
$siteurl = 	
		dirname((strtoupper($_SERVER["HTTPS"]) == "on" ? "https://" :  "http://") . 
		$_SERVER["HTTP_HOST"] . 
		($_SERVER["SERVER_PORT"] != 80 ? ':' . $_SERVER["SERVER_PORT"] : '') .
		$_SERVER["SCRIPT_NAME"] ) . "/";	

$siteurl = str_replace("install/" , "" , $siteurl);


require "lib/validate.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Installing Fluxglide Complete HTML5 Website Template </title>

	<script type="text/javascript" src="swfobject.js"></script>

<style>
#flashcontent {
	height: 100%;
	width: 100%;
	font: 12px 'Trebuchet MS', arial, sans-serif;
	font-weight: bold;
	color: #000000;
	text-align:center;
	line-height: 200px;
}
#flash{
display: block;
}

html{
	margin:0;
	padding:0;
	height:100%;
	width: 100%;
}



body {
	margin: 0;
	padding: 0;
	background-color: #000000;
	height:100%;
	width: 100%;
	min-width: 1000px;
	min-height: 700px;
}

</style>
</head>
<body>
	<script type="text/javascript">
		document.write("<div id=\"flashcontent\"> You need to upgrade your Flash Player</div>");
		// <![CDATA[				
		var so = new SWFObject('installer.swf?time=' + Date.parse(new Date()), "flash", "100%", "100%", "8", "#000000");
		so.addParam("scale","noscale");
		so.addParam("swLiveConnect", "true");
		so.addParam("allowscriptaccess", "always");
		so.addParam("allowFullScreen", "true");
		so.addVariable("siteURL", "<?php echo $siteurl;?>");
		so.write("flashcontent");
		// ]]>
	</script></body>
</html>
