<?php
	class PageObject{		
		public $pageID;
		public $shortURL;
		public $fullURL;
		public $title;
		public $parentID;
		public $menuID;
		public $cols;
		public $dbContent;
		public $content;
		
		public function __construct($pageID, $shortURL, $fullURL, $title, $parentID, $menuID, $cols, $dbContent)  
		{  
			$this->pageID = $pageID;
			$this->shortURL = $shortURL;
			$this->fullURL = $fullURL;
			$this->title = $title;
			$this->parentID = $parentID;
			$this->menuID = $menuID;
			$this->cols = $cols;
			$this->dbContent = $dbContent;
		}  
	}
	
	class Page{
		function GetByShortURL($shortURL){
			global $mysqlReader;
			$sqlCommand = "SELECT * FROM pages where shortURL = :shortURL";
			$sqlParameters = Array(":shortURL"=>$shortURL);
			$pages = DB::Query($sqlCommand, $sqlParameters);
			foreach($pages as $page){
				$page = self::arrayToObject($page);
				if($page->dbContent){
					$page->pageContent = Page::GetPageContent($page->pageID);
				}
				return $page;
			}
			return null;
		}
		
		/**
		*
		**/
		function GetPageContent($pageID){
			global $mysqlReader;
			global $mysqlAdmin;
			global $url;
			
			$sqlCommand = "SELECT * FROM pageContent where pageID = :pageID";
			$sqlParameters = Array(":pageID"=>$pageID);
			$pages = DB::Query($sqlCommand, $sqlParameters);
			
			foreach($pages as $page){
				return $page['content'];
			}
			return null;
		}
		
		function arrayToObject($pageArray){			
			return new PageObject(
				$pageArray['pageID'],
				$pageArray['shortURL'],
				$pageArray['fullURL'],
				$pageArray['title'],
				$pageArray['parentID'],
				$pageArray['menuID'],
				$pageArray['cols'],
				$pageArray['dbContent']
			);
		}
	}
?>