<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2008 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: name.php,v 0.0.1 dd/mm/yyyy hh:mm:ss oxylus Exp $
	description
*/

// dependencies

if ($_GET["sub"] == "cron") {

	header('Content-type: image/jpeg');

	//get all blog modules
	$blogs = $this->db->QFetchRowArray("SELECT * FROM {$_MODULES[oxymall]->private->tables['core:user_modules']} WHERE mod_module_code='blog'");
	
	if (is_array($blogs)) {
		foreach ($blogs as $key => $val) {
			$settings = unserialize($val["mod_settings"]);

			//check for twitter
			if ($settings["set_twitter_rss"]) {

				$filename = "upload/blog/blog_twitter_" . $val["mod_id"] . ".rss";


				if (!file_exists($filename) || (filemtime($filename) <  (time()-$settings["set_twitter_refresh"]))) {

					@unlink($filename);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $settings["set_twitter_rss"]);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

					$content = curl_exec($ch);
					curl_close($ch);

					SaveFileContents(
						$filename , 
						$content
					);

					@chmod($filename , 0777);
				}

			}

			//check for flicker

			if ($settings["set_flickr_rss"]) {
			
				$filename = "upload/blog/blog_flickr_" . $val["mod_id"] . ".rss";

				if (!file_exists($filename) || (filemtime($filename) <  (time()-$settings["set_flickr_refresh"]))) {

					@unlink($filename);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $settings["set_flickr_rss"]);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

					$content = curl_exec($ch);
					curl_close($ch);

					SaveFileContents(
						$filename , 
						$content
					);

					@chmod($filename , 0777);
				}
			}
			
		}		
	}

	die();
}

?>
