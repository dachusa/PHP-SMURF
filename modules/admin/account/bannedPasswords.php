<?php
function inBanList($password){
	$banList = array(
		"password",
		"password1",
		"12345678"
		);
	if(in_array($password,$banList)){
		return true;
	}else{
		return false;
	}
}
?>