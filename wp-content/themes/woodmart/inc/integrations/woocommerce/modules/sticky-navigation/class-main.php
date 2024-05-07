<?php
/**
 * Sticky navigation.
 *
 * @package woodmart
 */

namespace XTS\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use WOODMART_Mega_Menu_Walker;
use XTS\Options;
use XTS\Singleton;

/**
 * Sticky navigation.
 *
 * @since 1.0.0
 */
class Main extends Singleton {
	/**
	 * Basic initialization class required for Module class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'init', array( $this, 'add_options' ) );

		add_action( 'wp_head', array( $this, 'enqueue_styles' ), 200 );
		add_action( 'woodmart_after_body_open', array( $this, 'template' ), 600 );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'woodmart_localized_string_array', array( $this, 'add_localized_settings' ) );
	}

	/**
	 * Output sticky category navigation menu.
	 *
	 * @since 1.0.0
	 */
	public function template() {
		if ( ! woodmart_get_opt( 'sticky_navigation_menu' ) || woodmart_is_maintenance_active() || wp_is_mobile() && woodmart_get_opt( 'mobile_optimization', 0 ) ) {
			return;
		}

		$title = woodmart_get_opt( 'sticky_navigation_title' );

		if ( ! $title ) {
			$title = esc_html__( 'Menu', 'woodmart' );
		}

		woodmart_enqueue_js_script( 'menu-sticky-offsets' );
		woodmart_enqueue_js_script( 'menu-overlay' );
		?>
			<div class="wd-sticky-nav wd-hide-md">
				<div class="wd-sticky-nav-title">
					<span>
						<?php echo esc_html( $title ); ?>
					</span>
				</div>

				<?php
				wp_nav_menu(
					array(
						'menu'       => woodmart_get_opt( 'sticky_navigation_menu' ),
						'menu_class' => 'menu wd-nav wd-nav-vertical wd-nav-sticky',
						'container'  => '',
						'walker'     => new WOODMART_Mega_Menu_Walker(),
					)
				);
				?>
				<?php if ( woodmart_get_opt( 'sticky_navigation_area' ) || woodmart_get_opt( 'sticky_navigation_html_block' ) ) : ?>
					<div class="wd-sticky-nav-content">
						<?php if ( 'text' === woodmart_get_opt( 'sticky_navigation_content_type', 'text' ) ) : ?>
							<?php echo do_shortcode( woodmart_get_opt( 'sticky_navigation_area' ) ); ?>
						<?php else : ?>
							<?php echo woodmart_get_html_block( woodmart_get_opt( 'sticky_navigation_html_block' ) ); //phpcs:ignore ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php
	}

