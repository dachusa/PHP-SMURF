<?php if(isset($url[2]) && $url[2]=="action"){
	include("modules/admin/products/action.php");
	exit;
}?>
<?php addStyle("modules/admin/products/style.css"); ?>
<?php addVendor('tinyMCE'); ?>
<div class="heading">
	<h1>Products Admin</h1>
</div>
<div class="content">
	<form method="post" action="/admin/products" class="productsForm">
		<div>
			<select name="products" size="10" class="productsList">
				<?php 
					getProducts();
				?>
			</select>
			<p>
				<input type="button" value="Edit Product" class="editProductBtn" />
				<input type="button" value="Delete Product" class="deleteProductBtn"/>
			</p>
		</div>
	</form>
	<hr/>
	<form method="post" action="/admin/products" class="productForm">
		<input type="hidden" name="product[id]" id="product[id]"/>
		<p>
			<input type="button" value="New Product" class="newProductBtn" />
		</p>
		<p class="productName">
			<label for="product[name]">Name</label>
			<input type="text" name="product[name]" id="product[name]" />
		</p>
		<p class="productCategory">
			<label for="product[category]">Category</label>
			<select name="product[category]" id="product[category]">
				<?php 
					getCategoryOptions();
				?>
			</select>
		</p>
		<p class="productBody">
			<label for="product[description]">Description</label>
			<?php 
				tinyMCEBox("product[description]");
			?>
		</p>
		<p class="productImage">
			<label for="product[image]">Image</label>
			<input type="hidden" name="product[image]" id="product[image]" value="" />
			<img src="" alt="Product Image" id="imagePreview" />
			<select name="productImages" class="productImages">
				<option>Select Image</option>
				<?php 
					getProductImages();
				?>
			</select>
			<input type="button" name="addImageBtn" value="+" class="photoInserter"/>
		</p>
		<p class="productActive">
			<label for="product[active]">Active</label>
			<input type="checkbox" name="product[active]" id="product[active]" checked="checked"/>
		</p>
		<p>
			<input type="button" value="Add Product" class="submitBtn"/>
		</p>
	</form>
	<?php include('modules/admin/products/photoDialog.php'); ?>
</div>
<?php 
	addScript("modules/admin/products/script.js"); 
	addScript("scripts/jquery.form.js"); 
?>
<?php
	function getCategoryOptions(){
		global $connect;		
		$findCategories = "SELECT * FROM productcategories";
		$getCategories = @mysqli_query($connect, $findCategories) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getCategories)){
			extract($row);
			print "<option value=\"$id\">$name</option>";
		}
	}
	function getProducts(){		
		global $connect;		
		$findProducts = "SELECT id, name FROM products ORDER BY name";
		$getProducts = @mysqli_query($connect, $findProducts) or die('query error: ' . mysqli_error($connect));
		while($row = mysqli_fetch_array($getProducts)){
			extract($row);
			print "<option value=\"$id\">$name</option>";
		}
	}
	function getProductImages(){
		$images = array();	
		$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/";
		$path = $rootpath ."images/products/";
		if($handle = opendir($path)){
			/* This is the correct way to loop over the directory. */
			while (false !== ($image = readdir($handle))) {
				if($image!="."&&$image!=".."){
					$images[] = array(filemtime($path.$image),$image);
				}
			}
			rsort($images);
			$count = sizeof($images);	
			for ($i = 0; $i<$count; $i++) {
				print "<option value=\"/images/products/".$images[$i][1]."\">".$images[$i][1]."</option>";
			}
		}
	}
?>
