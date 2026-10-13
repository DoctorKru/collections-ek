$(document).ready( function() {
	$().fancybox({
		// FancyBox shows only filtered items with Isotope
		selector : $("#isotope-wrap").length ? '.isotope-item:visible > [data-fancybox="images"]' : '[data-fancybox="images"]',
		loop : true,
		preventCaptionOverlap: false,
		margin : [20, 0],
		buttons : [
			'thumbs',
			'slideShow',
			'download', // EK: Adds the download button to the toolbar
			'close'
		],
		protect : false,
		animationEffect : 'fade',
		touch : {
			vertical : false
		},
		slideShow : {
			autoStart : false,
			speed : 3000
		},

		// EK: Swaps the button target to your 3000px original file path
		beforeShow: function(instance, current) {
			var originalSrc = current.opts.$orig.attr('data-download-src');
			if (originalSrc) {
				instance.$refs.container.find('.fancybox-button--download').attr('href', originalSrc);
			}
		},

		clickContent : function( current, event ) {
			return current.type === 'image' ? 'toggleControls' : false;
		},
		dblclickContent : function( current, event ) {
			return current.type === 'image' ? 'zoom' : false;
		},
		clickSlide : false,
		clickOutside : false,

		caption : function( instance, item ) {
			if ($(this).find('.caption').length) {
				return $(this).find('.caption').html();
			} else {
				return $(this).attr('title');
			}
		},

		mobile : {
			thumbs : false,
			idleTime : 3,
			buttons : [
				'download', // EK: Keeps the download option active on smartphones
				'close'
			],

			clickContent : function( current, event ) {
				return current.type === 'image' ? 'toggleControls' : false;
			},
			dblclickContent : function( current, event ) {
				return current.type === 'image' ? 'next' : false;
			},
			dblclickSlide : false,
		},
	});
});
