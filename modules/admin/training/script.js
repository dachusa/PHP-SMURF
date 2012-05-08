$(function(){
	$(".trainingForm .editTrainingBtn").click(function(){
		loadTraining($(".trainingForm .trainingList option:selected").val());
	});
	$(".trainingForm .deleteTrainingBtn").click(function(){
		var deleteTrue = confirm("Are you sure you want to delete this training?");
		if(deleteTrue){
			deleteTraining($(".trainingForm .trainingList option:selected").val());
		}
	});
	$(".trainingForm .newTrainingBtn").click(function(){
		resetForm();
	});
	$(".trainingForm .submitBtn").click(function(){
		saveTraining();
	});

	$(".trainingImages").change(function(){
		setSelectedImage();
	});
	
	resetForm();
});

function loadTraining(id){
	var url = "/json/loadTraining/"+id;
	$.getJSON(
	  url,
	  function(data){
		populateValues(data);
		$(".trainingForm .newTrainingBtn").show();
		$(".trainingForm .submitBtn").val("Update Training");
	  }
	);
}

function reloadTraining(){
	var url = "/json/loadTraining";
	$.getJSON(
	  url,
	  function(data){
		populateTraining(data.training);
	  }
	);
}

function saveTraining(){
	var data ="";
	data+= "training[id]="+escape($("#training\\[id\\]").val());
	data+="&training[title]="+escape($("#training\\[title\\]").val());
	data+="&training[description]="+escape($("#training\\[description\\]").val());
	data+="&training[duration]="+escape($("#training\\[duration\\]").val());
	if($("#training\\[active\\]").is(":checked")){
		data+="&training[active]=1";
	}else{
		data+="&training[active]=0";
	}
	
	 $.ajax({
		type: "POST",
		url: "/admin/training/action",
		dataType: "application/x-www-form-urlencoded",
		data: "action=save&"+data,
		async: false,
		success: function(msg) {
			alert(msg);
			reloadTraining();
			resetForm();
		}
	});
	
}

function deleteTraining(id){
	$.ajax({
		type: "POST",
		url: "/admin/training/action",
		dataType: "application/x-www-form-urlencoded",
		data: "action=delete&training[id]="+id,
		async: false,
		success: function(msg) {
			alert(msg);
			reloadTraining();
			resetForm();
		}
	});
}
function populateValues(data){
	resetForm();
		
	//inputs
	$("#training\\[id\\]").val(data.id);
	$("#training\\[title\\]").val(data.title);
	$("#training\\[description\\]").val(data.description);
	$("#training\\[duration\\]").val(data.duration);
	
	//checkboxes
	if(data.active==0){
		$("#training\\[active\\]").attr("checked","false");
	}
}
function populateTraining(training){
	var dom="";
	for(var i=0; i<training.length;i++){
		dom+="<option value=\""+training[i].id+"\">"+training[i].title+"</option>";
	}
	$(".trainingList").html(dom);
}
function resetForm(){
	$("#training\\[id\\]").val("");
	$("#training\\[title\\]").val("");
	$("#training\\[description\\]").val("");
	$("#training\\[duration\\]").val("");
	$("#training\\[active\\]").attr("checked","true");
	$(".trainingForm .newTrainingBtn").hide();
	$(".trainingForm .submitBtn").val("Add Training");
}