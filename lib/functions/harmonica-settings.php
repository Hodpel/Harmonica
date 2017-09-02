<?php
//添加拾色器
add_action( 'admin_enqueue_scripts', 'wptuts_add_color_picker' );
function wptuts_add_color_picker( $hook ) {
 
    if( is_admin() ) { 
 
        // 添加拾色器的CSS文件       
        wp_enqueue_style( 'wp-color-picker' ); 
 
        // 引用我们自定义的jQuery文件以及加入拾色器的支持
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}
 // 设置选项页
function harmonica_menu()
{
// 在控制面板的侧边栏添加设置选项页链接
add_theme_page(__('Harmonica Settings','harmonica'), __('Harmonica Settings','harmonica'), 'edit_themes', basename(__FILE__) , 'harmonica_settings');
}
add_action('admin_menu','harmonica_menu');

function harmonica_update() {
if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.','harmonica' ) );
    } 
    if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']=='POST'){
		update_option('IfAuto', $_POST['IfAuto']);
		update_option('IfDark', $_POST['IfDark']);
		update_option('theme_color', $_POST['theme_color']);
		update_option('IfQplayer', $_POST['IfQplayer']);
		update_option('IfPjax', $_POST['IfPjax']);
		update_option('IfAvatar', $_POST['IfAvatar']);
		update_option('IfGravatar', $_POST['IfGravatar']);
		update_option('Avatarurl', $_POST['Avatarurl']);
		update_option('donateqrcode', $_POST['donateqrcode']);
        update_option('autoPlay', $_POST['autoPlay']);
        update_option('rotate', $_POST['rotate']);
        update_option('qcss', stripcslashes(sanitize_text_field($_POST['qcss'])));
        update_option('qjs', stripcslashes(sanitize_text_field($_POST['qjs'])));
        update_option('musicType', sanitize_text_field($_POST['musicType']));
        update_option('neteaseID', sanitize_text_field($_POST['neteaseID']));
        update_option('musicList',stripcslashes(sanitize_text_field($_POST['musicList'])));
		echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
		<p><strong>设置已保存。</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button></div>';
    } 
    if (isset($_POST['addMusic']) && $_SERVER['REQUEST_METHOD']=='POST') {
    	update_option('musicType',sanitize_text_field($_POST['musicType']));
        update_option('neteaseID',sanitize_text_field($_POST['neteaseID']));
    	$musicResult = parse(get_option('neteaseID'), get_option('musicType'));
    	$deal = get_option('musicList');
    	if ($deal != '' && substr(trim($deal), -1) != ','){
    		$deal .= ',';
    	}
    	update_option('musicList', $deal.$musicResult);
    	echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
		<p><strong>音乐已添加到音乐列表。</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button></div>';
	}
}
/**
 * 从netease中获取歌曲信息
 * 
 * @link https://github.com/webjyh/WP-Player/blob/master/include/player.php
 * @param unknown $id 
 * @param unknown $type 获取的id的类型，song:歌曲,album:专辑,artist:艺人,collect:歌单
 */
function get_netease_music($id, $type = 'song'){
    $return = false;
    switch ( $type ) {
        case 'song': $url = "http://music.163.com/api/song/detail/?ids=[$id]"; $key = 'songs'; break;
        case 'album': $url = "http://music.163.com/api/album/$id?id=$id"; $key = 'album'; break;
        case 'artist': $url = "http://music.163.com/api/artist/$id?id=$id"; $key = 'artist'; break;
        case 'collect': $url = "http://music.163.com/api/playlist/detail?id=$id"; $key = 'result'; break;
        default: $url = "http://music.163.com/api/song/detail/?ids=[$id]"; $key = 'songs';
    }

    if (!function_exists('curl_init')) return false;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Cookie: appver=2.0.2' ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, 'http://music.163.com/;');
    $cexecute = curl_exec($ch);
    curl_close($ch);

    if ( $cexecute ) {
        $result = json_decode($cexecute, true);
        if ( $result['code'] == 200 && $result[$key] ){

            switch ( $key ){
                case 'songs' : $data = $result[$key]; break;
                case 'album' : $data = $result[$key]['songs']; break;
                case 'artist' : $data = $result['hotSongs']; break;
                case 'result' : $data = $result[$key]['tracks']; break;
                default : $data = $result[$key]; break;
            }

            //列表
            $list = array();
            foreach ( $data as $keys => $data ){

                $list[$data['id']] = array(
                        'title' => $data['name'],
                        'artist' => $data['artists'][0]['name'],
                        'location' => 'http://music.163.com/song/media/outer/url?id=' . $data['id'] . '.mp3',
                        'pic' => $data['album']['blurPicUrl'].'?param=106x106'
                );
            }
            //修复一次添加多个id的乱序问题
            if ($type = 'song' && strpos($id, ',')) {
                $ids = explode(',', $id);
                $r = array();
                foreach ($ids as $v) {
                    if (!empty($list[$v])) {
                        $r[] = $list[$v];
                    }
                }
                $list = $r;
            }
            //最终播放列表
            $return = $list;
        }
    } else {
        $return = array('status' =>  false, 'message' =>  '非法请求');
    }
    return $return;
}

