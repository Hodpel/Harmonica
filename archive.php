<?php
/**
 * The template for displaying Archive pages.
 *
 * @package harmonica
 */

get_header(); ?>
	<main  class="<?php echo harmonica_apply_atomic( 'main_class', 'content' );?>" <?php harmonica_attr( 'content' ); ?>>
		<?php 
		do_action( 'harmonica_before_content' );
		do_action( 'harmonica_content' );
		do_action( 'harmonica_after_content' );
		?>	
	</main><!-- .content -->
<?php get_footer(); ?>