<?php
class Image {
	public function getThumbnailSize($ex_width, $ex_height, $maxheight=80, $maxwidth=80) {
		if($ex_width >= $ex_height){  
			if($ex_width > $maxwidth){   
				$ds_width_ex  = $maxwidth;   
				$ratio_ex     = $ex_width / $ds_width_ex;  
				$ds_height_ex = $ex_height / $ratio_ex;
				$ds_height_ex = round($ds_height_ex);  
				if($ds_height_ex > $maxheight)
					$ds_height_ex = $maxheight;    
			} else {   
				$ds_width_ex  = $ex_width;
				$ds_height_ex = $ex_height;   
				if($ds_height_ex > $maxheight)
					$ds_height_ex = $maxheight;    
			}  
		} else {  
			if($ex_height > $maxheight){  
				$ds_height_ex = $maxheight;
				$ratio_ex     = $ex_height / $ds_height_ex;
				$ds_width_ex  = $ex_width / $ratio_ex;
				$ds_width_ex  = round($ds_width_ex);  
				if($ds_width_ex > $maxwidth)
					$ds_width_ex = $maxwidth;   
			} else {   
				$ds_width_ex  = $ex_width;
				$ds_height_ex = $ex_height; 
				if($ds_width_ex > $maxwidth)
					$ds_width_ex = $maxwidth;   
			}  
		}  
		$size['width'] = $ds_width_ex;
		$size['height'] = $ds_height_ex;
		return $size;
	}
	public function buildThumbnail($url, $maxheight, $maxwidth, $format, $dest) {
		$format = strtolower($format);
		list($ex_width, $ex_height) = getimagesize($url);
		$size = $this->getThumbnailSize($ex_width, $ex_height, $maxheight, $maxwidth);
	  
		// create a black image
		$image_p = @imagecreatetruecolor($size['width'], $size['height']);
		// create white background
		$background = @imagecolorallocate($image_p, 255, 255, 255);
		// create rectangle with backgournd white
		@imagefilledrectangle($image_p, 0, 0, $size['width'], $size['height'], $background);
	
		if($format=="png") {
			$image = @imagecreatefrompng($url);
		} else if($format=="jpg") {
			$image = @imagecreatefromjpeg($url);	
		} else if($format=="gif") {
			$image = @imagecreatefromgif($url);	
		}
	
		@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['width'], $size['height'], $ex_width, $ex_height);
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($image_p, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($image_p, $dest);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($image_p, $dest);
		}
		@imagedestroy($image_p);
		return true;
	}
	public function buildThumbnailWithoutResize($url, $maxheight, $maxwidth, $format, $dest) {
		$format = strtolower($format);
		list($ex_width, $ex_height) = getimagesize($url);
		//$size = $this->getThumbnailSize($ex_width, $ex_height, $maxheight, $maxwidth);
		$size['width'] = $maxwidth;
		$size['height'] = $maxheight;
		// create a black image
		$image_p = @imagecreatetruecolor($size['width'], $size['height']);
		// create white background
		$background = @imagecolorallocate($image_p, 255, 255, 255);
		// create rectangle with backgournd white
		imagefilledrectangle($image_p, 0, 0, $size['width'], $size['height'], $background);
	
		if($format=="png") {
			$image = @imagecreatefrompng($url);
		} else if($format=="jpg") {
			$image = @imagecreatefromjpeg($url);	
		} else if($format=="gif") {
			$image = @imagecreatefromgif($url);	
		}
	
		@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['width'], $size['height'], $ex_width, $ex_height);
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($image_p, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($image_p, $dest);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($image_p, $dest);
		}
		@imagedestroy($image_p);
		return true;
	}
	
	public function getExtension($img) {
		$ext = substr(strrchr($img, '.'), 1);
		return $ext;
	}
	
	public function cropImage($get, $finalwidth, $finalheight) {
		// get variables
		$imgfile = $get['image'];
		$cropStartX = $get['cropStartX'];
		$cropStartY = $get['cropStartY'];
		$cropW = $get['cropWidth'];
		$cropH = $get['cropHeight'];
		$format = strtolower($this->getExtension($imgfile));
		$dest = $get['dest'];
		
		// Create two images
		if($format=="png") {
			$origimg = @imagecreatefrompng($imgfile);
		} else if($format=="jpg") {
			$origimg = @imagecreatefromjpeg($imgfile);	
		} else if($format=="gif") {
			$origimg = @imagecreatefromgif($imgfile);	
		}
		$cropimg = imagecreatetruecolor($finalwidth,$finalheight);
	
		// Get the original size
		//list($width, $height) = getimagesize($imgfile);
	
		// Crop
		imagecopyresampled($cropimg, $origimg, 0, 0, $cropStartX, $cropStartY, $finalwidth, $finalheight, $cropW, $cropH);
	
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($cropimg, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($cropimg, $dest, 90);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($cropimg, $dest);
		}
		@imagedestroy($cropimg);
	}
}
?>