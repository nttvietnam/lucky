<?php
session_start();
include 'config.php';
require_once 'src/facebook.php';
$app_id = $app_id;
$app_secret = $app_secret;
$redirect_uri ="".$scripturl."/main.php";
$facebook = new Facebook(array(
        'appId' => $app_id,
        'secret' => $app_secret,
        'cookie' => true
));
$user = $facebook->getUser();
$user_profile = $facebook->api('/me');

$fbid = "".$user_profile['id']."";
$name = "".$user_profile['name']."";
$access_token = $facebook->getAccessToken();

if ($_GET['action'] == "publish") {

$facebook->setFileUploadSupport(true);
$album_details = array(
        'message'=> $albumname,
        'name'=> $albumname
);
$create_album = $facebook->api('/me/albums', 'post', $album_details);
$album_uid = $create_album['id'];
$file='img/'.$fbid.'.jpg'; 

$photo_details = array( 'message'=> $albummessage, 'image' => '@' . realpath($file) );
$upload_photo = $facebook->api('/'.$album_uid.'/photos', 'post', $photo_details);

$upphoto = $upload_photo['id'];
header("Location: ".$finalurl."");
};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Publish To Wall?</title>
<style>
body {  color: #3B5998; font-weight:bold; font-family:"lucida grande", tahoma, verdana, arial, sans-serif; font-size: 19px; }
.main { padding-top: 35px; width: 500px; height: 210px; margin: 0 auto; }
.pic { width: 100px; height: 100px; float: left; position:relative; }
.name { float: top left; padding-left: 110px; margin-bottom: 4px; color: #3B5998; font-weight:bold; font-family:"lucida grande", tahoma, verdana, arial, sans-serif; font-size: 14px;}
.uploaded { float: left; height: 160px; width: 400px; }
.data { float: left; bottom: 0; width: 390px; padding-left: 100px; }
</style>
</head>
<p align="center">Post My Results to Facebook!</p>
<p align="center"><a href="upload.php?action=publish"><img src="publish.png" width="294" height="64" border="0" /></a></p>
<p align="center">Example:</p>
<div class="main">

  <div class="pic"><img src="https://graph.facebook.com/<?php echo $fbid ?>/picture" width="90" height="90" border="0" align="middle" /></div>
  <div class="name"><?php echo $name ?></div>
  <div class="uploaded"><img src="<?php echo $scripturl?>img/<?php echo $fbid ?>.jpg" width="400" height="160" /></div>
  <div class="data"><img src="show_image.png" width="397" height="21" /></div>

</div>
<p>&nbsp;</p>

