<?php
/**
 * General template functions.
 */

/**
 * Outputs the link back to the site.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function harmonica_site_link() {
	echo harmonica_get_site_link();
}

/**
 * Returns a link back to the site.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function harmonica_get_site_link() {
	return sprintf( '<a class="site-link" href="%s" rel="home">%s</a>', esc_url( home_url() ), get_bloginfo( 'name' ) );
}

/**
 * Displays a link to WordPress.org.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function harmonica_wp_link() {
	echo harmonica_get_wp_link();
}

/**
 * Returns a link to WordPress.org.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function harmonica_get_wp_link() {
	return sprintf( '<a class="wp-link" href="http://wordpress.org" title="%s">%s</a>', esc_attr__( 'State-of-the-art semantic personal publishing platform', 'harmonica' ), __( 'WordPress', 'harmonica' ) );
}

/**
 * Displays a link to the parent theme URI.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function harmonica_theme_link() {
	echo harmonica_get_theme_link();
}

/**
 * Returns a link to the parent theme URI.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function harmonica_get_theme_link() {
	$theme = wp_get_theme( get_template() );
	$uri   = $theme->get( 'ThemeURI' );
	$name  = $theme->display( 'Name', false, true );

	/* Translators: Theme name. */
	$title = sprintf( __( '%s WordPress Theme', 'harmonica' ), $name );

	return sprintf( '<a class="theme-link" rel="nofollow" href="%s" title="%s">%s</a>', esc_url( $uri ), esc_attr( $title ), $name );
}

/**
 * Returns a link to the parent theme URI.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function harmonica_get_author_uri() {
	$theme = wp_get_theme();
	$uri   = $theme->get( 'AuthorURI' );
	$name  = $theme->display( 'Author', false, true );

	/* Translators: Theme name. */
	$title = sprintf( __( '%s', 'harmonica' ), $name );

	if (is_child_theme()) {
		return sprintf( $name );
	} else {
		return sprintf( '<a class="theme-link" href="%s" title="%s">%s</a>', esc_url( $uri ), esc_attr( $title ), $name );
	}
}

/**
 * Displays a link to the child theme URI.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function harmonica_child_theme_link() {
	echo harmonica_get_child_theme_link();
}

/**
 * Returns a link to the child theme URI.
 *
 * @since  0.9.0
 * @access public
 * @return string
 */
function harmonica_get_child_theme_link() {

	if ( !is_child_theme() )
		return '';

	$theme = wp_get_theme();
	$uri   = $theme->get( 'ThemeURI' );
	$name  = $theme->display( 'Name', false, true );

	/* Translators: Theme name. */
	$title = sprintf( __( '%s WordPress Theme', 'harmonica' ), $name );

	return sprintf( '<a class="child-link" href="%s" title="%s">%s</a>', esc_url( $uri ), esc_attr( $title ), $name );
}

/**
 * Returns theme name.
 *
 * @since  1.1.2
 * @access public
 * @return string
 */
function harmonica_get_theme_name() {

	$theme = wp_get_theme();
	return $theme->display( 'Name', false, true );
}

/**
 * Outputs the loop title.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function harmonica_loop_title() {
	echo harmonica_get_loop_title();
}

/**
 * Gets the loop title.  This function should only be used on archive-type pages, such as archive, blog, and 
 * search results pages.  It outputs the title of the page.
 *
 * @link   http://core.trac.wordpress.org/ticket/21995
 * @since  0.9.0
 * @access public
 * @return string
 */
function harmonica_get_loop_title() {

	$loop_title = '';

	if ( is_home() && !is_front_page() )
		$loop_title = get_post_field( 'post_title', get_queried_object_id() );

	elseif ( is_category() ) 
		$loop_title = single_cat_title( '', false );

	elseif ( is_tag() )
		$loop_title = single_tag_title( '', false );

	elseif ( is_tax() )
		$loop_title = single_term_title( '', false );

	elseif ( is_author() )
		$loop_title = get_the_author();

	elseif ( is_search() )
		$loop_title = harmonica_search_title( '', false );

	elseif ( is_post_type_archive() )
		$loop_title = post_type_archive_title( '', false );

	elseif ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
		$loop_title = harmonica_single_minute_hour_title( '', false );

	elseif ( get_query_var( 'minute' ) )
		$loop_title = harmonica_single_minute_title( '', false );

	elseif ( get_query_var( 'hour' ) )
		$loop_title = harmonica_single_hour_title( '', false );

	elseif ( is_day() )
		$loop_title = harmonica_single_day_title( '', false );

	elseif ( get_query_var( 'w' ) )
		$loop_title = harmonica_single_week_title( '', false );

	elseif ( is_month() )
		$loop_title = single_month_title( ' ', false );

	elseif ( is_year() )
		$loop_title = harmonica_single_year_title( '', false );

	elseif ( is_archive() )
		$loop_title = harmonica_single_archive_title( '', false );

	return apply_filters( 'harmonica_loop_title', $loop_title );
}

/**
 * Outputs the loop description.
 *
 * @since  0.9.0
 * @access public
 * @return void
 */
function harmonica_loop_description() {
	echo harmonica_get_loop_description();
}

