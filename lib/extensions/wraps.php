<?php

function harmonica_wrap_open() {
  echo harmonica_apply_atomic( 'wrap_open', '<div class="wrap">');
}

function harmonica_wrap_close() {
  echo harmonica_apply_atomic( 'wrap_close', '</div>');
}

add_action('harmonica_header', 'harmonica_wrap_open', 7 );
add_action('harmonica_header', 'harmonica_wrap_close' );

add_action('harmonica_before_main', 'harmonica_wrap_open', 7 );
add_action('harmonica_after_main', 'harmonica_wrap_close' );

add_action('harmonica_before_primary_menu', 'harmonica_wrap_open', 7 );
add_action('harmonica_after_primary_menu', 'harmonica_wrap_close' );

add_action('harmonica_footer', 'harmonica_wrap_open', 7 );
add_action('harmonica_footer', 'harmonica_wrap_close' );

?>