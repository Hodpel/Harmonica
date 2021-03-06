<?php
/**
 * HTML attribute functions and filters.  The purposes of this is to provide a way for theme/plugin devs 
 * to hook into the attributes for specific HTML elements and create new or modify existing attributes.  
 * This is sort of like `body_class()`, `post_class()`, and `comment_class()` on steroids.  Plus, it 
 * handles attributes for many more elements.  The biggest benefit of using this is to provide richer 
 * microdata while being forward compatible with the ever-changing Web.  Currently, the default microdata 
 * vocabulary supported is Schema.org.
 */

/* Attributes for major structural elements. */
add_filter( 'harmonica_attr_head',    'harmonica_attr_head',    5    );
add_filter( 'harmonica_attr_body',    'harmonica_attr_body',    5    );
add_filter( 'harmonica_attr_header',  'harmonica_attr_header',  5    );
add_filter( 'harmonica_attr_footer',  'harmonica_attr_footer',  5    );
add_filter( 'harmonica_attr_content', 'harmonica_attr_content', 5    );
add_filter( 'harmonica_attr_sidebar', 'harmonica_attr_sidebar', 5, 2 );
add_filter( 'harmonica_attr_menu',    'harmonica_attr_menu',    5, 2 );

/* Header attributes. */
add_filter( 'harmonica_attr_site-title',       'harmonica_attr_site_title',       5 );
add_filter( 'harmonica_attr_site-description', 'harmonica_attr_site_description', 5 );

/* Loop attributes. */
add_filter( 'harmonica_attr_loop-meta',        'harmonica_attr_loop_meta',        5 );
add_filter( 'harmonica_attr_loop-title',       'harmonica_attr_loop_title',       5 );
add_filter( 'harmonica_attr_loop-description', 'harmonica_attr_loop_description', 5 );

/* Post-specific attributes. */
add_filter( 'harmonica_attr_post',            'harmonica_attr_post',            5    );
add_filter( 'harmonica_attr_entry',           'harmonica_attr_post',            5    ); // Alternate for "post".
add_filter( 'harmonica_attr_entry-title',     'harmonica_attr_entry_title',     5    );
add_filter( 'harmonica_attr_entry-author',    'harmonica_attr_entry_author',    5    );
add_filter( 'harmonica_attr_entry-published', 'harmonica_attr_entry_published', 5    );
add_filter( 'harmonica_attr_entry-content',   'harmonica_attr_entry_content',   5    );
add_filter( 'harmonica_attr_entry-summary',   'harmonica_attr_entry_summary',   5    );
add_filter( 'harmonica_attr_entry-terms',     'harmonica_attr_entry_terms',     5, 2 );

/* Comment specific attributes. */
add_filter( 'harmonica_attr_comment',           'harmonica_attr_comment',           5 );
add_filter( 'harmonica_attr_comment-author',    'harmonica_attr_comment_author',    5 );
add_filter( 'harmonica_attr_comment-published', 'harmonica_attr_comment_published', 5 );
add_filter( 'harmonica_attr_comment-permalink', 'harmonica_attr_comment_permalink', 5 );
add_filter( 'harmonica_attr_comment-content',   'harmonica_attr_comment_content',   5 );

/**
 * Outputs an HTML element's attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $slug        The slug/ID of the element (e.g., 'sidebar').
 * @param  string  $context     A specific context (e.g., 'primary').
 * @param  array   $attributes  Custom attributes to pass in.
 * @return void
 */
function harmonica_attr( $slug, $context = '', $attributes = array() ) {
	echo harmonica_get_attr( $slug, $context, $attributes );
}

/**
 * Gets an HTML element's attributes.  This function is actually meant to be filtered by theme authors, plugins, 
 * or advanced child theme users.  The purpose is to allow folks to modify, remove, or add any attributes they 
 * want without having to edit every template file in the theme.  So, one could support microformats instead 
 * of microdata, if desired.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $slug        The slug/ID of the element (e.g., 'sidebar').
 * @param  string  $context     A specific context (e.g., 'primary').
 * @param  array   $attributes  Custom attributes to pass in.
 * @return string
 */
function harmonica_get_attr( $slug, $context = '', $attributes = array() ) {
	$out    = '';
	$attr   = apply_filters( "harmonica_attr_{$slug}", $attributes, $context );
	if ( empty( $attr ) )
		$attr['class'] = $slug;
	foreach ( $attr as $name => $value )
		$out .= !empty( $value ) ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
	return trim( $out );
}

/* === Structural === */

