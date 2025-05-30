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
		), $atts, 'ar_viewer' );

		$id = 'ar-viewer-' . wp_rand( 10, 1000 );

		$evn              = ( isset( $atts['evn'] ) && ! empty( $atts['evn'] ) ) ? $atts['evn'] : ''; //hdr
		$src              = ( isset( $atts['src'] ) && ! empty( $atts['src'] ) ) ? $atts['src'] : ''; //glb
		$thumbnail        = ( isset( $atts['thumbnail'] ) && ! empty( $atts['thumbnail'] ) ) ? $atts['thumbnail'] : '';
		$alt              = ( isset( $atts['alt'] ) && ! empty( $atts['alt'] ) ) ? $atts['alt'] : '';
		$ar_placement     = ( isset( $atts['ar_placement'] ) && ! empty( $atts['ar_placement'] ) ) ? $atts['ar_placement'] : 'floor';
		$shadow_intensity = ( isset( $atts['shadow_intensity'] ) && is_numeric( $atts['shadow_intensity'] ) ) ? max( 0, min( 10, floatval( $atts['shadow_intensity'] ) ) ) : 1;
		$model_scale      = ( isset( $atts['model_scale'] ) && is_numeric( $atts['model_scale'] ) ) ? max( 0, min( 100, floatval( $atts['model_scale'] ) ) ) : 100;

		ob_start();

		?>
		<model-viewer width="<?php echo esc_attr( $atts['width'] ); ?>" height="<?php echo esc_attr( $atts['height'] ); ?>"
			id="<?php echo esc_attr( $id ); ?>" alt="<?php echo esc_attr( $alt ); ?>" src="<?php echo esc_url( $src ); ?>" ar
			<?php echo ( 'wall' === $ar_placement ) ? 'ar-placement="wall"' : ''; ?>
			<?php if ( $model_scale != 100 ) { $scale_value = $model_scale / 100; echo 'scale="' . esc_attr( $scale_value . ' ' . $scale_value . ' ' . $scale_value ) . '"'; } ?>
			environment-image="<?php echo esc_url( $evn ); ?>" poster="<?php echo esc_url( $thumbnail ); ?>" shadow-intensity="<?php echo esc_attr( $shadow_intensity ); ?>"
			camera-controls touch-action="pan-y" style="width: <?php echo esc_attr( $atts['width'] ); ?>; height:<?php echo esc_attr( $atts['height'] ); ?>;">
		</model-viewer>
		<?php

		return ob_get_clean();
	}
}
