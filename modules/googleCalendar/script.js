$(function(){
	$("#allCadCalendar .events .event").hover(function(){
		$(this).addClass("active");
	},function(){
		$(this).removeClass("active");
	});
});