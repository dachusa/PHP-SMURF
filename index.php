<?php
	ob_start();
	$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/";
	require_once $rootpath . 'includes/bootstrap.php'; 
	
	$url = explode("/",$_GET["page"]);
	if($cache && $url[0]=="" && !$cacheBypass && !isset($_GET["print"])){
		include("index.htm");
	}else{
		if($cacheBypass){
			$_GET['bypass']=null;
		}
		$page = Page::GetByShortURL($url[0]);

		if($page != null){
			if(!isset($_GET["print"])){
				if($page->cols>0){
					include_once 'includes/templates/header.php';
					Common::IncludeColHeader($page->cols);
				}
				
				if(!file_exists($page->fullURL) && $page->dbContent == 1){
					print $page->pageContent;
				}else{
					include_once $page->fullURL;
				}
				
				if($page->cols>0){
					Common::IncludeColFooter($page->cols);
					include_once 'includes/templates/footer.php';
				}
			}else{
				include_once 'includes/templates/printHeader.php';
				include_once $page->fullURL;
				include_once 'includes/templates/printFooter.php';
			}
		}else{
			include_once 'includes/templates/header.php';
			include_once 'errors/404.php';
			include_once 'includes/templates/footer.php';
		}
	}
	require_once 'includes/finalAct.php';
	ob_end_flush();
?>
