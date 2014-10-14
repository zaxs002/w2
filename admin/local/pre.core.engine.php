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

global $_ADMIN;

if ($_ADMIN) {
	switch ($_GET["sub"]) {
		case "core.sqladmin.file.upload":
			$file = true;
		case "core.sqladmin.image.upload":
			set_time_limit(0);

			//fix the filename if contains spaces
			if (stristr($_FILES['Filedata']['name'] , " ")) {
				$_FILES['Filedata']['name'] = str_replace(" " , "_" , $_FILES['Filedata']['name'] );
			}
	
			$to = '../upload/tmp/'. md5(uniqid(time())) . "_" . $_FILES['Filedata']['name'];
			if(move_uploaded_file($_FILES['Filedata']['tmp_name'], $to)) {

				if (!$file) {
					//check if the image its bigger then 2880x2880 ( the limit that flash cropper can handle )
					$image = @getImageSize($to);

					if ($image == false) {
						//error reading the image
						$response =	'<response>
									<status>failed</status>
									<message>Uploaded file its not a valid image!</message>
								</response>';
					} else {
						if (($image[0] > 2800 ) || ($image[1] > 2800)) {

							$img = new CImage();
							if ($image[0] > $image[1]) {
								$img->ResizeImageByWidth(
									$to , 
									$to . ".tmp",
									2800
								);
							} else {
								$img->ResizeImageByHeight(
									$to , 
									$to . ".tmp",
									2800
								);
							}

							unlink($to);
							rename($to . ".tmp" , $to);
							@chmod($to , 0777 );
						}						
					}
					
				}

				$response = 	'<response>
							<status>ok</status>
							<filePath>'.$to.'</filePath>
							<fileName>'.$_FILES["Filedata"]["name"] . '</fileName>
						</response>';
			} else {
				$response =	'<response>
							<status>failed</status>
							<message>Server side upload error !</message>
						</response>';
			}

			echo $response;
			die();
		break;

		case "core.sqladmin.file.web":
			$isfile = true;
		case "core.sqladmin.image.web":

			$to = '../upload/tmp/'. md5(uniqid(time())) . "_" . basename($_POST['url']);

			//fix the filename if contains spaces
			if (stristr($to , " ")) {
				$to = str_replace(" " , "_" , $to );
			}

			$from = $_POST["url"];

			//try to download by blocks 
			$file = @fopen($from,"r");
			$file2 = @fopen($to,"w");
			
			if ($file){
				
				while (!feof($file)) {
					$buffer= fread($file,1024);
					fwrite($file2 , $buffer );
				}

				fclose($file);
				fclose($file2);
			} else {

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $from);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

				$image = curl_exec($ch);

				curl_close($ch);

				SaveFileContents( $to , $image);
			}


			if (!$isfile) {
				//check if the image its bigger then 2880x2880 ( the limit that flash cropper can handle )
				$image = getImageSize($to);

				if ($image == false) {
					//error reading the image
					$response =	'<response>
								<status>failed</status>
								<message>Specified link its not a valid image!</message>
							</response>';
				} else {
					if (($image[0] > 2800 ) || ($image[1] > 2800)) {

						$img = new CImage();
						if ($image[0] > $image[1]) {
							$img->ResizeImageByWidth(
								$to , 
								$to . ".tmp",
								2800
							);
						} else {
							$img->ResizeImageByHeight(
								$to , 
								$to . ".tmp",
								2800
							);
						}

						unlink($to);
						rename($to . ".tmp" , $to);
					}						
				}
			}

			echo '<response>
					<status>ok</status>
					<filePath>'. $to . '</filePath>
					<fileName>'. basename($from) . '</fileName>
				 </response>';

			die();

		break;

		case "core.sqladmin.file.delete":
			$file = true;
		case "core.sqladmin.image.delete":
			$response =	'<response>
							<status>ok</status>
							<message></message>
						</response>';

			echo $response;

			die();
		break;
	}
}


?>
