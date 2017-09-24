<?php
/*
 *Template Name: [迹]
 *author: Hodpel
 *url: http://www.hodpel.top/tracks
*/

get_header(); ?>
<main class="<?php echo harmonica_apply_atomic( 'main_class', 'content' );?>" <?php harmonica_attr( 'content' ); ?>>
<div class="track">
<ul class="track-list">
<?php
if (have_posts()):while (have_posts()):the_post(); ?>
<li>
	<?php echo( '<div class="track-avatar">' . get_avatar( get_option( 'admin_email') , 100 ) . '</div>'); ?>
<div class="track-main"><div class="track-content"><?php the_content(); ?></div><div class="track-meta"><span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo the_time() . ' <i class="fa fa-user" aria-hidden="true"></i> '; the_author(); ?></span></div></div><?php endwhile;endif; ?></li>
</ul>
</div>
</main><!-- .content -->
<?php get_footer(); ?>
