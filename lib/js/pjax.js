function pjax() {
	$(document).ready(function() {
		$(document).pjax('a:not([href^="#"])', '.site-inner', {
			fragment: '.site-inner',
			timeout: 5000,
		}).on('submit', 'form[class="search-form"]',
		function(event) {
			$.pjax.submit(event, '.site-inner', {
				fragment: '.site-inner',
				timeout: 5000
			});
		}).on('pjax:send',
		function() {
			$('.menu-item').click(function() {
				$('.menu-item').removeClass('current-menu-item');
				$(this).addClass('current-menu-item');
			});
			$(".loadingback").css("display", "block");
			Waves.init();
			Waves.attach('.entry-summary .featured-image img', 'waves-light waves-float');
		}).on('pjax:complete',
		function() {
			var img = $(".site-image img");
			var header = 'url(' + img[0].src + ')';
			$(img[0]).remove();
			/*$(document).ready(function() {
var myDate = new Date();
var currentTime = myDate.getHours();
if (currentTime <= 6 || currentTime >= 22) {
	$("body").addClass("theme-dark ").removeClass("theme-light");
	$(".back-to-top").addClass("waves-light");
}
else{
	$("body").addClass("theme-light").removeClass("theme-dark");
	$(".back-to-top").removeClass("waves-light");
}
});*/
			menu_toggle();
			smiles();
			Prism.highlightAll();
			$(".loadingback").css("display", "none");
			$(".site-image").css('background-image', header);
			backtotop();
			article_index();
			index_button_click();
			bannerHeight();
			if (IfDark == 'yes') {
				$(".back-to-top").addClass("waves-light");
			}
		});
	});
}