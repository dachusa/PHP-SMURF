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
?>