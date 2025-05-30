<?php

/**
 * Shortcodes Class
 */

namespace AR_VIEWER\Inc;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
class Shortcodes {

	public function __construct() {
		add_shortcode( 'ar_viewer', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Render Shortcode
	 */
	public function render_shortcode( $atts ) {
		
		wp_enqueue_script_module(
			'model-viewer',
			AR_VIEWER_ASSETS . 'app/vendor/model-viewer.min.js',
			array(),
			'3.4.0'
		);

		$atts = shortcode_atts( array(
			'id'               => '',
			'src'              => '',
			'evn'              => '',
			'thumbnail'        => '',
			'alt'              => '',
			'height'           => '700px',
			'width'            => '700px',
			'ar_placement'     => 'floor',
			'shadow_intensity' => '1',
			'model_scale'      => '100',
			'web_model_scale'  => '50',
		), $atts, 'ar_viewer' );

		$id = 'ar-viewer-' . wp_rand( 10, 1000 );

		$evn              = ( isset( $atts['evn'] ) && ! empty( $atts['evn'] ) ) ? $atts['evn'] : ''; //hdr
		$src              = ( isset( $atts['src'] ) && ! empty( $atts['src'] ) ) ? $atts['src'] : ''; //glb
		$thumbnail        = ( isset( $atts['thumbnail'] ) && ! empty( $atts['thumbnail'] ) ) ? $atts['thumbnail'] : '';
		$alt              = ( isset( $atts['alt'] ) && ! empty( $atts['alt'] ) ) ? $atts['alt'] : '';
		$ar_placement     = ( isset( $atts['ar_placement'] ) && ! empty( $atts['ar_placement'] ) ) ? $atts['ar_placement'] : 'floor';
		$shadow_intensity = ( isset( $atts['shadow_intensity'] ) && is_numeric( $atts['shadow_intensity'] ) ) ? max( 0, min( 10, floatval( $atts['shadow_intensity'] ) ) ) : 1;
		$model_scale      = ( isset( $atts['model_scale'] ) && is_numeric( $atts['model_scale'] ) ) ? max( 0, min( 100, floatval( $atts['model_scale'] ) ) ) : 100;
		$web_model_scale  = ( isset( $atts['web_model_scale'] ) && is_numeric( $atts['web_model_scale'] ) ) ? max( 0, min( 100, floatval( $atts['web_model_scale'] ) ) ) : 50;

		// Generate unique ID if not provided
		if ( empty( $id ) ) {
			$id = 'ar-viewer-shortcode-' . wp_rand( 1000, 9999 );
		}

		ob_start();

		?>
		<model-viewer width="<?php echo esc_attr( $atts['width'] ); ?>" height="<?php echo esc_attr( $atts['height'] ); ?>"
			id="<?php echo esc_attr( $id ); ?>" alt="<?php echo esc_attr( $alt ); ?>" src="<?php echo esc_url( $src ); ?>" ar
			<?php echo ( 'wall' === $ar_placement ) ? 'ar-placement="wall"' : ''; ?>
			<?php if ( $model_scale != 100 ) { $scale_value = $model_scale / 100; echo 'scale="' . esc_attr( $scale_value . ' ' . $scale_value . ' ' . $scale_value ) . '"'; } ?>
			<?php 
			// Handle USDZ fallback for web display
			$ios_src = '';
			if ( ! empty( $src ) && strtolower( pathinfo( $src, PATHINFO_EXTENSION ) ) === 'usdz' ) {
				$ios_src = $src;
				// Look for GLB/GLTF fallback for web display
				$base_name = pathinfo( $src, PATHINFO_FILENAME );
				$dir_path = dirname( $src );
				
				// Try to find GLB version first, then GLTF
				$glb_fallback = $dir_path . '/' . $base_name . '.glb';
				$gltf_fallback = $dir_path . '/' . $base_name . '.gltf';
				
				// For shortcodes, we can only check URL-based fallbacks
				// Check if this is a local file (contains plugin directory)
				if ( strpos( $src, plugin_dir_url( dirname( __FILE__ ) ) ) !== false ) {
					// Check if GLB fallback exists
					$glb_file_path = str_replace( plugin_dir_url( dirname( __FILE__ ) ), plugin_dir_path( dirname( __FILE__ ) ), $glb_fallback );
					if ( file_exists( $glb_file_path ) ) {
					$src = $glb_fallback;
				} else {
					// Check if GLTF fallback exists
					$gltf_file_path = str_replace( plugin_dir_url( dirname( __FILE__ ) ), plugin_dir_path( dirname( __FILE__ ) ), $gltf_fallback );
					if ( file_exists( $gltf_file_path ) ) {
						$src = $gltf_fallback;
					} else {
						// If no fallback found, set src to empty to prevent USDZ from being used as src
						$src = '';
					}
				}
			}
		}
			
			// Add ios-src for USDZ models
			if ( ! empty( $ios_src ) ) {
				echo 'ios-src="' . esc_url( $ios_src ) . '"';
			}
			?>
			environment-image="<?php echo esc_url( $evn ); ?>" poster="<?php echo esc_url( $thumbnail ); ?>" shadow-intensity="<?php echo esc_attr( $shadow_intensity ); ?>"
			camera-controls touch-action="pan-y" camera-target="auto auto auto" field-of-view="auto" style="width: <?php echo esc_attr( $atts['width'] ); ?>; height:<?php echo esc_attr( $atts['height'] ); ?>;">
		</model-viewer>
		<script>
		(function() {
			const modelViewer = document.getElementById('<?php echo esc_js( $id ); ?>');
			if (modelViewer) {
				// Set initial web scale (50 = 100% original size, 0 = 0%, 100 = 200%)
				const webScale = <?php echo esc_js( $web_model_scale ); ?> / 50;
				
				// Apply scale to the 3D model, not the canvas
				modelViewer.scale = webScale + ' ' + webScale + ' ' + webScale;
				
				// Listen for AR mode changes to reset scale
				modelViewer.addEventListener('ar-status', function(event) {
					if (event.detail.status === 'session-started') {
						// In AR mode, use original scale (1 1 1)
						modelViewer.scale = '1 1 1';
					} else if (event.detail.status === 'not-presenting') {
						// Back to web view, restore web scale
						modelViewer.scale = webScale + ' ' + webScale + ' ' + webScale;
					}
				});
			}
		})();
		</script>
		<?php

		return ob_get_clean();
	}
}
