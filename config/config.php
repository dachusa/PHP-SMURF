<?php
	date_default_timezone_set('America/Boise');

	$globalSettings = Array(
		// Connection Settings
		// Read Only User
		"ReadOnlyUser" => array(
			"host" => "localhost",
			"user" => "",
			"pass" => "",
			 "dbname" => ""
			 ),
		// User with Select, Delete, Insert, and Update permissions
		"ReadWriteUser" => array(
			"host" => "localhost",
			"user" => "",
			"pass" => "",
			 "dbname" => ""
			 ),
		//Compress File Settings
		"CompressHTML"=>true,
		"CompressJavascript" => true,
		"CompressCSS" => true
	);
?>