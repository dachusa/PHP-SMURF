<?php
	require_once $rootpath . 'modules/admin/connect.php';
	if(count($url) > 2){
		switch($url[2]){
			case "create":
				include("modules/admin/account/create.php");
				break;
			case "manage":
				include("modules/admin/account/manage.php");
				break;
			case "register":
				include("modules/admin/account/register.php");
				break;
			case "login":
				include("modules/admin/account/login.php");
				break;
			case "logout":
				include("modules/admin/account/logout.php");
				break;
			case "settings":
				include("modules/admin/account/settings.php");
				break;
			case "temp":
				include("modules/admin/account/temp.php");
				break;
			case "success":
				include("modules/admin/account/sucess.php");
				break;
			case "deleted":
				include("modules/admin/account/deleted.php");
				break;
			default:
				include("modules/admin/account/account.php");
		}
	}else{
		include("modules/admin/account/account.php");	
	}
?>