<?php
/**
 * Plugin Name: SMART AR VIEWER
 * Plugin URI: https://github.com/GiorgioDeAngelis/smart-ar-viewer.git
 * Description: By using this plugin, you can easily create AR Viewer 3D model on your website.
 * Version: 1.0.0
 * Author: GDVERSE.s.r.l.
 * Author URI: https://github.com/GiorgioDeAngelis
 * Text Domain: ar-viewer
 * Domain Path: /languages
 * License: MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


define( 'AR_VIEWER_VERSION', '1.0.0' );

define( 'AR_VIEWER__FILE__', __FILE__ );
define( 'AR_VIEWER_PATH', plugin_dir_path( AR_VIEWER__FILE__ ) );
define( 'AR_VIEWER_INCLUDES', AR_VIEWER_PATH . 'includes/' );
define( 'AR_VIEWER_URL', plugins_url( '/', AR_VIEWER__FILE__ ) );
define( 'AR_VIEWER_ASSETS', AR_VIEWER_URL . 'assets/' );
define( 'AR_VIEWER_PATH_NAME', basename( dirname( AR_VIEWER__FILE__ ) ) );
define( 'AR_VIEWER_INC_PATH', AR_VIEWER_PATH . 'includes/' );
define( 'AR_VIEWER_ADMIN_VIEWS_PATH', AR_VIEWER_PATH . 'includes/Admin/views/' );
define( 'AR_VIEWER_ASSETS_URL_ADMIN', AR_VIEWER_URL . 'assets/admin/' );


/**
 * Load Plugin
 */
require_once AR_VIEWER_PATH . 'plugin.php';

/**
 * Load Elementor Support
 */
if ( ! function_exists( 'ar_viewer_dep_loader' ) ) {
	function ar_viewer_dep_loader() {
		if ( did_action( 'elementor/loaded' ) ) {
			require_once AR_VIEWER_INCLUDES . 'elementor/elementor.php';
		}

	}
	add_action( 'plugins_loaded', 'ar_viewer_dep_loader', 9 );
}

/**
 * Register Blocks
 */

add_action( 'init', function () {
	register_block_type_from_metadata( AR_VIEWER_PATH . 'build/blocks/ar-viewer' );
} );

function ar_viewer_blocks_render( $block_content, $block ) {
	if ( isset( $block['blockName'] ) && str_contains( $block['blockName'], 'ar-viewer/' ) ) {
		$tags = new WP_HTML_Tag_Processor( $block_content );
		$tags->next_tag( 'div' );
		$tags->add_class( 'ar-viewer' );
		$tags->get_updated_html();
		$module_style = ! empty( $block['attrs']['moduleStyle'] ) ? $block['attrs']['moduleStyle'] : '';
		return sprintf( "<style>%1s</style> %2s", $module_style, $tags );
	}

	return $block_content;
}
add_filter( 'render_block', 'ar_viewer_blocks_render', 10, 2 );


/**
 * Enqueue scripts for custom blocks
 */
function custom_block_scripts() {
	wp_register_script_module( 'model-viewer', AR_VIEWER_ASSETS . 'app/vendor/model-viewer.min.js', [], AR_VIEWER_VERSION );
}
add_action( 'enqueue_block_assets', 'custom_block_scripts' );

function ar_viewer_support_mime_types( $mimes ) {
	$_mimes = [ 
		'glb'  => 'model/gltf-binary',
		'gltf' => 'model/gltf-binary',
		'usdz' => 'model/vnd.usdz+zip',
		'obj'  => 'model/obj',
		'3ds'  => 'application/x-3ds',
		'step' => 'application/step',
		'stl'  => 'application/vnd.ms-pki.stl',
		'fbx'  => 'application/octet-stream',
		'3dml' => 'text/vnd.in3d.3dml',
		'dae'  => 'application/collada+xml',
		'wrl'  => 'model/vrml',
		'3mf'  => 'application/vnd.ms-3mfdocument',
		'bin'  => 'application/octet-stream',
		'hdr'  => 'image/vnd.radiance',
	];
	return wp_parse_args( $mimes, $_mimes );
}

add_filter( 'upload_mimes', 'ar_viewer_support_mime_types' );