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
			var container = document.getElementsByClassName('OwO')[0];
			var target = document.getElementsByClassName('commenttextarea')[0];
			if (container !== undefined && target !== undefined) {
				var OwO_demo = new OwO({
					logo: 'OωO',
					container: container,
					target: target,
					api: LocalConst.BASE_SCRIPT_URL + '/lib/widgets/OwO.json',
					position: 'down',
					style: '400px',
					maxHeight: '250px'
				});
			};
			Prism.highlightAll();
			$(".loadingback").css("display", "none");
			$(".site-image").css('background',header);
			$('.back-to-top').click(function() {
				$('html, body').animate({
					scrollTop: 0
				},
				1000);
			});
			$(document).ready(function() {
				$('a[href^="#title"]').click(function() {
					$("html, body").animate({
						scrollTop: $($(this).attr("href")).offset().top - 80 + "px"
					},
					{
						duration: 500,
						easing: "swing"
					});
					return false;
				});
			});
		});
	});
}