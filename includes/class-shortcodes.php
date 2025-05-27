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
			'id'        => '',
			'src'       => '',
			'evn'       => '',
			'thumbnail' => '',
			'alt'       => '',
			'height'    => '700px',
			'width'     => '700px',
		), $atts, 'ar_viewer' );

		$id = 'ar-viewer-' . wp_rand( 10, 1000 );

		$evn       = ( isset( $atts['evn'] ) && ! empty( $atts['evn'] ) ) ? $atts['evn'] : ''; //hdr
		$src       = ( isset( $atts['src'] ) && ! empty( $atts['src'] ) ) ? $atts['src'] : ''; //glb
		$thumbnail = ( isset( $atts['thumbnail'] ) && ! empty( $atts['thumbnail'] ) ) ? $atts['thumbnail'] : '';
		$alt       = ( isset( $atts['alt'] ) && ! empty( $atts['alt'] ) ) ? $atts['alt'] : '';

		ob_start();

		?>
		<model-viewer width="<?php echo esc_attr( $atts['width'] ); ?>" height="<?php echo esc_attr( $atts['height'] ); ?>"
			id="<?php echo esc_attr( $id ); ?>" alt="<?php echo esc_attr( $alt ); ?>" src="<?php echo esc_url( $src ); ?>" ar
			environment-image="<?php echo esc_url( $evn ); ?>" poster="<?php echo esc_url( $thumbnail ); ?>" shadow-intensity="1"
			camera-controls touch-action="pan-y" style="width: <?php echo esc_attr( $atts['width'] ); ?>; height:<?php echo esc_attr( $atts['height'] ); ?>;">
		</model-viewer>
		<?php

		return ob_get_clean();
	}
}
