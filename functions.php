<?php
/**
 * Glisten functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Glisten
 * @since Glisten 1.0
 */
namespace Glisten;


/**
 * Set up theme defaults and register various WordPress features.
 */
function setup() {

	// Enqueue editor styles and fonts.
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );


/**
 * Enqueue styles.
 */
function enqueue_style_sheet() {
	wp_enqueue_style( sanitize_title( __NAMESPACE__ ), get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_style_sheet' );

/**
 * Load custom block styles only when the block is used.
 */
function enqueue_custom_block_styles() {

	// Scan our styles folder to locate block styles.
	$files = glob( get_template_directory() . '/assets/styles/*.css' );

	foreach ( $files as $file ) {

		// Get the filename and core block name.
		$filename   = basename( $file, '.css' );
		$block_name = str_replace( 'core-', 'core/', $filename );

		wp_enqueue_block_style(
			$block_name,
			array(
				'handle' => "ollie-block-{$filename}",
				'src'    => get_theme_file_uri( "assets/styles/{$filename}.css" ),
				'path'   => get_theme_file_path( "assets/styles/{$filename}.css" ),
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\enqueue_custom_block_styles' );


/**
 * Add block style variations.
 */
function register_block_styles() {

	$block_styles = array(
		'core/post-terms'                    => array(
			'icon-only' 	=> __( 'Icon Only', 'glisten' ),
		)
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block_styles' );