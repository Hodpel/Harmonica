<?php
define('AC_VERSION','1.0.0');

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	wp_die(_('Please upgrade into wordpress 4.4'));
}

if(!function_exists('fa_ajax_comment_scripts')) :

    function fa_ajax_comment_scripts(){
        wp_enqueue_style( 'ajax-comment', get_template_directory_uri() . '/lib/ajax-comment/app.css', array(), AC_VERSION );
        wp_enqueue_script( 'ajax-comment', get_template_directory_uri() . '/lib/ajax-comment/app.js', array( 'jquery' ), AC_VERSION , true );
        wp_localize_script( 'ajax-comment', 'ajaxcomment', array(
            'ajax_url'   => admin_url('admin-ajax.php'),
            'order' => get_option('comment_order'),
            'formpostion' => 'top', //Default: bottom , if your form is on the top, use top.
        ) );
    }

endif;

if(!function_exists('fa_ajax_comment_err')) :

    function fa_ajax_comment_err($a) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $a;
        exit;
    }

endif;

if(!function_exists('fa_ajax_comment_callback')) :

    function fa_ajax_comment_callback(){
        $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
        if ( is_wp_error( $comment ) ) {
            $data = $comment->get_error_data();
            if ( ! empty( $data ) ) {
            	fa_ajax_comment_err($comment->get_error_message());
            } else {
                exit;
            }
        }
        $user = wp_get_current_user();
        do_action('set_comment_cookies', $comment, $user);
        $GLOBALS['comment'] = $comment;
        ?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<article <?php harmonica_attr( 'comment' ); ?>>
		<p <?php harmonica_attr( 'comment-author' ); ?>>
			<?php echo get_avatar( $comment, 48 ); ?>
			<?php printf( __( '<cite class="fn">%s</cite>', 'harmonica' ), get_comment_author_link() ); ?>
		</p>
		<p class="comment-meta"> 
			<time <?php harmonica_attr( 'comment-published' ); ?>><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s', 'harmonica' ), the_time() ); ?></a></time>
			<?php edit_comment_link( __( '(Edit)', 'harmonica' ), '' ); ?>
		</p>
		<div class="comment-content">
			<?php comment_text(); ?>
		</div><!-- .comment-content -->
		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		<a itemprop="replyToUrl" rel="nofollow" class="comment-reply-link" href="http://127.0.0.1/2017/09/03/hello-world/?replytocom=<?php echo get_comment_ID(); ?>#respond" onclick="return addComment.moveForm( &quot;comment-<?php echo get_comment_ID(); ?>&quot;, &quot;<?php echo get_comment_ID(); ?>&quot;, &quot;respond&quot;, &quot;1&quot; )"><i class="fa fa-reply" aria-hidden="true"></i><span> reply</span></a>
		</div>
		</article>	
        <?php die();
    }

endif;

add_action( 'wp_enqueue_scripts', 'fa_ajax_comment_scripts' );
add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');