<?php 
	$includeDir = array (
		$rootpath.'config/',
		$rootpath.'includes/system/',
		$rootpath.'model/'
	);
	
	foreach ($includeDir as $directory) {
		foreach (glob("{$directory}*.php") as $filename)
		{			
			require_once $filename;
		}
	}
	
	//Include Modules
	$modulesPath = $rootpath."modules/";
	find_files($modulesPath, '/model.php$/', 'includeModel');
	
	function includeModel($model){
		include_once $model;
	}
	function find_files($path, $pattern, $callback) {
		$path = rtrim(str_replace("\\", "/", $path), '/') . '/';
		$matches = Array();
		$entries = Array();
		$dir = dir($path);
		while (false !== ($entry = $dir->read())) {
			$entries[] = $entry;
		}
		$dir->close();
		foreach ($entries as $entry) {
			$fullname = $path . $entry;
			if ($entry != '.' && $entry != '..' && is_dir($fullname)) {
				find_files($fullname, $pattern, $callback);
			} else if (is_file($fullname) && preg_match($pattern, $entry)) {
				call_user_func($callback, $fullname);
			}
		}
	}
	
?>