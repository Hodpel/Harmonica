<?php
/**
 * Internationalization and translation functions.  Because harmonica Core is a framework made up of various 
 * extensions with different textdomains, it must filter 'gettext' so that a single translation file can 
 * handle all translations.
 */

/* Filter the textdomain mofile to allow child themes to load the parent theme translation. */
add_filter( 'load_textdomain_mofile', 'harmonica_load_textdomain_mofile', 10, 2 );

/* Filter text strings for harmonica Core and extensions so themes can serve up translations. */
add_filter( 'gettext',               'harmonica_gettext',                          1, 3 );
add_filter( 'gettext',               'harmonica_extensions_gettext',               1, 3 );
add_filter( 'gettext_with_context',  'harmonica_gettext_with_context',             1, 4 );
add_filter( 'gettext_with_context',  'harmonica_extensions_gettext_with_context',  1, 4 );
add_filter( 'ngettext',              'harmonica_ngettext',                         1, 5 );
add_filter( 'ngettext',              'harmonica_extensions_ngettext',              1, 5 );
add_filter( 'ngettext_with_context', 'harmonica_ngettext_with_context',            1, 6 );
add_filter( 'ngettext_with_context', 'harmonica_extensions_ngettext_with_context', 1, 6 );

/**
 * Checks if a textdomain's translation files have been loaded.  This function behaves differently from 
 * WordPress core's is_textdomain_loaded(), which will return true after any translation function is run over 
 * a text string with the given domain.  The purpose of this function is to simply check if the translation files 
 * are loaded.
 *
 * @since 0.9.0
 * @access private This is only used internally by the framework for checking translations.
 * @param string $domain The textdomain to check translations for.
 */
function harmonica_is_textdomain_loaded( $domain ) {
	global $harmonica;

	return ( isset( $harmonica->textdomain_loaded[ $domain ] ) && true === $harmonica->textdomain_loaded[ $domain ] ) ? true : false;
}

/**
 * Loads the framework's translation files.  The function first checks if the parent theme or child theme 
 * has the translation files housed in their '/languages' folder.  If not, it sets the translation file the the 
 * framework '/languages' folder.
 *
 * @since 0.9.0
 * @access private
 * @uses load_textdomain() Loads an MO file into the domain for the framework.
 * @param string $domain The name of the framework's textdomain.
 * @return true|false Whether the MO file was loaded.
 */
function harmonica_load_framework_textdomain( $domain ) {

	/* Get the WordPress installation's locale set by the user. */
	$locale = get_locale();

	/* Check if the mofile is located in parent/child theme /languages folder. */
	$mofile = locate_template( array( "languages/{$locale}.mo" ) );

	/* If no mofile was found in the parent/child theme, set it to the framework's mofile. */
	if ( empty( $mofile ) )
		$mofile = trailingslashit( harmonica_LANGUAGES ) . "{$locale}.mo";

	return load_textdomain( $domain, $mofile );
}

/**
 * @since 0.7.0
 * @deprecated 0.9.0
 */
function harmonica_get_textdomain() {
	_deprecated_function( __FUNCTION__, '0.9.0', 'harmonica_get_parent_textdomain' );
	return harmonica_get_parent_textdomain();
}

/**
 * Gets the parent theme textdomain. This allows the framework to recognize the proper textdomain of the 
 * parent theme.
 *
 * Important! Do not use this for translation functions in your theme.  Hardcode your textdomain string.  Your 
 * theme's textdomain should match your theme's folder name.
 *
 * @since 0.9.0
 * @access private
 * @uses get_template() Defines the theme textdomain based on the template directory.
 * @global object $harmonica The global harmonica object.
 * @return string $harmonica->textdomain The textdomain of the theme.
 */
function harmonica_get_parent_textdomain() {
	global $harmonica;

	/* If the global textdomain isn't set, define it. Plugin/theme authors may also define a custom textdomain. */
	if ( empty( $harmonica->parent_textdomain ) ) {

		$theme = wp_get_theme( get_template() );

		$textdomain = $theme->get( 'TextDomain' ) ? $theme->get( 'TextDomain' ) : get_template();

		$harmonica->parent_textdomain = sanitize_key( apply_filters( 'harmonica_parent_textdomain', $textdomain ) );
	}

	/* Return the expected textdomain of the parent theme. */
	return $harmonica->parent_textdomain;
}

/**
 * Gets the child theme textdomain. This allows the framework to recognize the proper textdomain of the 
 * child theme.
 *
 * Important! Do not use this for translation functions in your theme.  Hardcode your textdomain string.  Your 
 * theme's textdomain should match your theme's folder name.
 *
 * @since 0.9.0
 * @access private
 * @uses get_stylesheet() Defines the child theme textdomain based on the stylesheet directory.
 * @global object $harmonica The global harmonica object.
 * @return string $harmonica->child_theme_textdomain The textdomain of the child theme.
 */
