<?php
/**
 * Functions for making various theme elements context-aware.  Controls things such as the smart 
 * and logical body, post, and comment CSS classes as well as context-based action and filter hooks.  
 * The functions also integrate with WordPress' implementations of body_class, post_class, and 
 * comment_class, so your theme won't have any trouble with plugin integration.
 */

/* Filters the WordPress 'body_class' early. */
add_filter( 'body_class', 'harmonica_body_class_filter', 0, 2 );

/* Filters the WordPress 'post_class' early. */
add_filter( 'post_class', 'harmonica_post_class_filter', 0, 3 );

/* Filters the WordPress 'comment_class' early. */
add_filter( 'comment_class', 'harmonica_comment_class_filter', 0, 3 );

/**
 * harmonica's main contextual function.  This allows code to be used more than once without running 
 * hundreds of conditional checks within the theme.  It returns an array of contexts based on what 
 * page a visitor is currently viewing on the site.  This function is useful for making dynamic/contextual
 * classes, action and filter hooks, and handling the templating system.
 *
 * Note that time and date can be tricky because any of the conditionals may be true on time-/date-
 * based archives depending on several factors.  For example, one could load an archive for a specific
 * second during a specific minute within a specific hour on a specific day and so on.
 *
 * @since 0.7.0
 * @access public
 * @global $wp_query The current page's query object.
 * @global $harmonica The global harmonica object.
 * @return array $harmonica->context Several contexts based on the current page.
 */
function harmonica_get_context() {
	global $harmonica;

	/* If $harmonica->context has been set, don't run through the conditionals again. Just return the variable. */
	if ( isset( $harmonica->context ) )
		return apply_filters( 'harmonica_context', $harmonica->context );

	/* Set some variables for use within the function. */
	$harmonica->context = array();
	$object = get_queried_object();
	$object_id = get_queried_object_id();

	/* Front page of the site. */
	if ( is_front_page() )
		$harmonica->context[] = 'home';

	/* Blog page. */
	if ( is_home() ) {
		$harmonica->context[] = 'blog';
	}

	/* Singular views. */
	elseif ( is_singular() ) {
		$harmonica->context[] = 'singular';
		$harmonica->context[] = "singular-{$object->post_type}";
		$harmonica->context[] = "singular-{$object->post_type}-{$object_id}";
	}

	/* Archive views. */
	elseif ( is_archive() ) {
		$harmonica->context[] = 'archive';

		/* Post type archives. */
		if ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_query_var( 'post_type' ) );
			$harmonica->context[] = "archive-{$post_type->name}";
		}

		/* Taxonomy archives. */
		if ( is_tax() || is_category() || is_tag() ) {
			$harmonica->context[] = 'taxonomy';
			$harmonica->context[] = "taxonomy-{$object->taxonomy}";

			$slug = ( ( 'post_format' == $object->taxonomy ) ? str_replace( 'post-format-', '', $object->slug ) : $object->slug );
			$harmonica->context[] = "taxonomy-{$object->taxonomy}-" . sanitize_html_class( $slug, $object->term_id );
		}

		/* User/author archives. */
		if ( is_author() ) {
			$user_id = get_query_var( 'author' );
			$harmonica->context[] = 'user';
			$harmonica->context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', $user_id ), $user_id );
		}

		/* Date archives. */
		if ( is_date() ) {
			$harmonica->context[] = 'date';

			if ( is_year() )
				$harmonica->context[] = 'year';

			if ( is_month() )
				$harmonica->context[] = 'month';

			if ( get_query_var( 'w' ) )
				$harmonica->context[] = 'week';

			if ( is_day() )
				$harmonica->context[] = 'day';
		}

		/* Time archives. */
		if ( is_time() ) {
			$harmonica->context[] = 'time';

			if ( get_query_var( 'hour' ) )
				$harmonica->context[] = 'hour';

			if ( get_query_var( 'minute' ) )
				$harmonica->context[] = 'minute';
		}
	}

	/* Search results. */
	elseif ( is_search() ) {
		$harmonica->context[] = 'search';
	}

	/* Error 404 pages. */
	elseif ( is_404() ) {
		$harmonica->context[] = 'error-404';
	}

	return array_map( 'esc_attr', apply_filters( 'harmonica_context', array_unique( $harmonica->context ) ) );
}

/**
 * @since  0.9.0
 */
