<?php
	class MenuItem{		
		public $title;
		public $rank;
		public $pageID;
		public $menuID;
		public $page;
		
		public function __construct($title, $rank, $pageID, $menuID, $page)  
		{  
			$this->title = $title;
			$this->rank = $rank;
			$this->pageID = $pageID;
			$this->menuID = $menuID;
			$this->page = $page;
		}  
	}

	class SiteMenu{
		function GetSiteMenuItems(){
			$sqlCommand = 
				"SELECT 
					menuitems.title,
					menuitems.rank,
					menuitems.pageID as menuPageID,
					menuitems.menuID,
					pages.pageID,
					pages.shortURL,
					pages.fullURL,
					pages.title as pageTitle,
					pages.parentID,
					pages.menuID as pageMenuID,
					pages.cols,
					pages.dbContent
				FROM menuitems
				INNER JOIN 
					pages on menuitems.pageID = pages.pageID
				WHERE menuitems.menuID = 0
				ORDER BY rank";

			$menuItems = Array();
			foreach(DB::Query($sqlCommand) as $dbMenuItem){
				$menuPage = new PageObject(
											$dbMenuItem['pageID'],
											$dbMenuItem['shortURL'],
											$dbMenuItem['fullURL'],
											$dbMenuItem['pageTitle'],
											$dbMenuItem['parentID'],
											$dbMenuItem['pageMenuID'],
											$dbMenuItem['cols'],
											$dbMenuItem['dbContent']
										);
				$menuItem = new MenuItem(
										$dbMenuItem['title'],
										$dbMenuItem['rank'],
										$dbMenuItem['menuPageID'],
										$dbMenuItem['menuID'],
										$menuPage
									);
				$menuItems[] = $menuItem;
			}
			unset($sqlCommand);
			return $menuItems;
		}
	}
?>