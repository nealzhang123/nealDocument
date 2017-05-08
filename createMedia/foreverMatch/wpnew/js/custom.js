/*
	Scripts for Sympathique - V1.0
*/
(function($){
jQuery(document).ready(function() {
	
	// FADING EFFECT FOR CLIENTS //
	

	// IN AND OUT EFFECT FOR CAROUSEL //
	$('.item-on-hover, .item-on-hover-white').hover(function(){		 		 
		$(this).animate({ opacity: 1 }, 200);
		$(this).children('.hover-link, .hover-image, .hover-video').animate({ opacity: 1 }, 200);
	}, function(){
		$(this).animate({ opacity: 0 }, 200);
		$(this).children('.hover-link, .hover-image, .hover-video').animate({ opacity: 0 }, 200);
	});
	
	// PORTFOLIO GRID IN AND OUT EFFECT //
	// $('.grid-item-on-hover').hover(function(){
	// 	$(this).animate({ opacity: 0.9 }, 200);
	// }, function(){
	// 		$(this).animate({ opacity: 0 }, 200);
	// 	});

	// // ISOTOPE SCRIPTS FOR PORTFOLIO FILTER, PORTFOLIO GRID LAYOUT, BLOG MASONRY //
	// var $container = $('.grid');
	// var $blog_container = $('#masonry-blog');
	// var $portfolio_container = $('.portfolio-gallery');
	// var $gallery_container = $('.gallery-page');
	// var $four_container = $('.four-columns, .three-columns, .two-columns');

	// 	// blog masonry layout
	// 	$blog_container.imagesLoaded( function(){
	// 	  $blog_container.isotope({
	// 			itemSelector: '.masonry-post',
	// 			animationEngine: 'jquery',	
	// 			gutterWidth: 20	
	// 	  });
	// 	});	
		
	// 	// gallery masonry layout
	// 	$gallery_container.imagesLoaded( function(){
	// 	  $gallery_container.isotope({
	// 			itemSelector: 'li',
	// 			animationEngine: 'jquery',	
	// 			gutterWidth: 20	
	// 	  });
	// 	});			

	// 	// portfolio gallery masonry option
	// 	$portfolio_container.imagesLoaded( function(){
	// 	  $portfolio_container.isotope({
	// 			itemSelector: 'a',
	// 			animationEngine: 'jquery',	
	// 			gutterWidth: 20	
	// 	  });
	// 	});
		
	// 	// portfolio grid layout and filtering
	// 	$container.isotope({
	// 		itemSelector: 'li',
	// 		animationEngine: 'jquery',
	// 		masonry: {
	// 			columnWidth: 5
	// 		}
	// 	});
		
	// 	// portfolio filtering
	// 	$four_container.isotope({
	// 		itemSelector: 'li',
	// 		animationEngine: 'jquery'
	// 	});	  
		  
	// 	var $optionSets = $('#options .option-set'),
	// 		$optionLinks = $optionSets.find('a');

	// 	$optionLinks.click(function(){
	// 		var $this = $(this);
	// 		// don't proceed if already selected
	// 		if ( $this.hasClass('selected') ) {
	// 			return false;
	// 		}
	// 		var $optionSet = $this.parents('.option-set');
	// 		$optionSet.find('.selected').removeClass('selected');
	// 		$this.addClass('selected');
	  
	// 		// make option object dynamically, i.e. { filter: '.my-filter-class' }
	// 		var options = {},
	// 			key = $optionSet.attr('data-option-key'),
	// 			value = $this.attr('data-option-value');
	// 		// parse 'false' as false boolean
	// 		value = value === 'false' ? false : value;
	// 		options[ key ] = value;
	// 		if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
	// 		  // changes in layout modes need extra logic
	// 		  changeLayoutMode( $this, options )
	// 		} else {
	// 		  // otherwise, apply new options
	// 		  $container.isotope( options );
	// 		  $four_container.isotope( options );
	// 		}
			
	// 		return false;
	// 	});
	

	//TRANSFORM MENU INTO SELECT FOR RESPONSIVE LAYOUT //
	$('#mainnav').mobileMenu({
		defaultText: 'Navigate to...',
		className: 'select-menu',
		subMenuDash: '&ndash;'
	});

	
	// PRELOAD IMAGES //
	//$("#portfolio-carousel, #homeblog-carousel, .post-thumbnail, .portfolio li").preloadify();

	
	// MENU SUBNAV HACKS //
	// $('ul#mainnav').superfish({
	// 	delay: 100,
	// 	autoArrows: false,
	// 	animation: {opacity:'show',opacity:'show'}, 
 //           speed: 'fast' 
	// });
	
	$("ul#mainnav li").css({ "overflow":"visible"});

	$("ul#mainnav li ul li:last-child").addClass('nav-last-item');
	$("ul#mainnav li ul li:first-child").addClass('nav-first-item');
	
	var $thisis;
	$("#mainnav > li").each(function(){
		$thisis = $(this);
		if(($thisis.find("> a.current").length) || ($thisis.find("> ul > li > a.current").length)) {
			$thisis.addClass("current-item item-active");		
			$(this).prev().addClass('prev-item');
		  }
	});	

	$('#mainnav > li').hover(
		function(){ $(this).prev().addClass('previ-item') },
		function(){ $(this).prev().removeClass('previ-item') }
	)	
	
	


	
	// FIXES THE BACKGROUND IMAGE WHEN ADDED //
	$(window).load(function() {    

		var theWindow        = $(window),
			$bg              = $("#bg"),
			aspectRatio      = $bg.width() / $bg.height();
									
		function resizeBg() {
			
			if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
				$bg
					.removeClass()
					.addClass('bgheight');
			} else {
				$bg
					.removeClass()
					.addClass('bgwidth');
			}
						
		}
									
		theWindow.resize(function() {
			resizeBg();
		}).trigger("resize");

	});	

	
	// PRETTYPHOTO //
	$("a[rel^='prettyPhoto']").prettyPhoto({
		animation_speed:'normal',
		theme:'light_square',
		slideshow:3000, 
		autoplay_slideshow: false,
		social_tools:false,
	});

	
	// Z-INDEX FOR HEADER IMAGES //
	var zIndexNumber = 1000;
		$('#top div').each(function() {
			$(this).css('zIndex', zIndexNumber);
			zIndexNumber -= 10;
		});	

		
	// HOMEBLOG CAROUSEL //
	$('#homeblog-carousel').jcarousel({
        vertical: false,
        rtl: false,
        start: 1,
        offset: 1,
        scroll: 1,
        animation: 'normal',
        easing: 'swing',
        auto: 0
	});			
		
	// HOMEPAGE PORTFOLIO CAROUSEL //
	if (document.documentElement.clientWidth < 1000) {
		$('#portfolio-carousel').jcarousel({
			vertical: false,
			rtl: false,
			start: 1,
			offset: 1,
			scroll: 1,
			animation: 'normal',
			easing: 'swing',
			auto: 0
		});	
	}
		
	else {	$('#portfolio-carousel').jcarousel({
			vertical: false,
			rtl: false,
			start: 1,
			offset: 1,
			scroll: 4,
			animation: 'normal',
			easing: 'swing',
			auto: 0
	});	}
		
	
	// SHADOWS LOADING EFFECT //
	$(".home .top-shadow").hide().delay(1500).fadeIn(3000);
	$(".home .bottom-shadow").hide().delay(1500).fadeIn(3000);
	

	// TABS FUNCTION //
	$('.tabs-wrapper').each(function() {
		$(this).find(".tab-content").hide(); //Hide all content
		$(this).find("ul.tabs li:first").addClass("active").show(); //Activate first tab
		$(this).find(".tab-content:first").show(); //Show first tab content
	});
	$("ul.tabs li").click(function(e) {
		$(this).parents('.tabs-wrapper').find("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(this).parents('.tabs-wrapper').find(".tab-content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$("li.tab-item:first-child").css("background", "none" );
		$(this).parents('.tabs-wrapper').find(activeTab).fadeIn(); //Fade in the active ID content
		e.preventDefault();
	});
	$("ul.tabs li a").click(function(e) {
		e.preventDefault();
	})
	$("li.tab-item:last-child").addClass('last-item');


	// ACCORDION FUNCTION //		
	// $('.ac-btn').click(function() {	

	// 	$('.ac-btn').removeClass('on');
	// 	$('.ac-selected').slideUp('normal');
	// 	$('.ac-content').removeClass('ac-selected');
	// 	$('.ac-content').slideUp('normal');
	// 	if($(this).next().is(':hidden') == true) {
	// 		$(this).addClass('on');
	// 		$(this).next().slideDown('normal');
	// 	 }   
	//  });
	// $('.ac-btn').mouseover(function() {
	// 	$(this).addClass('over');
	// }).mouseout(function() {
	// 	$(this).removeClass('over');										
	// });	
	// $('.ac-content').hide();		
	
	// TOGGLE FUNCTION //
	$('#toggle-view li').click(function () {
        var text = $(this).children('div.panel');
        if (text.is(':hidden')) {
            text.slideDown('200');
            $(this).children('span').addClass('toggle-minus');     
            $(this).addClass('activated');     
        } else {
            text.slideUp('200');
			$(this).children('span').removeClass('toggle-minus'); 
            $(this).children('span').addClass('toggle-plus'); 
			$(this).removeClass('activated'); 			
        }
         
    });

	// APPENDING HTML CONTENT FOR ICON FONT
	$('#topfooter').append('<div class="clear"></div>');

	$('.box-error').prepend('<i class="icon-minus-sign"></i>');
	$('.box-notice').prepend('<i class="icon-exclamation-sign"></i>');
	$('.box-success').prepend('<i class="icon-flag"></i>');
	$('.box-info').prepend('<i class="icon-info-sign"></i>');

	$('.check').prepend('<i class="icon-ok"></i>');

	$('.tick-list li').prepend('<i class="icon-ok"></i>');
	$('.play-list li').prepend('<i class="icon-caret-right"></i>');
	$('.star-list li').prepend('<i class="icon-star"></i>');
	$('.arrow-list li').prepend('<i class="icon-double-angle-right"></i>');

	

	$('.article-modal').click(function () {
		var pid = $(this).attr('data-pid');
		$('.article_modal_title').html($('#article-title'+pid).html());
		$('.article_modal_image').attr("src",$('#article-image'+pid).attr('src'));
		$('.article_modal_content').html($('#article-content'+pid).html());

        $('#article_modal').modal('show');
         
    });

    $(".contact-reset").on('click', function(e){
	    e.preventDefault();

	    $('.contact-form')[0].reset();
  	});

    $(".contact-submit").on('click', function(e){
	    e.preventDefault();

	    sweetAlert("發送成功", "感謝您對我們的支持!", "success");
	    
	    $.post(
	        ajaxurl,
	        {
		        'action': 'about-form-save-ajax',
		        'form_data':$(".contact-form").serializeArray(),
	        },
	      	function( response){
	        	$('.contact-form')[0].reset();
	      	}
	    );
  	});
	// AUDIO PLAYER //
	// $("#audio_jplayer").jPlayer({
	// 	ready: function (event) {
	// 		$(this).jPlayer("setMedia", {
	// 			mp3:"media/audio.mp3",
	// 			ogg:"media/audio.ogg"
	// 		});
	// 	},
	// 	swfPath: "../../media",
	// 	supplied: "mp3, ogg",
	// 	wmode: "window"
	// });
  
});

})(jQuery);