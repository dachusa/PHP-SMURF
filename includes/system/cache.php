<?php
	$cache=false;
	$cacheBypassKey="0Av!dkc83kd";
	$cacheBypass = false;
	if(isset($_GET["bypass"])&&$cacheBypassKey==$_GET["bypass"]){
		$cacheBypass = true;
	}
?>