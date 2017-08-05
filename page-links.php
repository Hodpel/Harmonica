<?php
/**
 * The template for displaying all pages.
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
	<header class="entry-header">	<h1 class="entry-title"><?php echo get_the_title(get_page($page_id)); ?></h1>
</header>
			<article id="post-<?php echo get_page_id(links); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php 
						$page_id = get_page_id(links);
						$page_data = get_page($page_id);
						$content = apply_filters('the_content', $page_data->post_content);
						require get_template_directory() . '/lib/functions/page-links.php'; 
					
					
					?>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->
		<?php 
			if (comments_open() || get_comments_number()):
				comments_template();
			endif;
		?>
</main><!-- .content -->
<?php get_footer(); ?>