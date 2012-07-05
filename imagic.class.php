<?php

/**
* @package Resize image and create thumbnails
* @version 1.0
* @author  Andros Romo <me@androsromo.com>
* @twitter @AndrosRomo
* @license GNU GPL
* @desc    Resize any image (including transparent PNGs) and creates thumbnails with specified size or proportion of the original image
* @returns True or False if you want save result in a folder
* @example index.php
* @updated 04/Jul/2012
*
* class imagic
*/


class imagic {
	
	var $save;
	
	var $path;
	
	var $image;
	
	/*
	 * __construct()
	 */
	
	function __construct() {
		
		$this->save = false;
		
		$this->path = $path;
		
		$this->image = $image;
		
		$this->crop->width = 120;
		
		$this->crop->height = 120;
		
		$this->crop->centerX = false;
		
		$this->crop->centerY = false;
		
		$this->crop->minusX = 0;
		
		$this->crop->minusY = 0;
	}
	
	public function getImage(){
		
		$this->img = $this->path.$this->image;
		
		if( file_exists($this->img) ):
			
			$data = getimagesize($this->img);
			
			$this->imagen->data = $data;
			
			$this->imagen->width= $data[0];
			
			$this->imagen->height=$data[1];
			
			return true;

		else:
		
			return false;
		
		endif;
		
		
	}
	
	public function imageNewSize( $redim , $base = 'horizontal' ){
		
		$this->getImage();
		
		if( strstr($redim,"%") ){
			
			$redim = preg_replace("@([^0-9]+)@i","",$redim);
			
		} else {
			
			if( $base == "horizontal" ):
			
				$redim = ($redim*100)/$this->imagen->width;
				
			else:
			
				$redim = ($redim*100)/$this->imagen->height;				
			
			endif;
			
		}
		
		$this->imagen->new_width = ceil( ($redim*$this->imagen->width)/100 );
				
		$this->imagen->new_height = ceil( ($redim*$this->imagen->height)/100 );
		
	}
	
	public function resizeImage(){
		
		$image = $this->img;
		
		$nwidth = $this->imagen->new_width;
		
		$nheight = $this->imagen->new_height;
		
		$image_info = $this->imagen->data;

		if ($image_info['mime'] == 'image/gif') {
			
			$alphablending = true;
			$img_old = imagecreatefromgif($image);
			imagealphablending($img_old, true);
			imagesavealpha($img_old, true);
			
		} elseif ($image_info['mime'] == 'image/png') {
			
			$alphablending = false;
			$img_old = imagecreatefrompng($image);
			imagealphablending($img_old, true);
			imagesavealpha($img_old, true);
			
		} elseif($image_info['mime'] == 'image/jpeg'){
			
			$alphablending = false;
			$img_old = imagecreatefromjpeg($image);
			imagealphablending($img_old, true);
			imagesavealpha($img_old, true);
			
		}
		
		$img_temp = imagecreatetruecolor($nwidth, $nheight);
		
		imagecolortransparent($img_temp, imagecolorallocate($img_temp, 0, 0, 0));		
			
		imagealphablending($img_temp, $alphablending);
	
		imagesavealpha($img_temp, true);

		imagecopyresampled(
			$img_temp,
			$img_old,
			0, 0, 0, 0,
			$nwidth,
			$nheight,
			imagesx($img_old),
			imagesy($img_old)
		);
		
		if( !$this->save ) header("Content-type: image/png");
		
		if ($image_info['mime'] == 'image/gif') {
			
			imagegif($img_temp,$this->save);
			
		} elseif ($image_info['mime'] == 'image/png') {
			
			imagepng($img_temp,$this->save);
			
		} elseif ($image_info['mime'] == 'image/jpeg') {
			
			imagejpeg($img_temp,$this->save,90);
			
		}
	       
		imagedestroy($img_old);
		imagedestroy($img_temp);
		
		if( $this->save ) return true;
	}
	
	public function cropImage(){
		
		$image = $this->img;
		
		$width = $this->crop->width;
		
		$height = $this->crop->height;
		
		$nwidth = $this->imagen->new_width;
		
		$nheight = $this->imagen->new_height;
		
		$image_info = $this->imagen->data;
		
		
		$centerx = ( is_numeric($this->crop->centerX) )?$this->crop->centerX:($width/2)-($nwidth/2);
		
		$centery = ( is_numeric($this->crop->centerY) )?$this->crop->centerY:($height/2)-($nheight/2);
		
		$minusx = ( is_numeric($this->crop->minusX) )?$this->crop->minusX:($nwidth/2)-($width/2);
		
		$minusy = ( is_numeric($this->crop->minusY) )?$this->crop->minusY:($nheight/2)-($height/2);

		if ($image_info['mime'] == 'image/gif') {
			
			$alphablending = true;
			$img_old = imagecreatefromgif($image);
			imagealphablending($img_old, true);
			imagesavealpha($img_old, true);
			
		} elseif ($image_info['mime'] == 'image/png') {
			
			$alphablending = false;
			$img_old = imagecreatefrompng($image);
			imagealphablending($img_old, true);
			imagesavealpha($img_old, true);
			
		} elseif($image_info['mime'] == 'image/jpeg'){
			
			$alphablending = false;
			$img_old = imagecreatefromjpeg($image);
			imagealphablending($img_old, true);
			imagesavealpha($img_old, true);
			
		}
		
		$img_temp = imagecreatetruecolor($width, $height);
		
		imagecolortransparent($img_temp, imagecolorallocate($img_temp, 0, 0, 0));		
			
		imagealphablending($img_temp, $alphablending);
	
		imagesavealpha($img_temp, true);

		imagecopyresampled(
			$img_temp,
			$img_old,
			$centerx, $centery, $minusx, $minusy,
			$nwidth,
			$nheight,
			imagesx($img_old),
			imagesy($img_old)
		);
		
		if( !$this->save ) header("Content-type: image/png");
		
		if ($image_info['mime'] == 'image/gif') {
			
			imagegif($img_temp,$this->save);
			
		} elseif ($image_info['mime'] == 'image/png') {
			
			imagepng($img_temp,$this->save);
			
		} elseif ($image_info['mime'] == 'image/jpeg') {
			
			imagejpeg($img_temp,$this->save,90);
			
		}
	       
		imagedestroy($img_old);
		imagedestroy($img_temp);
		
		if( $this->save ) return true;
		
		
	}
}

