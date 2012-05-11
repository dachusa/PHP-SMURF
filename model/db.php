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

	class DBConnection{
		public $readOnly;
		public $readWrite;
				
		public function __construct($readOnly, $readWrite)  
		{  
			$this->readOnly = $readOnly;
			$this->readWrite = $readWrite;
		}
	}
	
	class DB extends ConnectionSettings{
		private static $dbConnection;
		
		function EstablishConnections(){
			//Establish Read Only Connection
			if(!isset($mysql) || $mysql==null){				
				$mysqlReader =  new PDO("mysql:host=" . self::Host . ";dbname=".self::DBName, self::ReadOnlyUser, self::ReadOnlyPassword);
			}
			
			//Establish Read Write Connection
			if(!isset($mysql) || $mysql==null){				
				$mysqlAdmin =  new PDO("mysql:host=" . self::Host . ";dbname=".self::DBName, self::ReadWriteUser, self::ReadWritePassword);
			}
			
			self::$dbConnection = new DBConnection($mysqlReader, $mysqlAdmin);
		}
		
		function Query($sqlCommand,$sqlParameters=null){
			try {
				$readOnly = self::$dbConnection->readOnly;
				$readOnly->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if($sqlParameters!=null){
					$sqlQuery = $readOnly->prepare($sqlCommand);
					$sqlQuery->execute($sqlParameters);
					return $sqlQuery->fetchAll();
				}else{
					$sqlResponse = $readOnly->query($sqlCommand);
					return $sqlResponse;
				}
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		}
		function QueryCount($sqlCommand,$sqlParameters=null){
			try {
				$readOnly = self::$dbConnection->readOnly;
				$readOnly->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if($sqlParameters!=null){
					$sqlQuery = $readOnly->prepare($sqlCommand);
					$sqlQuery->execute($sqlParameters);
					return sizeof($sqlQuery->fetchAll());
				}else{
					$readOnly->query($sqlCommand);
					$foundRows = $readOnly->query("SELECT FOUND_ROWS()")->fetchColumn();
					return $foundRows;
				}
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		}
	}
	
	DB::EstablishConnections();
?>