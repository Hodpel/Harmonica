<div class="entry-meta">
	<i class="fa fa-calendar" aria-hidden="true"></i>
	<time <?php harmonica_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
	<?php echo '|' ?>
	<i class="fa fa-comment" aria-hidden="true"></i>
	<?php echo harmonica_comments_users($post->ID) . ' Comments | <i class="fa fa-eye" aria-hidden="true"></i> ' . getPostViews( get_the_ID() ) . ' Views | '?>
	<span <?php harmonica_attr( 'entry-author' ); ?>><?php echo __('Post by', 'harmonica');?> <?php the_author_posts_link(); ?></span>	
	<?php edit_post_link( __('Edit', 'harmonica'), ' | ' ); ?>
</div><!-- .entry-meta -->
