<?php 		
if (!is_page())
	if( get_theme_mod( 'post_thumbnail', 1 ) && has_post_thumbnail()) {

		if ( ! class_exists( 'Get_The_Image' ) ) {
			apply_filters ( 'harmonica_featured_image' , printf( '<div class="entry-image"><a href="%s" title="%s">%s</a></div>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_post_thumbnail(get_the_ID(), get_theme_mod( 'image_size' ), array('class' => get_theme_mod( 'image_size' )) ) ));
		} else {
			get_the_image( array( 'size' => get_theme_mod( 'image_size' ) ) );		
		}	
	}
?>