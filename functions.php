<?php
/**
 * WyrdPrints Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wyrdprints_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );

	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'wyrdprints_setup' );

function wyrdprints_enqueue_styles() {
	wp_enqueue_style(
		'wyrdprints-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'wyrdprints_enqueue_styles' );