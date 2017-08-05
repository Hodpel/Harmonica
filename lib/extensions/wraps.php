<?php

function harmonica_wrap_open() {
  echo harmonica_apply_atomic( 'wrap_open', '<div class="wrap">');
}

function harmonica_wrap_close() {
  echo harmonica_apply_atomic( 'wrap_close', '</div>');
}

function harmonica_wrap_content_open() {
  echo harmonica_apply_atomic( 'wrap_content_open', '<div class="content-wrap"><div class="wrap">');
}

function harmonica_wrap_content_close() {
  echo harmonica_apply_atomic( 'wrap_content_close', '</div></div>');
}

add_action('harmonica_header', 'harmonica_wrap_open', 7 );
add_action('harmonica_header', 'harmonica_wrap_close' );

add_action('harmonica_before_main', 'harmonica_wrap_content_open', 7 );
add_action('harmonica_after_main', 'harmonica_wrap_content_close' );

add_action('harmonica_before_primary_menu', 'harmonica_wrap_open', 7 );
add_action('harmonica_after_primary_menu', 'harmonica_wrap_close' );

add_action('harmonica_footer', 'harmonica_wrap_open', 7 );
add_action('harmonica_footer', 'harmonica_wrap_close' );

?>