function load() {
	menu_toggle();
	var SMILES_EMOJI_PATH = LocalConst.SMILES_EMOJI_PATH;
	bannerHeight();
	//	$(".site-image").css('background',header);
	Waves.init();
	Waves.attach('.entry-summary .featured-image img', 'waves-light waves-float');
	smiles();
	backtotop();
	article_index();
	upvote()
}
function bannerHeight() {
	var getBgHeight = function(windowHeight, bannerHeight, mobileBannerHeight) {
		windowHeight = windowHeight || 560;
		if (windowHeight > window.screen.availHeight) {
			windowHeight = window.screen.availHeight;
		}
		if (window.innerHeight > window.innerWidth) {
			bannerHeight = parseFloat(mobileBannerHeight);
		} else {
			bannerHeight = parseFloat(bannerHeight);
		}
		bannerHeight = Math.round(windowHeight * bannerHeight / 100);
		return bannerHeight;

	};
	var head = $(".site-header");
	var bgHeight = getBgHeight(window.innerHeight, '65', '45');
	head.css('height', bgHeight + "px");
}

function smiles() {
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
}

function backtotop() {
	$(window).scroll(function() {
		if ($(window).scrollTop() > 500) {
			$('.back-to-top').css('opacity', '1');
		} else {
			$('.back-to-top').css('opacity', '0');
		}
	});
	$('.back-to-top').click(function() {
		$('html, body').animate({
			scrollTop: 0
		},
		1000);
	});
}

function article_index() {
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
}

function upvote() {
	$.fn.postLike = function() {
		if ($(this).hasClass('done')) {
			alert('您已赞过本博客');
			return false;
		} else {
			$(this).addClass('done');
			var id = $(this).data("id"),
			action = $(this).data('action'),
			rateHolder = $(this).children('.count');
			var ajax_data = {
				action: "upvote",
				um_id: id,
				um_action: action
			};
			$.post("/wp-admin/admin-ajax.php", ajax_data,
			function(data) {
				$(rateHolder).html(data);
			});
			return false;
		}
	};
	$(document).on("click", ".upvote",
	function() {
		$(this).postLike();
	});
}

function index_button_click() {
	$('.index-button').click(function() {
		if ($('.index-button').hasClass('index-button-on')) {
			$('.article-index').css('width', '0%');
			$('.index-button').removeClass('index-button-on');
		} else {
			$('.article-index').css('width', '35%');
			$('.index-button').addClass('index-button-on');
		}
	});
}

function menu_toggle() {
jQuery(document).ready(function($) {
	// Toggle mobile menu
	$(".menu-icon").on("click", function(){
		if ($(".nav-primary .wrap").hasClass("active")) {
			$(".nav-primary .wrap").removeClass("active");
		}
		else {
			$(".nav-primary .wrap").addClass("active");
		}
	});
})
}