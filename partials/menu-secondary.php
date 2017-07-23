<nav class="nav-secondary" <?php harmonica_attr( 'menu' ); ?>>	
	<?php 
	do_action( 'harmonica_before_secondary_menu' ); 	
	wp_nav_menu( array(
		'theme_location' => 'secondary',
		'container'      => '',
		'menu_class'     => 'menu harmonica-nav-menu menu-secondary'
		)); 
	do_action( 'harmonica_after_secondary_menu' );
	?>
</nav><!-- .nav-secondary -->