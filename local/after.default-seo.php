<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2010 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies

$_MODULES["oxymall"]->plugins["modules"]->SetSEo(
	array (
		"seo_title"	=> $_MODULES["oxymall"]->private->vars->data["set_meta_title"],
		"seo_desc"	=> $_MODULES["oxymall"]->private->vars->data["set_meta_desc"],
		"seo_keys"	=> $_MODULES["oxymall"]->private->vars->data["set_meta_keys"],
	)
);
?>
