<?php

namespace XTS\Inc\Admin\Dashboard;

use XTS\Modules\Patcher\Client;
use XTS\Options;
use XTS\Presets;
use XTS\Setup_Wizard;
use XTS\Singleton;

class Dashboard extends Singleton {
	/**
	 * Constructor.
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_filter( 'views_edit-woodmart_layout', [ $this, 'print_header' ], 9 );
		add_filter( 'views_edit-woodmart_slide', [ $this, 'print_header' ], 9 );
		add_filter( 'views_edit-woodmart_sidebar', [ $this, 'print_header' ], 9 );
		add_filter( 'woodmart_slider_pre_add_form', [ $this, 'print_header' ], 9 );
		add_filter( 'views_edit-cms_block', [ $this, 'print_header' ], 9 );
		add_filter( 'cms_block_cat_pre_add_form', [ $this, 'print_header' ], 9 );
		add_action( 'admin_menu', [ $this, 'add_pages_to_dashboard_menu' ] );
		add_filter( 'admin_body_class', [ $this, 'admin_body_classes' ] );

		if ( current_user_can( apply_filters( 'woodmart_dashboard_theme_links_access', 'administrator' ) ) ) {
			add_action( 'admin_bar_menu', [ $this, 'add_pages_to_admin_bar_menu' ], 100 );
		}
	}

	/**
	 * Get logo url.
	 *
	 * @return string
	 */
	protected function get_logo_url() {
		$logo_url = '';

		$white_label_logo = woodmart_get_opt( 'white_label_sidebar_icon_logo', array( 'url' => '' ) );
		if ( woodmart_get_opt( 'white_label' ) && ! empty( $white_label_logo['url'] ) ) {
			$image_data = woodmart_get_opt( 'white_label_sidebar_icon_logo' );

			if ( isset( $image_data['url'] ) && $image_data['url'] ) {
				$logo_url = wp_get_attachment_image_url( $image_data['id'], 'full' );
			}
		}

		return $logo_url;
	}

