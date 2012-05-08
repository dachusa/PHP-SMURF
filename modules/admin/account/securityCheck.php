<?php
session_start();

unset($_SESSION[user]);
unset($user);

$user["sGUID"]=$_SESSION["session_id"];

$user["sGUID2"]=$_COOKIE["session_id"];

if(isset($url)){
	$source = "/".implode("/",$url);
}else{
	$source = $_SERVER["REQUEST_URI"];
}
if($user[sGUID]==$user[sGUID2] && $user[sGUID2]!=null && $user[sGUID2]!=""){
	$findUser = "SELECT name, username, securityLevel, temp, sGUID FROM users WHERE sGUID = '$user[sGUID]'";
	$getUser = @mysqli_query($connect, $findUser) 
		or die('query error: ' . mysqli_error($connect));
	if($row = mysqli_fetch_array($getUser)) {
		extract($row);
		setcookie("session_id", $sGUID, time()+3600, "/admin/");
		$user = array();
		$user["securityLevel"]=$securityLevel;
		$user["username"]=$username;
		$user["name"]=$name;
		$_SESSION[user] = $user;
		if($temp){
			if(isset($_POST['source'])){
				setcookie("source", $_POST['source'], time()+3600, "/admin/");
			}else{
				setcookie("source", $source, time()+3600, "/admin/");
			}			
			if($url[2]!="temp"){
				header("Location: /admin/account/temp");
			}
		}
		if($securityLevel>$adminSecurity){
			header("Location: /admin/account/restricted");
		}
	} else {
		setcookie("source", $source, time()+3600, "/admin/");
		header("Location: /admin/login");
	}
}else {
	setcookie("source", $source, time()+3600, "/admin/");
	header("Location: /admin/login");
}
?>