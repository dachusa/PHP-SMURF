var playSlideshow = true;
var transitionSpeed = "normal";
var timer;

$(function(){
	$("#slide1").addClass("activeSlide");
	$(".slideLink a[rel='slide1']").addClass("activeLink");
	
	$(".slideLink a").click(function(){
		clearTimeout(timer);
		startSlideshow();
		if(!$("#"+$(this).attr("rel")).hasClass("activeSlide")){
			var clickedLink = $(this);
			$(".activeSlide").fadeOut(transitionSpeed, function(){
				$(this).removeClass("activeSlide");
				$(".activeLink").removeClass("activeLink");
			});
			$("#"+$(clickedLink).attr("rel")).fadeIn(transitionSpeed, function(){
					$(this).addClass("activeSlide");
					$(clickedLink).addClass("activeLink");
			});
		}
		return false;
	});
	
	startSlideshow();
});

function startSlideshow(){
	if(playSlideshow){
		var timeout = slideShowTimeoutInSeconds * 1000;
		timer = setTimeout(function(){nextSlide();}, timeout);
		return false;
	}
}

function nextSlide(){
	var slideCount = $(".slide").length;
	var activeSlide = $(".activeSlide").attr("rel");
	if(activeSlide<slideCount){
		activeSlide++;
	}else{
		activeSlide = 1;
	}
	$(".activeSlide").fadeOut(transitionSpeed, function(){
		$(this).removeClass("activeSlide");
		$(".activeLink").removeClass("activeLink");
	});
	$("#slide"+activeSlide).fadeIn(transitionSpeed, function(){
			$(this).addClass("activeSlide");
			$(".slideLink a[rel='slide"+activeSlide+"']").addClass("activeLink");
	});
	startSlideshow();	
}

/*
$(".activeSlide").slideUp(transitionSpeed, function(){
		$(this).removeClass("activeSlide");
		$(".activeLink").removeClass("activeLink");
		$("#slide"+activeSlide).slideDown(transitionSpeed, function(){
			$(this).addClass("activeSlide");
			$(".slideLink a[rel='slide"+activeSlide+"']").addClass("activeLink");
		});
	});
*/