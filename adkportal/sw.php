<?php
/********************************************************
* Adk Portal                   
* Version: 2.0
* Official support: http://www.smfpersonal.net           
* Founder & Developer: Lucas-ruroken
* Project Manager: ^Heracles^ - Enik
* 2009-2011
* Smf Personal - Home of adkportal
/**********************************************************/

if(empty($_REQUEST['sw']))
	die();

$image = mysql_escape_string($_GET['sw']);
$watermark = "water.png";

$im = imagecreatefrompng($watermark);

//Find Extension
$explode = explode('.',$image);
$count = count($explode) -1;
$extension = $explode[$count];

//all jpeg = jpg
if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG')
	$extension = 'jpg';


if($extension == "gif"){
	if (!$im2 = imagecreatefromgif($image)) {
		echo "Error opening $image!"; exit;
	}
} 
elseif($extension == "jpg"){
	if (!$im2 = imagecreatefromjpeg($image)) {
		echo "Error opening $image!"; exit;
	}
}
elseif($extension == "png"){
	if (!$im2 = imagecreatefrompng($image)) {
		echo "Error opening $image!"; exit;
	}
} 
else{die;}

imagecopy($im2, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));

header("Content-Type: image/jpeg");
imagejpeg($im2);
imagedestroy($im);
imagedestroy($im2);

?> 