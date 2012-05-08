<?php
	if(isset($url[1])){
		$data = $url[1];
	}else{
		include("errors/404.php");
	}
	
	switch($data){
		case "loadProduct":
			include("modules/json/loadProduct.php");
			break;
		case "loadTraining":
			include("modules/json/loadTraining.php");
			break;
		default:
			include("errors/404.php");
	}
?>