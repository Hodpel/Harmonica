<nav id="navigation" class="nav-primary" <?php harmonica_attr( 'menu' ); ?>>	
	<?php 
	do_action( 'harmonica_before_primary_menu' ); 
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => '',
		'menu_class'     => 'menu harmonica-nav-menu menu-primary',
		'fallback_cb'	 => 'harmonica_default_menu'
		)); 
	do_action( 'harmonica_after_primary_menu' );
	?>
</nav><!-- .nav-primary -->