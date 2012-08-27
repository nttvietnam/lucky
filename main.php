<?php
session_start();
include 'config.php';
require_once 'src/facebook.php';
$app_id = $app_id;
$app_secret = $app_secret;
$redirect_uri ="".$scripturl."main.php";
$facebook = new Facebook(array(
        'appId' => $app_id,
        'secret' => $app_secret,
        'cookie' => true
));
$user = $facebook->getUser();
$user_profile = $facebook->api('/me');

$coded = $_REQUEST['code'];

$access_token = $facebook->getAccessToken();
$name = "".$user_profile['name']."";
$fbid = "".$user_profile['id']."";

function RandomLine($filename) { 
    $lines = file($filename) ; 
    return $lines[array_rand($lines)] ; 
} 
$reason = RandomLine("reason.txt");   

$canvas = imagecreatefromjpeg ("bg.jpg");                                   // background image file
$black = imagecolorallocate( $canvas, 0, 0, 0 );                         // The second colour - to be used for the text
$font = "arial.ttf";                                                         // Path to the font you are going to use
$fontsize = 20;                                                             // font size

$birthday = "".$user_profile['birthday']."";
$death = "- ".date('d/m/Y', strtotime( '+'.rand(0, 10000).' days'))."";

imagettftext( $canvas, 22, 0, 110, 120, $black, $font, $name );            // name
imagettftext( $canvas, 22, 0, 110, 170, $black, $font, $birthday );        // birthday
imagettftext( $canvas, 22, 0, 255, 172, $black, $font, $death );           // death
imagettftext( $canvas, 20, 0, 110, 220, $black, $font, $reason );           // reason

imagejpeg( $canvas, "img/".$fbid.".jpg", 50 );

ImageDestroy( $canvas );

header("Location: ".$scripturl."upload.php?id=".$fbid."")
?>
