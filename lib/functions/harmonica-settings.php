<?php
 // 设置选项页
function harmonica_menu()
{
// 在控制面板的侧边栏添加设置选项页链接
add_theme_page(__('Harmonica Settings'), __('Harmonica Settings'), 'edit_themes', basename(__FILE__) , 'harmonica_settings');
}
add_action('admin_menu','harmonica_menu');

function harmonica_update()
{
update_option('IfAuto', $_POST['IfAuto']);
update_option('IfDark', $_POST['IfDark']);
update_option('theme_color', $_POST['theme_color']);
update_option('IfPjax', $_POST['IfPjax']);
update_option('IfAvatar', $_POST['IfAvatar']);
update_option('IfGravatar', $_POST['IfGravatar']);
update_option('Avatarurl', $_POST['Avatarurl']);
update_option('donateqrcode', $_POST['donateqrcode']);
echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong>设置已保存。</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button></div>';
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
			<p><label><input type="text" name="theme_color" value="<?php echo get_option('theme_color'); ?>"></label></p>
			<p class="tip">默认为<span style="color: #8b84a3;">#8b84a3</span>.自定义主色调支持css的设置格式(#/rgb/rgba/hsl/hsla等),填写其他错误的格式可能不会生效.</p>
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
</script>
<?php
}
?>