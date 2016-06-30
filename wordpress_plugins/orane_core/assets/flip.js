jQuery.noConflict();
(function( $ ) {
		$(document).ready(function() {	

			var days = 2;
			if (typeof orane_flip !== 'undefined') {
				days = orane_flip.days;
			}

			var hours = days * 3600 *24;		
			var clock = $('.daily-counter').FlipClock(hours, {
				clockFace: 'DailyCounter',
				countdown: true
			});


		});
})( jQuery );

