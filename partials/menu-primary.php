<nav id="navigation" class="nav-primary" <?php harmonica_attr( 'menu' ); ?>>	
	<?php 
	//Site title
	//Add avatar
	if (get_option('IfAvatar')== 'yes') {
		if(get_option('IfGravatar')== 'yes') {
			$avatar = sprintf( '<div class="title-avatar" style=""><a href="%1$s" title="%2$s" target="_self" style="">' . get_avatar( get_option( 'admin_email') , 100 ) . '</a></div>', home_url(), esc_attr( $avatar ) );
		}
		else {
			$avatar = sprintf( '<div class="title-avatar" style=""><a href="%1$s" title="%2$s" target="_self" style=""><img alt="" src="' . get_option('Avatarurl') . '" srcset="' . get_option('Avatarurl') . ' 2x" class="avatar avatar-100 photo" height="100" width="100" itemprop="image"></a></div>', home_url(), esc_attr( $avatar ) );
		}
	}
	//Add blog name
	if ( $title = get_bloginfo( 'name' ) ) {		
		$title = sprintf( '<div class="site-title"><a href="%1$s" title="%2$s" rel="home">%3$s</a></div>', home_url(), esc_attr( $title ), $title );		
	}
	//Add blog description
	if ( $desc = get_bloginfo( 'description' ) )
		$desc = sprintf( '<div class="site-description"><span>%1$s</span></div>', $desc );
	//Set
	echo '<div class="site-info">' . harmonica_apply_atomic( 'title_avatar', $avatar ) . harmonica_apply_atomic( 'site_title', $title ) . harmonica_apply_atomic( 'site_description', $desc ) . '</div>';
	//nav
	do_action( 'harmonica_before_primary_menu' ); 
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => '',
		'menu_class'     => 'menu harmonica-nav-menu menu-primary',
		'fallback_cb'	 => 'harmonica_default_menu'
		)); 
	do_action( 'harmonica_after_primary_menu' );
	?>
	<div class="back-to-top waves-effect"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
</nav><!-- .nav-primary -->