/**
 * <head> element attributes.
 *
 * @since  1.2.2
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_head( $attr ) {
	return $attr;
}

/**
 * <body> element attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_body( $attr ) {
	$attr['dir']       = is_rtl() ? 'rtl' : 'ltr';
	return $attr;
}

/**
 * Page <header> element attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_header( $attr ) {
	$attr['id']        = 'header';
	$attr['class']     = 'site-header';
	$attr['role']      = 'banner';
	return $attr;
}

/**
 * Page <footer> element attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_footer( $attr ) {

	$attr['id']        = 'footer';
	$attr['class']     = 'site-footer';
	$attr['role']      = 'contentinfo';
	return $attr;
}

/**
 * Main content container of the page attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_content( $attr ) {

	$attr['id']       = 'content';
	$attr['role']     = 'main';
	if ( is_singular( 'post' ) || is_home() || is_archive() ) {
	} elseif ( is_search() ) {
	}

	return $attr;
}

/**
 * Sidebar attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_sidebar( $attr, $context ) {

	if ( !empty( $context ) )
		$attr['id'] = "sidebar-{$context}";

	$attr['role']      = 'complementary';
	return $attr;
}

/**
 * Nav menu attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_menu( $attr, $context ) {

	if ( !empty( $context ) )
	$attr['id'] = "menu-{$context}";
	$attr['role']      = 'navigation';
	return $attr;
}

/* === header === */

/**
 * Site title attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_site_title( $attr ) {
	$attr['id']       = 'site-title';
	return $attr;
}

/**
 * Site description attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_site_description( $attr ) {
	$attr['id']       = 'site-description';
	return $attr;
}

/* === loop === */

/**
 * Loop meta attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_loop_meta( $attr ) {
	$attr['class']     = 'loop-meta';
	return $attr;
}

/**
 * Loop title attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_loop_title( $attr ) {
	$attr['class']     = 'loop-title';
	return $attr;
}

/**
 * Loop description attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_loop_description( $attr ) {
	$attr['class']     = 'loop-description';
	return $attr;
}

/* === posts === */

/**
 * Post <article> element attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_post( $attr ) {
	$post = get_post();

	/* Make sure we have a real post first. */
	if ( !empty( $post ) ) {
		$attr['id']        = 'post-' . get_the_ID();
		$attr['class']     = join( ' ', get_post_class() );
	} else {
		$attr['id']    = 'post-0';
		$attr['class'] = join( ' ', get_post_class() );
	}

	return $attr;
}

/**
 * Post title attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_entry_title( $attr ) {
	$attr['class']    = 'entry-title';
	return $attr;
}

/**
 * Post author attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_entry_author( $attr ) {
	$attr['class']     = 'entry-author';
	return $attr;
}

/**
 * Post time/published attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_entry_published( $attr ) {
	$attr['class']    = 'entry-time';
	$attr['datetime'] = get_the_time( 'Y-m-d\TH:i:sP' );
	/* Translators: Post date/time "title" attribute. */
	$attr['title']    = get_the_time( _x( 'l, F j, Y, g:i a', 'post time format', 'harmonica' ) );
	return $attr;
}

/**
 * Post content (not excerpt) attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_entry_content( $attr ) {
	$attr['class']    = 'entry-content';	
	return $attr;
}

/**
 * Post summary/excerpt attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_entry_summary( $attr ) {
	$attr['class']    = 'entry-summary';
	return $attr;
}

/**
 * Post terms (tags, categories, etc.) attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @param  string  $context
 * @return array
 */
function harmonica_attr_entry_terms( $attr, $context ) {
	if ( !empty( $context ) ) {
		$attr['class'] = 'entry-terms ' . sanitize_html_class( $context );
	}
	return $attr;
}


/* === Comment elements === */


/**
 * Comment wrapper attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_comment( $attr ) {
	//$attr['id']    = 'comment-' . get_comment_ID(); hence disabled
	//$attr['class'] = join( ' ', get_comment_class() );
	//if ( in_array( get_comment_type(), array( '', 'comment' ) ) ) {
		$attr['class']     = 'comment-item';
	//}
	return $attr;
}

/**
 * Comment author attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_comment_author( $attr ) {
	$attr['class']     = 'comment-author';
	return $attr;
}

/**
 * Comment time/published attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_comment_published( $attr ) {
	$attr['class']    = 'comment-published';
	$attr['datetime'] = get_comment_time( 'Y-m-d\TH:i:sP' );
	/* Translators: Comment date/time "title" attribute. */
	$attr['title']    = get_comment_time( _x( 'l, F j, Y, g:i a', 'comment time format', 'harmonica' ) );
	return $attr;
}

/**
 * Comment permalink attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_comment_permalink( $attr ) {

	$attr['class']    = 'comment-permalink';
	$attr['href']     = get_comment_link();
	return $attr;
}

/**
 * Comment content/text attributes.
 *
 * @since  0.9.0
 * @access public
 * @param  array   $attr
 * @return array
 */
function harmonica_attr_comment_content( $attr ) {
	$attr['class']    = 'comment-content';
	$attr['itemprop'] = 'commentText';
	return $attr;
}