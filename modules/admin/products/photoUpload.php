<?php
	$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/";
	require_once $rootpath . 'includes/bootstrap.php'; 
	require_once $rootpath . 'modules/admin/connect.php';

	$path = $rootpath ."images/products/";

	if(isset($_FILES["file"])){
		if (($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")){
			if ($_FILES["file"]["error"] > 0){
				echo "Error: " . $_FILES["file"]["error"] . "<br />";
			}else{
				if (file_exists($path . $_FILES["file"]["name"])){
					echo "Error: " . $_FILES["file"]["name"] . " already exists.";
				}else{
					move_uploaded_file($_FILES["file"]["tmp_name"],
					$path . $_FILES["file"]["name"]);
					$fileName = $path . $_FILES["file"]["name"];
					if (file_exists($fileName)) {	
						print "/images/products/".$_FILES["file"]["name"]."";
					} else {
						echo "Error: Failed to open $fileName";
					}
				}
			}
		}else{
			echo "Error: Invalid file type: ".$_FILES["file"]["type"];
		}
	}
?>