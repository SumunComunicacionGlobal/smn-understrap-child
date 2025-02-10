<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'PLACEHOLDER_ID', 13 );
define( 'RESERVA_ID', 1530 );
define( 'SVG_FLECHA', '<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 10L5.5 6L1.5 2" stroke="currentColor" stroke-width="2" stroke-linecap="square"/></svg>' );
// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
    // '/smn-dummy-content.php',
    '/smn-security.php',
    '/smn-seo.php',
    '/smn-widgets.php',
    '/smn-post-types.php',
    '/smn-setup.php',
    '/smn-hooks.php',
    '/smn-customizer.php',
    '/smn-template-tags.php',
    '/smn-shortcodes.php',
    '/smn-blocks.php',
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
    $understrap_includes[] = '/smn-woocommerce.php';
}

if ( class_exists('ACF')) {
    $understrap_includes[] = '/smn-acf.php';
}

if ( class_exists('FacetWP') ) {
    $understrap_includes[] = '/smn-facetwp.php';
}

if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
    $understrap_includes[] = '/smn-moove-gdpr-cookies.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
    require_once get_theme_file_path( $understrap_inc_dir . $file );
}

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
	
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

// Remove each WooCommerce style one by one
// add_filter( 'woocommerce_enqueue_styles', 'smn_wc_dequeue_styles' );
function smn_wc_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	// unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	// unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}

/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.css' );
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/js/slick/slick-theme.css' );

	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$woocommerce_styles = "/css/woocommerce{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";
	
	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_styles );

	wp_enqueue_style( 'smn-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version );
	// wp_register_style( 'smn-woocommerce', get_stylesheet_directory_uri() . $woocommerce_styles, array(), $css_version );
	// if ( class_exists( 'woocommerce' ) ) {
	// 	wp_enqueue_style( 'smn-woocommerce' );
	// }

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.min.js', null, null, true );
    wp_enqueue_script( 'multi-animated-counter', get_stylesheet_directory_uri() . '/js/multi-animated-counter.js', null, null, true );

	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_scripts );
	
	wp_enqueue_script( 'smn-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 999 );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
	load_child_theme_textdomain( 'smn', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );