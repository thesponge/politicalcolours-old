<?php
// CONFIG
define("root", "../../");

$width  = "70";
$height = "35";

$bgs = array(
   root.'lib/captcha/bg/bg_1.png', 
   root.'lib/captcha/bg/bg_2.png', 
   root.'lib/captcha/bg/bg_3.png', 
   root.'lib/captcha/bg/bg_4.png'
);

// INIT
error_reporting(E_ALL ^ E_NOTICE);
include(root. "lib/captcha/class.php");
$captcha = new captcha();

// THE SCRIPT
if ($_GET['mode'] == 'new' || strlen($captcha->returnCaptcha()) == 0)
{
    $captcha->refreshCaptcha();
}

$string = $captcha->returnCaptcha();

$captcha = imagecreatetruecolor($width, $height);
$black = imagecolorallocate($captcha, 0, 0, 0);

$bgs = array_values($bgs);
$bg = $bgs[rand(0,(count($bgs)-1))];
list($bgWidth, $bgHeight) = getimagesize($bg);    
$bgImg = imagecreatefrompng($bg); 
$bgX = rand(0, $bgWidth-$width);
$bgY = rand(0, $bgHeight-$height);
imagecopy($captcha, $bgImg, 0, 0, $bgX, $bgY, $width, $height);
imagedestroy($bgImg);

$line = imagecolorallocate($captcha,200,0,0);
imageline($captcha,0,0,39,29,$line);
imageline($captcha,40,0,64,29,$line);

imagestring($captcha, 7, 15, 10, $string, $black);

header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header( 'Content-type: image/png' );
imagepng($captcha);
?>