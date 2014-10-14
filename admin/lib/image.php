<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: image.php,v 0.0.1 03/03/2004 17:38:21 oxylus Exp $
	forms generation class
*/

$CIMAGE_DEFAULT_QUALITY = "90";

class CImage {
	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	
	/**
	* unique library identifier
	*
	* @var string
	*
	* @access private
	*/
	var $name;
	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $types;
	
	/**
	* constructor which sets the lib`s name
	*
	* @param string $name	unique library identifier
	*
	* @return void
	*
	* @acces public
	*/
	function CImage() {
		$this->name = "image";		
	}

	function ResizeImageByHeight(
		$source,
		$destination,
		$height
	) {

		$src_img = $this->ReadImage($source);

		$old_height = $src_img["height"];
		$old_width = $src_img["width"];

		if ($height && $old_height)  {
			$ratio = $height / $old_height;

			$width = $old_width * $ratio;

			$im = $this->NewImage($width , $height , $src_img["type"] , $src_img["image"]);

			ImageCopyResampled(
				$im["image"],
				$src_img["image"],
				0,
				0,
				0,
				0,
				$width,
				$height,
				$old_width,
				$old_height
			);

			@ImageDestroy($src_img["image"]);

			$this->SaveImage(
				&$im["image"] , 
				$im["type"] , 
				$destination
			);

		} else {
			copy($source , $destination);
		}
	}

	
	function ResizeImageByWidth(
		$source,
		$destination,
		$width
	) {

		$src_img = $this->ReadImage($source);

		$old_height = $src_img["height"];
		$old_width = $src_img["width"];

		if ($width && $old_width)  {
			$ratio = $width / $old_width;

			$height= $old_height * $ratio;

			$im = $this->NewImage($width , $height , $src_img["type"] , $src_img["image"]);

			ImageCopyResampled(
				$im["image"],
				$src_img["image"],
				0,
				0,
				0,
				0,
				$width,
				$height,
				$old_width,
				$old_height
			);

			@ImageDestroy($src_img["image"]);

			$this->SaveImage(
				&$im["image"] , 
				$im["type"] , 
				$destination
			);
		} else {
			copy($source , $destination);
		}
	}

