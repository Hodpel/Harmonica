<?php
/**
 * The template for displaying woocommerce page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package harmonica
 */

get_header(); ?>

	<main  class="<?php echo harmonica_apply_atomic( 'main_class', 'content' );?>" <?php harmonica_attr( 'content' ); ?>>

		<?php 
		do_action( 'harmonica_before_content' ); 

		woocommerce_content(); 

		do_action( 'harmonica_after_content' ); 
		?>

	</main><!-- .content -->

<?php get_footer(); ?>
