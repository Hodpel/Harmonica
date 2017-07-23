<?php if ( have_comments() ) : ?>
	<h3><?php comments_number( '', __( 'One Comment', 'harmonica' ), __( '% Comments', 'harmonica' ) ); ?></h3>
	<?php get_template_part( 'partials/comments-loop-nav' ); // Loads the comment-loop-nav.php template. ?>	
	<ol class="comment-list">
		<?php wp_list_comments(
			array(
				'callback'     => 'harmonica_comments_callback',
				'end-callback' => 'harmonica_comments_end_callback'
			)
		); ?>
	</ol><!-- .comment-list -->
<?php endif; // have_comments() ?>
<?php get_template_part( 'partials/comments-loop-error' ); // Loads the comments-loop-error.php template. ?>