function harmonica_get_child_textdomain() {
	global $harmonica;

	/* If a child theme isn't active, return an empty string. */
	if ( !is_child_theme() )
		return '';

	/* If the global textdomain isn't set, define it. Plugin/theme authors may also define a custom textdomain. */
	if ( empty( $harmonica->child_textdomain ) ) {

		$theme = wp_get_theme();

		$textdomain = $theme->get( 'TextDomain' ) ? $theme->get( 'TextDomain' ) : get_stylesheet();

		$harmonica->child_textdomain = sanitize_key( apply_filters( 'harmonica_child_textdomain', $textdomain ) );
	}

	/* Return the expected textdomain of the child theme. */
	return $harmonica->child_textdomain;
}

/**
 * Filters the 'load_textdomain_mofile' filter hook so that we can change the directory and file name 
 * of the mofile for translations.  This allows child themes to have a folder called /languages with translations
 * of their parent theme so that the translations aren't lost on a parent theme upgrade.
 *
 * @since 0.9.0
 * @access private
 * @param string $mofile File name of the .mo file.
 * @param string $domain The textdomain currently being filtered.
 * @return $mofile
 */
function harmonica_load_textdomain_mofile( $mofile, $domain ) {

	/* If the $domain is for the parent or child theme, search for a $domain-$locale.mo file. */
	if ( $domain == harmonica_get_parent_textdomain() || $domain == harmonica_get_child_textdomain() ) {

		/* Check for a $domain-$locale.mo file in the parent and child theme root and /languages folder. */
		$locale = get_locale();
		$locate_mofile = locate_template( array( "languages/{$locale}.mo", "{$locale}.mo" ) );

		/* If a mofile was found based on the given format, set $mofile to that file name. */
		if ( !empty( $locate_mofile ) )
			$mofile = $locate_mofile;
	}

	/* Return the $mofile string. */
	return $mofile;
}

/**
 * Helper function for allowing the theme to translate the text strings for both harmonica Core and the 
 * available framework extensions.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $domain
 * @param  string  $text
 * @param  string  $context
 * @return string
 */
function harmonica_translate( $domain, $text, $context = null ) {

	$translations = get_translations_for_domain( $domain );

	return $translations->translate( $text, $context );
}

/**
 * Helper function for allowing the theme to translate the plural text strings for both harmonica Core and 
 * the available framework extensions.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $domain
 * @param  string  $single
 * @param  string  $plural
 * @param  int     $number
 * @param  string  $context
 * @return string
 */
function harmonica_translate_plural( $domain, $single, $plural, $number, $context = null ) {

	$translations = get_translations_for_domain( $domain );

	return $translations->translate_plural( $single, $plural, $number, $context );
}

/**
 * Filters 'gettext' to change the translations used for the 'harmonica' textdomain.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $text       The original, untranslated text.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_gettext( $translated, $text, $domain ) {

	/* Check if 'harmonica' is the current textdomain, there's no mofile for it, and the theme has a mofile. */
	if ( 'harmonica' == $domain && !harmonica_is_textdomain_loaded( 'harmonica' ) && harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
		$translated = harmonica_translate( harmonica_get_parent_textdomain(), $text );

	return $translated;
}

/**
 * Filters 'gettext_with_context' to change the translations used for the 'harmonica' textdomain.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $text       The original, untranslated text.
 * @param  string $context    The context of the text.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_gettext_with_context( $translated, $text, $context, $domain ) {

	/* Check if 'harmonica' is the current textdomain, there's no mofile for it, and the theme has a mofile. */
	if ( 'harmonica' == $domain && !harmonica_is_textdomain_loaded( 'harmonica' ) && harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
		$translated = harmonica_translate( harmonica_get_parent_textdomain(), $text, $context );

	return $translated;
}

/**
 * Filters 'ngettext' to change the translations used for the 'harmonica' textdomain.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $single     The singular form of the untranslated text.
 * @param  string $plural     The plural form of the untranslated text.
 * @param  int    $number     The number to use to base whether something is singular or plural.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_ngettext( $translated, $single, $plural, $number, $domain ) {

	/* Check if 'harmonica' is the current textdomain, there's no mofile for it, and the theme has a mofile. */
	if ( 'harmonica' == $domain && !harmonica_is_textdomain_loaded( 'harmonica' ) && harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
		$translated = harmonica_translate_plural( harmonica_get_parent_textdomain(), $single, $plural, $number );

	return $translated;
}

/**
 * Filters 'ngettext_with_context' to change the translations used for the 'harmonica' textdomain.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $single     The singular form of the untranslated text.
 * @param  string $plural     The plural form of the untranslated text.
 * @param  int    $number     The number to use to base whether something is singular or plural.
 * @param  string $context    The context of the text.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_ngettext_with_context( $translated, $single, $plural, $number, $context, $domain ) {

	/* Check if 'harmonica' is the current textdomain, there's no mofile for it, and the theme has a mofile. */
	if ( 'harmonica' == $domain && !harmonica_is_textdomain_loaded( 'harmonica' ) && harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
		$translated = harmonica_translate_plural( harmonica_get_parent_textdomain(), $single, $plural, $number, $context );

	return $translated;
}

