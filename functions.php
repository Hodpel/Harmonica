<?php
/* Load harmonica theme framework. */
require ( trailingslashit( get_template_directory() ) . 'lib/framework.php' );
new harmonica();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function harmonica_theme_setup() {

	//remove_theme_mods();

	/* Load harmonica functions */
	require get_template_directory() . '/lib/functions/hooks.php';

	add_theme_support( 'title-tag' ); 
	
	/* Load scripts. */
	add_theme_support( 
		'harmonica-scripts', 
		array( 'comment-reply' ) 
	);
	
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'harmonica-theme-settings' );

	add_theme_support( 'harmonica-content-archives' );
		
	/* implement editor styling, so as to make the editor content match the resulting post output in the theme. */
	add_editor_style();

	/* Add default posts and comments RSS feed links to <head>.  */
	add_theme_support( 'automatic-feed-links' );

	/* Enable wraps */
	add_theme_support( 'harmonica-wraps' );

	/* Enable custom post */
	add_theme_support( 'harmonica-custom-post' );
	
	/* Enable custom css */
	add_theme_support( 'harmonica-custom-css' );
	
	/* Enable custom header */
	$header = array(
	'default-image'          => get_theme_file_uri('/images/header.png'),
	'random-default'         => false,
	'width'                  => '2000px',
	'height'                 => '500px',
	'flex-height'            => false,
	'flex-width'             => false,
	'default-text-color'     => '',
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
	add_theme_support( 'custom-header' , $header);
	
	/* Handle content width for embeds and images. */
	harmonica_set_content_width( 700 );

}

add_action( 'after_setup_theme', 'harmonica_theme_setup' );

/* Add the dark style css. */
//wp_enqueue_style( 'harmonica-colors-dark', get_theme_file_uri( '/lib/css/dark-style.css' ), array( 'harmonica-style' ), '1.0' );

//Add Font Awesome
wp_enqueue_style( 'harmonica-fontawesome', get_theme_file_uri( '/lib/css/font-awesome.css' ), array( 'harmonica-style' ), '1.0' );

/**
 * Add widgets.
 *
 * @since Harmonica 1.0
 */
 
// Add theme widgets
require_once (get_template_directory() . "/lib/widgets/recent-comments.php");
//Add waves
  function add_waves() {
        wp_register_style(
		'WavesCSS', 
		get_stylesheet_directory_uri() . '/lib/css/waves.min.css'
         );
          wp_register_script(
		'WavesJS',
		get_stylesheet_directory_uri() . '/lib/js/waves.min.js'
         );
        wp_enqueue_style('WavesCSS');
        wp_enqueue_script('WavesJS');
    }
add_action('wp_enqueue_scripts', 'add_waves');

// Delist the default WordPress widgets replaced by custom theme widgets
add_action('widgets_init', 'harmonica_unregister_default_widgets', 11);
 
function harmonica_unregister_default_widgets() {
	unregister_widget('WP_Widget_Recent_Comments');
}

/**
 * Get Page ID
 *
 * @since Harmonica 1.0
 */

function

