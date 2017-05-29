
(function($) {
  "use strict";
/* ------------------------------------------------------------------------ */
/*	COUNTDOWN
/* ------------------------------------------------------------------------ */
		$('#clock').countdown('2015/05/28 12:00:00').on('update.countdown', function(event) {
			var $this = $(this).html(event.strftime(''
				+ '<div class="counter-container"><div class="counter-box first"><div class="number">%-D</div><span>Dia%!d</span></div>'
				+ '<div class="counter-box"><div class="number">%H</div><span>Horas</span></div>'
				+ '<div class="counter-box"><div class="number">%M</div><span>Minutos</span></div>'
				+ '<div class="counter-box last"><div class="number">%S</div><span>Segundos</span></div></div>'
			));
		});
							

jQuery(document).ready(function() {

	/* How to Handle Hashtags */
	jQuery(window).hashchange(function(){
		var hash = location.hash;
		jQuery('a[href='+hash+']').trigger('click');
	});
	jQuery('section.content.hide').hide();
	/* Main Navigation Clicks */
	jQuery('.main-nav ul li a').click(function() {
		var link = jQuery(this).attr('href').substr(1);
		
		if ( !jQuery('section.content.show, section#' + link).is(':animated') ) {
			jQuery('.main-nav ul li a').removeClass('active'); //remove active
			jQuery('section.content.show').addClass('show').animate({'opacity' : 0}, {queue: false, duration: 1000,
				complete: function() {
					jQuery('section.content.show').hide();
					jQuery('a[href="#'+link+'"]').addClass('active'); // add active
					jQuery('section#' + link).show();
					jQuery('section#' + link).addClass('show').animate({'opacity' : 1}, {queue: false, duration: 1000});	
				}
			});
		}
	});

});

})(jQuery);
