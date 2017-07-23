<?php
/* Register custom menus. */
add_action( 'init', 'harmonica_register_menus' );

/* Register sidebars. */
add_action( 'widgets_init', 'harmonica_register_sidebars' );

/* Add default theme settings */
add_filter( 'harmonica_default_theme_settings', 'harmonica_set_default_theme_settings');

add_action( 'wp_enqueue_scripts', 'harmonica_scripts' );
add_action( 'wp_head', 'harmonica_styles' );

/* Load the primary menu. */
add_action( 'harmonica_before_header', 'harmonica_get_primary_menu' );
add_action( 'harmonica_before_primary_menu', 'harmonica_menu_icon');

/* Header actions. */
add_action( 'harmonica_header', 'harmonica_header_markup_open', 5 );
add_action( 'harmonica_header', 'harmonica_branding' );
add_action( 'harmonica_header', 'harmonica_header_markup_close', 15 );

/* footer insert to the footer. */
add_action( 'harmonica_footer', 'harmonica_footer_markup_open', 5 );
add_action( 'harmonica_footer', 'harmonica_footer_insert' );
add_action( 'harmonica_footer', 'harmonica_footer_markup_close', 15 );

/* load content */
add_action( 'harmonica_content', 'harmonica_content');

add_action( 'harmonica_before_loop', 'harmonica_archive_title'); 
add_action( 'harmonica_after_loop', 'harmonica_content_nav'); 
add_action( 'harmonica_after_loop', 'comments_template');  // Loads the comments.php template.  

/* Add the title, byline, and entry meta before and after the entry.*/
add_action( 'harmonica_before_entry', 'harmonica_entry_header' );
add_action( 'harmonica_entry', 'harmonica_entry' );
add_action( 'harmonica_after_entry', 'harmonica_entry_footer' );

/* Add the primary sidebars after the main content. */
add_action( 'harmonica_after_main', 'harmonica_primary_sidebar' );

add_filter( 'harmonica_footer_insert', 'harmonica_default_footer_insert' );

add_filter( 'comment_form_defaults', 'harmonica_custom_comment_form' );


/**
 * Registers nav menu locations.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function harmonica_register_menus() {
	register_nav_menu( 'primary',   _x( 'Primary', 'nav menu location', 'harmonica' ) );
}

/**
 * Registers sidebars.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */

function harmonica_register_sidebars() {
	harmonica_register_sidebar(
		array(
			'id'          => 'primary',
			'name'        => _x( 'Primary', 'sidebar', 'harmonica' ),
			'description' => __( 'The main sidebar. It is displayed on either the left or right side of the page based on the chosen layout.', 'harmonica' )
		)
	);
}

/**
 * Adds custom default theme settings.
 *
 * @since 0.3.0
 * @access public
 * @param array $settings The default theme settings.
 * @return array $settings
 */

function harmonica_set_default_theme_settings( $settings ) {

	$settings = array(
		'comments_pages'       	=> 0,
		'content_archive'       => 'full',
		'content_archive_limit'	=> 0,
		'post_thumbnail' 		=> 1,
		'more_text'      		=> '[Read more...]',
		'no_more_scroll'		=> 1,
		'image_size'           	=> 'large',
	);

	return $settings;

}


function harmonica_header_markup_open() {
	echo '<header ' . harmonica_get_attr('header') . '>';
}


function harmonica_header_markup_close() {
	echo '</header><!-- .site-header -->';
}

function harmonica_footer_markup_open() {
	echo '<footer ' . harmonica_get_attr('footer') . '>';
}


function harmonica_footer_markup_close() {
	echo '</footer><!-- .site-footer -->';
}

/**
 * Dynamic element to wrap the site title and site description. 
 */
function harmonica_branding() {
	get_template_part( 'partials/title', 'area' );	
}

/**
 * default footer insert filter
 */
function harmonica_default_footer_insert( $settings ) {

	/* If there is a child theme active, use [child-link] shortcode to the $footer_insert. */
	if ( !is_child_theme() ) {
		return '<p class="copyright">' . __( 'Copyright &#169; ', 'harmonica' ) . date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '.</p>' . "\n\n" . '<p class="credit">' . harmonica_get_theme_name() . __( ' WordPress Theme by ', 'harmonica' ) . harmonica_get_author_uri() . '</p>';		
	} else {
		return '<p class="copyright">' . __( 'Copyright &#169; ', 'harmonica' ) . date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '.</p>' . "\n\n" . '<p class="credit">' . harmonica_get_child_theme_link() . __( ' WordPress Theme by ', 'harmonica' ) . harmonica_get_author_uri() . '</p>';		
	}
	

}

