jQuery(function($){
	
	if ( $('.woocommerce-content').length > 0) {
		$('.woocommerce-content').photoSwipe({
			itemSelector: '.images .wc-photoswipe',
			zoomEl: false
		});
		
		$('.woocommerce-content .owl-carousel').owlCarousel({
			loop:false,
			margin: 15,
			autoWidth:true,
			nav: true,
			dots: false,
			  navText: [
				"<i class='icon-chevron-left icon-white'><</i>",
				"<i class='icon-chevron-right icon-white'>></i>"
			  ],
			responsive:{
				0:{
					items:2
				},
				600:{
					items:2
				},
				1000:{
					items:4
				}
			}
		});
	}
	
	
	
	
	
});