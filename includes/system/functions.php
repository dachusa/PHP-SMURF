<?php
	
	function file_extension($filename)
	{
		$path_info = pathinfo($filename);
		return $path_info['extension'];
	}
	
/**
 * Fetch the files contents -- parsed by PHP -- as if it were included
 *
 * @param string $file
 * @return string
 */
function get_include_contents($file) {
	if (!is_file($file) || !file_exists($file) || !is_readable($file)) return false;
	ob_start();
	include($file);
	$contents = ob_get_contents();
	ob_end_clean();
	return $contents;
}

function minifyCss($filename) {
    $css = implode('',file($filename));
    $css = preg_replace('/\s+/', ' ', $css);
    $css = preg_replace('/\/\*.*?\*\//', '', $css);
    $css = preg_replace('/\}/', '}'.chr(13), $css);
    return trim($css);
}
function minifyJS($filename) {
    $js = implode('',file($filename));
    return trim($js);
}

function curPageURL() {
	
	$pageURL = removeCacheBypass(siteURL().$_SERVER["REQUEST_URI"]);
	return $pageURL;
}

function siteURL(){
	$siteURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$siteURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$siteURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	} else {
		$siteURL .= $_SERVER["SERVER_NAME"];
	}
	return $siteURL;
}
function addGetVar($url, $getVar,$getValue){
	if($getValue!=""){
		$getValue="=$getValue";
	}
	if(stristr($url,"?")){
		return $url."&$getVar$getValue";
	}else{
		return $url."?$getVar$getValue";
	}
}
function removeCacheBypass($url){
	global $cacheBypassKey;
	$url = str_replace("bypass=$cacheBypassKey","",$url);
	if(stripos($url,"?")==strlen($url)-1){
		$url = str_replace("?","",$url);
	}
	return $url;
}
function StartsWith($FullStr, $StartStr)
{
	return strtolower(substr($FullStr,0,1)) == $StartStr;
}
function EndsWith($FullStr, $EndStr)
{
	// Get the length of the end string
	$StrLen = strlen($EndStr);
	// Look at the end of FullStr for the substring the size of EndStr
	$FullStrEnd = substr($FullStr, strlen($FullStr) - $StrLen);
	// If it matches, it does end with EndStr
	return $FullStrEnd == $EndStr;
}
function asorti(&$array)
{
   $copy = $array;
   $array = array_map('strtolower', $array);
   asort($array);
   foreach ($array as $index => $value) {
	  $array[$index] = $copy[$index];
   }
   $array = array_values($array);
   
}
function reverse_escape($str)
{
  $escapeArr=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
  $replaceArr=array("\\","\0","\n","\r","\x1a","'",'"');
  return str_replace($escapeArr,$replaceArr,$str);
}
?>