	/**
	 * Enqueue style.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		if ( ! woodmart_get_opt( 'sticky_navigation_menu' ) ) {
			return;
		}

		woodmart_enqueue_inline_style( 'mod-nav-vertical' );
		woodmart_enqueue_inline_style( 'sticky-nav' );
	}

	/**
	 * Add options.
	 *
	 * @since 1.0.0
	 */
	public function add_options() {
		Options::add_section(
			array(
				'id'       => 'sticky_navigation_section',
				'name'     => esc_html__( 'Sticky navigation', 'woodmart' ),
				'parent'   => 'general_parent_section',
				'priority' => 80,
				'icon'     => 'xts-i-home',
			)
		);

		Options::add_field(
			array(
				'id'       => 'sticky_navigation_notice',
				'type'     => 'notice',
				'style'    => 'info',
				'name'     => '',
				'content'  => esc_html__( 'Before selecting the menu for the "Sticky navigation" option, make sure that images are uploaded. You can configure them via Appearance -> Menus.', 'woodmart' ),
				'section'  => 'sticky_navigation_section',
				'priority' => 10,
			)
		);

		Options::add_field(
			array(
				'id'           => 'sticky_navigation_menu',
				'type'         => 'select',
				'name'         => esc_html__( 'Select menu', 'woodmart' ),
				'hint'         => '<video data-src="' . WOODMART_TOOLTIP_URL . 'sticky-navigation-menu.mp4" autoplay loop muted></video>',
				'empty_option' => true,
				'select2'      => true,
				'options'      => $this->get_menus_array(),
				'section'      => 'sticky_navigation_section',
				'tags'         => esc_html__( 'Sticky navigation', 'woodmart' ),
				'default'      => '',
				'priority'     => 20,
				'class'        => 'xts-tooltip-bordered',
			)
		);

		Options::add_field(
			array(
				'id'       => 'sticky_navigation_title',
				'name'     => esc_html__( 'Title', 'woodmart' ),
				'type'     => 'text_input',
				'section'  => 'sticky_navigation_section',
				'priority' => 25,
				'description' => esc_html__( 'Specify your custom title or leave it empty to keep "Menu".', 'woodmart' ),
			)
		);

		Options::add_field(
			array(
				'id'       => 'sticky_navigation_content_type',
				'name'     => esc_html__( 'Bottom content', 'woodmart' ),
				'hint'     => '<video data-src="' . WOODMART_TOOLTIP_URL . 'sticky-navigation-content-type.mp4" autoplay loop muted></video>',
				'type'     => 'buttons',
				'section'  => 'sticky_navigation_section',
				'options'  => array(
					'text'       => array(
						'name'  => esc_html__( 'Text', 'woodmart' ),
						'value' => 'text',
					),
					'html_block' => array(
						'name'  => esc_html__( 'HTML Block', 'woodmart' ),
						'value' => 'html_block',
					),
				),
				'default'  => 'text',
				'priority' => 30,
				'class'    => 'xts-html-block-switch xts-tooltip-bordered',
			)
		);

		Options::add_field(
			array(
				'id'       => 'sticky_navigation_area',
				'type'     => 'textarea',
				'wysiwyg'  => true,
				'name'     => esc_html__( 'Text', 'woodmart' ),
				'default'  => '',
				'section'  => 'sticky_navigation_section',
				'tags'     => 'prefooter',
				'requires' => array(
					array(
						'key'     => 'sticky_navigation_content_type',
						'compare' => 'equals',
						'value'   => 'text',
					),
				),
				'priority' => 40,
			)
		);

		Options::add_field(
			array(
				'id'           => 'sticky_navigation_html_block',
				'name'         => esc_html__( 'HTML Block', 'woodmart' ),
				'type'         => 'select',
				'section'      => 'sticky_navigation_section',
				'select2'      => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => 'cms_block',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				'requires'     => array(
					array(
						'key'     => 'sticky_navigation_content_type',
						'compare' => 'equals',
						'value'   => 'html_block',
					),
				),
				'priority'     => 40,
			)
		);
	}

	/**
	 * Get all menus.
	 *
	 * @return array
	 */
	private function get_menus_array() {
		$output = array();
		$menus  = wp_get_nav_menus();

		if ( ! $menus ) {
			return $output;
		}

		foreach ( $menus as $menu ) {
			$output[ $menu->slug ] = array(
				'name'  => $menu->name,
				'value' => $menu->slug,
			);
		}

		return $output;
	}

	/**
	 * Added extra class for sticky navigation.
	 *
	 * @param array $classes Body class.
	 *
	 * @return array
	 */
	public function body_class( $classes ) {
		if ( woodmart_get_opt( 'sticky_navigation_menu' ) ) {
			$classes[] = 'wd-sticky-nav-enabled';
		}

		return $classes;
	}

	/**
	 * Add localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function add_localized_settings( $settings ) {
		if ( woodmart_get_opt( 'sticky_navigation_menu' ) ) {
			$settings['clear_menu_offsets_on_resize'] = apply_filters( 'wd_clear_menu_offsets_on_resize', true ) ? 'yes' : 'no';
		}

		return $settings;
	}
}

Main::get_instance();
