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
<script src="<?php bloginfo('template_url');?>/lib/js/jquery.pjax.js"></script>
<script>
Waves.init();
Waves.attach('.entry-summary .featured-image img' , 'waves-light waves-float');
$(".smilies").click(function(){
  $("p").slideToggle();
});
var OwO_demo = new OwO ({
    logo: 'OωO',
    container: document.getElementsByClassName('OwO')[0],
    target: document.getElementsByClassName('commenttextarea')[0],
	api: 'http://127.0.0.1/wp-content/themes/harmonica/lib/widgets/OwO.json',
    position: 'down',
    width: '400px',
    maxHeight: '250px'
});
</script>
<script type="text/javascript">
    window['LocalConst'] = {
        BASE_SCRIPT_URL: "http://127.0.0.1/wp-content/themes/harmonica/",
    };
    LocalConst.SMILES_EMOJI_PATH = 'http://127.0.0.1/wp-content/themes/harmonica/images/smilies/';
    var SMILES_EMOJI_PATH = LocalConst.SMILES_EMOJI_PATH;
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
$(document).getscript("<?php echo get_template_directory() . '/lib/js/OwO.js'; ?>");
    }).on('pjax:complete', function() {
Prism.highlightAll();
$(".loadingback").css("display","none");
    });
});
    </script>
</body>
</html>