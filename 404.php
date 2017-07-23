<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package harmonica
 */

get_header();?>
	<main class="<?php echo harmonica_apply_atomic( 'main_class', 'content' );?>"  role="main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'harmonica' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p><?php echo sprintf( __( 'It looks like nothing was found at this location. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'harmonica' ), home_url() ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
	</main><!-- .content -->
<?php get_footer(); ?>