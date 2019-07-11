<?php
session_start();
$ranStr = substr(str_shuffle("0123456789"),0,6);
$_SESSION['cap_code'] = $ranStr;
$newImage = imagecreatefromjpeg("_dist/img/cap_bg.jpg");
$txtColor = imagecolorallocate($newImage, 0, 0, 0);
imagestring($newImage, 5, 5, 5, $ranStr, $txtColor);
header("Content-type: image/jpeg");
imagejpeg($newImage);
?>