	function NewImage($new_width , $new_height , $type , $src_img ) {
		$im = ImageCreateTrueColor ($new_width,$new_height);

        $white = imagecolorallocatealpha ($im, 255, 255, 255, 127);

		imagefill($im, 0, 0, $white);
		imagesavealpha( $im, true );				
		imagealphablending($im , true);

		if ( ($type  == IMAGETYPE_GIF) || ($type ==  IMAGETYPE_PNG) ) {
			$trnprt_indx = imagecolortransparent($src_img);


			if ($trnprt_indx >= 0) {
				$trnprt_color    =  imagecolorsforindex($src_img,  $trnprt_indx);
				$trnprt_indx    =   imagecolorallocate($im, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

				imagefill($im, 0, 0,  $trnprt_indx);
				imagecolortransparent($im, $trnprt_indx);
			}
		}


		return array(
			"image"	=> $im , 
			"type" => $type
		);
	}

	function ReadImage($source) {

		$info = GetImageSize($source);

		switch ($info[2]) {
			case IMAGETYPE_GIF:
				$image = ImageCreateFromGIF($source);
				$type = IMAGETYPE_GIF;
			break;

			case IMAGETYPE_PNG:
				$image = ImageCreateFromPNG($source);
				$type = IMAGETYPE_PNG;
			break;

			case IMAGETYPE_JPEG:
				$image = ImageCreateFromJPEG($source);
				$type = IMAGETYPE_JPEG;
			break;
		}

		if ($image) {
			return array(
				"image"	=> $image,
				"type"	=> $type,
				"width"	=> imageSX($image),
				"height" => imageSY($image),
					
			);
		}	

		// returnuing error
		return false;
	}
	

	function SaveImage($image , $type , $destination) {
		global $CIMAGE_DEFAULT_QUALITY;

		if (($type == IMAGETYPE_GIF) && (imagetypes() & IMG_GIF))  {
			ImageGif(
				$image,
				$destination				
			);

			ImageDestroy($image);
			return true;
		} else {
			if (($type == IMAGETYPE_PNG) && (imagetypes() & IMG_PNG))  {
				Imagepng(
					$image,
					$destination				
				);

				ImageDestroy($image);
				return true;	
			} else {
				ImageJpeg(
					$image,
					$destination,
					$CIMAGE_DEFAULT_QUALITY
				);

				ImageDestroy($image);
				return true;
			}
		}	

		//at this point i failed
		return false;
	}
	
	

	function CCrop(
		$source,
		$destination, 
		$new_width,
		$new_height,
		$x,
		$y,
		$width,
		$height) {

		global $CIMAGE_DEFAULT_QUALITY;

		if (file_exists($source)) {
			$src_img = $this->ReadImage($source);

			$im = $this->NewImage($new_width , $new_height , $src_img["type"] , $src_img["image"]);

			ImageCopyResampled(
				$im["image"],
				$src_img["image"],
				0,
				0,
				$x,
				$y,
				$new_width,
				$new_height,
				$width,
				$height
			);


			$this->SaveImage(
				&$im["image"] , 
				$im["type"] , 
				$destination
			);

			@ImageDestroy($src_img["image"]);
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
	function Crop(
				$source , 
				$destination , 
				$resize_width ,
				$resize_force = NULL, 
				$border = NULL , 
				$shadow = NULL , 
				$texture = NULL , 
				$texture_tile = NULL , 
				$background = NULL , 
				$quality = NULL , 
				$watermark = array (),
				$resize_height = NULL

		) {
		$resize = true;

		
		//if no height then set it to be the same with width
		if (!$resize_height)
			$resize_height = $resize_width;
	
		//use the max size to be resized
		$size = max($resize_width , $resize_height);
		
		if (file_exists($source)) {
			$src_img = $this->ReadImage($source);

			//return errorr, coudnt open the image
			if ($src_img === false)
				return false;

			//check if i need to resize the image first
			if ($resize == true) {
				$width = $src_img["width"];
				$height = $src_img["height"];

				$oRatio = $width / $height;
				$nRatio = $resize_width / $resize_height;

				if ($oRatio > $nRatio) {
					$nWidth = (int)$resize_width  * ( $oRatio / $nRatio );
					$nHeight = $resize_height;
				} else {
					$nHeight = (int)$resize_height  * ( $nRatio / $oRatio );
					$nWidth = $resize_width;
				}

				//generate the new image, overwrite the existing one

				$im = $this->NewImage($nWidth , $nHeight , $src_img["type"] , $src_img["image"]);

				ImageCopyResampled(
					$im["image"],
					$src_img["image"],
					0,
					0,
					0,
					0,
					$nWidth,
					$nHeight,
					$width,
					$height
				);

				@ImageDestroy($src_img["image"]);

				$this->SaveImage(
					&$im["image"] , 
					$im["type"] , 
					$destination
				);


				//overwrite with the new one
				$src_img = $im;	
			}

			return true;
		}
			
		return false;

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
	function CropSquare(
			$source,
			$destination,
			$size,
			$resize = true,
			$quality = 90
		) {


		if (!(int) $quality)
			$quality = 100;
		
		if (file_exists($source)) {
			$src_img = $this->ReadImage($source);

			//return errorr, coudnt open the image
			if ($src_img === false)
				return false;

			//check if i need to resize the image first
			if ($resize == true) {
				$width = $src_img["width"];
				$height = $src_img["height"];

				if ($width > $height) {
					$nheight = $size;
					$nwidth = (int) ( $size * ( $width / $height ));
				} else {
					$nwidth = $size;
					$nheight = (int) ($size * ($height / $width ));
				}

				//generate the new image, overwrite the existing one

				$im = $this->NewImage($nwidth , $nheight , $src_img["type"] , $src_img["image"]);


				ImageCopyResampled($im,$src_img,0,0,0,0,$nwidth,$nheight,$width,$height);

				@ImageDestroy($src_img["image"]);

				$this->SaveImage(
					&$im["image"] , 
					$im["type"] , 
					$destination
				);

			}
			return true;
		}
			

		return false;
	}

	
	/**
	* description resize and process an image using gd or imagemagick
	*
	* @param string $source			filename which will be processed
	* @param string $destination	the output filename, if empty will be shonwd in browser, mime types must be set to jpeg
	* @param integer $resize_width	width for output image
	* @param boolean $resize_force	if set the image will be resized even if it is smaller the $resize_width
	* @param integer $border		border width, for none set it to 0
	* @param integer $shadow		shadow size, for none set it to 0
	* @param string $texture		the backgroud texture, if NULL no texture will be used
	* @param boolean $texture_tile  if true, the texture will be tiled else the texture will be streched to result image 
	* @param array $background		background rdb colors $background[0] -> red,$background[1] -> green,$background[2] -> blue
	* @param 0..100 $quality		sets the output image quality (jpeg only) 
	*
	* @return image
	*
	* @access public
	*/
	function ResizePro(
				$source , 
				$destination , 
				$resize_width ,
				$resize_force = NULL, 
				$border = NULL , 
				$shadow = NULL , 
				$texture = NULL , 
				$texture_tile = NULL , 
				$background = NULL , 
				$quality = NULL , 
				$watermark = array (),
				$resize_height = 0
			) {

		//manualy setuping the default values
		$resize_force = (($resize_force == "FALSE") || ($resize_force == "TRUE")) ? $resize_force : "FALSE";
		$quality = (is_numeric($quality) && ($quality >= 0) && ($guality <= 100)) ? $quality : 90;

		//seting timelimit 0, lets hope not to be a stupid error there :]
		//set_time_limit(0);
		//if is gd loaded i try to use it, else i try using other methods
		if (extension_loaded("gd")) {
				// for fucking reasons i use imagick to convert it in jpeg
			$src_img = $this->ReadImage($source);

			$src_width = $src_img["width"];
			$src_height = $src_img["height"];
			
			$ratio = imagesx($src_img) / imagesy($src_img);
			$new_width = $resize_width;
			$new_height = $resize_width  / $ratio;

			if ($new_height > $resize_height) {
				$new_height = $resize_height;
				$new_width = $resize_height * $ratio;
			}

			$new_width = min(round($new_width) , $resize_width);
			$new_height = min(round($new_height) , $resize_height);
			
			
			// creatuong the result image
			$im = $this->NewImage($new_width , $new_height , $src_img["type"] , $src_img["image"]);
			
			//resampling the image to new dimensions

			(int) ImageCopyResampled(
				$im["image"],
				$src_img["image"],
				0,
				0,
				0,
				0,
				$new_width,
				$new_height,
				$src_width,
				$src_height
			);
			
			@ImageDestroy($src_img);
			//returning the result image
			$this->SaveImage(
				&$im["image"] , 
				$im["type"] , 
				$destination
			);
		} 
		return NULL; //for the momment i return nothing in time i will make a table of errors
	}
	
	/**
	* description resize and process an image using gd or imagemagick
	*
	* @param string $source			filename which will be processed
	* @param string $destination	the output filename, if empty will be shonwd in browser, mime types must be set to jpeg
	* @param integer $resize_width	width for output image
	* @param boolean $resize_force	if set the image will be resized even if it is smaller the $resize_width
	* @param integer $border		border width, for none set it to 0
	* @param integer $shadow		shadow size, for none set it to 0
	* @param string $texture		the backgroud texture, if NULL no texture will be used
	* @param boolean $texture_tile  if true, the texture will be tiled else the texture will be streched to result image 
	* @param array $background		background rdb colors $background[0] -> red,$background[1] -> green,$background[2] -> blue
	* @param 0..100 $quality		sets the output image quality (jpeg only) 
	*
	* @return image
	*
	* @access public
	*/
	function Resize(
				$source , 
				$destination , 
				$resize_width ,
				$resize_force = NULL, 
				$border = NULL ,			//deprecated
				$shadow = NULL ,			//deprecated
				$texture = NULL ,			//deprecated
				$texture_tile = NULL ,		//deprecated
				$background = NULL ,		//deprecated
				$quality = NULL ,			//deprecated - globaly controled
				$watermark = array (),
				$resize_height = 0
			) {

	
		//manualy setuping the default values
		$resize_force = (($resize_force == "FALSE") || ($resize_force == "TRUE")) ? $resize_force : "FALSE";

		//seting timelimit 0, lets hope not to be a stupid error there :]
		//set_time_limit(0);
		//if is gd loaded i try to use it, else i try using other methods
		if (extension_loaded("gd")) {

			$src_img = $this->ReadImage($source);


			//check if the image its at the correct dimensions 
			if (($resize_width == $src_img["width"]) && ($resize_height == $src_img["height"])) {
				copy ( $source , $destination);
				return true;
			}
			

			// seting the new dimensions
			if (($src_img["width"] > $resize_width) || ($resize_force == "TRUE")) {
				//setting the new dimensions
				$width = $resize_width;

				//if height exists then use the height
				if ($height == 0)
					$height = $src_img["height"] * ($resize_width / $src_img["width"] );
			} else {
				// kepping the old dimensions
				$width = $src_img["width"];
				$height = $src_img["height"];
			}

			// creatuong the result image
			$im = $this->NewImage($width , $height , $src_img["type"] , $src_img["image"]);

						
			//resampling the image to new dimensions
			ImageCopyResampled($im["image"],$src_img["image"],0,0,0,0,$width,$height,$src_img["width"],$src_img["height"]);

			//add the watermark

#NONFUNCTIONAL WILL BE UPDATED IN A FUTURE VERSION
/*
			if (count($watermark)) {

				//debug($watermark,1);

				if (file_exists($watermark["file"])) {

					//check the params 
					$watermark["pos_y"] = in_array($watermark["pos_y"], array("bottom" , "top" , "middle" , "random")) ? $watermark["pos_y"] : "bottom";
					$watermark["pos_x"] = in_array($watermark["pos_x"], array("left" , "right" , "center" , "random")) ? $watermark["pos_x"] : "right";
				
					//$wmImg   = imageCreateFromGIF($watermark["file"]);

					$wmImg = imagecreatefrompng($watermark["file"]);

					imageAlphaBlending($wmImg, false);
					imageSaveAlpha($wmImg, true);


					switch ($watermark["pos_y"]) {
						case "bottom":
							$wmY = imageSY($im) - imageSY($wmImg); 
						break;
						
						case "top":
							$wmY = 0; 
						break;

						case "middle": 
							$wmY = (int) ((imageSY($im) - imageSY($wmImg)) / 2); 
						break;

						case "random":
							$wmY = (bool)rand(0,1) ? $margin : (imageSY($im) - imageSY($wmImg));
						break;
					}

					switch ($watermark["pos_x"]) {
						case "left":
							$wmX = 0; 
						break;
						
						case "center":
							$wmX = (int) ((imageSX($im) - imageSX($wmImg)) / 2); 
						break;

						case "right": 
							$wmX = imageSX($im) - imageSX($wmImg) ;
						break;

						case "random":
							$wmX = (bool)rand(0,1) ? $margin : (imageSX($im) - imageSX($wmImg));
						break;
					}

					// Water mark process
					imageCopy($im, $wmImg, $wmX, $wmY, 0, 0, imageSX($wmImg), imageSY($wmImg));//, $watermark["transparency"]);
				}
			}
*/			

			$this->SaveImage(
				&$im["image"] , 
				$im["type"] , 
				$destination
			);

			//destroing the temporary images
			@ImageDestroy($src_img);
			@ImageDestroy($im);
			@ImageDestroy($txt_img);
		} 

		return NULL; //for the momment i return nothing in time i will make a table of errors
	}

}



/**

History:

v0.2
	14 May 2010 

		Added more complex ResizeFunction
		Added CCrop function ( to be used with the flash widget for uploading images )
		Removed ImageMagick Support, totaly useless
		Removed GetData, Get Type
		Added ResizeImageByWidth
		Added ResizeImageByHeight
		Added NewImage
		Added ReadImage
		Added SaveImage

		Updated all the code to use the NEW/READ/SAVE Image
		Full support for transparent PNG & GIF

v0.1.3
	Sometime in past
		Added height for Resize
		Added CropSquare, and support for not rectangle.
		Added wbmp support
		Added bmp support & php function fix


v0.1.2
	Thursday 14 August 2003
		When using the ImageMagick, for animated gifs it creates multiple files when trying to convert in jpg. 
		Now the library knows to search for .x files in tmp folder and to remove them after conversion.


v0.1.1
	Monday 29 April 2003
		Add source file exists and texture file check
		Setuping the default values in the function body, good for lazy ppl
		If i detect image magick then i convert any images in jpeg format and after that i process it.
		If source image doens exist and empty image is created with an error text inside.
		adding border and resizing with image magick if PB_IMAGE_MAGICK is set to 1
		Corected some bugs at temporary files.

v0.1
	Monday 28 April 2003 
		first version of image library
		knows how to detect the image type, to resize an image, to add border, dropshadow using GD functions only.
		**
		function GetType($image,$return_type = 1) {
		function GetData($filename) {
		function Resize($source , $destination = "" , $resize_width = 135 ,$resize_force = FALSE, $border = 1 , $shadow = 5 , $texture = NULL , $texture_tile = FALSE , $background = array("255","255","255") , $quality = 85) {
		**

**/
?>