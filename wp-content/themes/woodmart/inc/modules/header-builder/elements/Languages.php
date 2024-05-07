<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Languages. A few kinds of it.
 * ------------------------------------------------------------------------------------------------
 */

if ( ! class_exists( 'WOODMART_HB_Languages' ) ) {
	class WOODMART_HB_Languages extends WOODMART_HB_Element {

		public function __construct() {
			parent::__construct();

			$this->template_name = 'languages';
		}

		public function map() {
			$this->args = array(
				'type'            => 'languages',
				'title'           => esc_html__( 'WPML Languages', 'woodmart' ),
				'text'            => esc_html__( 'Language selectors', 'woodmart' ),
				'icon'            => 'xts-i-translate',
				'editable'        => true,
				'container'       => false,
				'edit_on_create'  => true,
				'drag_target_for' => array(),
				'drag_source'     => 'content_element',
				'removable'       => true,
				'addable'         => true,
				'params'          => array(
					'show_language_flag' => array(
						'id'          => 'show_language_flag',
						'title'       => esc_html__( 'Show Flag', 'woodmart' ),
						'description' => esc_html__( 'Show flag of languages', 'woodmart' ),
						'type'        => 'switcher',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'value'       => true,
					),
					'mouse_event'        => array(
						'id'      => 'mouse_event',
						'title'   => esc_html__( 'Open on mouse event', 'woodmart' ),
						'type'    => 'selector',
						'tab'     => esc_html__( 'General', 'woodmart' ),
						'value'   => 'hover',
						'options' => array(
							'hover' => array(
								'value' => 'hover',
								'label' => esc_html__( 'Hover', 'woodmart' ),
							),
							'click' => array(
								'value' => 'click',
								'label' => esc_html__( 'Click', 'woodmart' ),
							),
						),
					),
					'color_scheme'       => array(
						'id'          => 'color_scheme',
						'title'       => esc_html__( 'Text color scheme', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'value'       => 'dark',
						'options'     => array(
							'dark'  => array(
								'value' => 'dark',
								'label' => esc_html__( 'Dark', 'woodmart' ),
							),
							'light' => array(
								'value' => 'light',
								'label' => esc_html__( 'Light', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'Select different text color scheme depending on your header background.', 'woodmart' ),
					),
				),
			);
		}
	}
}
