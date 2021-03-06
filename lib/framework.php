<?php
/**
 * harmonica Framework - A WordPress theme development framework.
 *
 * harmonica Framework is a framework for developing WordPress themes.  The framework allows theme developers / designers
 * to quickly build child themes without having to handle all of the "logic" behind the theme or having to code 
 * complex functionality for features that are often needed in themes.  The framework does these things 
 * for developers to allow them to get back to what matters the most:  developing and designing themes.  
 * The framework was built to make it easy for developers to include (or not include) specific, pre-coded 
 * features.  Themes handle all the markup, style, and scripts while the framework handles the logic.
 *
 * harmonica Framework is a modular system, which means that developers can pick and choose the features they 
 * want to include within their themes.  Many files are only loaded if the theme registers support for the 
 * feature using the add_theme_support( $feature ) function within their theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   harmonica
 * @author 	  Hence Wijaya <hence.wijaya@gmail.com>
 * @copyright Copyright (c) 2013, themehall.com
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2013, Justin Tadlock
 * @link 	  http://themehall.com/harmonica
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * The harmonica class launches the framework.  It's the organizational structure behind the entire framework. 
 * This class should be loaded and initialized before anything else within the theme is called to properly use 
 * the framework.  
 *
 * After parent themes call the harmonica class, they should perform a theme setup function on the 
 * 'after_setup_theme' hook with a priority of 10.  Child themes should add their theme setup function on
 * the 'after_setup_theme' hook with a priority of 11.  This allows the class to load theme-supported features
 * at the appropriate time, which is on the 'after_setup_theme' hook with a priority of 12.
 *
 * Note that while it is possible to extend this class, it's not usually recommended unless you absolutely 
 * know what you're doing and expect your sub-class to break on updates.  This class often gets modifications 
 * between versions.
 *
 * @since  0.7.0
 * @access public
 */
class harmonica {

	/**
	 * Constructor method for the harmonica class.  This method adds other methods of the class to 
	 * specific hooks within WordPress.  It controls the load order of the required files for running 
	 * the framework.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	function __construct() {
		global $harmonica;

		/* Set up an empty class for the global $harmonica object. */
		$harmonica = new stdClass;

