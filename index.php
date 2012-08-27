<?php
session_start();
include 'config.php';
require 'src/facebook.php';
ob_start("ob_gzhandler");
function parsePageSignedRequest() {
    if (isset($_REQUEST['signed_request'])) {
      $encoded_sig = null;
      $payload = null;
      list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
      $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
      $data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
      return $data;
    }
    return false;
  }
  if($signed_request = parsePageSignedRequest()) {
    if($signed_request->page->liked) {
?>
<script>top.location="index.php"</script>
<?php
      
    } else {
header("Location: like.php");
    }
  }

$facebook = new Facebook(array(
  'appId'  => $app_id,
  'secret' => $app_secret
));

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'status_update,publish_stream,user_birthday', 'redirect_uri' => ''.$scripturl.'main.php', 'response_type' => 'code'));
}
if ($user): 
else: ?>
	  <script type="text/javascript">

	  window.top.location="<?php echo $loginUrl ?>";

      </script>
</div>
<? endif ?>