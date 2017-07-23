<?php

/* Register custom sections, settings, and controls. */
add_action( 'customize_register', 'harmonica_customize_comment_register' );


/**
 * Registers custom sections, settings, and controls for the $wp_customize instance.
 *
 * @since 0.3.2
 * @access private
 * @param object $wp_customize
 */
function harmonica_customize_comment_register( $wp_customize ) {

	/* Add the comment section. */
	$wp_customize->add_section(
		'comment_section',
		array(
			'title'      => esc_html__( 'Comments', 'harmonica' ),
			'priority'   => 121,
			'capability' => 'edit_theme_options'
		)
	);

	/* Add the 'custom_comment' setting. */
	$wp_customize->add_setting(
		"page_comment",
		array(
			'default'              => false,
			'type'                 => 'theme_mod',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_text_field',
			//'sanitize_js_callback' => 'harmonica_customize_sanitize',
			//'transport'            => 'postMessage',
		)
	);

	/* Add the checkbox control for the 'custom_comment' setting. */
	$wp_customize->add_control( 
		new harmonica_Customize_Control_Checkbox(
			$wp_customize,
			'page_comment',
			array(
				'label'    => esc_html__( 'Enable comments on pages ', 'harmonica' ),
				'section'  => 'comment_section',
				'settings' => 'page_comment',
				'extra'	=> esc_html__( 'This option will enable comments on pages. Comments can also be disabled per page basis when creating/editing pages.', 'harmonica' )
			)
		)
	);

}