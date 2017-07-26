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
</body>
</html>