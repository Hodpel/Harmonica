<?php
if (is_home()) {
	echo '<div class="' . harmonica_apply_atomic( 'title_area_class', 'title-area') .'"></div>';
} else {
	echo '<div class="' . harmonica_apply_atomic( 'title_area_class', 'title-area') .'" style="display:block"></div>';
}
if (is_home() || !has_post_thumbnail()) {
	if (has_header_image()) {
		$headerimg = get_header_image();
	} else {
		$headerimg = get_theme_file_uri('/images/header.jpg');
	}
} else {
	$headerimg = wp_get_attachment_image_src(get_post_thumbnail_id($post ->ID), 'full')[0];
} 
echo '<div class="site-image"><img src="' . $headerimg . '" style="display:none" /></div>';
?>