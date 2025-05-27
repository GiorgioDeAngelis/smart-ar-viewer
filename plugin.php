<?php

/**
 * Main Plugin File
 */

namespace AR_VIEWER;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

final class Plugin {

	/**
	 * App Scripts
	 */
	public function app_scripts() {
		wp_register_script( 'model-viewer', AR_VIEWER_ASSETS . 'app/vendor/model-viewer.min.js', [], AR_VIEWER_VERSION, true );

		add_filter( 'wp_script_attributes', function ($attributes) {
			if ( isset( $attributes['id'] ) && $attributes['id'] === 'model-viewer-js' ) {
				$attributes['type'] = 'module';
			}
			return $attributes;
		}, 10, 1 );
	}


	/**
	 * Shortcodes
	 */
	public function shortcodes() {
		include_once AR_VIEWER_INC_PATH . 'class-shortcodes.php';

		if ( class_exists( 'AR_VIEWER\Inc\Shortcodes' ) ) {
			new Inc\Shortcodes();
		}
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'shortcodes' ] );
		add_action( 'enqueue_block_assets', [ $this, 'app_scripts' ], 1000 );

		// add_action( 'enqueue_block_assets', function () {
		// 	wp_enqueue_script( 'model-viewer' );
		// }, 1000 );

	}

}

if ( class_exists( 'AR_VIEWER\Plugin' ) ) {
	new Plugin();
}