<?php
/*Timezone set*/
date_default_timezone_set(PRC);
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
	'default-image'		  => get_theme_file_uri('/images/header.jpg'),
	'random-default'		 => false,
	'width'				  => '1920px',
	'height'				 => '650px',
	'flex-height'			=> false,
	'flex-width'			 => false,
	'default-text-color'	 => '',
	'header-text'			=> true,
	'uploads'				=> true,
	'wp-head-callback'	   => '',
	'admin-head-callback'	=> '',
	'admin-preview-callback' => '',
);
	add_theme_support( 'custom-header' , $header);
	
	/* Handle content width for embeds and images. */
	harmonica_set_content_width( 700 );

require (get_template_directory() . "/lib/functions/harmonica-settings.php");
}

add_action( 'after_setup_theme', 'harmonica_theme_setup' );

//Add Font Awesome
wp_enqueue_style( 'harmonica-fontawesome', get_theme_file_uri( '/lib/css/font-awesome.css' ), array( 'harmonica-style' ), '1.0' );
function fontawesome_admin() {
wp_enqueue_style( 'harmonica-fontawesome-admin', get_theme_file_uri( '/lib/css/font-awesome.css' ) );
}
add_action( 'admin_enqueue_scripts', 'fontawesome_admin' );

/**
 * Add widgets.
 *
 * @since Harmonica 1.0
 */
 
// Add theme widgets
require_once (get_template_directory() . "/lib/extensions/color-patterns.php");
require_once (get_template_directory() . "/lib/widgets/recent-comments.php");
require_once (get_template_directory() . "/lib/widgets/sidebar-links.php");
if (get_option('IfQplayer')=='yes') {
require_once (get_template_directory() . "/lib/widgets/Qplayer.php");
}
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
//	array_push( $buttons, "emoji" ); //添加一个buttom按钮   
  
	return $buttons;   
}   
function add_plugin( $plugin_array ) {   
   $plugin_array['prism'] = get_stylesheet_directory_uri() . '/lib/js/prism_quick_button.js'; 
//   $plugin_array['emoji'] = get_stylesheet_directory_uri() . '/lib/js/smilies.js';
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
* @Return string $count		  文章阅读数量
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
* @Return string $count		  文章阅读数量
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
 * Smilies
 *
 * @since Harmonica 1.0
 */
require_once (get_template_directory() . "/lib/widgets/smilies.php");

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
		wp_enqueue_style('OwOCSS');
		wp_register_script(
		'OwOJS',
		get_stylesheet_directory_uri() . '/lib/js/OwO.js'
		 );
		wp_enqueue_script('OwOJS');
	}
add_action('wp_enqueue_scripts', 'add_owo');

 /**
 * Nicescroll
 *
 * @since Harmonica 1.0
 */
  function add_nicescroll() {
		wp_register_script(
		'NICESCROLLL',
		get_stylesheet_directory_uri() . '/lib/js/jquery.pjax.js'
		 );
		wp_enqueue_script('NICESCROLLL');
	}
add_action('wp_footer', 'add_nicescroll');
 /**
 * Email
 *
 * @since Harmonica 1.0
 */
require_once (get_template_directory() . "/lib/widgets/emails.php");

 /**
 * Upvote
 *
 * @since Harmonica 1.0
 */

add_action('wp_ajax_nopriv_upvote', 'upvote');
add_action('wp_ajax_upvote', 'upvote');
function upvote(){
	global $wpdb,$post;
	$id = $_POST["um_id"];
	$action = $_POST["um_action"];
	if ( $action == 'ding'){
		$specs_raters = get_post_meta($id,'upvote',true);
		$expire = time() + 99999999;
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
		setcookie('upvote_'.$id,$id,$expire,'/',$domain,false);
		if (!$specs_raters || !is_numeric($specs_raters)) {
			update_post_meta($id, 'upvote', 1);
		} 
		else {
			update_post_meta($id, 'upvote', ($specs_raters + 1));
		}
		echo get_post_meta($id,'upvote',true);
	} 
	die;
}

	/*Add Jquery*/
  function add_jquery() {
		  wp_register_script(
		'Jquery',
		get_stylesheet_directory_uri() . '/lib/js/jquery-1.11.3.min.js'
		 );
		wp_enqueue_script('Jquery');
	}
