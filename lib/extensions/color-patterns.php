<?php 
function hex2rgb( $colour ) {
    if ( $colour[0] == '#' ) { 
        $colour = substr( $colour, 1 ); 
    } 
    if ( strlen( $colour ) == 6 ) { 
        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] ); 
    } elseif ( strlen( $colour ) == 3 ) { 
        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] ); 
    } else { 
        return false; 
    } 
    $r = hexdec( $r ); 
    $g = hexdec( $g ); 
    $b = hexdec( $b ); 
    return array( 'red' => $r, 'green' => $g, 'blue' => $b ); 
}
function add_custom_color_css() {
$theme_color_hex = get_option( 'theme_color' );
$theme_color_rgb = hex2rgb(get_option( 'theme_color' ));
$css='
::selection,
button:not([class="search-submit"]):hover,
input:hover[type="button"],
input:hover[type="reset"],
input:hover[type="submit"],
.page-numbers.current,
.mejs-controls .mejs-time-rail .mejs-time-current,
.sending-comment,
#pContent .ssBtn {
	background-color: ' . $theme_color_hex . '!important;
}

a:hover,
.widget_calendar td#today,
.back-to-top:hover,
.index-button:hover:before,
.entry-comments .comment-number,
.comment-item .comment-meta a:hover,
.comment-reply-title,
.search-form .search-submit:hover,
.harmonica-widget-list .title:hover,
.harmonica-widget-list .excerpt:hover,
.OwO.OwO-open .OwO-logo,
.OwO:hover .OwO-logo {
	color: ' . $theme_color_hex . '!important;
}

select:hover,
input:focus,
textarea:focus,
.entry-comments .comment-number,
.comment-form .form-submit input[type="submit"]:hover,
.widget .tagcloud a:hover, .widget.widget_tag_cloud a:hover, .wp_widget_tag_cloud a:hover,
.widget .harmonica-links a:hover, .widget_harmonica_sidebar_links a:hover, .widget_harmonica_sidebar_links a:hover,
.more>a:hover,
.OwO:hover,
.page-nav-button:hover,
.post-like.done,
#playlist li:hover,
#playlist li.playing {
	border-color: ' . $theme_color_hex . '!important;
}
	
.object {
	border-left-color: ' . $theme_color_hex . '!important;
	border-right-color: ' . $theme_color_hex . '!important;
}

.index-button:hover,
.widget .tagcloud a:hover, .widget.widget_tag_cloud a:hover, .wp_widget_tag_cloud a:hover,
.widget .harmonica-links a:hover, .widget_harmonica_sidebar_links a:hover, .widget_harmonica_sidebar_links a:hover,
.page-nav-button:hover {
	box-shadow: 0 0 10px ' . $theme_color_hex . '!important;
	-webkit-box-shadow: 0 0 10px ' . $theme_color_hex . '!important;
}

.alignright:hover,
.alignleft:hover,
.widget_calendar td#today,
.harmonica-nav-menu .current-menu-item,
.harmonica-nav-menu li:hover,
.index-ul li a:hover,
.OwO:hover {
	background-color: rgba(' . $theme_color_rgb["red"] . ',' . $theme_color_rgb["green"] . ',' . $theme_color_rgb["blue"] . ',0.2)!important;
}

.comment-form .form-submit input[type="submit"]:hover,
.widget .tagcloud a:hover, .widget.widget_tag_cloud a:hover, .wp_widget_tag_cloud a:hover,
.widget .harmonica-links a:hover, .widget_harmonica_sidebar_links a:hover, .widget_harmonica_sidebar_links a:hover,
.more>a:hover,
.page-nav-button:hover,
.post-like.done {
	background-color: rgba(' . $theme_color_rgb["red"] . ',' . $theme_color_rgb["green"] . ',' . $theme_color_rgb["blue"] . ',0.5)!important;
}

.widget_pages li:hover,
.widget_recent_entries li:hover,
.widget_meta li:hover,
.widget_rss li:hover,
.widget_archive li:hover,
.widget_categories li:hover,
.harmonica-widget-list li:hover,
.track-list li:hover .track-main, .track-list li:hover .track-avatar {
	box-shadow: 0 12px 40px rgba(' . $theme_color_rgb["red"] . ',' . $theme_color_rgb["green"] . ',' . $theme_color_rgb["blue"] . ',0.3)!important;
}

';
echo '<style type="text/css" id="custom-theme-colors">';
echo $css;
echo'</style>';
}
add_action( 'wp_head', 'add_custom_color_css' );
?>