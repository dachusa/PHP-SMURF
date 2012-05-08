<?php
setcookie("session_id",time() +"3600"); 

$cookies = 0; 
if (isset($_COOKIE["session_id"])) { 
	$cookies = 1; 
} 

if($cookies==0){
	print "cookies are disabled";
}else{
	print "cookies are enabled";
}
?>