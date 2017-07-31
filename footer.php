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
window['LocalConst'] = {
    BASE_SCRIPT_URL: "<?php echo get_stylesheet_directory_uri() ?>",
};
LocalConst.SMILES_EMOJI_PATH = "<?php echo get_stylesheet_directory_uri() . '/images/smilies/' ?>";
load();
<?php
if (get_option('IfPjax')=='yes') {
	echo 'pjax();';
}
if (get_option('IfAuto')=='yes') {
					echo'$(document).ready(function() {
					var myDate = new Date();
					var currentTime = myDate.getHours();
					if (currentTime < 6 || currentTime > 22) {
						$("body").addClass("theme-dark").removeClass("theme-light");
					}
					else{
						$("body").addClass("theme-light").removeClass("theme-dark");
					}
				});';
}

?>
    </script>
</body>
</html>