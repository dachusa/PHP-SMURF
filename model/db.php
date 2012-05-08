<?php
	class SQLParameter{
		public $parameter;
		public $variable;
		public $dataType;
		
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

	class DB{
		function Query($sqlCommand,$sqlParameters=null){
			global $mysqlReader;
			
			try {
				$mysqlReader->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if($sqlParameters!=null){
					$sqlQuery = $mysqlReader->prepare($sqlCommand);
					$sqlQuery->execute($sqlParameters);
					return $sqlQuery->fetchAll();
				}else{
					$sqlResponse = $mysqlReader->query($sqlCommand);
					return $sqlResponse;
				}
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		}
		function QueryCount($sqlCommand,$sqlParameters=null){
			global $mysqlReader;
			
			try {
				$mysqlReader->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if($sqlParameters!=null){
					$sqlQuery = $mysqlReader->prepare($sqlCommand);
					$sqlQuery->execute($sqlParameters);
					return sizeof($sqlQuery->fetchAll());
				}else{
					$mysqlReader->query($sqlCommand);
					$foundRows = $mysqlReader->query("SELECT FOUND_ROWS()")->fetchColumn();
					return $foundRows;
				}
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		}
	}
?>