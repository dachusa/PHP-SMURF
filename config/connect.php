<?php
	//Establish Read Only Connection
	if(!isset($mysql) || $mysql==null){
		 $mysqlReader =  new PDO("mysql:host=$readOnlyUser[host];dbname=$readOnlyUser[dbname]",$readOnlyUser['user'], $readOnlyUser['pass']);
	}
	
	//Establish Read Write Connection
	if(!isset($mysql) || $mysql==null){
		 $mysqlAdmin =  new PDO("mysql:host=$readWriteUser[host];dbname=$readWriteUser[dbname]",$readWriteUser['user'], $readWriteUser['pass']);
	}
?>