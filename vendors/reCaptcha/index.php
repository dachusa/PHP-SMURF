<?php
	require_once("vendors/reCaptcha/keys.php");
	require_once('vendors/reCaptcha/recaptchalib.php');
	echo recaptcha_get_html($publickey);
?>