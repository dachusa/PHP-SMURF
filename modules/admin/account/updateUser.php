<?php
	include("modules/admin/account/bannedPasswords.php");
	$error=false;
	$updateUser = $_POST['edituser'];
	$editOther=false;
	if(isset($url[3])&&$url[3]!="" && $user["securityLevel"]<2 && $updateUser["id"]==$url[3]){
		$findUser = "SELECT userID, name, username, email, securityLevel FROM users WHERE userID= $url[3] AND securityLevel >= $user[securityLevel] AND sGUID <> '$_SESSION[session_id]'";
		$getUser = @mysqli_query($connect, $findUser) or die('query error: ' . mysqli_error($connect));
		if($row = mysqli_fetch_array($getUser)) {
			$edituser=$row;
			$editOther=true;
		}
	}
	if(!$editOther){
		$findUser = "SELECT userID, name, username, email FROM users WHERE sGUID = '$_SESSION[session_id]'";
		$getUser = @mysqli_query($connect, $findUser) or die('query error: ' . mysqli_error($connect));
		if($row = mysqli_fetch_array($getUser)) {
			$edituser=$row;
		}
	}
	extract($edituser);
	
	
	/******UPDATE USER******/
	if(isset($updateUser[update])){
		/*********Password***************/
		if(!$editOther){
			if(isset($updateUser['password']) && isset($updateUser['passwordConfirm']) && $updateUser['password']==$updateUser['passwordConfirm'] && $updateUser['password']!=$updateUser['username'] &&strlen($updateUser['password'])>=8){
				$bannedPassword = inBanList($updateUser["password"]);
				if(!$bannedPassword){
					$pwd = stripslashes($updateUser["password"]);
					$pwd = sha1($pwd);
					$updatePassword = "Update users Set password = '$pwd', temp=0 Where userID = $userID";
					$setPassword = @mysqli_query($connectAdmin, $updatePassword) or die('query error: ' . mysqli_error($connectAdmin));
				}else{
					$error=true;
					$errorMessage["password"]="For security you may not use this password";
				}
			}else{
				if(strlen($updateUser['password'])<8 && $updateUser['password'] !="" && $updateUser['password'] != null){
					$error=true;
					$errorMessage["password"]="Password is too short";
				}
				if($updateUser['password']!=$updateUser['passwordConfirm']){
					$error=true;
					$errorMessage["password"]="Passwords do not match";
				}
				if($updateUser['password']==$updateUser['username']){
					$error=true;
					$errorMessage["password"]="Passwords cannot be the same as your username";
				}
			}
		}
		
		/************Name***********/
		if($updateUser['name']!=$name){
			if(isset($updateUser['name']) && $updateUser['name']!=null && $updateUser['name']!="" && strpos($updateUser["name"]," ")>0 && strlen($updateUser['name'])>=3){
				$updateName = "Update users Set name = '".$updateUser['name']."' Where userID = $userID";
				$setName = @mysqli_query($connectAdmin, $updateName) or die('query error: ' . mysqli_error($connectAdmin));
			}else{
				$error=true;				
				$errorMessage['name']="First and last name are required";
			}
		}
		
		/***********Username*********/
		if($updateUser['username']!=$username){
			if(isset($updateUser['username']) && $updateUser['username']!=null && $updateUser['username']!="" && strlen($updateUser['username'])>=1){
				$findUsername = "SELECT * FROM users WHERE username = '".$updateUser["username"] . "' AND userID<>$userID";
				$checkUsername = @mysqli_query($connect, $findUsername) or die('query error: ' . mysqli_error($connect));
				if(mysqli_num_rows($checkUsername)){
					$error=true;
					$errorMessage["username"] = "This username is taken (id:$userID)";
				}else{
					$updateUsername = "Update users Set username = '".$updateUser['username']."' Where userID = $userID";
					$setUsername = @mysqli_query($connectAdmin, $updateUsername) or die('query error: ' . mysqli_error($connectAdmin));
				}
			}else{
				$error=true;
				$errorMessage['username']="You must have a username";
			}
		}
		
		/***********Email*********/
		if($updateUser['email']!=$email){
			if(isset($updateUser['email']) && $updateUser['email']!=null && $updateUser['email']!="" && strlen($updateUser['email'])>=6 && validEmail($updateUser['email'])){
				$findEmail = "SELECT * FROM users WHERE email = '".$updateUser["email"] . "' AND userID<>$userID";
				$checkEmail = @mysqli_query($connect, $findEmail) or die('query error: ' . mysqli_error($connect));
				if(mysqli_num_rows($checkEmail)){
					$error=true;
					$errorMessage["email"] = "An account is already registered with this email address.";
				}else{
					$updateEmail = "Update users Set email = '".$updateUser['email']."' Where userID = $userID";
					$setEmail = @mysqli_query($connectAdmin, $updateEmail) or die('query error: ' . mysqli_error($connectAdmin));
				}
			}else{
				$error=true;
				if(!validEmail($updateUser['email'])){
					$errorMessage['email']="Email must be valid";
				}
				if(strlen($updateUser['email'])<6){
					$errorMessage['email']="You must have an email";
				}
			}
		}
		
		if(!$error){
			$usersuccess = ($editOther) ? "/$edituser[userID]" : "";
			header("Location: /admin/account/success$usersuccess");
		}
	}
	
	/*******Reset Password*******/
	if(isset($updateUser[reset])){
		if($editOther){
			$password= generatePassword();
			$pwd = sha1($password);	
	
			$updateEmail = "Update users Set password = '$pwd' WHERE userID = $userID";
			$setEmail = @mysqli_query($connectAdmin, $updateEmail) or die('query error: ' . mysqli_error($connectAdmin));
		
			if($setEmail){
				$to = $email;
				$subject = "Password Reset: Administrative Account";
		
				$headers = "From: noreply@siteurl.com\r\n";
				$headers .= "Reply-To: noreply@siteurl.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
				$filename="modules/admin/account/resetTemplate.html";
				$output="";
				if(is_file($filename)){
					$file = fopen("$filename", "r");
					if($file){
						while(!feof($file)) {
						  $output = $output . fgets($file, 4096);
						}
						fclose ($file); 
					}
					$message = str_replace("[%username%]", $username, $output);
					$message = str_replace("[%password%]", $password, $message);
					$mailSent = mail($to, $subject, $message, $headers);
					if($mailSent){
					?>
						<h3>Thank You! <?php print $name; ?> will receive an email shortly with their temporary password.</h3>
					<?php
					}else{
					?>
						<h3>An error occured and no email will be sent, please contact an administrator to reset the users password.</h3>
					<?php
					}
				}
			}
			$usersuccess = ($editOther) ? "/$edituser[userID]" : "";
		}
	}
	
	/*******Reset Password*******/
	if(isset($updateUser[delete])){
		if($editOther){
			$deleteUser = "DELETE FROM users WHERE userID = $userID";
			$doDeleteUser = @mysqli_query($connectAdmin, $deleteUser) or die('query error: ' . mysqli_error($connectAdmin));
			header("Location: /admin/account/deleted");
		}
	}
?>