	/**
	 * Get theme name.
	 *
	 * @return string
	 */
	protected function get_theme_name() {
		$theme_name = esc_html__( 'WoodMart', 'woodmart' );

		if ( woodmart_get_opt( 'white_label' ) && woodmart_get_opt( 'white_label_theme_name' ) ) {
			$theme_name = woodmart_get_opt( 'white_label_theme_name' );
		}

		return $theme_name;
	}
	/**
	 * Add theme settings links to the admin bar.
	 *
	 * @since 1.0.0
	 *
	 * @param object $admin_bar Admin bar object.
	 */
	public function add_pages_to_admin_bar_menu( $admin_bar ) {
		if ( ! woodmart_get_opt( 'theme_admin_bar_menu', true ) ) {
			return;
		}

		$theme_name    = $this->get_theme_name();
		$admin_bar_img = '';

		if ( $this->get_logo_url() ) {
			$admin_bar_img = '<img src="' . esc_url( $this->get_logo_url() ) . '" alt="icon">';
		}

		$admin_bar->add_node(
			array(
				'id'    => 'xts_dashboard',
				'title' => $admin_bar_img . $theme_name,
				'href'  => admin_url( 'admin.php?page=xts_dashboard' ),
				'meta'  => array(
					'title' => $theme_name,
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_theme_settings',
				'title'  => '<i class="xts-i-theme-settings"></i>' . esc_html__( 'Theme settings', 'woodmart' ),
				'href'   => admin_url( 'admin.php?page=xts_theme_settings' ),
				'parent' => 'xts_dashboard',
				'meta'   => array(
					'title' => esc_html__( 'Theme settings', 'woodmart' ),
				),
			)
		);

		foreach ( Options::get_sections() as $key => $section ) {
			if ( isset( $section['parent'] ) ) {
				continue;
			}

			$admin_bar->add_node(
				array(
					'id'     => 'wd_' . $section['id'],
					'title'  => '<i class="' . $section['icon'] . '"></i>' . $section['name'],
					'href'   => admin_url( 'admin.php?page=xts_theme_settings&tab=' . $key ),
					'parent' => 'xts_theme_settings',
				)
			);
		}

		$active_presets = Presets::get_active_presets();
		if ( $active_presets ) {
			$admin_bar->add_node(
				array(
					'id'     => 'xts_theme_settings_presets_active',
					'title'  => '<i class="xts-i-cog"></i>' . esc_html__( 'Active presets', 'woodmart' ),
					'href'   => admin_url( 'admin.php?page=xts_theme_settings_presets' ),
					'parent' => 'xts_dashboard',
					'meta'   => array(
						'title' => esc_html__( 'Active theme settings presets', 'woodmart' ),
					),
				)
			);

			foreach ( $active_presets as $preset_id ) {
				$all_presets = Presets::get_all();

				$admin_bar->add_node(
					array(
						'id'     => 'xts_theme_settings_presets_active_' . $preset_id,
						'title'  => $all_presets[ $preset_id ]['name'],
						'href'   => admin_url( 'admin.php?page=xts_theme_settings&preset=' . $preset_id ),
						'parent' => 'xts_theme_settings_presets_active',
						'meta'   => array(
							'title' => $all_presets[ $preset_id ]['name'],
						),
					)
				);
			}
		}

		$admin_bar->add_node(
			array(
				'id'     => 'xts_header_builder',
				'title'  => '<i class="xts-i-header-builder"></i>' . esc_html__( 'Header builder', 'woodmart' ),
				'href'   => admin_url( 'admin.php?page=xts_header_builder' ),
				'parent' => 'xts_dashboard',
				'meta'   => array(
					'title' => esc_html__( 'Header builder', 'woodmart' ),
				),
			)
		);

		$header_object = whb_get_header();

		if ( $header_object && ! is_admin() ) {
			$admin_bar->add_node(
				array(
					'id'     => 'xts_header_builder_edit',
					'title'  => esc_html__( 'Edit current header', 'woodmart' ),
					'href'   => admin_url( 'admin.php?page=xts_header_builder#/builder/' . $header_object->get_id() ),
					'parent' => 'xts_header_builder',
					'meta'   => array(
						'title' => $header_object->get_name(),
					),
				)
			);
		}

		if ( woodmart_get_opt( 'dummy_import', '1' ) ) {
			$admin_bar->add_node(
				array(
					'id'     => 'xts_prebuilt_websites',
					'title' => '<i class="xts-i-dummy-content"></i>' . esc_html__('Prebuilt websites', 'woodmart'),
					'href'   => admin_url( 'admin.php?page=xts_prebuilt_websites' ),
					'parent' => 'xts_dashboard',
					'meta'   => array(
						'title' => esc_html__( 'Prebuilt websites', 'woodmart' ),
					),
				)
			);
		}

		$admin_bar->add_node(
			array(
				'id'     => 'xts_layouts',
				'title'  => '<i class="xts-i-layouts"></i>' . esc_html__( 'Layouts', 'woodmart' ),
				'href'   => admin_url( 'edit.php?post_type=woodmart_layout' ),
				'parent' => 'xts_dashboard',
				'meta'   => array(
					'title' => esc_html__( 'Layouts', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_sliders',
				'title'  => '<i class="xts-i-slides"></i>' . esc_html__( 'Sliders', 'woodmart' ),
				'href'   => admin_url( 'edit-tags.php?taxonomy=woodmart_slider&post_type=woodmart_slide' ),
				'parent' => 'xts_dashboard',
				'meta'   => array(
					'title' => esc_html__( 'Sliders', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_slides',
				'title'  => esc_html__( 'Slides', 'woodmart' ),
				'href'   => admin_url( 'edit.php?post_type=woodmart_slide' ),
				'parent' => 'xts_sliders',
				'meta'   => array(
					'title' => esc_html__( 'Slides', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_slides_add',
				'title'  => esc_html__( 'Add new slide', 'woodmart' ),
				'href'   => admin_url( 'post-new.php?post_type=woodmart_slide' ),
				'parent' => 'xts_sliders',
				'meta'   => array(
					'title' => esc_html__( 'Add new', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_html_block',
				'title'  => '<i class="xts-i-html-block"></i>' . esc_html__( 'HTML Block', 'woodmart' ),
				'href'   => admin_url( 'edit.php?post_type=cms_block' ),
				'parent' => 'xts_dashboard',
				'meta'   => array(
					'title' => esc_html__( 'HTML Block', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_html_block_category',
				'title'  => esc_html__( 'Categories', 'woodmart' ),
				'href'   => admin_url( 'edit-tags.php?taxonomy=cms_block_cat&post_type=cms_block' ),
				'parent' => 'xts_html_block',
				'meta'   => array(
					'title' => esc_html__( 'Add new', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_html_block_add',
				'title'  => esc_html__( 'Add new', 'woodmart' ),
				'href'   => admin_url( 'post-new.php?post_type=cms_block' ),
				'parent' => 'xts_html_block',
				'meta'   => array(
					'title' => esc_html__( 'Add new', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_sidebars',
				'title'  => '<i class="xts-i-sidebars"></i>' . esc_html__( 'Sidebars', 'woodmart' ),
				'href'   => admin_url( 'edit.php?post_type=woodmart_sidebar' ),
				'parent' => 'xts_dashboard',
				'meta'   => array(
					'title' => esc_html__( 'Sidebars', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'xts_sidebars_add',
				'title'  => esc_html__( 'Add new', 'woodmart' ),
				'href'   => admin_url( 'post-new.php?post_type=woodmart_sidebar' ),
				'parent' => 'xts_sidebars',
				'meta'   => array(
					'title' => esc_html__( 'Add new', 'woodmart' ),
				),
			)
		);

		$admin_bar->add_group(
			array(
				'parent' => 'xts_dashboard',
				'id'     => 'xts_dashboard_external',
				'meta'   => array(
					'class' => 'ab-sub-secondary',
				),
			)
		);

		if ( woodmart_get_opt( 'white_label_theme_license_tab', '1' ) ) {
			$admin_bar->add_node(
				array(
					'parent' => 'xts_dashboard_external',
					'id' => 'xts_license',
					'title' => '<i class="xts-i-key"></i>' . esc_html__('Theme license', 'woodmart'),
					'href' => admin_url('admin.php?page=xts_license'),
				)
			);
		}

		$admin_bar->add_node(
			array(
				'parent' => 'xts_dashboard_external',
				'id'     => 'xts_plugins',
				'title'  => '<i class="xts-i-puzzle"></i>' . esc_html__( 'Plugins', 'woodmart' ),
				'href'   => admin_url( 'admin.php?page=xts_plugins' ),
			)
		);

		$patches_count = class_exists( 'XTS\Modules\Patcher\Client' ) ? Client::get_instance()->get_count_patches_map() : '';

		$admin_bar->add_node(
			array(
				'parent' => 'xts_dashboard_external',
				'id'     => 'xts_patcher',
				'title'  => '<i class="xts-i-cog"></i>' . esc_html__( 'Patcher', 'woodmart' ) . $patches_count,
				'href'   => admin_url( 'admin.php?page=xts_patcher' ),
			)
		);
	}

	/**
	 * Add pages to dashboard menu.
	 */
	public function add_pages_to_dashboard_menu() {
		global $menu, $submenu;

		$theme_name = $this->get_theme_name();

		$separator_position = '31.1';

		if ( isset( $menu[ $separator_position ] ) ) {
			$separator_position = $separator_position + base_convert( substr( md5( 'separator-xts_dashboard' . 'wp-menu-separator xts-dashboard' ), -4 ), 16, 10 ) * 0.00001;
		}

		$menu[ $separator_position ] = array( '', 'read', 'separator-xts_dashboard', '', 'wp-menu-separator xts-dashboard' );

		add_menu_page(
			$theme_name,
			$theme_name,
			apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_dashboard' ),
			'xts_dashboard',
			[ $this, 'page_content' ],
			$this->get_logo_url(),
			31.2
		);

		add_submenu_page(
			'xts_dashboard',
			esc_html__( 'Theme settings', 'woodmart' ),
			esc_html__( 'Theme settings', 'woodmart' ),
			apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_theme_settings' ),
			'xts_theme_settings',
			[ $this, 'page_content' ],
			1
		);

		add_submenu_page(
			'xts_dashboard',
			esc_html__( 'Theme settings backup', 'woodmart' ),
			esc_html__( 'Theme settings backup', 'woodmart' ),
			'manage_options',
			'xts_theme_settings_backup',
			[ $this, 'page_content' ],
			1
		);

		add_submenu_page(
			'xts_dashboard',
			esc_html__( 'Theme settings presets', 'woodmart' ),
			esc_html__( 'Theme settings presets', 'woodmart' ),
			'manage_options',
			'xts_theme_settings_presets',
			[ $this, 'page_content' ],
			2
		);

		add_submenu_page(
			'xts_dashboard',
			esc_html__( 'Header builder', 'woodmart' ),
			esc_html__( 'Header builder', 'woodmart' ),
			apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_header_builder' ),
			'xts_header_builder',
			[ $this, 'page_content' ],
			3
		);

		if ( woodmart_get_opt( 'dummy_import', '1' ) ) {
			add_submenu_page(
				'xts_dashboard',
				esc_html__( 'Prebuilt websites', 'woodmart' ),
				esc_html__( 'Prebuilt websites', 'woodmart' ),
				apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_prebuilt_websites' ),
				'xts_prebuilt_websites',
				[ $this, 'page_content' ],
				4
			);
		}

		if ( woodmart_get_opt( 'white_label_theme_license_tab', '1' ) ) {
			add_submenu_page(
				'xts_dashboard',
				esc_html__( 'Theme license', 'woodmart' ),
				esc_html__( 'Theme license', 'woodmart' ),
				apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_license' ),
				'xts_license',
				[ $this, 'page_content' ],
				5
			);
		}

		add_submenu_page(
			'xts_dashboard',
			esc_html__( 'Plugins', 'woodmart' ),
			esc_html__( 'Plugins', 'woodmart' ),
			apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'plugins' ),
			'xts_plugins',
			[ $this, 'page_content' ],
			6
		);

		$patches_count = class_exists( 'XTS\Modules\Patcher\Client' ) ? Client::get_instance()->get_count_patches_map() : '';

		add_submenu_page(
			'xts_dashboard',
			esc_html__( 'Patcher', 'woodmart' ),
			esc_html__( 'Patcher', 'woodmart' ) . $patches_count,
			apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_patcher' ),
			'xts_patcher',
			[ $this, 'page_content' ],
			7
		);

		add_submenu_page(
			'xts_dashboard',
			esc_html__( 'Status', 'woodmart' ),
			esc_html__( 'Status', 'woodmart' ),
			apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_status' ),
			'xts_status',
			[ $this, 'page_content' ],
			8
		);

		if ( woodmart_get_opt( 'white_label_changelog_tab', '1' ) ) {
			add_submenu_page(
				'xts_dashboard',
				esc_html__('Changelog', 'woodmart'),
				esc_html__('Changelog', 'woodmart'),
				apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_changelog' ),
				'xts_changelog',
				[$this, 'page_content'],
				9
			);
		}

		if ( 'wpb' === woodmart_get_current_page_builder() ) {
			add_submenu_page(
				'xts_dashboard',
				esc_html__( 'WPBakery CSS Generator', 'woodmart' ),
				esc_html__( 'WPBakery CSS Generator', 'woodmart' ),
				apply_filters( 'woodmart_capability_menu_page', 'manage_options', 'xts_wpb_css_generator' ),
				'xts_wpb_css_generator',
				[ $this, 'page_content' ],
				10
			);
		}

		add_menu_page(
			esc_html__( 'Theme settings', 'woodmart' ),
			esc_html__( 'Theme settings', 'woodmart' ),
			'manage_options',
			'xts_theme_settings',
			[ $this, 'page_content' ],
			'',
			31.3
		);

		foreach ( Options::get_sections() as $key => $section ) {
			if ( isset( $section['parent'] ) ) {
				continue;
			}

			add_submenu_page(
				'xts_theme_settings',
				$section['name'],
				$section['name'],
				'manage_options',
				'xts_theme_settings&tab=' . $key,
				[ $this, 'page_content' ]
			);
			
			
			
		}

		if ( current_user_can( 'manage_options' ) ) {
			// Hide submenu pages in woodmart dashboard menu.
			$hide_submenu = array( 'xts_theme_settings_backup', 'xts_theme_settings_presets' );

			foreach ( $submenu['xts_dashboard'] as $key => $xts_dashboard_submenu ) {
				if ( in_array( $xts_dashboard_submenu[2], $hide_submenu, true ) ) {
					$submenu['xts_dashboard'][ $key ][4] = 'xts-hidden'; // phpcs:ignore.
				}
			}
		}
	}

	/**
	 * Get page content callback.
	 */
	public function page_content() {
		$current_page = isset( $_GET['page'] ) ? wp_unslash( $_GET['page'] ) : ''; // phpcs:ignore
		$wizard       = Setup_Wizard::get_instance();

		if ( ! in_array( $current_page, $this->get_allowed_pages(), true ) ) {
			return;
		}

		if ( $wizard->is_setup() && 'done' !== get_option( 'woodmart_setup_status' ) ) {
			$wizard->setup_wizard_template();
			$this->print_footer();
			return;
		}

		do_action( 'xts_dashboard_before_page' );

		$this->print_header();
		$this->print_template( $current_page );
		$this->print_footer();
	}

	/**
	 * Get allowed pages.
	 *
	 * @return array
	 */
	protected function get_allowed_pages() {
		return [
			'xts_dashboard',
			'xts_theme_settings_backup',
			'xts_theme_settings_presets',
			'xts_theme_settings',
			'xts_prebuilt_websites',
			'xts_header_builder',
			'xts_license',
			'xts_wpb_css_generator',
			'xts_patcher',
			'xts_changelog',
			'xts_plugins',
			'xts_status',
		];
	}

	/**
	 * Get allowed post types.
	 *
	 * @return array
	 */
	protected function get_allowed_post_types() {
		return [
			'woodmart_layout',
			'woodmart_slide',
			'woodmart_sidebar',
			'cms_block',
		];
	}

	/**
	 * Print header.
	 *
	 * @param array $views Views.
	 *
	 * @return array|false
	 */
	public function print_header( $views = false ) {
		$this->print_template( 'header' );

		return $views;
	}

	/**
	 * Print footer.
	 */
	public function print_footer() {
		$this->print_template( 'footer' );
	}

	/**
	 * Print template file.
	 *
	 * @param string $name Template name.
	 */
	public function print_template( $name ) {
		include_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/admin/dashboard/templates/' . $name . '.php' );
	}

	/**
	 * Add custom class to body.
	 *
	 * @param string $classes Body classes.
	 *
	 * @return string
	 */
	public function admin_body_classes( $classes ) {
		global $hook_suffix;

		$current_page      = isset( $_GET['page'] ) ? wp_unslash( $_GET['page'] ) : ''; // phpcs:ignore
		$current_post_type = isset( $_GET['post_type'] ) ? wp_unslash( $_GET['post_type'] ) : ''; // phpcs:ignore

		if ( in_array( $current_page, $this->get_allowed_pages(), true ) || ( ( 'edit.php' === $hook_suffix || 'edit-tags.php' === $hook_suffix ) && in_array( $current_post_type, $this->get_allowed_post_types(), true ) ) ) {
			$classes = wd_add_cssclass( 'xts-pages', $classes );
		}

		if ( Setup_Wizard::get_instance()->is_setup() && 'done' !== get_option( 'woodmart_setup_status' ) ) {
			$classes = wd_add_cssclass( 'xts-wizard', $classes );
		}

		$white_label_logo = woodmart_get_opt( 'white_label_sidebar_icon_logo', array( 'url' => '' ) );

		if ( woodmart_get_opt( 'white_label' ) && ! empty( $white_label_logo['url'] ) ) {
			$classes = wd_add_cssclass( 'wd-white-label-img', $classes );
		}

		return $classes;
	}
}

Dashboard::get_instance();