add_action('wp_enqueue_scripts', 'add_jquery');

  function add_global() {
		wp_register_script(
		'GlobalJS',
		get_stylesheet_directory_uri() . '/lib/js/global.js'
		 );
		wp_enqueue_script('GlobalJS');
	}
add_action('wp_enqueue_scripts', 'add_global');

if (get_option('IfPjax')=='yes') {
  function add_pjax() {
		wp_register_script(
		'PJAXJS',
		get_stylesheet_directory_uri() . '/lib/js/pjax.js'
		 );
		wp_enqueue_script('PJAXJS');
	}
add_action('wp_enqueue_scripts', 'add_pjax');
}

 /**
 * At people
 *
 * @since Harmonica 1.0
 */
 
function harmonica_comment_add_at( $comment_text, $comment = '') { 
  if( $comment->comment_parent > 0) { 
	$comment_text = '<a href="#comment-' . $comment->comment_parent . '">@'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text; 
  } 
  return $comment_text; 
} 
add_filter( 'comment_text' , 'harmonica_comment_add_at', 20, 2);

 /**
 * Comment time set
 *
 * @since Harmonica 1.0
 */
function Harmonica_comment_time(){
	global $post ;
	$to = time();
	$from = get_comment_time('U') ;
	$diff = (int) abs($to - $from);
	if ($diff <= 3600) {
		$mins = round($diff / 60);
		if ($mins <= 1) {
			$mins = 1;
		}
		$time = sprintf(_n('%s minute', '%s minutes', $mins ), $mins) . __( ' ago' , 'harmonica' );
	}
	else if (($diff <= 86400) && ($diff > 3600)) {
		$hours = round($diff / 3600);
		if ($hours <= 1) {
			$hours = 1;
		}
		$time = sprintf(_n('%s hour', '%s hours', $hours ), $hours) . __( ' ago' , 'harmonica' );
	}
	elseif ($diff >= 86400) {
		$days = round($diff / 86400);
		if ($days <= 1) {
			$days = 1;
			$time = sprintf(_n('%s day', '%s days', $days ), $days) . __( ' ago' , 'harmonica' );
		}
		elseif( $days > 29){
			$time = get_the_time(get_option('date_format'));
		}
		else{
			$time = sprintf(_n('%s day', '%s days', $days ), $days) . __( 'ago' , 'harmonica' );
		}
	}
	return $time;
}
add_filter('the_time','Harmonica_comment_time');

 /**
 * Add article index
 *
 * @since Harmonica 1.0
 */

function article_index($content) {
$matches = array();
$ul_li = '';
$ul = '';

$r = '/<h([1-6]).*?\>(.*?)<\/h[1-6]>/is';

if(is_single() && preg_match_all($r, $content, $matches)) {
$count = count($matches[0]);
foreach($matches[1] as $key => $value) {
	if ($key <= 0) {
		$ul_li = '<ul class="index-ul">'; 
	}
	else {
		if ($value > $matches[1][$key - 1]) {
			if ($value - $matches[1][$key - 1] == 1) {
				$ul_li .= '<ul>'; 
			}
			elseif ($value == $matches[1][$key - 1]) {
			}
			else {
				$ul_li .= '文章目录层级不合法';
				return false;
			}
		}
	}
	$title = trim(strip_tags($matches[2][$key]));
	$content = str_replace($matches[0][$key], '<h' . $value . ' id="title-' . $key . '">'.$title.'</h' . $value . '>', $content);
	$ul_li .= '<li><a href="#title-'.$key.'" title="'.$title.'">'.$title."</a></li>\n";
	if ($key < $count - 1) {
		if ($value > $matches[1][$key + 1]) { 
			$c = $value - $matches[1][$key + 1];
			for ($i = 0; $i < $c; $i++) {
				$ul .= '</ul>';
				$ul_li .= $ul;
				$ul = '';
			}
		}
	} else {
		$ul_li .= '</ul>';
	}
}

$content = '<div class="article-index"><div class="index-button"></div><p class="title">文章目录</p>' . $ul_li . '</div>' . $content;
}

return $content;
}

