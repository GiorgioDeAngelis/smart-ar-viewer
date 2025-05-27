<?php

namespace AR_VIEWER\Inc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Elementor {

	public function __construct() {
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
	}

	public function init_widgets( $widgets_manager ) {
		require_once ( __DIR__ . '/ar-viewer.php' );
		$widgets_manager->register( new \AR_VIEWER\Inc\Ar_Viewer_Elementor_Widget() );
	}
}

if ( class_exists( 'AR_VIEWER\Inc\Elementor' ) ) {
	new Elementor();
}