function parse($id, $type) {
    $resultList = explode(",", $id);
    $result="\n";
    foreach ($resultList as $key => $value) {
        $musicList = get_netease_music($value,$type);
        foreach($musicList as $x=>$x_value) {
            $result .= "{";
            foreach ($x_value as $key => $value) {
                if ($key == 'location') {
                    $key = 'mp3';
                }
                if ($key == 'pic') {
                    $key = 'cover';
                }
                if (strpos($value, '"') !== false) {
                    $value = addcslashes($value, '"');
                }
                $result .= "$key:\"". $value."\",";
            }
            $result .= "},\n";
        }
    }
    return $result;
}

function harmonica_settings() {
	if ( $_POST['harmonica_settings'] == 'true' ) { harmonica_update(); }
?>
<div class="wrap">
<i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size:45px;float:left"></i>
<h1>主题设置</h1>
<form method="POST" action="">
<input type="hidden" name="harmonica_settings" value="true" />
<h3>主题配色方案</h3>
<table class="form-table">
<tr>
	<th scope="row">是否自动开启夜间模式</th>
	<td id="ifauto" >
		<fieldset>
			<p><label><input type="radio" name="IfAuto"  value="yes"  <?php if (get_option('IfAuto') == 'yes') echo "checked";?>>是</label></p>
			<p><label><input type="radio" name="IfAuto" value="no" <?php if (get_option('IfAuto') == 'no') echo "checked";?>>否</label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">默认主题基础色调</th>
	<td id="ifdark" >
		<fieldset>
			<p><label><input type="radio" name="IfDark" value="yes" <?php if (get_option('IfDark') == 'yes') echo "checked";?>>黑</label></p>
			<p><label><input type="radio" name="IfDark"  value="no"  <?php if (get_option('IfDark') == 'no') echo "checked";?>>白</label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">自定义主色调</th>
	<td>
		<fieldset>
			<p><label><input class="theme_color" type="text" name="theme_color" value="<?php echo get_option('theme_color'); ?>"></label></p>
			<p class="tip">默认为<span style="color: #8b84a3;">#8b84a3</span>.自定义主色调支持css的设置格式(#/rgb/rgba/hsl/hsla等),填写其他错误的格式可能不会生效.</p>
		</fieldset>
	</td>
</tr>
</table>
<h3>Qplayer设置</h3>
<table class="form-table">
<tr>
	<th scope="row">是否开启Qplayer</th>
	<td>
		<fieldset>
			<p><label><input type="radio" name="IfQplayer"  value="yes"  <?php if (get_option('IfQplayer') == 'yes') echo "checked";?>>是</label></p>
			<p><label><input type="radio" name="IfQplayer" value="no" <?php if (get_option('IfQplayer') == 'no') echo "checked";?>>否</label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">是否自动播放</th>
	<td>
		<fieldset>
			<p><label><input type="radio" name="autoPlay" value="yes" <?php if (get_option('autoPlay') == 'yes') echo "checked";?>>是</label></p>
			<p><label><input type="radio" name="autoPlay" value="no" <?php if (get_option('autoPlay') == 'no') echo "checked";?>>否</label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">是否封面旋转</th>
	<td>
		<fieldset>
			<p><label><input type="radio" name="rotate" value="yes" <?php if (get_option('rotate') == 'yes') echo "checked";?>>是</label></p>
			<p><label><input type="radio" name="rotate" value="no" <?php if (get_option('rotate') == 'no') echo "checked";?>>否</label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">自定义CSS</th>
	<td>
		<fieldset>
			<p><label><textarea rows="6" cols="100" name="qcss"><?php echo get_option('qcss') ?></textarea></label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">自定义JS</th>
	<td>
		<fieldset>
			<p><label><textarea rows="6" cols="100" name="qjs"><?php echo get_option('qjs') ?></textarea></label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">添加网易云音乐(需主机支持curl扩展)</th>
	<td>
		<fieldset>
			<p>id类型<label>
				<input type="radio" name="musicType"  value="collect"  <?php if (get_option('musicType') == 'collect') echo "checked";?>>歌单
                <input type="radio" name="musicType" value="album" <?php if (get_option('musicType') == 'album') echo "checked";?>>专辑
                <input type="radio" name="musicType" value="artist" <?php if (get_option('musicType') == 'artist') echo "checked";?>>艺人
                <input type="radio" name="musicType" value="song" <?php if (get_option('musicType') == 'song') echo "checked";?>>单曲</label></p>
			<p>id输入<label>
				<input type="text" id="inputID" onclick="clickAnimation()" placeholder="多个id用英文,分隔开" name="neteaseID" value="<?php echo get_option('neteaseID') ?>">
                <p class="tip" style="margin-bottom: 0;">请自行去网易云音乐网页版获取音乐id(具体在每个音乐项目的网址最后会有个id)。有版权的音乐无法解析!</p></label></p>
				<p class="submit"><input  type="submit" name="addMusic" id="addMusic" class="button button-primary" value="添加到歌曲列表"/></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">歌曲列表</th>
	<td>
		<fieldset>
			<p><label>
				<textarea rows="8" cols="100" name="musicList"><?php echo get_option('musicList') ?></textarea>
				<p class="tip">格式: {title:"xxx", artist:"xxx", cover:"http:xxxx", mp3:"http:xxxx"} ，每个歌曲之间用英文,隔开。请保证歌曲列表里至少有一首歌！</p>
			</label></p>
		</fieldset>
	</td>
</tr>
</table>
<h3>其他设置</h3>
<table class="form-table">
<tr>
	<th scope="row">是否使用Pjax加载</th>
	<td>
		<fieldset>
			<p><label><input type="radio" name="IfPjax"  value="yes"  <?php if (get_option('IfPjax') == 'yes') echo "checked";?>>是</label></p>
			<p><label><input type="radio" name="IfPjax" value="no" <?php if (get_option('IfPjax') == 'no') echo "checked";?>>否</label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">首页是否显示头像</th>
	<td>
		<fieldset>
			<p><label><input type="radio" name="IfAvatar"  value="yes"  <?php if (get_option('IfAvatar') == 'yes') echo "checked";?>>是</label></p>
			<p><label><input type="radio" name="IfAvatar" value="no" <?php if (get_option('IfAvatar') == 'no') echo "checked";?>>否</label></p>
		</fieldset>
	</td>
</tr>
<tr>
	<th scope="row">是否使用Gravatar头像</th>
	<td id="avatar" >
		<fieldset>
			<p><label><input type="radio" name="IfGravatar"  value="yes"  <?php if (get_option('IfGravatar') == 'yes') echo "checked";?>>是</label></p>
			<p><label><input type="radio" name="IfGravatar" value="no" <?php if (get_option('IfGravatar') == 'no') echo "checked";?>>否</label></p>
				<ul><li><label>头像地址: <input type="text" name="Avatarurl" value="<?php echo get_option('Avatarurl'); ?>"></label></li></ul>
		<fieldset>
	</td>
</tr>
<tr>
	<th scope="row">打赏二维码图片地址</th>
	<td>
		<fieldset>
			<p><label><input type="text" name="donateqrcode" value="<?php echo get_option('donateqrcode'); ?>"></label></p>
			<p class="tip">推荐大小:150*150px.</p>
		</fieldset>
	</td>
</tr>
</table>
<p class="submit"><input  type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"/></p>
</form>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var sectionavatar = $('#avatar'),
			staticPage = sectionavatar.find('input:radio[value="no"]'),
			selects = sectionavatar.find('input:text'),
			check_disabled = function(){
				selects.prop( 'disabled', ! staticPage.prop('checked') );
			};
		check_disabled();
 		sectionavatar.find('input:radio').change(check_disabled);
	});
	jQuery(document).ready(function($){
		var sectionifdark = $('#ifdark'),
			  sectionifauto = $('#ifauto'),
			staticPage = sectionifauto.find('input:radio[value="no"]'),
			selects = sectionifdark.find('input:radio'),
			check_disabled = function(){
				selects.prop( 'disabled', ! staticPage.prop('checked') );
			};
		check_disabled();
 		sectionifauto.find('input:radio').change(check_disabled);
	});
	(function( $ ) {
	
		// 添加颜色选择器到所有包含"color-field"类的 input 中
		$(function() {
			$('.theme_color').wpColorPicker();
		});
	
	})( jQuery );
</script>
<?php
}
?>