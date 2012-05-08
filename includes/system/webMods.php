<?php
function webValid($str){
	$str = str_replace("®","&reg;",$str);
	$str = str_replace("'","&#39;",$str);
	$str = str_replace("’","&#39;",$str);
	//$str = str_replace("\"","&quot;",$str);
	$str = str_replace("\&","&amp;",$str);
	$str = str_replace("–","&ndash;",$str);
	return $str;
}

function linkHttp($str){
	$str= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $str);  
	$str= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $str);  
	$str= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $str);  
	
	return $str;
}
?>