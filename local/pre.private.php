<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2005 OXYLUS Development
		web:  www.oxylus.ro
		mail: support@oxylus.ro		

	$Id: after.private.php,v 0.0.1 dd/mm/yyyy hh:mm:ss author Exp $
	description predefined variables which are ment to be used just in the engine
*/


if (!isset($_TSM["FORMS.PRIVATE.ONLOAD"])) {
	$_TSM["FORMS.PRIVATE.ONLOAD"] = "";
}

//load the security box if required
if (file_exists("local/forms/after.forms.private.php")) {
	require_once "local/forms/after.forms.private.php";
}


?>
