<?php

namespace AR_VIEWER\Inc;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Ar_Viewer_Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'bdt-ar-viewer';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'SMART AR VIEWER', 'ar-viewer' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-banner';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'ar', 'viewer', '3d', '360', 'AR Viewer' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'src_section',
			[ 
				'label' => esc_html__( 'Content', 'ar-viewer' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'poster_source_type',
			[ 
				'label'       => esc_html__( 'Poster Source', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'remote',
				'render_type' => 'template',
				'options'     => [ 
					'self'   => [ 
						'title' => esc_html__( 'Self Media', 'ar-viewer' ),
						'icon'  => 'eicon-image-rollover'
					],
					'remote' => [ 
						'title' => esc_html__( 'Remote URL', 'ar-viewer' ),
						'icon'  => 'eicon-link'
					]
				]
			]
		);

		$this->add_control(
			'poster',
			[ 
				'label'       => esc_html__( 'Poster', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'poster_source_type' => 'remote'
				]
			]
		);

		$this->add_control(
			'poster_image',
			[ 
				'label'       => esc_html__( 'Poster Image', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select the image to be displayed as the poster.', 'ar-viewer' ),
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'poster_source_type' => 'self'
				]
			]
		);

		$this->add_control(
			'env_source_type',
			[ 
				'label'       => esc_html__( 'Environment Image Source', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'remote',
				'render_type' => 'template',
				'options'     => [ 
					'self'   => [ 
						'title' => esc_html__( 'Self Media', 'ar-viewer' ),
						'icon'  => 'eicon-image-rollover'
					],
					'remote' => [ 
						'title' => esc_html__( 'Remote URL', 'ar-viewer' ),
						'icon'  => 'eicon-link'
					]
				]
			]
		);

		$this->add_control(
			'environment_image',
			[ 
				'label'       => esc_html__( 'Environment Image', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'description' => esc_html__( 'HDR image to use as the environment map.', 'ar-viewer' ),
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'env_source_type' => 'remote'
				]
			]
		);

		$this->add_control(
			'environment_image_self',
			[ 
				'label'       => esc_html__( 'Environment Image', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select the image to be displayed as the environment map.', 'ar-viewer' ),
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'env_source_type' => 'self'
				],
				'media_type'  => 'application/octet-stream',
			]
		);

		$this->add_control(
			'src_source_type',
			[ 
				'label'       => esc_html__( 'Model Source', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'remote',
				'render_type' => 'template',
				'options'     => [ 
					'self'   => [ 
						'title' => esc_html__( 'Self Media', 'ar-viewer' ),
						'icon'  => 'eicon-image-rollover'
					],
					'remote' => [ 
						'title' => esc_html__( 'Remote URL', 'ar-viewer' ),
						'icon'  => 'eicon-link'
					]
				]
			]
		);

		$this->add_control(
			'model_url',
			[ 
				'label'       => esc_html__( 'Model', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'description' => esc_html__( 'The URL of the glTF or GLB model to be displayed.', 'ar-viewer' ),
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'src_source_type' => 'remote'
				]
			]
		);

		$this->add_control(
			'model',
			[ 
				'label'       => esc_html__( 'Model', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select the model to be displayed.', 'ar-viewer' ),
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'src_source_type' => 'self'
				],
				'media_type'  => 'application/octet-stream',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'canvas_section',
			[ 
				'label' => esc_html__( 'Canvas', 'ar-viewer' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'canvas_height',
			[ 
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Height', 'ar-viewer' ),
				'size_units'  => [ 'px', 'em', 'rem', 'vh' ],
				'range'       => [ 
					'px' => [ 
						'min' => 1,
						'max' => 2000,
					],
				],
				'default'     => [ 
					'unit' => 'px',
					'size' => 320,
				],
				'render_type' => 'template',
				'selectors'   => [ 
					'{{WRAPPER}} model-viewer' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'canvas_width',
			[ 
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Width', 'ar-viewer' ),
				'size_units'  => [ 'px', 'em', 'rem', 'vh' ],
				'range'       => [ 
					'px' => [ 
						'min' => 1,
						'max' => 2000,
					],
				],
				'default'     => [ 
					'unit' => 'px',
					'size' => 320,
				],
				'render_type' => 'template',
				'selectors'   => [ 
					'{{WRAPPER}} model-viewer' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'camera_settings_section',
			[ 
				'label' => esc_html__( 'Camera Settings', 'ar-viewer' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'auto_rotate',
			[ 
				'label'        => esc_html__( 'Auto Rotate', 'ar-viewer' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'shadow_intensity',
			[ 
				'label'   => esc_html__( 'Shadow Intensity', 'ar-viewer' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => [ 
					'px' => [ 
						'min' => 0,
						'max' => 10,
					],
				],
				'default' => [ 
					'unit' => 'px',
					'size' => 1,
				],
			]
		);

		$this->add_control(
			'camera_orbit',
			[ 
				'label'       => esc_html__( 'Camera Orbit', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '45deg 55deg 4m',
				'description' => esc_html__( 'Set the camera-orbit change the initial angle and position of the camera. Example - 45deg 55deg 4m', 'ar-viewer' ),
			]
		);

		$this->add_control(
			'disable_zoom',
			[ 
				'label'        => esc_html__( 'Disable Zoom', 'ar-viewer' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'description'  => esc_html__( 'Disable zooming in and out of the model.', 'ar-viewer' ),
			]
		);

		$this->add_control(
			'disable_tap',
			[ 
				'label'        => esc_html__( 'Disable Tap', 'ar-viewer' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'description'  => esc_html__( 'Disable tap to rotate the model.', 'ar-viewer' ),
			]
		);

		$this->add_control(
			'model_scale',
			[ 
				'label'   => esc_html__( 'Model Scale', 'ar-viewer' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [ 
					'unit' => 'px',
					'size' => 100,
				],
				'description' => esc_html__( 'Scale the model size (0-100%).', 'ar-viewer' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'env_section',
			[ 
				'label' => esc_html__( 'Light & Environment', 'ar-viewer' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'skybox_source_type',
			[ 
				'label'       => esc_html__( 'Poster / Fallback Source', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'remote',
				'render_type' => 'template',
				'options'     => [ 
					'self'   => [ 
						'title' => esc_html__( 'Self Media', 'ar-viewer' ),
						'icon'  => 'eicon-image-rollover'
					],
					'remote' => [ 
						'title' => esc_html__( 'Remote URL', 'ar-viewer' ),
						'icon'  => 'eicon-link'
					]
				]
			]
		);

		$this->add_control(
			'skybox_image',
			[ 
				'label'       => esc_html__( 'Skybox Image URL', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'description' => esc_html__( 'The URL of the skybox image to be displayed.', 'ar-viewer' ),
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'skybox_source_type' => 'remote'
				]
			]
		);

		$this->add_control(
			'skybox_image_self',
			[ 
				'label'       => esc_html__( 'Skybox Image', 'ar-viewer' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select the image to be displayed as the skybox.', 'ar-viewer' ),
				'render_type' => 'template',
				'options'     => false,
				'condition'   => [ 
					'skybox_source_type' => 'self'
				],
				'media_type'  => 'application/octet-stream',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ar_section',
			[ 
				'label' => esc_html__( 'AR Settings', 'ar-viewer' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ar_placement',
			[ 
				'label'   => esc_html__( 'AR Placement Mode', 'ar-viewer' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'floor',
				'options' => [ 
					'floor' => esc_html__( 'Floor', 'ar-viewer' ),
					'wall'  => esc_html__( 'Wall', 'ar-viewer' ),
				],
				'description' => esc_html__( 'Choose where the AR model should be placed when viewed in AR mode.', 'ar-viewer' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[ 
				'label' => esc_html__( 'Content', 'ar-viewer' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'alignment',
			[ 
				'label'                => esc_html__( 'Alignment', 'ar-viewer' ),
				'type'                 => \Elementor\Controls_Manager::CHOOSE,
				'default'              => 'center',
				'options'              => [ 
					'left'   => [ 
						'title' => esc_html__( 'Left', 'ar-viewer' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [ 
						'title' => esc_html__( 'Center', 'ar-viewer' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [ 
						'title' => esc_html__( 'Right', 'ar-viewer' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [ 
					'left'   => 'justify-content: left;',
					'center' => 'justify-content: center;',
					'right'  => 'justify-content: right;',
				],
				'selectors'            => [ 
					'{{WRAPPER}} .elementor-widget-container' => 'display:flex; {{VALUE}};',
				],
				'render_type'          => 'template'
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		wp_enqueue_script_module(
			'model-viewer',
			AR_VIEWER_ASSETS . 'app/vendor/model-viewer.min.js',
			array(),
			'3.4.0'
		);

		$evn_img   = isset( $settings['environment_image']['url'] ) ? $settings['environment_image']['url'] : ''; //hdr
		$evn_img   = isset( $settings['environment_image_self']['url'] ) ? $settings['environment_image_self']['url'] : $evn_img; //hdr
		$model_url = isset( $settings['model_url']['url'] ) ? $settings['model_url']['url'] : ''; //glb
		$model_url = isset( $settings['model']['url'] ) ? $settings['model']['url'] : $model_url; //glb
		$thumbnail = isset( $settings['poster']['url'] ) ? $settings['poster']['url'] : '';
		$thumbnail = isset( $settings['poster_image']['url'] ) ? $settings['poster_image']['url'] : $thumbnail;
		$alt       = isset( $settings['poster']['id'] ) ? get_post_meta( $settings['poster']['id'], '_wp_attachment_image_alt', true ) : '';
		$alt       = isset( $settings['poster_image']['id'] ) ? get_post_meta( $settings['poster_image']['id'], '_wp_attachment_image_alt', true ) : $alt;

		$this->add_render_attribute( 'ar-viewer', [ 
			'alt'               => $alt,
			'src'               => $model_url,
			'environment-image' => $evn_img,
			'poster'            => $thumbnail,
			'shadow-intensity'  => ! empty( $settings['shadow_intensity']['size'] ) ? $settings['shadow_intensity']['size'] : 1,
			'camera-controls'   => '',
			'touch-action'      => 'pan-y',
			'tone-mapping'      => 'neutral',
		] );

		if ( 'true' === $settings['auto_rotate'] ) {
			$this->add_render_attribute( 'ar-viewer', 'auto-rotate', '' );
		}

		if ( ! empty( $settings['camera_orbit'] ) ) {
			$this->add_render_attribute( 'ar-viewer', 'camera-orbit', $settings['camera_orbit'] );
		}

		if ( 'true' === $settings['disable_zoom'] ) {
			$this->add_render_attribute( 'ar-viewer', 'disable-zoom', '' );
		}

		if ( 'true' === $settings['disable_tap'] ) {
			$this->add_render_attribute( 'ar-viewer', 'disable-tap', '' );
		}

		if ( ! empty( $settings['skybox_image']['url'] ) ) {
			$this->add_render_attribute( 'ar-viewer', 'skybox-image', $settings['skybox_image']['url'] );
		}

		if ( ! empty( $settings['skybox_image_self']['url'] ) ) {
			$this->add_render_attribute( 'ar-viewer', 'skybox-image', $settings['skybox_image_self']['url'] );
		}

		// Add AR placement mode
		if ( ! empty( $settings['ar_placement'] ) && 'wall' === $settings['ar_placement'] ) {
			$this->add_render_attribute( 'ar-viewer', 'ar-placement', 'wall' );
		}

		// Add model scale
		if ( ! empty( $settings['model_scale']['size'] ) && $settings['model_scale']['size'] != 100 ) {
			$scale_value = $settings['model_scale']['size'] / 100;
			$this->add_render_attribute( 'ar-viewer', 'scale', $scale_value . ' ' . $scale_value . ' ' . $scale_value );
		}

		?>
		<model-viewer ar <?php $this->print_render_attribute_string( 'ar-viewer' ); ?>>
		</model-viewer>
		<?php
	}
}
