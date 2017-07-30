<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the class=site-inner div and all content after
 *
 * @package harmonica
 */
?>
		<?php do_action( 'harmonica_after_main' ); ?>
	</div><!-- .site-inner -->
	<?php 
	do_action( 'harmonica_before_footer' ); 
	do_action( 'harmonica_footer' ); 
	do_action( 'harmonica_after_footer' ); 
	?>
</div><!-- .site-container -->
<?php do_action( 'harmonica_after' ); ?>
<?php wp_footer(); ?>
<div class="loadingback"> <div class="loader">
        <div class="loader-inner square-spin">
          <div></div>
        </div>
      </div>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/lib/js/jquery.pjax.js"></script>
<script>
Waves.init();
Waves.attach('.entry-summary .featured-image img' , 'waves-light waves-float');
window['LocalConst'] = {
    BASE_SCRIPT_URL: "<?php echo get_stylesheet_directory_uri() ?>",
};
LocalConst.SMILES_EMOJI_PATH = "<?php echo get_stylesheet_directory_uri() . '/images/smilies/' ?>";
var SMILES_EMOJI_PATH = LocalConst.SMILES_EMOJI_PATH;
var container = document.getElementsByClassName('OwO')[0];
var target = document.getElementsByClassName('commenttextarea')[0];
    if (container !== undefined && target !== undefined) {
        var OwO_demo = new OwO ({
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
        if ($(window).scrollTop() > 500)
            $('.back-to-top').css('opacity','1');
        else
            $('.back-to-top').css('opacity','0');
    });
    $('.back-to-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 1000);
    });
});
$(document).ready(function(){
    $(document).pjax('a', '.site-inner', {
        fragment: '.site-inner',
        timeout: 5000, 
    });
$(document).on('submit', 'form[class="search-form"]', function (event) {$.pjax.submit(event, '.site-inner', {fragment:'.site-inner', timeout:5000});});
$(document).on('pjax:send', function() {
(function smoothscroll(){
    var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
    if (currentScroll > 0) {
         window.requestAnimationFrame(smoothscroll);
         window.scrollTo (0,currentScroll - (currentScroll/5));
    }
}
)();
$('.menu-item').click(function() {
	    $('.menu-item').removeClass('current-menu-item');
        $(this).addClass('current-menu-item');
    });
$(".loadingback").css("display","block");
Waves.init();
Waves.attach('.entry-summary .featured-image img' , 'waves-light waves-float');
    }).on('pjax:complete', function() {
var container = document.getElementsByClassName('OwO')[0];
var target = document.getElementsByClassName('commenttextarea')[0];
    if (container !== undefined && target !== undefined) {
        var OwO_demo = new OwO ({
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
$(".loadingback").css("display","none");
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

    </script>
</body>
</html>