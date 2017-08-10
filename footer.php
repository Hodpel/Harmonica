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
<div class="loadingback">
<div id="loading">
<div id="loading-center">
<div id="loading-center-absolute">
<div class="object" id="object_four"></div>
<div class="object" id="object_three"></div>
<div class="object" id="object_two"></div>
<div class="object" id="object_one"></div>

</div>
</div>
 
</div>
</div>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/lib/js/jquery.pjax.js"></script>
<script>
window['LocalConst'] = {
	BASE_SCRIPT_URL: "<?php echo get_stylesheet_directory_uri() ?>",
};
LocalConst.SMILES_EMOJI_PATH = "<?php echo get_stylesheet_directory_uri() . '/images/smilies/' ?>"; 
IfDark = "<?php echo get_option('IfDark'); ?>";
<?php
if (is_home() || !has_post_thumbnail()) {
	if (has_header_image()) {
		$headerimg = get_header_image();
	} else {
		$headerimg = get_theme_file_uri('/images/header.jpg');
	}
} else {
	$headerimg = wp_get_attachment_image_src(get_post_thumbnail_id($post ->ID), 'full')[0];
} 
?>
var header = 'url(<?php echo $headerimg ?>)';
$(".site-image").css('background', header);
load(); 
<?php
if (get_option('IfPjax') == 'yes') {
	echo 'pjax();';
}
if (get_option('IfAuto') == 'yes') {
	echo '$(document).ready(function() {
							var myDate = new Date();
							var currentTime = myDate.getHours();
								if (currentTime <= 6 || currentTime >= 20) {
									$("body").addClass("theme-dark ").removeClass("theme-light");
									$(".back-to-top").addClass("waves-light");
								}
								else{
									$("body").addClass("theme-light").removeClass("theme-dark");
									$(".back-to-top").removeClass("waves-light");
								}
							});';
}
?>
if (IfDark == 'yes') {
	$(".back-to-top").addClass("waves-light");
}
if (screen.width <= 1024) {
	$(".back-to-top").removeClass("waves-effect");
}


index_button_click();
</script>
</body>
</html>