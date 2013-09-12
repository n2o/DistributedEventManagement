$(document).ready(function() {
	var top = $('div#sidebar').offset().top - parseFloat($('div#sidebar').css('margin-top').replace(/auto/, 0));
	$(window).scroll(function (event) {
		// what the y position of the scroll is
		var y = $(this).scrollTop();

		if (y >= top) {
			$('div#sidebar').addClass('fixed').css('width', $('div#sidebar-wrapper').width() + 'px');
		} else {
			$('div#sidebar').removeClass('fixed').css('width', '100%');
		}
	});
	
	$('div.entry *').nabatar();
});