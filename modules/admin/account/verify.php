<?php
if(isset($_POST['submit'])){
	$errorMessage = "";
	if(!isset($_POST['login']) || !is_array($_POST['login'])){
		$errorMessage ="Your login information was incorrect.";
	}else{
		extract($_POST['login']);
		if(!isset($username) | !isset($password)){
			$errorMessage = "You did not fill in a required field.";	
		}else{
			if (!get_magic_quotes_gpc()) {
				$username = addslashes($username);
			}
			$pwd = stripslashes($password);
			$pwd = sha1($pwd);
			$findUser = "SELECT userID, MD5(UNIX_TIMESTAMP() + userID + RAND(UNIX_TIMESTAMP())) sGUID, temp FROM users WHERE username = '$username' and password = '$pwd'";
			$getUser = @mysqli_query($connect, $findUser) or die('query error: ' . mysqli_error($connect));
			if($row = mysqli_fetch_array($getUser)) {
				extract($row);
				$updateSession = "Update users Set sGUID = '$sGUID', lastLogin=CURRENT_TIMESTAMP Where userID = $userID";
				$setSession = @mysqli_query($connectAdmin, $updateSession) or die('query error: ' . mysqli_error($connectAdmin));
				
				// Set the cookie and redirect
				setcookie("session_id", $sGUID, time()+3600, "/admin/");

				session_start();
				$_SESSION["session_id"]=$sGUID; 
				if($temp){
					if(isset($source)){
						setcookie("source", $source, time()+3600, "/admin/");
					}
					header("Location: /admin/account/temp");
				}else{
					if(isset($source)&&$source!="/admin/login"){
						setcookie("source", null, time()-3600, "/admin/");
						header("Location: " . $source);
					}else{
						header("Location: /admin/panel");
					}
				}
			} else {
				$errorMessage = "Your login information was incorrect."; 
			}	
		}
	}
} 
?>