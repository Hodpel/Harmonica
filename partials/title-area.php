<?php
if (is_home()) {
	echo '<div class="' . harmonica_apply_atomic( 'title_area_class', 'title-area') .'"></div>';
} else {
	echo '<div class="' . harmonica_apply_atomic( 'title_area_class', 'title-area') .'" style="display:block"></div>';
}
echo '<div class="site-image"></div>';
?>