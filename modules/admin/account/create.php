 <?php
	$newuser = $_POST["newuser"];
	$error = false;
	$errorMessage = array();
	
	if($newuser["name"]=="" || strpos($newuser["name"]," ")<1){
		$error=true;
		$errorMessage["name"]="Invalid Name";
	}
	
	if($newuser["username"]==""){
		$error=true;
		$errorMessage["username"]="Invalid Username";
	}
	
	$findUsername = "SELECT * FROM users WHERE username = '".$newuser["username"] . "';";
	$checkUsername = @mysqli_query($connect, $findUsername) or die('query error: ' . mysqli_error($connect));
	if(mysqli_num_rows($checkUsername)){
		$error=true;
		$errorMessage["username"] = "Username is taken";
	}
	
	$password= generatePassword();
	$newuser["password"] = sha1($password);	
	
	if(!validEmail($newuser["email"])){
		$error=true;
		$errorMessage["email"]="Invalid Email Address";
	}else{
		$findEmail = "SELECT * FROM users WHERE email = '".$newuser["email"] . "';";
		$checkEmail = @mysqli_query($connect, $findEmail) or die('query error: ' . mysqli_error($connect));
		if(mysqli_num_rows($checkEmail)){
			$error=true;
			$errorMessage["email"] = "An account is already registered with this email address.";
		}
	}
	
	if(!$error){
		$addUser = "INSERT INTO users (name, username, password, email, securityLevel, temp) VALUES ('".$newuser['name']."', '".$newuser['username']."', '".$newuser['password']."', '". $newuser['email'] . "', ".$newuser['security'].", 1)";
		$confirmUser = @mysqli_query($connectAdmin, $addUser) or die('query error: ' . mysqli_error($connectAdmin));
		if($confirmUser){
			
			$to = $newuser['email'];
			$subject = "Administrative Account Registration";
	
			$headers = "From: noreply@siteurl.com\r\n";
			$headers .= "Reply-To: noreply@siteurl.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$filename="modules/admin/account/template.html";
			$output="";
			if(is_file($filename)){
				$file = fopen("$filename", "r");
				if($file){
					while(!feof($file)) {
					  $output = $output . fgets($file, 4096);
					}
					fclose ($file); 
				}
				$message = str_replace("[%username%]", $newuser["username"], $output);
				$message = str_replace("[%password%]", $password, $message);
				$mailSent = mail($to, $subject, $message, $headers);
				if($mailSent){
				?>
				<h1>Thank You! <?php print $newuser["name"]; ?> will receive an email shortly with their temporary password.</h1>
			<?php
				}else{
			?>
					<h1>The user is successfully registered, but an error occured with the mail server.  No confirmation email will be sent, please contact an administrator to reset the users password.</h1>
			<?php
				}
			}
		}
	}else{
		include("modules/admin/account/register.php");
	}
  ?>