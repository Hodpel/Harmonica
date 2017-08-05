<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to harmonica_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package harmonica
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

/* If a post password is required or no comments are given and comments/pings are closed, return. */
if ( post_password_required() || ( !have_comments() && !comments_open() && !pings_open() ) )
	return;

if ( is_singular( 'page' ) &&  !get_theme_mod( 'page_comment' ) )
	return;
?>
<?php $comments_args = array(
	
	'title_reply' =>
		_('Leave a Reply'),
		
	'title_reply_to' =>
		_('Leave a Reply to'),

	'comment_notes_before' => 
		'',
		
	'comment_notes_after' =>
		'<div class="comment-form-nav"><div class="OwO"></div><div class="comment-form-labels"></div></div>
		',

	'comment_field' => 
		'<p class="comment-form-comment"><textarea class="commenttextarea" placeholder="Type in your comments ..." id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
	
	'fields' => apply_filters( 'comment_form_default_fields', array(
	
		'author' =>
			'<div class="comment-form-info"><p class="comment-form-author">
				<input placeholder="Your Name" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" />
			</p>',
		
		'email' =>
			'<p class="comment-form-email">
				<input placeholder="Your Email Address" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" />
			</p>',
		
		'url' =>
			'<p class="comment-form-url">
				<input placeholder="Your Site" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
			</p></div>')
	),
);

if ( comments_open() ) { echo '<div class="comment-place" id="comments"></div><div class="respond-container">'; }
comment_form($comments_args);
if ( comments_open() ) { echo '</div> <!-- /respond-container -->'; }

?>
<div class="entry-comments">
	<?php get_template_part( 'partials/comments-loop' ); // Loads the comments-loop.php template. ?>
</div><!-- #comments -->

<?php if ( ! comments_open() && ! is_page() ) : ?>

	<p class="no-comments"><span class="fa fw fa-times"></span><?php _e( 'Comments are Closed', 'harmonica' ); ?></p>
	
<?php endif; ?>