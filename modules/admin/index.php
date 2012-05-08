<?php
	require_once $rootpath . 'modules/admin/connect.php'; 
	if(isset($url[1])){
		$findURL = "SELECT * FROM adminswitchboard where adminShortURL = '$url[1]'";
		$getURL = @mysqli_query($connect, $findURL) or die('query error: ' . mysqli_error($connect));
		if(mysqli_num_rows($getURL)){
			$row = mysqli_fetch_array($getURL);
			extract($row);
			if($adminSecurity>-1){
				include("modules/admin/account/securityCheck.php");			
			}
			if($adminPanel==1){
				panelPrep();
			}
			include($adminFullURL);
		}else{
			include("errors/404.php");
		}
	}else{
		include("errors/404.php");
	}
	function panelPrep(){
		global $url;
		addStyle("modules/admin/style.css");
		print "<div class=\"panelLinks\"><ul>";
		if($url[1]!="panel"){
			print "<li><a href=\"/admin/panel\">Admin Panel</a></li>";		
		}
		print "<li><a href=\"/admin/account/settings\">My Account</a></li>";
		print "<li><a href=\"/admin/logout\">Logout</a></li>";
		print "</ul></div>";
		print "<div class='clearFix'></div>";
	}
?>