/**
 * Gets the loop description.  This function should only be used on archive-type pages, such as archive, blog, and 
 * search results pages.  It outputs the description of the page.
 *
 * @link   http://core.trac.wordpress.org/ticket/21995
 * @since  0.9.0
 * @access public
 * @return string
 */
function harmonica_get_loop_description() {

	$loop_desc = '';

	if ( is_home() && !is_front_page() )
		$loop_desc = get_post_field( 'post_content', get_queried_object_id(), 'raw' );

	elseif ( is_category() )
		$loop_desc = get_term_field( 'description', get_queried_object_id(), 'category', 'raw' );

	elseif ( is_tag() )
		$loop_desc = get_term_field( 'description', get_queried_object_id(), 'post_tag', 'raw' );

	elseif ( is_tax() )
		$loop_desc = get_term_field( 'description', get_queried_object_id(), get_query_var( 'taxonomy' ), 'raw' );

	elseif ( is_author() )
		$loop_desc = get_the_author_meta( 'description', get_query_var( 'author' ) );

	elseif ( is_search() )
		$loop_desc = sprintf( __( 'You are browsing the search results for &#8220;%s&#8221;', 'harmonica' ), get_search_query() );

	elseif ( is_post_type_archive() )
		$loop_desc = get_post_type_object( get_query_var( 'post_type' ) )->description;

	elseif ( is_time() )
		$loop_desc = __( 'You are browsing the site archives by time.', 'harmonica' );

	elseif ( is_day() )
		$loop_desc = sprintf( __( 'You are browsing the site archives for %s.', 'harmonica' ), harmonica_single_day_title( '', false ) );

	elseif ( is_month() )
		$loop_desc = sprintf( __( 'You are browsing the site archives for %s.', 'harmonica' ), single_month_title( ' ', false ) );

	elseif ( is_year() )
		$loop_desc = sprintf( __( 'You are browsing the site archives for %s.', 'harmonica' ), harmonica_single_year_title( '', false ) );

	elseif ( is_archive() )
		$loop_desc = __( 'You are browsing the site archives.', 'harmonica' );

	return apply_filters( 'harmonica_loop_description', $loop_desc );
}

/**
 * Retrieve the general archive title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_single_archive_title( $prefix = '', $display = true ) {

	$title = $prefix . __( 'Archives', 'harmonica' );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Retrieve the year archive title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_single_year_title( $prefix = '', $display = true ) {

	$title = $prefix . get_the_date( _x( 'Y', 'yearly archives date format', 'harmonica' ) );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Retrieve the week archive title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_single_week_title( $prefix = '', $display = true ) {

	/* Translators: 1 is the week number and 2 is the year. */
	$title = $prefix . sprintf( __( 'Week %1$s of %2$s', 'harmonica' ), get_the_time( _x( 'W', 'weekly archives date format', 'harmonica' ) ), get_the_time( _x( 'Y', 'yearly archives date format', 'harmonica' ) ) );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Retrieve the day archive title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_single_day_title( $prefix = '', $display = true ) {

	$title = $prefix . get_the_date( _x( 'F j, Y', 'daily archives date format', 'harmonica' ) );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Retrieve the hour archive title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_single_hour_title( $prefix = '', $display = true ) {

	$title = $prefix . get_the_time( _x( 'g a', 'hour archives time format', 'harmonica' ) );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Retrieve the minute archive title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_single_minute_title( $prefix = '', $display = true ) {

	/* Translators: Minute archive title. %s is the minute time format. */
	$title = $prefix . sprintf( __( 'Minute %s', 'harmonica' ), get_the_time( _x( 'i', 'minute archives time format', 'harmonica' ) ) );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Retrieve the minute + hour archive title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_single_minute_hour_title( $prefix = '', $display = true ) {

	$title = $prefix . get_the_time( _x( 'g:i a', 'minute and hour archives time format', 'harmonica' ) );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Retrieve the search results title.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $prefix
 * @param  bool    $display
 * @return string
 */
function harmonica_search_title( $prefix = '', $display = true ) {

	/* Translators: %s is the search query. The HTML entities are opening and closing curly quotes. */
	$title = $prefix . sprintf( __( 'Search results for &#8220;%s&#8221;', 'harmonica' ), get_search_query() );

	if ( false === $display )
		return $title;

	echo $title;
}

/**
 * Produces the date of post publication.
 *
 * Supported attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *
 * Output passes through 'harmonica_get_post_date' filter before returning.
 *
 * @since 1.1.0
 * @access public
 * @param  string  $after
 * @param  string  $before
 * @param  string  $format
 * @param  string  $label
 * @return string
 */

function harmonica_get_post_date( $after = '', $before = '', $format = '', $label = '' ) {

	if ($format == '') $format = get_option( 'date_format' );

	$display = ( 'relative' === $format ) ? harmonica_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'harmonica' ) : get_the_time( $format );

	$output = sprintf( '<time %s>', harmonica_get_attr( 'entry-published' ) ) . $before . $label . $display . $after . '</time>';

	return apply_filters( 'harmonica_get_post_date', $output, $after, $before, $format, $label  );

}