<?php
$width = 300;
$height = 300;
$CenterX = round($width / 2);
$CenterY = round($height / 2);
$DiameterX = round($width * 0.95);
$DiameterY = round($height * 0.95);
$MinDisplayPct = 0.01;
$DisplayColors = 'FF0000;3399FF;66CC66;CCCC99;FFCCCC;9933FF;CC66CC;3333FF';
$BackgroundColor ='FFFFFF';
$LineColor = 'CCCCCC';
$Legend=true;
$FontNumber=3;
if ($Legend) {
	$DiameterX = $DiameterY;
	$CenterX   = $width - $CenterY;
	}
function FilledArc(&$im, $CenterX, $CenterY, $DiameterX, $DiameterY, $Start, $End, $line_color, $fill_color='none') {
		ImageArc($im, $CenterX, $CenterY, $DiameterX, $DiameterY, $Start, $End, $line_color);
		// To close the arc with 2 lines between the center and the 2 limits of the arc 
		$x = $CenterX + (cos(deg2rad($Start)) * ($DiameterX / 2)); 
		$y = $CenterY + (sin(deg2rad($Start)) * ($DiameterY / 2)); 
		ImageLine($im, $x, $y, $CenterX, $CenterY, $line_color); 
		$x = $CenterX + (cos(deg2rad($End)) * ($DiameterX / 2)); 
		$y = $CenterY + (sin(deg2rad($End)) * ($DiameterY / 2)); 
		ImageLine($im, $x, $y, $CenterX, $CenterY, $line_color); 
		// To fill the arc, the starting point is a point in the middle of the closed space 
		$x = $CenterX + (cos(deg2rad(($Start + $End) / 2)) * ($DiameterX / 4)); 
		$y = $CenterY + (sin(deg2rad(($Start + $End) / 2)) * ($DiameterY / 4)); 
		ImageFillToBorder($im, $x, $y, $line_color, $fill_color);
		}

function phPie($data, $width, $height, $CenterX, $CenterY, $DiameterX, $DiameterY, $MinDisplayPct, $DisplayColors, $BackgroundColor, $LineColor, $Legend, $FontNumber) {
	if ($im = @ImageCreate($width, $height)) {
		$background_color = ImageColorAllocate($im, hexdec(substr($BackgroundColor, 0, 2)), hexdec(substr($BackgroundColor, 2, 2)), hexdec(substr($BackgroundColor, 4, 2)));
		$line_color       = ImageColorAllocate($im, hexdec(substr($LineColor, 0, 2)), hexdec(substr($LineColor, 2, 2)), hexdec(substr($LineColor, 4, 2)));
		$fillcolorsarray = explode(';', $DisplayColors);
		for ($i = 0; $i < count($fillcolorsarray); $i++) {
			$fill_color[]  = ImageColorAllocate($im, hexdec(substr($fillcolorsarray["$i"], 0, 2)), hexdec(substr($fillcolorsarray["$i"], 2, 2)), hexdec(substr($fillcolorsarray["$i"], 4, 2)));
			$label_color[] = ImageColorAllocate($im, hexdec(substr($fillcolorsarray["$i"], 0, 2)) * 0.8, hexdec(substr($fillcolorsarray["$i"], 2, 2)) * 0.8, hexdec(substr($fillcolorsarray["$i"], 4, 2)) * 0.8);
		}
		$TotalArrayValues = array_sum($data);
		arsort($data);
		$Start = 0;
		$valuecounter = 0;
		$ValuesSoFar = 0;
		foreach ($data as $key => $value) {
			$ValuesSoFar += $value;
			if (($value / $TotalArrayValues) > $MinDisplayPct) {
				//$End = $Start + floor(($value / $TotalArrayValues) * 360);
				$End = ceil(($ValuesSoFar / $TotalArrayValues) * 360);
				FilledArc($im, $CenterX, $CenterY, $DiameterX, $DiameterY, $Start, $End, $line_color, $fill_color[$valuecounter % count($fill_color)]);
				if ($Legend) {
					ImageString($im, $FontNumber, 5, round((ImageFontHeight($FontNumber) * .5) + ($valuecounter * 1.5 * ImageFontHeight($FontNumber))), $key.' ('.number_format(($value / $TotalArrayValues) * 100, 1).'%)', $label_color[$valuecounter % count($label_color)]);
				}
				$Start = $End;
			} else {
				// too small to bother drawing - just finish off the arc with no fill and break
				$End = 360;
				FilledArc($im, $CenterX, $CenterY, $DiameterX, $DiameterY, $Start, $End, $line_color, $line_color);
				if ($Legend) {
					ImageString($im, $FontNumber, 5, round((ImageFontHeight($FontNumber) * .5) + ($valuecounter * 1.5 * ImageFontHeight($FontNumber))), '', $line_color);
					//ImageString($im, $FontNumber, 5, round((ImageFontHeight($FontNumber) * .5) + ($valuecounter * 1.5 * ImageFontHeight($FontNumber))), 'Other ('.number_format((($TotalArrayValues - $ValuesSoFar) / $TotalArrayValues) * 100, 1).'%)', $line_color);
				}
				break;
			}
			$valuecounter++;
		}
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
		return TRUE;
	
	} else {

		 echo 'Cannot Initialize new GD image stream';
		 return FALSE;

	}
}
$arr['Up'] = $_GET['up'];
$arr['Down'] = $_GET['down'];
phPie($arr, $width, $height, $CenterX, $CenterY, $DiameterX, $DiameterY, $MinDisplayPct, $DisplayColors, $BackgroundColor, $LineColor, $Legend, $FontNumber);
?>