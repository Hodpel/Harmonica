<?php
if ( is_home() || is_archive() || is_search() ) {
?>	
	<div <?php harmonica_attr( 'entry-summary' ); ?>>
<?php 		
	if( get_theme_mod( 'post_thumbnail', 1 ) && has_post_thumbnail()) {

		if ( ! class_exists( 'Get_The_Image' ) ) {
			apply_filters ( 'harmonica_featured_image' , printf( '<div class="featured-image"><a href="%s" title="%s">%s</a></div>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_post_thumbnail(get_the_ID(), get_theme_mod( 'image_size' ), array('class' => get_theme_mod( 'image_size' )) ) ));
		} else {
			get_the_image( array( 'size' => get_theme_mod( 'image_size' ) ) );		
		}	
	}

	if ( 'excerpts' === get_theme_mod( 'post_excerpt', 'excerpts' ) ) {
		if ( get_theme_mod( 'excerpt_chars_limit', 0 ) ) {
			the_content_limit( (int) get_theme_mod( 'excerpt_chars_limit' ), get_theme_mod( 'more_text', '[Read more...]' ) );
		} else {
			the_excerpt();
		}
	}
	else {
		the_content( get_theme_mod( 'more_text' ) );
	}
?>	
	</div>
<?php 	
} else {
?>	
	<div <?php harmonica_attr( 'entry-content' ); ?>>
<?php 	
	the_content();
	wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'harmonica' ) . '</span>', 'after' => '</p>' ) );
?>	
<div class="aritcle-nav">
    <a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="post-like page-nav-button upvote <?php if(isset($_COOKIE['upvote'.$post->ID])) echo 'done';?>"><i class="fa fa-thumbs-o-up"></i>  赞  <span class="count">
        <?php if( get_post_meta($post->ID,'upvote',true) ){
            		echo get_post_meta($post->ID,'upvote',true);
                } else {
					echo '0';
				}?></span>
    </a>
    <a class="donate page-nav-button"><img class="donate-img" src="http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php the_permalink(); ?>" alt="<?php the_title(); ?>"/><i class="fa fa-money" aria-hidden="true"></i>  赏  </a>
	<a class="qrcode page-nav-button"><img class="qrcode-img" src="http://127.0.0.1/wp-content/uploads/QRcode-QQ.png" alt="QRcode-QQ" /><i class="fa fa-qrcode" aria-hidden="true"></i>  二维码  </a>
</div>
	</div>
<?php 	
}
?>