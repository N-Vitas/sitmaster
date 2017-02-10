addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
function hideURLbar(){ window.scrollTo(0,1);}

//$(document).ready(function($) {
	$(".scroll").click(function(event){		
		event.preventDefault();
		$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
	});

	var navoffeset=$(".navigation").offset().top;
	$(window).scroll(function(){
		var scrollpos=$(window).scrollTop(); 
		if(scrollpos >=navoffeset){
			$(".navigation").addClass("fixed");
		}else{
			$(".navigation").removeClass("fixed");
		}
	});

	$(".tab1 p").hide();
	$(".tab2 p").hide();
	$(".tab3 p").hide();
	$(".tab4 p").hide();
	$(".tab1 ul").click(function(){
		$(".tab1 p").slideToggle(300);
		$(".tab2 p").hide();
		$(".tab3 p").hide();
		$(".tab4 p").hide();
	})
	$(".tab2 ul").click(function(){
		$(".tab2 p").slideToggle(300);
		$(".tab1 p").hide();
		$(".tab3 p").hide();
		$(".tab4 p").hide();
	})
	$(".tab3 ul").click(function(){
		$(".tab3 p").slideToggle(300);
		$(".tab4 p").hide();
		$(".tab2 p").hide();
		$(".tab1 p").hide();
	})
	$(".tab4 ul").click(function(){
		$(".tab4 p").slideToggle(300);
		$(".tab3 p").hide();
		$(".tab2 p").hide();
		$(".tab1 p").hide();	
	});

	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});

	$().UItoTop({ easingType: 'easeOutQuart' });

//});
//end ready
var colors = [
		['#000000', '#99cc33'], ['#000000', '#99cc33'], ['#000000', '#99cc33'], ['#000000', '#99cc33']
	];
for (var i = 1; i <= 4; i++) {
	var child = document.getElementById('circles-' + i),
		percentage = 40 + (i * 10);
		
	Circles.create({
		id:         child.id,
		percentage: percentage,
		radius:     80,
		width:      10,
		number:   	percentage / 10,
		text:       '%',
		colors:     colors[i - 1]
	});
}

$( "span.menu" ).click(function() {
	$( "ul.nav1" ).slideToggle( 300, function() {
	 // Animation complete.
	});
});

$(function () {
	var filterList = {
		init: function () {
			// MixItUp plugin
			// http://mixitup.io
			$('#portfoliolist').mixitup({
				targetSelector: '.portfolio',
				filterSelector: '.filter',
				effects: ['fade'],
				easing: 'snap',
				// call the hover effect
				onMixEnd: filterList.hoverEffect()
			});				
		},
		hoverEffect: function () {
		
			// Simple parallax effect
			$('#portfoliolist .portfolio').hover(
				function () {
					$(this).find('.label').stop().animate({bottom: 0}, 200, 'easeOutQuad');
					$(this).find('img').stop().animate({top: -30}, 500, 'easeOutQuad');				
				},
				function () {
					$(this).find('.label').stop().animate({bottom: -40}, 200, 'easeInQuad');
					$(this).find('img').stop().animate({top: 0}, 300, 'easeOutQuad');								
				}		
			);				
		}
	};
	// Run the show!
	filterList.init();
});
// You can also use "$(window).load(function() {"
$(function () {
	 // Slideshow 4
	$("#slider3,#slider4").responsiveSlides({
		auto: true,
		pager: true,
		nav: false,
		speed: 500,
		namespace: "callbacks",
		before: function () {
	$('.events').append("<li>before event fired.</li>");
	},
	after: function () {
		$('.events').append("<li>after event fired.</li>");
		}
	});
});