		/* Define framework, parent theme, and child theme constants. */
		add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );

		/* Load the core functions/classes required by the rest of the framework. */
		add_action( 'after_setup_theme', array( $this, 'core' ), 2 );

		/* Initialize the framework's default actions and filters. */
		add_action( 'after_setup_theme', array( $this, 'default_filters' ), 3 );

		/* Language functions and translations setup. */
		add_action( 'after_setup_theme', array( $this, 'i18n' ), 4 );

		/* Handle theme supported features. */
		add_action( 'after_setup_theme', array( $this, 'theme_support' ), 12 );

		/* Load framework includes. */
		add_action( 'after_setup_theme', array( $this, 'includes' ), 13 );

		/* Load the framework extensions. */
		add_action( 'after_setup_theme', array( $this, 'extensions' ), 14 );

		/* Load admin files. */
		add_action( 'wp_loaded', array( $this, 'admin' ) );
	}

	/**
	 * Defines the constant paths for use within the core framework, parent theme, and child theme.  
	 * Constants prefixed with 'harmonica_' are for use only within the core framework and don't 
	 * reference other areas of the parent or child theme.
	 *
	 * @since  0.7.0
	 * @access public
	 * @return void
	 */
	function constants() {

		/* Sets the path to the parent theme directory. */
		define( 'THEME_DIR', get_template_directory() );

		/* Sets the path to the parent theme directory URI. */
		define( 'THEME_URI', get_template_directory_uri() );

		/* Sets the path to the child theme directory. */
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

		/* Sets the path to the child theme directory URI. */
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

		/* Sets the path to the core framework directory. */
		if ( !defined( 'harmonica_DIR' ) )
			define( 'harmonica_DIR', trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework directory URI. */
		if ( !defined( 'harmonica_URI' ) )
			define( 'harmonica_URI', trailingslashit( THEME_URI ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework admin directory. */
		define( 'harmonica_ADMIN', trailingslashit( harmonica_DIR ) . 'admin' );

		/* Sets the path to the core framework classes directory. */
		define( 'harmonica_CLASSES', trailingslashit( harmonica_DIR ) . 'classes' );

		/* Sets the path to the core framework extensions directory. */
		define( 'harmonica_EXTENSIONS', trailingslashit( harmonica_DIR ) . 'extensions' );

		/* Sets the path to the core framework functions directory. */
		define( 'harmonica_FUNCTIONS', trailingslashit( harmonica_DIR ) . 'functions' );

		/* Sets the path to the core framework languages directory. */
		define( 'harmonica_LANGUAGES', trailingslashit( harmonica_DIR ) . 'languages' );

		/* Sets the path to the core framework images directory URI. */
		define( 'harmonica_IMAGES', trailingslashit( harmonica_URI ) . 'images' );

		/* Sets the path to the core framework CSS directory URI. */
		define( 'harmonica_CSS', trailingslashit( harmonica_URI ) . 'css' );

		/* Sets the path to the core framework JavaScript directory URI. */
		define( 'harmonica_JS', trailingslashit( harmonica_URI ) . 'js' );
	}

	/**
	 * Loads the core framework files.  These files are needed before loading anything else in the 
	 * framework because they have required functions for use.  Many of the files run filters that 
	 * theme authors may wish to remove in their theme setup functions.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	function core() {

		/* Load the core framework functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'core.php' );

		/* Load the context-based functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'context.php' );

		/* Load the framework customize functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'customize.php' );

		/* Load the framework filters. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'filters.php' );

		/* Load the <head> functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'head.php' );

		/* Load media-related functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'media.php' );

		/* Load the sidebar functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'sidebars.php' );

		/* Load the scripts functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'scripts.php' );

		/* Load the utility functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'utility.php' );

		/* Load the image functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'image.php' );
	}

	/**
	 * Loads theme translation files. All translation and locale functions files are expected to be within the theme's '/languages' folder, but the 
	 * framework will fall back on the theme root folder if necessary.  Translation files are expected 
	 * to be prefixed with the template or stylesheet path (example: 'en_US.mo').
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	function i18n() {

		//load_theme_textdomain( 'harmonica', FALSE, harmonica_LANGUAGES );

		load_theme_textdomain( 'harmonica', get_template_directory() . '/languages' );
		
	}

	/**
	 * Removes theme supported features from themes in the case that a user has a plugin installed
	 * that handles the functionality.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	function theme_support() {

		/* Adds core WordPress HTML5 support. */
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	}

	/**
	 * Loads the framework files supported by themes and template-related functions/classes.  Functionality 
	 * in these files should not be expected within the theme setup function.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	function includes() {

		/* Load the HTML attributes functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'attr.php' );

		/* Load the template functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'template.php' );

		/* Load the comments functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'template-comments.php' );

		/* Load the general template functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'template-general.php' );

		/* Load the media template functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'template-media.php' );

		/* Load the post template functions. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'template-post.php' );

		/* Load the theme settings functions */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'settings.php' );

		/* Load the template hierarchy if supported. */
		require_if_theme_supports( 'harmonica-template-hierarchy', trailingslashit( harmonica_FUNCTIONS ) . 'template-hierarchy.php' );

		/* Custom template tags for harmonica theme. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'template-tags.php' );

		/* Custom functions that act independently of the theme templates. */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'extras.php' );

		/* Load the deprecated functions */
		require_once( trailingslashit( harmonica_FUNCTIONS ) . 'deprecated.php' );
	}

	/**
	 * Load extensions (external projects).  Extensions are projects that are included within the 
	 * framework but are not a part of it.  They are external projects developed outside of the 
	 * framework.  Themes must use add_theme_support( $extension ) to use a specific extension 
	 * within the theme.  This should be declared on 'after_setup_theme' no later than a priority of 11.
	 *
	 * @since  0.7.0
	 * @access public
	 * @return void
	 */
	function extensions() {

		/* Load the Get the Image extension if supported. */
		require_if_theme_supports( 'get-the-image', trailingslashit( harmonica_EXTENSIONS ) . 'get-the-image.php' );

		/* Load the Loop Pagination extension if supported. */
		require_if_theme_supports( 'loop-pagination', trailingslashit( harmonica_EXTENSIONS ) . 'loop-pagination.php' );

		/* Load the Color Palette extension if supported. */
		require_if_theme_supports( 'color-palette', trailingslashit( harmonica_EXTENSIONS ) . 'color-palette.php' );

		/* Load  child themes page if supported. */
		require_if_theme_supports( 'harmonica-child-page', trailingslashit( harmonica_EXTENSIONS ) . '/harmonica-child-page.php' );

		/* Load wraps extension if supported. */
		require_if_theme_supports( 'harmonica-wraps', trailingslashit( harmonica_EXTENSIONS ) . '/wraps.php' );

		/* Load custom css extension if supported. */
		require_if_theme_supports( 'harmonica-custom-css', trailingslashit( harmonica_EXTENSIONS ) . '/custom-css.php' );

		/* Load custom logo extension if supported. */
		require_if_theme_supports( 'harmonica-custom-logo', trailingslashit( harmonica_EXTENSIONS ) . '/custom-logo.php' );

		/* Load custom comment extension. */
		require_once( trailingslashit( harmonica_EXTENSIONS ) . '/custom-comment.php' );

		/* Load custom post extension if supported. */
		require_if_theme_supports( 'harmonica-custom-post', trailingslashit( harmonica_EXTENSIONS ) . '/custom-post.php' );

		/* Load footer widgets extension if supported. */
		require_if_theme_supports( 'harmonica-footer-widgets', trailingslashit( harmonica_EXTENSIONS ) . '/footer-widgets.php' );

		/* Load custom footer extension if supported. */
		require_if_theme_supports( 'custom-footer', trailingslashit( harmonica_EXTENSIONS ) . '/custom-footer.php' );


		/* Load the plugin Activation extension if supported. */
		require_if_theme_supports( 'plugin-activation', trailingslashit( harmonica_EXTENSIONS ) . 'class-tgm-plugin-activation.php' );
      
	}
	
	/**
	 * Load admin files for the framework.
	 *
	 * @since  0.7.0
	 * @access public
	 * @return void
	 */
	function admin() {

		/* Check if in the WordPress admin. */
		if ( is_admin() ) {

			/* Load the main admin file. */
			require_once( trailingslashit( harmonica_ADMIN ) . 'admin.php' );
			//require_once( trailingslashit( harmonica_ADMIN ) . 'harmonica-upgrade.php' );
		}
	}

	/**
	 * Adds the default framework actions and filters.
	 *
	 * @since  0.9.0
	 * @access public
	 * @return void
	 */
	function default_filters() {
		global $wp_embed;

		/* Remove bbPress theme compatibility if current theme supports bbPress. */
		if ( current_theme_supports( 'bbpress' ) )
			remove_action( 'bbp_init', 'bbp_setup_theme_compat', 8 );

		/* Move the WordPress generator to a better priority. */
		remove_action( 'wp_head', 'wp_generator' );
		add_action( 'wp_head', 'wp_generator', 1 );

		/* Make text widgets and term descriptions shortcode aware. */
		add_filter( 'widget_text', 'do_shortcode' );

		/* Filters for the audio transcript. */
		add_filter( 'harmonica_audio_transcript', 'wptexturize',   10 );
		add_filter( 'harmonica_audio_transcript', 'convert_chars', 20 );
		add_filter( 'harmonica_audio_transcript', 'wpautop',       25 );
	}
}