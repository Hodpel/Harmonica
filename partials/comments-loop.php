<?php if ( have_comments() ) : ?>
	<p class="comment-number"><?php comments_number( '', __( 'One Comment', 'harmonica' ), __( '% Comments', 'harmonica' ) ); ?></p>
	<ol class="comment-list">
		<?php wp_list_comments(
			array(
				'callback'     => 'harmonica_comments_callback',
				'end-callback' => 'harmonica_comments_end_callback',
				'reply_text'  => '<i class="fa fa-reply" aria-hidden="true"></i><span> reply</span>',
			)
		); ?>
	</ol><!-- .comment-list -->
	<?php the_comments_pagination( array(
			'prev_text' =>  '',
			'next_text' => '' ,
		)); ?>	
<?php endif; // have_comments() ?>
<?php get_template_part( 'partials/comments-loop-error' ); // Loads the comments-loop-error.php template. ?>