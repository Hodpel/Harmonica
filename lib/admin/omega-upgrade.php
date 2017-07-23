<?php
/**
 * Sets $options['upgrade-1-0-2'] to true if user is updating
 */
function harmonica_upgrade_routine() {

	$options = get_option( 'harmonica_framework', false );
	
	// If version is set, upgrade routine has already run
	if ( $options['version'] == '1.0.2' ) {
		return;
	}
	
	// If $options exist, user is upgrading
	if ( empty( $options['upgrade-1-0-2']) && get_option( 'harmonica_theme_settings', false ) ) {
		$options['upgrade-1-0-2'] = true;
	}

	// New version number
	$options['version'] = '1.0.2';

	update_option( 'harmonica_framework', $options );
}

function harmonica_upgrade_routine_1_1_0() {

	$options = get_option( 'harmonica_framework', false );
	
	// If version is set, upgrade routine has already run
	if ( $options['version'] == '1.1.0' ) {
		return;
	}
	
	// If $options exist, user is upgrading
	if ( empty( $options['upgrade-1-1-0']) && get_option( 'harmonica_theme_settings', false ) ) {
		$options['upgrade-1-1-0'] = true;
	}

	// New version number
	$options['version'] = '1.1.0';

	update_option( 'harmonica_framework', $options );
}

add_action( 'admin_init', 'harmonica_upgrade_routine_1_1_0' );

/**
 * Displays notice if user has upgraded theme
 */
function harmonica_upgrade_notice() {

	if ( current_user_can( 'edit_theme_options' ) ) {
		$options = get_option( 'harmonica_framework', false );

		if ( !empty( $options['upgrade-1-0-2'] ) && $options['upgrade-1-0-2'] ) {
			echo '<div class="updated"><p>';
				printf( __(
					'Thanks for updating harmonica Theme.  Please <a href="%1$s" target="_blank">read about important changes</a> in this version and give your site a quick check. <a href="%2$s">Dismiss notice</a>', 'harmonica' ),
					'http://themehall.com/forums/topic/harmonica-1-0-0-updates',
					'?harmonica_upgrade_notice_ignore=1' );
			echo '</p></div>';
		}
	}

}

function harmonica_upgrade_notice_1_1_0() {

	if ( current_user_can( 'edit_theme_options' ) ) {
		$options = get_option( 'harmonica_framework', false );

		if ( !empty( $options['upgrade-1-1-0'] ) && $options['upgrade-1-1-0'] ) {
			echo '<div class="updated"><p>';
				printf( __(
					'Thanks for updating harmonica Theme.  Please <a href="%1$s" target="_blank">read about important changes</a> in this version and give your site a quick check. <a href="%2$s">Dismiss notice</a>', 'harmonica' ),
					'https://themehall.com/forums/topic/harmonica-1-1-0-updates',
					'?harmonica_upgrade_notice_ignore=1' );
			echo '</p></div>';
		}
	}

}

add_action( 'admin_notices', 'harmonica_upgrade_notice_1_1_0', 100 );

/**
 * Hides notices if user chooses to dismiss it
 */
function harmonica_notice_ignores() {

	$options = get_option( 'harmonica_framework' );

	if ( isset( $_GET['harmonica_upgrade_notice_ignore'] ) && '1' == $_GET['harmonica_upgrade_notice_ignore'] ) {
		$options['upgrade-1-1-0'] = false;
		update_option( 'harmonica_framework', $options );
	}

}
add_action( 'admin_init', 'harmonica_notice_ignores' );
?>