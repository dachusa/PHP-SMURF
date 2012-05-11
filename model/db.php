<?php
	class SQLParameter{
		public $parameter;
		public $value;
		public $dataType;
		
		public function __construct($parameter, $value, $dataType="string")  
		{  
			$this->parameter = $parameter;
			$this->value = $value;
			switch($dataType){
				case "string":
					$this->dataType = PDO::PARAM_STR;
					break;
				case "int":
					$this->dataType = PDO::PARAM_INT;
					break;
				case "bool":
					$this->dataType = PDO::PARAM_BOOL;
					break;
				case "null":
					$this->dataType = PDO::PARAM_NULL;
					break;
				default:
					$this->dataType = PDO::PARAM_STR;
			}
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
					foreach($sqlParameters as $sqlParameter){
						$sqlQuery->bindParam($sqlParameter->parameter, $sqlParameter->value, $sqlParameter->dataType);
					}
					$sqlQuery->execute();
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