/**
 * Loads footer content
 */
function harmonica_footer_insert() {
	
	echo '<div class="footer-content footer-insert">';
	
	if ( $footer_insert = get_theme_mod( 'custom_footer' ) ) {
		echo harmonica_apply_atomic_shortcode( 'footer_content', $footer_insert );		
	} else {
		echo harmonica_apply_atomic_shortcode( 'footer_content', apply_filters( 'harmonica_footer_insert','') );
	}
	
	echo '</div>';
}

/**
 * Loads the menu-primary.php template.
 */
function harmonica_get_primary_menu() {
	get_template_part( 'partials/menu', 'primary' );
}

/**
 * print menu icon
 */
function harmonica_menu_icon() {
	echo '<a href="#" id="menu-icon" class="menu-icon"><span></span></a>';
}

/**
 * Display primary sidebar
 */
function harmonica_primary_sidebar() {
	get_sidebar();
}

/**
 * Display the default entry header.
 */
function harmonica_entry_header() {
	get_template_part( 'partials/entry', 'header' );	
}

/**
 * Display the default entry metadata.
 */
function harmonica_entry() {
	get_template_part( 'partials/entry' );	
}

function harmonica_excerpt_more( $more ) {
	return ' ... <span class="more"><a class="more-link" href="'. get_permalink( get_the_ID() ) . '">' . get_theme_mod( 'more_text', '[Read more...]' ) . '</a></span>';
}
add_filter('excerpt_more', 'harmonica_excerpt_more');

/**
 * Display the default entry footer.
 */
function harmonica_entry_footer() {
	if ( 'post' == get_post_type() ) get_template_part( 'partials/entry', 'footer' );
}

/**
 * Enqueue scripts and styles
 */
function harmonica_scripts() {
	wp_enqueue_style( 'harmonica-style', get_stylesheet_uri() );
}

/**
 * Insert conditional script / style for the theme used sitewide.
 */
function harmonica_styles() {
?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
<?php 
}

/**
 * Display navigation to next/previous pages when applicable
 */
function harmonica_content_nav() {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( (!$next && !$previous) )
			return;
	}

	if ( is_singular() && !get_theme_mod( 'single_nav', 0 ) ) {
		return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';
	
	?>
	<nav role="navigation" id="nav-below" class="navigation  <?php echo $nav_class; ?>">

	<?php 
	if ( is_single() && get_theme_mod( 'single_nav', 0 ) ) : // navigation links for single posts 
		get_template_part( 'partials/single', 'nav' );
   	elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages 
		loop_pagination();
	endif; 
	?>

	</nav><!-- #nav-below -->
	<?php
}

function harmonica_archive_title() {
	if(is_archive() || is_search() ) {
	?>

		<header class="page-header">
			<h1 class="archive-title">
				<?php
					if ( is_category() ) :
						single_cat_title();

					elseif ( is_search() ) :
						printf( __( 'Search Results for: %s', 'harmonica' ), '<span>' . get_search_query() . '</span>' );

					elseif ( is_tag() ) :
						single_tag_title();

					elseif ( is_author() ) :
						/* Queue the first post, that way we know
						 * what author we're dealing with (if that is the case).
						*/
						the_post();
						printf( __( 'Author: %s', 'harmonica' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
						/* Since we called the_post() above, we need to
						 * rewind the loop back to the beginning that way
						 * we can run the loop properly, in full.
						 */
						rewind_posts();

					elseif ( is_day() ) :
						printf( __( 'Day: %s', 'harmonica' ), '<span>' . get_the_date() . '</span>' );

					elseif ( is_month() ) :
						printf( __( 'Month: %s', 'harmonica' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

					elseif ( is_year() ) :
						printf( __( 'Year: %s', 'harmonica' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

					else :
						_e( 'Archives', 'harmonica' );

					endif;
				?>
			</h1>
			<?php
				// Show an optional term description.
				$term_description = term_description();
				if ( ! empty( $term_description ) ) :
					printf( '<div class="taxonomy-description">%s</div>', $term_description );
				endif;
			?>
		</header><!-- .page-header -->

	<?php 
	}
}

function harmonica_content() {
	get_template_part( 'partials/content' );	
}

function harmonica_custom_comment_form($fields) {
	$fields['comment_notes_after'] = ''; //Removes Form Allowed Tags Box
return $fields;
}


// add disqus compatibility
if (function_exists('dsq_comments_template')) {
	remove_filter( 'comments_template', 'dsq_comments_template' );
	add_filter( 'comments_template', 'dsq_comments_template', 12 ); // You can use any priority higher than '10'	
}