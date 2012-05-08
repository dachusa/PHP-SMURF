<?php
	include("modules/admin/account/bannedPasswords.php");

	$updateUser = $_POST['user'];
	$findUser = "SELECT userID FROM users WHERE sGUID='$_SESSION[session_id]'";
	$getUser = @mysqli_query($connect, $findUser) or die('query error: ' . mysqli_error($connect));
	if($row = mysqli_fetch_array($getUser)) {
		extract($row);
		if(isset($updateUser['password']) && isset($updateUser['passwordConfirm']) && $updateUser['password']==$updateUser['passwordConfirm'] && $updateUser['password']!=$updateUser['username'] &&strlen($updateUser['password'])>=8){
			$bannedPassword = inBanList($updateUser["password"]);
			if(!$bannedPassword){
				$pwd = stripslashes($updateUser["password"]);
				$pwd = sha1($pwd);
				$updateSession = "Update users Set password = '$pwd', temp=0 Where userID = $userID";
				$setSession = @mysqli_query($connectAdmin, $updateSession) or die('query error: ' . mysqli_error($connectAdmin));
				header("Location: /admin/account/success");
			}else{
				$errorMessage="For security you may not use this password";
			}
		}else{
			if(strlen($updateUser['password'])<8){
				$errorMessage="Password is too short";
			}
			if($updateUser['password']!=$updateUser['passwordConfirm']){
				$errorMessage="Passwords do not match";
			}
			if($updateUser['password']==$updateUser['username']){
				$errorMessage="Passwords cannot be the same as your username";
			}
		}
	}
?>