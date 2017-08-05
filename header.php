<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> <?php harmonica_attr( 'body' ); ?>>
<?php do_action( 'harmonica_before' ); ?>
<div class="<?php echo harmonica_apply_atomic( 'site_container_class', 'site-container' );?>">
	<div class="site-inner">
		<?php 
			do_action( 'harmonica_before_header' );
			do_action( 'harmonica_header' );
			do_action( 'harmonica_after_header' ); 
			do_action( 'harmonica_before_main' ); ?>