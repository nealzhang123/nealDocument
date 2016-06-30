jQuery.noConflict();
(function( $ ) {

$(document).ready(function(){
		$("#owl-demo").owlCarousel({
			 items : 3,
			 itemsDesktop : [1200,3],
		      itemsDesktopSmall : [1100,3], // betweem 900px and 601px
		      itemsTablet: [600,2], //2 items between 600 and 0
		      itemsMobile : [400,2] // itemsMobile disabled - inherit from itemsTablet option			 
		});

		$("#latest-custom-posts").owlCarousel({
			 items : 3,
			 itemsDesktop : [1200,3],
		      itemsDesktopSmall : [1100,2], // betweem 900px and 601px
		      itemsTablet: [600,1], //2 items between 600 and 0
		      itemsMobile : [400,1] // itemsMobile disabled - inherit from itemsTablet option			 
		});




		if(jQuery().owlCarousel) {
		    
		    $(".testimonial-carousel").owlCarousel({
		        autoPlay: 5000,
		        slideSpeed: 500,
		        items: 1,
		        itemsDesktop: [1199, 1],
		        itemsDesktopSmall: [979, 1],
		        itemsTablet: [768, 1],
		        itemsMobile: [479, 1],
		        autoHeight: true,
		        pagination: true,
		        navigation: false,
		        transitionStyle: "fade",
		        navigationText: [
		            "<i class='fa fa-angle-left'></i>",
		            "<i class='fa fa-angle-right'></i>"
		        ],
		    });

		}//end if
		

});

})( jQuery );

