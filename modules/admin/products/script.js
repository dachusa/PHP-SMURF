$(function(){
	$(".productsForm .editProductBtn").click(function(){
		loadProduct($(".productsForm .productsList option:selected").val());
	});
	$(".productsForm .deleteProductBtn").click(function(){
		var deleteTrue = confirm("Are you sure you want to delete this product?");
		if(deleteTrue){
			deleteProduct($(".productsForm .productsList option:selected").val());
		}
	});
	$(".productForm .newProductBtn").click(function(){
		resetForm();
	});
	$(".productForm .submitBtn").click(function(){
		saveProduct();
	});
	$(".photoInserter").click(function(){
		$(".photoHandler").slideDown();
	});

	$(".productImages").change(function(){
		setSelectedImage();
	});
	
	$(".photoHandler #photoUpload").ajaxForm({
		success: function(data) {
			if(data.indexOf("Error", 0)==0){
				alert(data);
			}else{
				$(".productImages li:selected").removeAttr("selected");
				var newLI = "<option selected=\"selected\" value=\"" + data + "\">" + data.replace("/images/products/","") + "</option>";
				$(".productImages").append(newLI);
				setSelectedImage();
				$(".photoHandler").slideUp();
			}
		}
	});
	$(".photoHandler .closeUpload").click(function(){
		$(".photoHandler").slideUp();
		return false;
	});
	
	resetForm();
});

function setSelectedImage(){
	var imagePath = $(".productImages").val();
	$("#imagePreview").attr("src",imagePath);
	$("#product\\[image\\]").val(imagePath);
}

function loadProduct(id){
	var url = "/json/loadProduct/"+id;
	$.getJSON(
	  url,
	  function(data){
		populateValues(data);
		$(".productForm .newProductBtn").show();
		$(".productForm .submitBtn").val("Update Product");
	  }
	);
}

function reloadProducts(){
	var url = "/json/loadProduct";
	$.getJSON(
	  url,
	  function(data){
		populateProducts(data.products);
	  }
	);
}

function saveProduct(){
	var data ="";
	data+= "product[id]="+escape($("#product\\[id\\]").val());
	data+="&product[name]="+escape($("#product\\[name\\]").val());
	data+="&product[description]="+escape($("#product\\[description\\]").val());
	data+="&product[category]="+escape($("#product\\[category\\]").val());
	data+="&product[image]="+escape($("#product\\[image\\]").val());
	if($("#product\\[active\\]").is(":checked")){
		data+="&product[active]=1";
	}else{
		data+="&product[active]=0";
	}
	
	 $.ajax({
		type: "POST",
		url: "/admin/products/action",
		dataType: "application/x-www-form-urlencoded",
		data: "action=save&"+data,
		async: false,
		success: function(msg) {
			alert(msg);
			reloadProducts();
			resetForm();
		}
	});
	
}

function deleteProduct(id){
	$.ajax({
		type: "POST",
		url: "/admin/products/action",
		dataType: "application/x-www-form-urlencoded",
		data: "action=delete&product[id]="+id,
		async: false,
		success: function(msg) {
			alert(msg);
			reloadProducts();
			resetForm();
		}
	});
}
function populateValues(data){
	resetForm();
		
	//inputs
	$("#product\\[id\\]").val(data.id);
	$("#product\\[name\\]").val(data.name);
	$("#product\\[description\\]").val(data.description);
	
	//selects
	$("#product\\[category\\] option:selected").removeAttr("selected");
	$("#product\\[category\\]").val(data.category);
	$("#product\\[image\\]").val(data.image);
	$(".productImages").val(data.image);
	$("#imagePreview").attr("src",data.image);	
	
	//checkboxes
	if(data.active==0){
		$("#product\\[active\\]").attr("checked","false");
	}
}
function populateProducts(products){
	var dom="";
	for(var i=0; i<products.length;i++){
		dom+="<option value=\""+products[i].id+"\">"+products[i].name+"</option>";
	}
	$(".productsList").html(dom);
}
function resetForm(){
	$("#product\\[id\\]").val("");
	$("#product\\[name\\]").val("");
	$("#product\\[description\\]").val("");
	$("#product\\[category\\]").val(1);
	$("#product\\[active\\]").attr("checked","true");
	$(".productForm .newProductBtn").hide();
	$(".productForm .submitBtn").val("Add Product");
	$(".productImages").val("");
	$("#imagePreview").attr("src","/images/placeholder.png");	
}