/**
 * Filters 'gettext_with_context' to change the translations used for each of the extensions' textdomains.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $text       The untranslated text.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_extensions_gettext( $translated, $text, $domain ) {

	$extensions = array( 'custom-field-series', 'featured-header', 'post-stylesheets' );

	/* Check if the current textdomain matches one of the framework extensions. */
	if ( in_array( $domain, $extensions ) && current_theme_supports( $domain ) ) {

		/* If the framework mofile is loaded, use its translations. */
		if ( harmonica_is_textdomain_loaded( 'harmonica' ) )
			$translated = harmonica_translate( 'harmonica', $text );

		/* If the theme mofile is loaded, use its translations. */
		elseif ( harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
			$translated = harmonica_translate( harmonica_get_parent_textdomain(), $text );
	}

	return $translated;
}

/**
 * Filters 'gettext_with_context' to change the translations used for each of the extensions' textdomains.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $text       The untranslated text.
 * @param  string $context    The context of the text.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_extensions_gettext_with_context( $translated, $text, $context, $domain ) {

	$extensions = array( 'custom-field-series', 'featured-header', 'post-stylesheets' );

	/* Check if the current textdomain matches one of the framework extensions. */
	if ( in_array( $domain, $extensions ) && current_theme_supports( $domain ) ) {

		/* If the framework mofile is loaded, use its translations. */
		if ( harmonica_is_textdomain_loaded( 'harmonica' ) )
			$translated = harmonica_translate( 'harmonica', $text, $context );

		/* If the theme mofile is loaded, use its translations. */
		elseif ( harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
			$translated = harmonica_translate( harmonica_get_parent_textdomain(), $text, $context );
	}

	return $translated;
}

/**
 * Filters 'ngettext' to change the translations used for each of the extensions' textdomains.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $single     The singular form of the untranslated text.
 * @param  string $plural     The plural form of the untranslated text.
 * @param  int    $number     The number to use to base whether something is singular or plural.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_extensions_ngettext( $translated, $single, $plural, $number, $domain ) {

	$extensions = array( 'custom-field-series', 'featured-header', 'post-stylesheets' );

	/* Check if the current textdomain matches one of the framework extensions. */
	if ( in_array( $domain, $extensions ) && current_theme_supports( $domain ) ) {

		/* If the framework mofile is loaded, use its translations. */
		if ( harmonica_is_textdomain_loaded( 'harmonica' ) )
			$translated = harmonica_translate_plural( 'harmonica', $single, $plural, $number );

		/* If the theme mofile is loaded, use its translations. */
		elseif ( harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
			$translated = harmonica_translate_plural( harmonica_get_parent_textdomain(), $single, $plural, $number );
	}

	return $translated;
}

/**
 * Filters 'ngettext_with_context' to change the translations used for each of the extensions' textdomains.
 *
 * @since  0.9.0
 * @access public
 * @param  string $translated The translated text.
 * @param  string $single     The singular form of the untranslated text.
 * @param  string $plural     The plural form of the untranslated text.
 * @param  int    $number     The number to use to base whether something is singular or plural.
 * @param  string $context    The context of the text.
 * @param  string $domain     The textdomain for the text.
 * @return string
 */
function harmonica_extensions_ngettext_with_context( $translated, $single, $plural, $number, $context, $domain ) {

	$extensions = array( 'custom-field-series', 'featured-header', 'post-stylesheets' );

	/* Check if the current textdomain matches one of the framework extensions. */
	if ( in_array( $domain, $extensions ) && current_theme_supports( $domain ) ) {

		/* If the framework mofile is loaded, use its translations. */
		if ( harmonica_is_textdomain_loaded( 'harmonica' ) )
			$translated = harmonica_translate_plural( 'harmonica', $single, $plural, $number, $context );

		/* If the theme mofile is loaded, use its translations. */
		elseif ( harmonica_is_textdomain_loaded( harmonica_get_parent_textdomain() ) )
			$translated = harmonica_translate_plural( harmonica_get_parent_textdomain(), $single, $plural, $number, $context );
	}

	return $translated;
}

/**
 * Gets the language for the currently-viewed page.  It strips the region from the locale if needed 
 * and just returns the language code.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $locale
 * @return string
 */
function harmonica_get_language( $locale = '' ) {

	if ( empty( $locale ) )
		$locale = get_locale();

	return preg_replace( '/(.*?)_.*?$/i', '$1', $locale );
}

/**
 * Gets the region for the currently viewed page.  It strips the language from the locale if needed.  Note that 
 * not all locales will have a region, so this might actually return the same thing as `harmonica_get_language()`.
 *
 * @since  0.9.0
 * @access public
 * @param  string  $locale
 * @return string
 */
function harmonica_get_region( $locale = '' ) {

	if ( empty( $locale ) )
		$locale = get_locale();

	return preg_replace( '/.*?_(.*?)$/i', '$1', $locale );
}