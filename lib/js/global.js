function load() {
	Waves.init();
	Waves.attach('.entry-summary .featured-image img', 'waves-light waves-float');
	var SMILES_EMOJI_PATH = LocalConst.SMILES_EMOJI_PATH;
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
	$(function() {
		$(window).scroll(function() {
			if ($(window).scrollTop() > 500) $('.back-to-top').css('opacity', '1');
			else $('.back-to-top').css('opacity', '0');
		});
		$('.back-to-top').click(function() {
			$('html, body').animate({
				scrollTop: 0
			},
			1000);
		});
	});
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