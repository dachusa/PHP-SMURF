<?php
class Common{

	private $scripts="";
	private $styles="";
	private $doUpdate = true;
	
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
		if(!isset($_GET["print"])){
			global $scripts;
			global $doUpdate;
			
			print "<script type=\"text/javascript\" src=\"/$script_path\"></script>";
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
		}
	}
	
	/**
	*	Add the style file to the common css and minify it
	**/
	function AddStyle($style_path){
		if(!isset($_GET["print"])){
			global $styles;
			global $doUpdate;
			
			print "<link rel=\"stylesheet\" type=\"text/css\" href=\"/$style_path\" />";
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
	
	/**
	*   Add a Vendor
	**/
	function AddVendor($vendor){
		global $mysqlReader;
		global $mysqlAdmin;
		global $url;
		include('vendors/$vendor/index.php');
	}
	
	/**
	*   Add Module
	**/
	function AddModule($module){
		global $mysqlReader;
		global $mysqlAdmin;
		global $url;
		include('modules/$module/index.php');
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