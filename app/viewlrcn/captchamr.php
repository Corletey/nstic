<?php
session_start();
$code=rand(100000,9999999);
$_SESSION["code"]=$code;
$im = imagecreatetruecolor(88, 28);
$bg = imagecolorallocate($im, 22, 86, 165);
$fg = imagecolorallocate($im, 255, 255, 255);
imagefill($im, 0, 0, $bg);
imagestring($im, 6, 6, 6,  $code, $fg);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>