<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package harmonica
 */

if ( is_active_sidebar( 'primary' ) ) : ?>	
	<div  class="<?php echo harmonica_apply_atomic( 'sidebar_class', 'sidebar sidebar-primary widget-area' );?>">	
		<?php do_action( 'before_primary' ); ?>
		<?php dynamic_sidebar( 'primary' ); ?>
		<?php do_action( 'after_primary' ); ?>
  	</div><!-- .sidebar -->
<?php endif;  ?>