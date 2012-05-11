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
			$sqlCommand = 
				"SELECT * 
				FROM pages 
				WHERE shortURL = :shortURL";
			$sqlParameters = Array(
				new SQLParameter(":shortURL", $shortURL, "string")
			);
			$pages = DB::Query($sqlCommand, $sqlParameters);
				unset($sqlCommand);
				unset($sqlParameters);
				
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
			
			$sqlCommand = 
				"SELECT * 
				FROM pageContent 
				WHERE pageID = :pageID";
			$sqlParameters = Array(
				new SQLParameter(":pageID", $pageID, "int")
			);
			$pages = DB::Query($sqlCommand, $sqlParameters);
			
			foreach($pages as $page){
				return $page['content'];
			}
			return null;
		}
		
		private function arrayToObject($pageArray){			
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