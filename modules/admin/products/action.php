<?php
	ob_end_clean();
	$action = $_POST["action"];
	$product = $_POST["product"];
	
	switch($action){
		case "save":
			saveProduct($product);
			break;
		case "delete":
			deleteProduct($product);
			break;
		default:

	}
	
	function saveProduct($product){
		global $connectAdmin;
		$product[description] = mysqli_real_escape_string($connectAdmin, $product[description]);

		if($product[id]!=""){
			updateProduct($product);
		}else{
			insertProduct($product);
		}
	}

	function deleteProduct($product){
		global $connectAdmin;
		$deleteProduct = "DELETE FROM products WHERE id = '$product[id]'";
		$doDeleteProduct = @mysqli_query($connectAdmin, $deleteProduct) or die('query error: ' . mysqli_error($connectAdmin));
		print "Delete Successful";
	}
	
	function updateProduct($product){
		global $connectAdmin;
		$productExists = false;
		$checkForProduct = "SELECT * FROM products WHERE id = '$product[id]'";
		$getProduct = @mysqli_query($connectAdmin, $checkForProduct) or die('query error: ' . mysqli_error($connectAdmin));
			if(mysqli_num_rows($getProduct)){
				$productExists = true;
			}
		if($productExists){
			$updateProduct = "UPDATE products SET categoryID= '$product[category]', name='$product[name]', description='$product[description]', image='$product[image]', active=$product[active]  WHERE id = '$product[id]'";
			$doUpdateProduct = @mysqli_query($connectAdmin, $updateProduct) or die('query error: ' . mysqli_error($connectAdmin));
			print "Update Successful";
		}else{
			print "Cannot update: the selected product ID does not exist.";
		}
	}
	function insertProduct($product){
		global $connectAdmin;		
		$insertRow = "INSERT INTO products (categoryid, name, description, image, active) VALUES ('$product[category]', '$product[name]', '$product[description]', '$product[image]', '$product[active]')";
		$doInsertRow = @mysqli_query($connectAdmin, $insertRow) or die('query error: ' . mysqli_error($connectAdmin));
		print "Insert Successful";
	}
?>