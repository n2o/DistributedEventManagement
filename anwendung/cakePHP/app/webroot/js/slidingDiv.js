(function ($) {
	$.fn.slidingDiv = function (options) {
		//default vars for the plugin
		var defaults = {
			speed: 1000,
			easing: '',
			changeText: 0,
			showText: 'Show',
			hideText: 'Hide'
		};
		var options = $.extend(defaults, options);

		$(this).click(function () {	

			$('.switchDiv').slideUp(options.speed, options.easing);	
			// this var stores which button you've clicked
			var switchClick = $(this);
			// this reads the rel attribute of the button to determine which div id to toggle
			var switchDiv = $(this).attr('rel');
			// here we toggle show/hide the correct div at the right speed and using which easing effect
			$(switchDiv).slideToggle(options.speed, options.easing, function() {
			// this only fires once the animation is completed
				if (options.changeText == 1) {
					$(switchDiv).is(":visible") ? switchClick.text(options.hideText) : switchClick.text(options.showText);
				}
			});
			return false;
		});
	};
})(jQuery);