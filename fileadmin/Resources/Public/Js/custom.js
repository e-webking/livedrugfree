$(document).ready(function(){
	
	//Home page sponsor logo carousel:
	$(".home-sponsor-row .macina-banners-wrapper").addClass("sponsor-carousel");
	
	$('.sponsor-carousel').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		autoplay:true,
		autoplayTimeout:3000,
		autoplayHoverPause:true,
		responsive:{
			0:{
				items:1,
				nav:false
			},
			700:{
				items:3,
				nav:false
			},
			1000:{
				//items:5,
				items:4,
				nav:false
			}
		}
	});
	
	var loop = false;
	if($('.slider-carousel > .custom-slide').length > 1){
		var loop = true;
	}
	$('.slider-carousel').owlCarousel({
		loop:loop,
		margin:0,
		responsiveClass:true,
		autoplay:true,
		autoplayTimeout:6000,
		autoplayHoverPause:true,
		items:1,
		autoplaySpeed: 600
	});
	
});