<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package harmonica
 */

/**
 * Returns true if a blog has more than 1 category
 */
function harmonica_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so harmonica_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so harmonica_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in harmonica_categorized_blog
 */
function harmonica_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'harmonica_category_transient_flusher' );
add_action( 'save_post',     'harmonica_category_transient_flusher' );