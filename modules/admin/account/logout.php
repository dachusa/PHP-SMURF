<?php
session_start(); 
if(session_is_registered('session_id')){
	$updateSession = "Update users Set sGUID = '' Where sGUID = '".$_SESSION['session_id']."'";
	$setSession = @mysqli_query($connectAdmin, $updateSession) or die('query error: ' . mysqli_error($connectAdmin));
	//session variable is registered, the user is ready to logout
	session_unset();
	session_destroy();
	setcookie("session_id",null,time()-3600);
	
} 
header("Location: /admin/login");
?> 