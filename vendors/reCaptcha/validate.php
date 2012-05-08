<?php
  require_once("vendors/reCaptcha/keys.php");
  require_once('vendors/reCaptcha/recaptchalib.php');
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
	$reCaptcha = array("success"=>false, "error"=>$resp->error);
  } else {
	$reCaptcha = array("success"=>true, "error"=>"");
  }
?>