get_page_id($page_name){

    global

$wpdb;

    $page_name

= $wpdb->get_var("SELECT
 ID FROM $wpdb->posts WHERE post_name = '".$page_name."'
 AND post_status = 'publish' AND post_type = 'page'");

    return

$page_name;

}

/**
 * Prism.js.
 *
 * @since Harmonica 1.0
 */

 function add_prism() {
        wp_register_style(
            'prismCSS', 
            get_stylesheet_directory_uri() . '/lib/css/prism.css' //自定义路径
         );
          wp_register_script(
            'prismJS',
            get_stylesheet_directory_uri() . '/lib/js/prism.js'   //自定义路径
         );
        wp_enqueue_style('prismCSS');
        wp_enqueue_script('prismJS');
    }
add_action('wp_enqueue_scripts', 'add_prism');

	//初始化时执行prism_quick_button函数   
add_action('init', 'prism_quick_button');   
function prism_quick_button() {   
    //判断用户是否有编辑文章和页面的权限   
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {   
        return;   
    }   
    //判断用户是否使用可视化编辑器   
    if ( get_user_option('rich_editing') == 'true' ) {   
  
        add_filter( 'mce_external_plugins', 'add_plugin' );   
        add_filter( 'mce_buttons', 'register_button' );   
    }   
}  

function register_button( $buttons ) {   
    array_push( $buttons, "|", "prism" ); //添加 一个按钮   
    //array_push( $buttons, "|", "buttom" ); //添加一个buttom按钮   
  
    return $buttons;   
}   
function add_plugin( $plugin_array ) {   
   $plugin_array['prism'] = get_stylesheet_directory_uri() . '/lib/js/prism_quick_button.js'; //myadvert按钮的js路径   
   //$plugin_array['buttom'] = get_bloginfo( 'template_url' ) . '/js/buttom.js'; //buttom按钮的js路径   
   return $plugin_array;   
}  

/**
 * Get Comment numbers.
 *
 * @since Harmonica 1.0
 */
 
function harmonica_comments_users($postid=0,$which=0) {
	$comments = get_comments('status=approve&type=comment&post_id='.$postid); //获取文章的所有评论
	if ($comments) {
		$i=0; $j=0; $commentusers=array();
		foreach ($comments as $comment) {
			++$i;
			if ($i==1) { $commentusers[] = $comment->comment_author_email; ++$j; }
			if ( !in_array($comment->comment_author_email, $commentusers) ) {
				$commentusers[] = $comment->comment_author_email;
				++$j;
			}
		}
		$output = array($j,$i);
		$which = ($which == 0) ? 0 : 1;
		return $output[$which]; //返回评论人数
	}
	return 0; //没有评论返回0
}

/**
 * Get view numbers.
 *
 * @since Harmonica 1.0
 */
 


/**
* getPostViews()函数
* 功能：获取阅读数量
* 在需要显示浏览次数的位置，调用此函数
* @Param object|int $postID   文章的id
* @Return string $count          文章阅读数量
*/
function getPostViews( $postID ) {
     $count_key = 'post_views_count';
     $count = get_post_meta( $postID, $count_key, true );
     if( $count=='' ) {
         delete_post_meta( $postID, $count_key );
         add_post_meta( $postID, $count_key, '0' );
         return "0";
     }
    return $count;
 }


/**
* setPostViews()函数  
* 功能：设置或更新阅读数量
* 在内容页(single.php，或page.php )调用此函数
* @Param object|int $postID   文章的id
* @Return string $count          文章阅读数量
*/
 function setPostViews( $postID ) {
     $count_key = 'post_views_count';
     $count = get_post_meta( $postID, $count_key, true );
     if( $count=='' ) {
         $count = 0;
         delete_post_meta( $postID, $count_key );
         add_post_meta( $postID, $count_key, '0' );
     } else {
         $count++;
         update_post_meta( $postID, $count_key, $count );
     }
 }
 
 /**
 * Add ajax comments
 *
 * @since Harmonica 1.0
 */
require get_template_directory() . '/lib/ajax-comment/main.php';

 /**
 * Add MCE buttoms
 *
 * @since Harmonica 1.0
 */
 
function add_mce_buttons_1($buttons) {
    $buttons = array('newdocument','undo','redo','|','bold','italic','underline','strikethrough','|','justifyleft','justifycenter','justifyright','justifyfull','|','styleselect','formatselect','fontselect','fontsizeselect','wp_more','wp_adv');
    return $buttons;
}
 
function add_mce_buttons_2($buttons) {
    $buttons = array('cut','copy','paste','pastetext','pasteword','|','search','replace','|','bullist','numlist','|','outdent','indent','blockquote','|','|','link','unlink','anchor','image','cleanup','code','|','forecolor','backcolor','hr','removeformat','|','sub','sup','|','spellchecker','charmap','fullscreen','wp_help');
    return $buttons;
}
 
add_filter("mce_buttons", "add_mce_buttons_1");
add_filter("mce_buttons_2", "add_mce_buttons_2");

 /**
 * Comment on face
 *
 * @since Harmonica 1.0
 */
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src ($img_src, $img, $siteurl){
    return get_bloginfo('template_directory').'/images/smilies/'.$img;
}
function disable_emojis_tinymce( $plugins ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
}
function smilies_reset() {
    global $wpsmiliestrans, $wp_smiliessearch, $wp_version;
    if ( !get_option( 'use_smilies' ) || $wp_version < 4.2)
        return;
    $wpsmiliestrans = array(
    ':mrgreen:' => 'icon_mrgreen.png',
    ':exclaim:' => 'icon_exclaim.png',
    ':neutral:' => 'icon_neutral.png',
    ':twisted:' => 'icon_twisted.png',
      ':arrow:' => 'icon_arrow.png',
        ':eek:' => 'icon_eek.png',
      ':smile:' => 'icon_smile.png',
   ':confused:' => 'icon_confused.png',
       ':cool:' => 'icon_cool.png',
       ':evil:' => 'icon_evil.png',
    ':biggrin:' => 'icon_biggrin.png',
       ':idea:' => 'icon_idea.png',
    ':redface:' => 'icon_redface.png',
       ':razz:' => 'icon_razz.png',
   ':rolleyes:' => 'icon_rolleyes.png',
       ':wink:' => 'icon_wink.png',
        ':cry:' => 'icon_cry.png',
  ':surprised:' => 'icon_surprised.png',
        ':lol:' => 'icon_lol.png',
        ':mad:' => 'icon_mad.png',
        ':sad:' => 'icon_sad.png',
    );
}
smilies_reset();

 /**
 * OwO
 *
 * @since Harmonica 1.0
 */
  function add_owo() {
        wp_register_style(
		'OwOCSS', 
		get_stylesheet_directory_uri() . '/lib/css/OwO.min.css'
         );
          wp_register_script(
		'OwOJS',
		get_stylesheet_directory_uri() . '/lib/js/OwO.js'
         );
        wp_enqueue_style('OwOCSS');
        wp_enqueue_script('OwOJS');
    }
add_action('wp_enqueue_scripts', 'add_owo');
