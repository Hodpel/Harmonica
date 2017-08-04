<?php
/*<div class="header section" style="background-image: url(<?php if (get_header_image() != '') : ?><?php header_image(); ?><?php else : ?><?php echo get_template_directory_uri() . '/images/header.jpg'; ?><?php endif; ?>);">*/

echo '<div class="site-image"></div>';

echo '<div class="' . harmonica_apply_atomic( 'title_area_class', 'title-area') .'">';

/* Get the site title.  If it's not empty, wrap it with the appropriate HTML. */	
if ( $title = get_bloginfo( 'name' ) ) {		
	if (is_home()) {
		$title = sprintf( '<h1 class="site-title" itemprop="headline"><a href="%1$s" title="%2$s" rel="home">%3$s</a></h1>', home_url(), esc_attr( $title ), $title );		
	} else {
		$title = sprintf( '<h2 class="site-title" itemprop="headline"><a href="%1$s" title="%2$s" rel="home">%3$s</a></h2>', home_url(), esc_attr( $title ), $title );		
	}
}

/* Get the avatar.  If it's not empty, wrap it with the appropriate HTML. */
if (get_option('IfAvatar')== 'yes') {
	if(get_option('IfGravatar')== 'yes') {
		$avatar = sprintf( '<div class="title-avatar" style=""><a href="%1$s" title="%2$s" target="_self" style="">' . get_avatar( get_option( 'admin_email') , 100 ) . '</a></div>', home_url(), esc_attr( $avatar ) );
	}
	else {
		$avatar = sprintf( '<div class="title-avatar" style=""><a href="%1$s" title="%2$s" target="_self" style=""><img alt="" src="' . get_option('Avatarurl') . '" srcset="' . get_option('Avatarurl') . ' 2x" class="avatar avatar-100 photo" height="100" width="100" itemprop="image"></a></div>', home_url(), esc_attr( $avatar ) );
	}
}
/* Display theavatar and apply filters for developers to overwrite. */
echo harmonica_apply_atomic( 'title_avatar', $avatar );

/* Display the site title and apply filters for developers to overwrite. */
echo harmonica_apply_atomic( 'site_title', $title );

/* Get the site description.  If it's not empty, wrap it with the appropriate HTML. */
if ( $desc = get_bloginfo( 'description' ) )
	$desc = sprintf( '<h3 class="site-description"><span>%1$s</span></h3>', $desc );

/* Display the site description and apply filters for developers to overwrite. */
echo harmonica_apply_atomic( 'site_description', $desc );

echo '</div>';
?>