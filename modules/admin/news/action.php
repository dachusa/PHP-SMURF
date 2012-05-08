<?php
	$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/";
	require_once $rootpath . 'includes/bootstrap.php'; 
	require_once $rootpath . 'modules/admin/connect.php';
	
	$action = $_POST["action"];
	$newsArticle = $_POST["news"];
	switch($action){
		case "save":
			saveArticle($newsArticle);
			break;
		case "delete":
			deleteArticle($newsArticle);
			break;
		default:

	}
	
	function saveArticle($newsArticle){
		$newsArticle[body] = mysql_real_escape_string($newsArticle[body]);
		$newsArticle[starttime] = date("Y-m-d h:i:s A",strtotime($newsArticle[starttime]));
		$newsArticle[endtime] = ($newsArticle[endtime]!="") ? date("Y-m-d h:i:s A",strtotime($newsArticle[endtime])) : "";
		if($newsArticle[id]!=""){
			updateArticle($newsArticle);
		}else{
			insertArticle($newsArticle);
		}
	}

	function deleteArticle($newsArticle){
		global $connectAdmin;
		$deleteArticle = "DELETE FROM newsitems WHERE newsitemsid = '$newsArticle[id]'";
		$doDeleteArticle = @mysqli_query($connectAdmin, $deleteArticle) or die('query error: ' . mysqli_error($connectAdmin));
		print "Delete Successful";
	}
	
	function updateArticle($newsArticle){
		global $connectAdmin;
		$articleExists = false;
		$checkForArticle = "SELECT * FROM newsitems WHERE newsitemsid = '$newsArticle[id]'";
		$getArticle = @mysqli_query($connectAdmin, $checkForArticle) or die('query error: ' . mysqli_error($connectAdmin));
			if(mysqli_num_rows($getArticle)){
				$articleExists = true;
			}
		if($articleExists){
			$updateArticle = "UPDATE newsitems SET categoryid = '$newsArticle[category]', starttime='$newsArticle[starttime]', endtime='$newsArticle[endtime]', title='$newsArticle[title]', body='$newsArticle[body]', active=$newsArticle[active]  WHERE newsitemsid = '$newsArticle[id]'";
			$doUpdateArticle = @mysqli_query($connectAdmin, $updateArticle) or die('query error: ' . mysqli_error($connectAdmin));
			print "Update Successful";
		}else{
			print "Cannot update: the selected news article ID does not exist.";
		}
	}
	function insertArticle($newsArticle){
		global $connectAdmin;
		$insertRow = "INSERT INTO newsitems (categoryid, starttime, endtime, title, body, active) VALUES ('$newsArticle[category]', '$newsArticle[starttime]', '$newsArticle[endtime]', '$newsArticle[title]', '$newsArticle[body]', '$newsArticle[active]')";
		$doInsertRow = @mysqli_query($connectAdmin, $insertRow) or die('query error: ' . mysqli_error($connectAdmin));
		print "Insert Successful";
	}
?>