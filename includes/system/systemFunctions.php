<?php
class Common{

	private $scripts = Array();
	private $styles = Array();
	private $doUpdate = true;
	
	function OB_Callback($buffer){
		global $globalSettings;
		
		$html = $buffer;
		$html = str_replace("<smurf:styles />", self::GetStyles(), $html);
		$html = str_replace("<smurf:scripts />", self::GetScripts(), $html);
		
		if(CommonSettings::CompressHTML){
			$html = self::StripBufferSkipTextareaTags($html);
		}
		
		return $html;
	}
	
	private function StripBufferSkipTextareaTags($buffer){
		$poz_current = 0;
		$poz_end = strlen($buffer)-1;
		$result = "";
		
		while ($poz_current < $poz_end){
			$t_poz_start = stripos($buffer, "<textarea", $poz_current);
			if ($t_poz_start === false){
				$buffer_part_2strip = substr($buffer, $poz_current);
				$temp = self::StripBuffer($buffer_part_2strip);
				$result .= $temp;
				$poz_current = $poz_end;
			}
			else{
				$buffer_part_2strip = substr($buffer, $poz_current, $t_poz_start-$poz_current);
				$temp = self::StripBuffer($buffer_part_2strip);
				$result .= $temp;
				$t_poz_end = stripos($buffer, "</textarea>", $t_poz_start);
				$temp = substr($buffer, $t_poz_start, $t_poz_end-$t_poz_start);
				$result .= $temp;
				$poz_current = $t_poz_end;
			}
		}
		return $result;
	}
	
	private function StripBuffer($buffer){
		// change new lines and tabs to single spaces
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $buffer);
		// multispaces to single...
		$buffer = ereg_replace(" {2,}", ' ',$buffer);
		// remove single spaces between tags
		$buffer = str_replace("> <", "><", $buffer);
		return $buffer;
	}
	
	function IsActivePage($relativeURL, $class=""){
		if(self::IsCurrentPage($relativeURL)){
			print " class='active $class'";
		}else{
			print " class='$class'";
		}
	}
	
	function IsCurrentPage($relativeURL){
		global $url;
		$rURL = explode("/",$relativeURL);
		if($rURL[1]==$url[0]){
			return true;
		}else{
			return false;
		}
	}
	
	function PrintListItemLink($name, $link, $class=''){
		print "<li";
		print self::IsActivePage($link, $class);
		print "><a href=\"$link\">$name</a></li>" ;
	}
	
	
	
	/**
	*	Add the script file to the head for library use
	**/
	function AddBaseScript($script_path){
		if(!isset($_GET["print"])){
			global $scripts;
			global $doUpdate;
			print "<script type=\"text/javascript\" src=\"/$script_path\"></script>";
		}
	}
	
	/** 
	*	Add the script file to the common js
	**/
	function AddScript($script_path){
		global $scripts;
		global $doUpdate;
		global $globalSettings;
		
		if(!isset($_GET["print"])){
			if($scripts==null ||  !in_array($script_path, $scripts)){
			
				if(CommonSettings::CompressJavascript){
					$script_path = str_replace(".js", ".js.gzip", $script_path);
				}
				$scripts[] = $script_path;
			}
		}
	}
	
	private function GetScripts(){
		global $scripts;
		
		$collectiveScripts="";
		foreach($scripts as $script){
			$collectiveScripts.="<script type=\"text/javascript\" src=\"/$script\"></script>";
		}
		
		/*
			if($doUpdate){
				if (isset($script_path)) {
					$scripts .= minifyJS($script_path);
					$scriptFile = "script.js";
					$fh = fopen($scriptFile, 'w') or die("can't open file");
					fwrite($fh, $scripts);
					fclose($fh);		
				}else{
					trigger_error('Script file not found');
				}
			}
			*/
			
		return $collectiveScripts;
	}
	
	/**
	*	Add the style file to the common css and minify it
	**/
	function AddStyle($style_path){
		global $styles;
		global $doUpdate;
		global $globalSettings;
		
		if(!isset($_GET["print"])){
			if($styles==null || !in_array($style_path, $styles)){
				if(CommonSettings::CompressCSS){
					$style_path = str_replace(".css", ".css.gzip", $style_path);
				}
				$styles[] = $style_path;
			}
			
			/*
			if($doUpdate){
				if (isset($style_path)) {
					$styles .= minifyCss("$style_path");
					$styleFile = "style.css";
					$fh = fopen($styleFile, 'w') or die("can't open file");
					fwrite($fh, $styles);
					fclose($fh);
				}else{
					trigger_error('Script file not found');
				}
			}
			*/
		}
	}
	
	private function GetStyles(){
		global $styles;
		
		$collectiveStyles="";
		foreach($styles as $style){
			$collectiveStyles.="<link rel=\"stylesheet\" type=\"text/css\" href=\"/$style\" />";
		}
		
		return $collectiveStyles;
	}
	
	/**
	*   Add a Vendor
	**/
	function AddVendor($vendor){
		global $mysqlReader;
		global $mysqlAdmin;
		global $url;
		include("vendors/$vendor/index.php");
	}
	
	function IncludeColHeader($cols){
		global $rootpath;
		
		if($cols == 1){
			include_once $rootpath."includes/templates/oneColHeader.php";
		}
		if($cols == 2){
			include_once $rootpath."includes/templates/twoColHeader.php";
		}
	}
	
	function IncludeColFooter($cols){
		global $rootpath;
	
		if($cols == 1){
			include_once $rootpath."includes/templates/oneColFooter.php";
		}
		if($cols == 2){
			include_once $rootpath."includes/templates/twoColFooter.php";
		}
	}
	
}
?>