add_filter( 'the_content', 'article_index' );

 /**
 * Add tracks
 *
 * @since Harmonica 1.0
 */
  add_action('init', 'tracks');   
function tracks()	
{
  $labels = array(   
	'name' => '[迹]',   
	'singular_name' => '一篇[迹]',   
	'add_new' => '留下[迹]',   
	'add_new_item' => '留下[迹]',   
	'edit_item' => '重述',   
	'new_item' => '崭新的[迹]',   
	'view_item' => '回首[迹]',   
	'search_items' => '搜寻[迹]',   
	'not_found' =>  '找不到[迹]',   
	'not_found_in_trash' => '找不到被遗弃的[迹]',	
	'parent_item_colon' => '',   
	'menu_name' => '[迹]'   
  
  );   
  $args = array(   
	'labels' => $labels,   
	'public' => true,   
	'publicly_queryable' => true,   
	'show_ui' => true,	
	'show_in_menu' => true,	
	'query_var' => true,   
	'rewrite' => true,   
	'capability_type' => 'post',   
	'has_archive' => true,	
	'hierarchical' => false,   
	'menu_position' => null,   
	'supports' => array('title','editor','author')   
  );	
  register_post_type('tracks',$args);   
};

// This will occur when the comment is posted
function plc_comment_post( $incoming_comment ) {
// convert everything in a comment to display literally
$incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);
// the one exception is single quotes, which cannot be #039; because WordPress marks it as spam
$incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );
return( $incoming_comment );
}
// This will occur before a comment is displayed
function plc_comment_display( $comment_to_display ) {
// Put the single quotes back in
$comment_to_display = str_replace( '&apos;', "'", $comment_to_display );
return $comment_to_display;
}

// 替换Gravatar为v2ex头像源
function mytheme_get_avatar( $avatar ) {
	$avatar = preg_replace("/http:\/\/(www|\d).gravatar.com\/avatar\//","http://cdn.v2ex.com/gravatar/",$avatar);
	return $avatar;
}
add_filter('get_avatar', 'mytheme_get_avatar');

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
   // admin.php?page=theme-settings-slug 改成你的主题设置页面网址
	wp_redirect( admin_url( 'themes.php?page=harmonica-settings.php' ) );
	update_option('IfAuto', 'yes');
	update_option('IfDark', 'no');
	update_option('theme_color', '#8b84a3');
	update_option('IfQplayer', 'yes');
	update_option('IfPjax', 'yes');
	update_option('IfAvatar', 'yes');
	update_option('IfGravatar', 'yes');
	update_option('Avatarurl', '');
	update_option('donateqrcode', '');
	update_option('autoPlay', 'yes');
	update_option('rotate', 'yes');
	update_option('qcss', '');
	update_option('qjs', '');
	update_option('musicType', '');
	update_option('neteaseID', '');
	update_option('musicList','{ title: "Luv Letter", artist: "DJ Okawari", mp3: "http://link.hhtjim.com/163/406232.mp3", cover: "http://p1.music.126.net/YXY1vPG5rtdV7w_cWDnNWw==/884007348732141.jpg?param=106x106", },{ title: "Demons", artist: "Imagine Dragons", mp3: "http://link.hhtjim.com/163/19945727.mp3", cover: "http://p1.music.126.net/FtqiYsgqfgU0AwYcdc2cBQ==/19089720881705423.jpg?param=106x106", }');
   exit;
}