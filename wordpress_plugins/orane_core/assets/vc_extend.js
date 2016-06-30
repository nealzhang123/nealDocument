jQuery.noConflict();
(function( $ ) {



//check if isotope is loaded
if(jQuery().isotope) {

///////////// isotope portfolio
		var $container = $('.custom-portfolio');
		// init
		    var margin = 0,
		    colWidth = function () {
		        var w = $container.width(), 
		            columnNum   = 1,
		            columnWidth = 0;

					if (w > 1600) {
						columnNum  = 4;
					}else if (w > 1200) {
						columnNum  = 4;
					} else if (w > 900) {
						columnNum  = 4;
					} else if (w > 600) {
						columnNum  = 3;
					} else if (w > 500) {
						columnNum  = 2;
					}else if (w > 300) {
						columnNum  = 2;
					} 			

		        columnWidth = Math.floor(w/columnNum);
		        $container.find('.port_item').each(function() {

		            $(this).css({
		                width: columnWidth - margin,
		            });
		        });

		        return columnWidth;
		    },

		    isotope = function () {

		        $container.isotope({
		            resizable: false,
		            itemSelector: '.port_item',
		            masonry: {
		                columnWidth: colWidth(),
		                gutterWidth: margin
		            }
		        });
		    };
		isotope();
		$(window).on('debouncedresize', isotope);

}//ends if block
////////////////////////////////////////////////////


if(jQuery().magnificPopup) {

	//magnific popup init
	$('.custom-portfolio').magnificPopup({

		type:'image',
		delegate: 'a.itemzoom',

		 gallery: {
		    enabled: true
		  }

	});

}


})( jQuery );