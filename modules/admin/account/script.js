$(function(){
	$("#signupForm .text_field").focus(function(){
		$(this).addClass("active");
		$(this).parent().next().find(".info").show();
		$(this).parent().next().find(".error").hide();
	}).blur(function(){
		$(this).removeClass("active");
		$(this).parent().next().find(".info").hide();
	});
	$("#user_create_submit").click(function(){
		if($("#user_name").val() == "" || $("#user_name").val().indexOf(" ") == -1){
			$(".full-name .col-help .info").show();
			return false;
		}
		if($("#user_screen_name").val() == ""){
			$(".screen-name .col-help .info").show();
			return false;
		}
		if(!validEmail($("#user_email").val())){
			$(".email .col-help .error").html("We need a valid one").show();
			return false;
		}
		$("#signupForm fieldset").hide();
	});
	/////
	$("#signupForm #user_password").passStrength({
		userid:	"#user_screen_name",
		resultLocation: ".pstrength-text"
	});
	$("#signupForm #user_password").focus(function(){
		$(".password .col-help .error").hide();
		$(this).addClass("active");
		$(this).parent().next().find(".password-meter").show();
	}).blur(function(){
		$(this).removeClass("active");
		if($(this).val()==""){
			$(this).parent().next().find("div .pstrength-text").html("Too short").parent().hide();
		}
	});
	$("#signupForm #user_passwordConfirm").focus(function(){
		$(this).addClass("active");
		$(this).parent().next().find(".password-confirm").show();
	}).blur(function(){
		$(this).removeClass("active");
		if($(this).val()==""){
			$(this).parent().next().find("div .pconfirm-text").html("Passwords do not match").parent().hide();
		}
	});
	$("#signupForm #user_password").keyup(function(){
		if($("#signupForm #user_passwordConfirm").val()!=""){
			if($(this).val()!=$("#signupForm #user_passwordConfirm").val()){
				$("#signupForm #user_passwordConfirm").parent().next()
					.find("div").removeClass("goodPass").addClass("badPass")
					.find(".pconfirm-text").html("Passwords do not match");
			}else{
				$("#signupForm #user_passwordConfirm").parent().next()
					.find("div").addClass("goodPass").removeClass("badPass")
					.find(".pconfirm-text").html("Confirmed");
			}
		}
		checkEnableSubmit();
	});
	$("#signupForm #user_passwordConfirm").keyup(function(){
		if($(this).val()!=$("#signupForm #user_password").val()){
			$(this).parent().next()
				.find("div").removeClass("goodPass").addClass("badPass")
				.find(".pconfirm-text").html("Passwords do not match");
		}else{
			$(this).parent().next()
				.find("div").addClass("goodPass").removeClass("badPass")
				.find(".pconfirm-text").html("Confirmed");
		}
		checkEnableSubmit();
	});
});

function checkEnableSubmit(){
	if($("#user_screen_name").val()==$("#user_password").val() || $("#user_password").val().length<8 || $("#user_password").val()!=$("#user_passwordConfirm").val()){
		$("#password_change_submit").attr("disabled","disabled");
	}else{
		$("#password_change_submit").removeAttr("disabled");
	}
}
function validEmail(email){
var status = true;
var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
     if (email.search(emailRegEx) == -1) {
          status = false;
     }
     return status;
}