function harmonica_body_class_filter( $classes, $class ) {

	/* WordPress class for uses when WordPress isn't always the only system on the site. */
	$classes = array( 'wordpress' );

	/* Text direction. */
	$classes[] = is_rtl() ? 'rtl' : 'ltr';

	/* Check if the current theme is a parent or child theme. */
	$classes[] = is_child_theme() ? 'child-theme' : 'parent-theme';

	/* Multisite check adds the 'multisite' class and the blog ID. */
	if ( is_multisite() ) {
		$classes[] = 'multisite';
		$classes[] = 'blog-' . get_current_blog_id();
	}

	/* Date classes. */
	$time = time() + ( get_option( 'gmt_offset' ) * 3600 );
	$classes[] = strtolower( gmdate( '\yY \mm \dd \hH l', $time ) );

	/* Is the current user logged in. */
	$classes[] = is_user_logged_in() ? 'logged-in' : 'logged-out';

	/* WP admin bar. */
	if ( is_admin_bar_showing() )
		$classes[] = 'admin-bar';

	/* Use the '.custom-background' class to integrate with the WP background feature. */
	if ( get_background_image() || get_background_color() )
		$classes[] = 'custom-background';

	/* Add the '.custom-header' class if the user is using a custom header. */
	if ( get_header_image() || ( display_header_text() && get_header_textcolor() ) )
		$classes[] = 'custom-header';

	/* Add the '.display-header-text' class if the user chose to display it. */
	if ( display_header_text() )
		$classes[] = 'display-header-text';

	/* Plural/multiple-post view (opposite of singular). */
	if ( is_home() || is_archive() || is_search() )
		$classes[] = 'plural';

	/* Merge base contextual classes with $classes. */
	$classes = array_merge( $classes, harmonica_get_context() );

	/* Singular post (post_type) classes. */
	if ( is_singular() ) {

		/* Get the queried post object. */
		$post = get_queried_object();

		/* Checks for custom template. */
		$template = str_replace( array ( "{$post->post_type}-template-", "{$post->post_type}-" ), '', basename( get_post_meta( get_queried_object_id(), "_wp_{$post->post_type}_template", true ), '.php' ) );
		if ( !empty( $template ) )
			$classes[] = "{$post->post_type}-template-{$template}";

		/* Attachment mime types. */
		if ( is_attachment() ) {
			foreach ( explode( '/', get_post_mime_type() ) as $type )
				$classes[] = "attachment-{$type}";
		}
	}

	/* Paged views. */
	if ( is_paged() ) {
		$classes[] = 'paged';
		$classes[] = 'paged-' . intval( get_query_var( 'paged' ) );
	}

	/* Singular post paged views using <!-- nextpage -->. */
	elseif ( is_singular() && 1 < get_query_var( 'page' ) ) {
		$classes[] = 'paged';
		$classes[] = 'paged-' . intval( get_query_var( 'page' ) );
	}

	/* Input class. */
	if ( !empty( $class ) ) {
		$class   = is_array( $class ) ? $class : preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	}

	return array_map( 'esc_attr', $classes );
}

/**
 * @since  0.9.0
 */
function harmonica_post_class_filter( $classes, $class, $post_id ) {

	if ( is_admin() )
		return $classes;

	$_classes    = array();
	$post        = get_post( $post_id );
	$post_type   = get_post_type();
	$post_status = get_post_status();

	$remove = array( 'hentry', "type-{$post_type}", "status-{$post_status}", 'post-password-required' );

	foreach ( $classes as $key => $class ) {

		if ( in_array( $class, $remove ) )
			unset( $classes[ $key ] );
		else
			$classes[ $key ] = str_replace( 'tag-', 'post_tag-', $class );
	}

	$_classes[] = 'entry';
	$_classes[] = $post_type;
	$_classes[] = $post_status;

	/* Author class. */
	$_classes[] = 'author-' . sanitize_html_class( get_the_author_meta( 'user_nicename' ), get_the_author_meta( 'ID' ) );

	/* Password-protected posts. */
	if ( post_password_required() )
		$_classes[] = 'protected';

	/* Has excerpt. */
	if ( post_type_supports( $post->post_type, 'excerpt' ) && has_excerpt() )
		$_classes[] = 'has-excerpt';

	/* Has <!--more--> link. */
	if ( !is_singular() && false !== strpos( $post->post_content, '<!--more-->' ) )
		$_classes[] = 'has-more-link';

	return array_map( 'esc_attr', array_unique( array_merge( $_classes, $classes ) ) );
}

/**
 * @since  0.9.0
 */
function harmonica_comment_class_filter( $classes, $class, $comment_id ) {

	$comment = get_comment( $comment_id );

	/* If the comment type is 'pingback' or 'trackback', add the 'ping' comment class. */
	if ( in_array( $comment->comment_type, array( 'pingback', 'trackback' ) ) )
		$classes[] = 'ping';

	/* User classes to match user role and user. */
	if ( 0 < $comment->user_id ) {

		/* Create new user object. */
		$user = new WP_User( $comment->user_id );

		/* Set a class with the user's role(s). */
		if ( is_array( $user->roles ) ) {
			foreach ( $user->roles as $role )
				$classes[] = sanitize_html_class( "role-{$role}" );
		}
	}

	/* Get comment types that are allowed to have an avatar. */
	$avatar_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );

	/* If avatars are enabled and the comment types can display avatars, add the 'has-avatar' class. */
	if ( get_option( 'show_avatars' ) && in_array( $comment->comment_type, $avatar_types ) )
		$classes[] = 'has-avatar';

	return array_map( 'esc_attr', array_unique( $classes ) );
}