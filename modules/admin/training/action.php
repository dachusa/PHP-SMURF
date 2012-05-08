<?php	
	ob_end_clean();
	$action = $_POST["action"];
	$training = $_POST["training"];
	
	switch($action){
		case "save":
			saveTraining($training);
			break;
		case "delete":
			deleteTraining($training);
			break;
		default:

	}
	
	function saveTraining($training){
		global $connectAdmin;
		$training[description] = mysqli_real_escape_string($connectAdmin, $training[description]);

		if($training[id]!=""){
			updateTraining($training);
		}else{
			insertTraining($training);
		}
	}

	function deleteTraining($training){
		global $connectAdmin;
		$deleteTraining = "DELETE FROM training WHERE id = '$training[id]'";
		$doDeleteTraining = @mysqli_query($connectAdmin, $deleteTraining) or die('query error: ' . mysqli_error($connectAdmin));
		print "Delete Successful";
	}
	
	function updateTraining($training){
		global $connectAdmin;
		$trainingExists = false;
		$checkForTraining = "SELECT * FROM training WHERE id = '$training[id]'";
		$getTraining = @mysqli_query($connectAdmin, $checkForTraining) or die('query error: ' . mysqli_error($connectAdmin));
			if(mysqli_num_rows($getTraining)){
				$trainingExists = true;
			}
		if($trainingExists){
			$updateTraining = "UPDATE training SET title='$training[title]', description='$training[description]', duration='$training[duration]', active=$training[active]  WHERE id = '$training[id]'";
			$doUpdateTraining = @mysqli_query($connectAdmin, $updateTraining) or die('query error: ' . mysqli_error($connectAdmin));
			print "Update Successful";
		}else{
			print "Cannot update: the selected training ID does not exist.";
		}
	}
	function insertTraining($training){
		global $connectAdmin;		
		$insertRow = "INSERT INTO training (title, description, duration, active) VALUES ('$training[title]', '$training[description]', '$training[duration]', '$training[active]')";
		$doInsertRow = @mysqli_query($connectAdmin, $insertRow) or die('query error: ' . mysqli_error($connectAdmin));
		print "Insert Successful";
	}
?>