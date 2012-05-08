$(function(){
	$(".articlesForm .editArticleBtn").click(function(){
		loadArticle($(".articlesForm .newsArticlesList option:selected").val());
	});
	$(".articlesForm .deleteArticleBtn").click(function(){
		var deleteTrue = confirm("Are you sure you want to delete this article?");
		if(deleteTrue){
			deleteArticle($(".articlesForm .newsArticlesList option:selected").val());
		}
	});
	$(".articleForm .newArticleBtn").click(function(){
		resetForm();
	});
	$(".articleForm #news\\[leavePosted\\]").change(function(){
		if($(this).is(":checked")){
			$(".articleForm .newsEndTime").hide();
		}else{
			$(".articleForm .newsEndTime").show();
		}
	});
	$(".articleForm .submitBtn").click(function(){
		saveArticle();
	});
	$(".photoInserter").click(function(){
		$(".photoHandler").slideDown();
	});
	$(".photoHandler .insertPhotoBtn").click(function(){
			var image ="<img src=\""+$(".newsImages option:selected").val()+"\" alt=\""+$(".newsImages option:selected").html()+"\" />";
			$("#news\\[body\\]").append(image);
			$(".photoHandler").slideUp();
	});
	
	$(".photoHandler #photoUpload").ajaxForm({
		success: function(data) {
			if(data.indexOf("Error", 0)==0){
				alert(data);
			}else{
				$("#news\\[body\\]").append(data);
				$(".photoHandler").slideUp();
			}
		}
	});
	resetForm();
});

function loadArticle(id){
	var url = "/json/loadArticle/"+id;
	$.getJSON(
	  url,
	  function(data){
		populateValues(data);
		$(".articleForm .newArticleBtn").show();
		$(".articleForm .submitBtn").val("Update Article");
	  }
	);
}

function reloadArticles(){
	var url = "/json/loadArticle";
	$.getJSON(
	  url,
	  function(data){
		populateArticles(data.articles);
	  }
	);
}

function saveArticle(){
	var data ="";
	data+= "news[id]="+escape($("#news\\[id\\]").val());
	data+="&news[title]="+escape($("#news\\[title\\]").val());
	data+="&news[body]="+escape($("#news\\[body\\]").val());
	data+="&news[starttime]="+escape($("#news\\[startTime\\]").val());
	data+="&news[endtime]="+escape($("#news\\[endTime\\]").val());
	data+="&news[category]="+escape($("#news\\[category\\]").val());
	if($("#news\\[active\\]").is(":checked")){
		data+="&news[active]=1";
	}else{
		data+="&news[active]=0";
	}
	 $.ajax({
		type: "POST",
		url: "/modules/admin/news/action.php",
		dataType: "application/x-www-form-urlencoded",
		data: "action=save&"+data,
		async: false,
		success: function(msg) {
			alert(msg);
			reloadArticles();
			resetForm();
		}
	});
	
}

function deleteArticle(id){
	$.ajax({
		type: "POST",
		url: "/modules/admin/news/action.php",
		dataType: "application/x-www-form-urlencoded",
		data: "action=delete&news[id]="+id,
		async: false,
		success: function(msg) {
			alert(msg);
			reloadArticles();
			resetForm();
		}
	});
}
function populateValues(data){
	resetForm();
		
	//inputs
	$("#news\\[id\\]").val(data.id);
	$("#news\\[title\\]").val(data.title);
	$("#news\\[body\\]").val(data.body);
	$("#news\\[startTime\\]").val(data.starttime);
	$("#news\\[endTime\\]").val(data.endtime);
	//$("#news\\[startTime\\]").val($.format.date(data.starttime, "dd/MM/yyyy hh:mm:ss a"));
	//$("#news\\[endTime\\]").val($.format.date(data.endtime, "dd/MM/yyyy hh:mm:ss a"));
	
	//selects
	$("#news\\[category\\] option:selected").removeAttr("selected");
	$("#news\\[category\\]").val(data.category);
	
	//checkboxes
	if(data.active==0){
		$("#news\\[active\\]").attr("checked","false");
	}
	if(data.endtime!=""){
		$("#news\\[leavePosted\\]").removeAttr("checked");
		$(".articleForm .newsEndTime").show();
	}else{
		$("#news\\[leavePosted\\]").attr("checked","true");
	}
}
function populateArticles(articles){
	var dom="";
	for(var i=0; i<articles.length;i++){
		dom+="<option value=\""+articles[i].id+"\">"+articles[i].title+"</option>";
	}
	$(".newsArticlesList").html(dom);
}
function resetForm(){
	$("#news\\[id\\]").val("");
	$("#news\\[title\\]").val("");
	$("#news\\[body\\]").val("");
	$("#news\\[startTime\\]").val("");
	$("#news\\[endTime\\]").val("");
	$("#news\\[category\\]").val(1);
	$("#news\\[active\\]").attr("checked","true");
	$("#news\\[leavePosted\\]").attr("checked","true");
	$(".articleForm .newsEndTime").hide();
	$(".articleForm .newArticleBtn").hide();
	$(".articleForm .submitBtn").val("Add Article");
}