<?php
/*
Plugin Name: QPlayer
Plugin URI: https://github.com/Jrohy/QPlayer-WordPress-Plugin
Version: 1.3.4.2
Author: Jrohy
Author URI: https://32mb.space
Description:简洁美观非常Qの悬浮音乐播放器，支持网易云音乐解析
*/

/*
* Qplayer content
*/

add_action('wp_footer', 'footer');

function footer(){

	echo '
		<div id="QPlayer" style="z-index:2016">
		<div id="pContent">
			<div id="player">
				<span class="cover"></span>
				<div class="ctrl">
					<div class="musicTag marquee">
						<strong>Title</strong>
						 <span> - </span>
						<span class="artist">Artist</span>
					</div>
					<div class="progress">
						<div class="timer left">0:00</div>
						<div class="contr">
							<div class="fa rewind icon"></div>
							<div class="fa playback icon"></div>
							<div class="fa fastforward icon"></div>
						</div>
						<div class="right">
							<div class="fa liebiao icon list-off"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="ssBtn">
			        <div class="fa adf"></div>
		    </div>
		</div>
		<ol id="playlist"></ol>
		</div>
         ';
         
    if (get_option('qcss') != '') {
        echo '<style>'.get_option('qcss').'</style>' . "\n";
    }
    echo '
        <script>
          var autoplay = '.(get_option('autoPlay')?1:0).';
          var playlist = ['.get_option('musicList').'];
          var isRotate = '.(get_option('rotate')?1:0).';
        </script> ' . "\n";
    wp_enqueue_script( 'QplayerMarquee', get_stylesheet_directory_uri() . '/lib/js/jquery.marquee.min.js','jquery','1.0', true);
    wp_enqueue_script( 'QplayerJS', get_stylesheet_directory_uri() . '/lib/js/Qplayer.js','jquery','1.0', true);

    if (get_option('js') != '') {
        echo '<script>'.get_option('qjs').'</script>' . "\n";
    }
}

?>