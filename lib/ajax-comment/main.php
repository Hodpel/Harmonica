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
<li class="comment even thread-odd thread-alt depth-1" id="comment-276">
		<article class="comment-item" itemscope="itemscope" itemtype="http://schema.org/UserComments">
	<p class="comment-author" itemprop="creator" itemscope="itemscope" itemtype="http://schema.org/Person">
		<?php echo get_avatar( $comment, $size = '56')?>
		<cite class="fn"><?php echo get_comment_author_link();?></cite>
	</p>
	<p class="comment-meta"> 
		<time class="comment-published" datetime="<?php echo get_comment_time( 'Y-m-d\TH:i:sP' ); ?>" title="<?php echo get_comment_time( 'Y-m-d\TH:i:sP' ); ?>" itemprop="commentTime"><a href="comment-link"><?php echo get_comment_time( 'Y-m-d\TH:i:sP' ); ?></a></time>
	</p>
	<div class="comment-content">
		<p><?php comment_text(); ?></p>
	</div><!-- .comment-content -->
	<div class="reply">
		<i class="fa fa-reply" aria-hidden="true"></i><a itemprop="replyToUrl" rel="nofollow" class="comment-reply-link" href="reply" onclick="return addComment.moveForm( &quot;comment-232&quot;, &quot;232&quot;, &quot;respond&quot;, &quot;714&quot; )" aria-label="<?php  echo __('Reply')?>"><?php echo __('Reply')?></a>
	</div>
</article>
</li>
        <?php die();
    }

endif;

add_action( 'wp_enqueue_scripts', 'fa_ajax_comment_scripts' );
add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');