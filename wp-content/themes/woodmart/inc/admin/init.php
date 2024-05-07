<?php
/**
 * This file enqueue scripts and styles for admin.
 *
 * @package Woodmart
 */

use XTS\Google_Fonts;
use XTS\Import\Helpers;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_theme_settings_search_data' ) ) {
	/**
	 * Get theme settings search data.
	 */
	function woodmart_get_theme_settings_search_data() {
		check_ajax_referer( 'woodmart-get-theme-settings-data-nonce', 'security' );

		$all_fields   = XTS\Options::get_fields();
		$all_sections = XTS\Options::get_sections();

		$options_data = array();
		foreach ( $all_fields as $field ) {
			$section_id = $field->args['section'];
			$section    = $all_sections[ $section_id ];

			if ( isset( $section['parent'] ) ) {
				$path = $all_sections[ $section['parent'] ]['name'] . ' -> ' . $section['name'];
			} else {
				$path = $section['name'];
			}

			$text = isset( $field->args['name'] ) ? $field->args['name'] : '';
			if ( isset( $field->args['description'] ) ) {
				$text .= ' ' . $field->args['description'];
			}
			if ( isset( $field->args['tags'] ) ) {
				$text .= ' ' . $field->args['tags'];
			}

			$options_data[] = array(
				'id'         => $field->args['id'],
				'title'      => isset( $field->args['name'] ) ? $field->args['name'] : '',
				'text'       => $text,
				'section_id' => $section['id'],
				'icon'       => isset( $section['icon'] ) ? $section['icon'] : $all_sections[ $section['parent'] ]['icon'],
				'path'       => $path,
			);
		}

		wp_send_json(
			array(
				'theme_settings' => $options_data,
			)
		);
	}

	add_action( 'wp_ajax_woodmart_get_theme_settings_search_data', 'woodmart_get_theme_settings_search_data' );
}

if ( ! function_exists( 'woodmart_get_theme_settings_typography_data' ) ) {
	/**
	 * Get theme settings typography data.
	 */
	function woodmart_get_theme_settings_typography_data() {
		check_ajax_referer( 'woodmart-get-theme-settings-data-nonce', 'security' );

		$custom_fonts_data = woodmart_get_opt( 'multi_custom_fonts' );
		$custom_fonts      = array();
		if ( isset( $custom_fonts_data['{{index}}'] ) ) {
			unset( $custom_fonts_data['{{index}}'] );
		}

		if ( is_array( $custom_fonts_data ) ) {
			foreach ( $custom_fonts_data as $font ) {
				if ( ! $font['font-name'] ) {
					continue;
				}

				$custom_fonts[ $font['font-name'] ] = $font['font-name'];
			}
		}

		$typekit_fonts = woodmart_get_opt( 'typekit_fonts' );

		if ( $typekit_fonts ) {
			$typekit = explode( ',', $typekit_fonts );
			foreach ( $typekit as $font ) {
				$custom_fonts[ ucfirst( trim( $font ) ) ] = trim( $font );
			}
		}

		wp_send_json(
			array(
				'typography' => array(
					'stdfonts'    => woodmart_get_config( 'standard-fonts' ),
					'googlefonts' => Google_Fonts::$all_google_fonts,
					'customFonts' => $custom_fonts,
				),
			)
		);
	}

	add_action( 'wp_ajax_woodmart_get_theme_settings_typography_data', 'woodmart_get_theme_settings_typography_data' );
}

if ( ! function_exists( 'woodmart_admin_wpb_scripts' ) ) {
	/**
	 * Add scripts for WPB fields.
	 */
	function woodmart_admin_wpb_scripts() {
		if ( 'wpb' !== woodmart_get_current_page_builder() ) {
			return;
		}

		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			wp_enqueue_script( 'wd-wpb-colorpicker-gradient', WOODMART_ASSETS . '/js/libs/colorpicker.min.js', array(), WOODMART_VERSION, true );
			wp_enqueue_script( 'wd-wpb-gradient', WOODMART_ASSETS . '/js/libs/gradX.min.js', array(), WOODMART_VERSION, true );
		}

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-datetimepicker', WOODMART_ASSETS . '/js/libs/datetimepicker.min.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wp-color-picker-alpha', WOODMART_ASSETS . '/js/libs/wp-color-picker-alpha.js', array( 'wp-color-picker' ), woodmart_get_theme_info( 'Version' ), true );

		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wd-wpb-slider', WOODMART_ASSETS . '/js/vc-fields/slider.js', array(), WOODMART_VERSION, true );

		wp_enqueue_script( 'wd-wpb-image-hotspot', WOODMART_ASSETS . '/js/vc-fields/image-hotspot.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-title-divider', WOODMART_ASSETS . '/js/vc-fields/title-divider.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-responsive-size', WOODMART_ASSETS . '/js/vc-fields/responsive-size.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-responsive-spacing', WOODMART_ASSETS . '/js/vc-fields/responsive-spacing.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-image-select', WOODMART_ASSETS . '/js/vc-fields/image-select.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-colorpicker', WOODMART_ASSETS . '/js/vc-fields/colorpicker.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-datepicker', WOODMART_ASSETS . '/js/vc-fields/datepicker.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-switch', WOODMART_ASSETS . '/js/vc-fields/switch.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-button-set', WOODMART_ASSETS . '/js/vc-fields/button-set.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-functions', WOODMART_ASSETS . '/js/vc-fields/vc-functions.js', array(), WOODMART_VERSION, true );

		wp_enqueue_script( 'wd-wpb-slider-responsive', WOODMART_ASSETS . '/js/vc-fields/slider-responsive.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-number', WOODMART_ASSETS . '/js/vc-fields/number.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-colorpicker-new', WOODMART_ASSETS . '/js/vc-fields/wd-colorpicker.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-box-shadow', WOODMART_ASSETS . '/js/vc-fields/box-shadow.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-select', WOODMART_ASSETS . '/js/vc-fields/select.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-dimensions', WOODMART_ASSETS . '/js/vc-fields/dimensions.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-list-element', WOODMART_ASSETS . '/js/vc-fields/list-element.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-wpb-templates', WOODMART_ASSETS . '/js/vc-templates.js', array(), WOODMART_VERSION, true );
	}

	add_action( 'vc_backend_editor_render', 'woodmart_admin_wpb_scripts' );
	add_action( 'vc_frontend_editor_render', 'woodmart_admin_wpb_scripts' );
}

if ( ! function_exists( 'woodmart_admin_wpb_styles' ) ) {
	/**
	 * Add styles for WPB fields.
	 */
	function woodmart_admin_wpb_styles() {
		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			wp_enqueue_style( 'wd-wpb-colorpicker-gradient', WOODMART_ASSETS . '/css/colorpicker.css', array(), WOODMART_VERSION );
			wp_enqueue_style( 'wd-wpb-gradient', WOODMART_ASSETS . '/css/gradX.css', array(), WOODMART_VERSION );
		}

		wp_enqueue_style( 'wd-jquery-ui', WOODMART_ASSETS . '/css/jquery-ui.css', array(), WOODMART_VERSION );
	}

	add_action( 'vc_backend_editor_render', 'woodmart_admin_wpb_styles' );
	add_action( 'vc_frontend_editor_render', 'woodmart_admin_wpb_styles' );
}


if ( ! function_exists( 'woodmart_wpb_frontend_editor_enqueue_scripts' ) ) {
	/**
	 * WPB frontend editor scripts.
	 */
	function woodmart_wpb_frontend_editor_enqueue_scripts() {
		woodmart_enqueue_js_library( 'cookie' );
		wp_enqueue_script( 'wd-wpb-frontend-editor', WOODMART_ASSETS . '/js/vc-fields/frontend-editor-functions.js', array(), WOODMART_VERSION, true );
	}

	add_action( 'vc_frontend_editor_enqueue_js_css', 'woodmart_wpb_frontend_editor_enqueue_scripts' );
}

if ( ! function_exists( 'woodmart_enqueue_widgets_admin_scripts' ) ) {
	/**
	 * Enqueue a scripts.
	 */
	function woodmart_enqueue_widgets_admin_scripts() {
		wp_enqueue_script( 'select2', WOODMART_ASSETS . '/js/libs/select2.full.min.js', array(), woodmart_get_theme_info( 'Version' ), true );
		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
	}

	add_action( 'widgets_admin_page', 'woodmart_enqueue_widgets_admin_scripts' );
}

if ( ! function_exists( 'woodmart_enqueue_admin_scripts' ) ) {
	/**
	 * Enqueue a scripts.
	 */
	function woodmart_enqueue_admin_scripts() {
		global $pagenow;

		wp_enqueue_script( 'woodmart-admin-scripts', WOODMART_ASSETS . '/js/admin.js', array(), WOODMART_VERSION, true );

		$localize_data = array(
			'searchOptionsPlaceholder'           => esc_js( __( 'Search for options', 'woodmart' ) ),
			'ajaxUrl'                            => admin_url( 'admin-ajax.php' ),
			'demoAjaxUrl'                        => WOODMART_DEMO_URL . 'wp-admin/admin-ajax.php',
			'activate_plugin_btn_text'           => esc_html__( 'Activate', 'woodmart' ),
			'update_plugin_btn_text'             => esc_html__( 'Update', 'woodmart' ),
			'deactivate_plugin_btn_text'         => esc_html__( 'Deactivate', 'woodmart' ),
			'install_plugin_btn_text'            => esc_html__( 'Install', 'woodmart' ),
			'activate_process_plugin_btn_text'   => esc_html__( 'Activating', 'woodmart' ),
			'update_process_plugin_btn_text'     => esc_html__( 'Updating', 'woodmart' ),
			'deactivate_process_plugin_btn_text' => esc_html__( 'Deactivating', 'woodmart' ),
			'install_process_plugin_btn_text'    => esc_html__( 'Installing', 'woodmart' ),
			'animate_it_btn_text'                => esc_html__( 'Animate it', 'woodmart' ),
			'remove_backup_text'                 => esc_html__( 'Are you sure you want to remove backup? This process cannot be undone. Continue?', 'woodmart' ),
			'apply_backup_text'                  => esc_html__( 'Are you sure you want to apply backup? This process cannot be undone. Continue?', 'woodmart' ),
			'wd_layout_type'                     => 'post.php' === $pagenow && isset( $_GET['post'] ) ? get_post_meta( woodmart_clean( $_GET['post'] ),'wd_layout_type', true ) : '', // phpcs:ignore
			'current_page_builder'               => woodmart_get_current_page_builder(),
			'import_base_versions_name'          => implode( ',', Helpers::get_instance()->get_base_version() ),
		);
		
		if ( current_user_can( 'administrator' ) ) {
			$localize_data = array_merge($localize_data, array(
				'deactivate_plugin_nonce'            => wp_create_nonce( 'woodmart_deactivate_plugin_nonce' ),
				'check_plugins_nonce'                => wp_create_nonce( 'woodmart_check_plugins_nonce' ),
				'install_child_theme_nonce'          => wp_create_nonce( 'woodmart_install_child_theme_nonce' ),
				'get_builder_elements_nonce'         => wp_create_nonce( 'woodmart-get-builder-elements-nonce' ),
				'get_builder_element_nonce'          => wp_create_nonce( 'woodmart-get-builder-element-nonce' ),
				'builder_load_header_nonce'          => wp_create_nonce( 'woodmart-builder-load-header-nonce' ),
				'builder_save_header_nonce'          => wp_create_nonce( 'woodmart-builder-save-header-nonce' ),
				'builder_remove_header_nonce'        => wp_create_nonce( 'woodmart-builder-remove-header-nonce' ),
				'builder_set_default_header_nonce'   => wp_create_nonce( 'woodmart-builder-set-default-header-nonce' ),
				'presets_nonce'                      => wp_create_nonce( 'xts_presets_nonce' ),
				'import_nonce'                       => wp_create_nonce( 'woodmart-import-nonce' ),
				'backup_nonce'                       => wp_create_nonce( 'xts_backup_nonce' ),
				'import_remove_nonce'                => wp_create_nonce( 'woodmart-import-remove-nonce' ),
				'mega_menu_added_thumbnail_nonce'    => wp_create_nonce( 'woodmart-mega-menu-added-thumbnail-nonce' ),
				'get_hotspot_image_nonce'            => wp_create_nonce( 'woodmart-get-hotspot-image-nonce' ),
				'get_theme_settings_data_nonce'      => wp_create_nonce( 'woodmart-get-theme-settings-data-nonce' ),
				'get_new_template_nonce'             => wp_create_nonce( 'wd-new-template-nonce' ),
				'patcher_nonce'                      => wp_create_nonce( 'patcher_nonce' ),
				'bought_together_nonce'              => wp_create_nonce( 'bought_together_nonce' ),
				'get_slides_nonce'                   => wp_create_nonce( 'woodmart-get-slides-nonce' )
			));
		}

		wp_localize_script( 'woodmart-admin-scripts', 'woodmartConfig', apply_filters( 'woodmart_admin_localized_string_array', $localize_data ) );
	}

	add_action( 'admin_init', 'woodmart_enqueue_admin_scripts', 100 );
}

if ( ! function_exists( 'woodmart_enqueue_admin_styles' ) ) {
	/**
	 * Enqueue a CSS stylesheets.
	 */
	function woodmart_enqueue_admin_styles() {
		wp_enqueue_style( 'wd-admin-base', WOODMART_ASSETS . '/css/parts/base.min.css', array(), WOODMART_VERSION );

		if ( 'wpb' === woodmart_get_current_page_builder() ) {
			wp_enqueue_style( 'wd-admin-int-wpbakery', WOODMART_ASSETS . '/css/parts/int-wpbakery.min.css', array(), WOODMART_VERSION );
		}

		if ( isset( $_GET['taxonomy'] ) && 'woodmart_slider' === $_GET['taxonomy'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-slider', WOODMART_ASSETS . '/css/parts/page-slider.min.css', array(), WOODMART_VERSION );
		}

		if ( isset( $_GET['tab'] ) && 'wizard' === $_GET['tab'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-setup-wizard', WOODMART_ASSETS . '/css/parts/page-setup-wizard.min.css', array(), WOODMART_VERSION );
		}

		if ( isset( $_GET['page'] ) && 'xts_license' === $_GET['page'] || isset( $_GET['tab'], $_GET['step'] ) && 'activation' === $_GET['step'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-theme-license', WOODMART_ASSETS . '/css/parts/page-theme-license.min.css', array(), WOODMART_VERSION );
		}

		if ( isset( $_GET['page'] ) && 'xts_plugins' === $_GET['page'] || isset( $_GET['tab'], $_GET['step'] ) && 'plugins' === $_GET['step'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-plugins', WOODMART_ASSETS . '/css/parts/page-plugins.min.css', array(), WOODMART_VERSION );
		}

		if ( isset( $_GET['page'] ) && 'xts_prebuilt_websites' === $_GET['page'] || isset( $_GET['tab'], $_GET['step'] ) && 'prebuilt-websites' === $_GET['step'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-dummy-content', WOODMART_ASSETS . '/css/parts/page-dummy-content.min.css', array(), WOODMART_VERSION );
		}

		if ( isset( $_GET['page'] ) && 'product_attributes' === $_GET['page'] || isset( $_GET['post_type'], $_GET['taxonomy'] ) && 'product' === $_GET['post_type'] && 'product_cat' !== $_GET['taxonomy'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-int-woo-page-attributes', WOODMART_ASSETS . '/css/parts/int-woo-page-attributes.min.css', array(), WOODMART_VERSION );
		}

		if ( isset( $_GET['post_type'], $_GET['taxonomy'] ) && ( 'product_cat' === $_GET['taxonomy'] || 'cms_block_cat' === $_GET['taxonomy'] ) ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-int-woo-page-categories', WOODMART_ASSETS . '/css/parts/int-woo-page-categories.min.css', array(), WOODMART_VERSION );
		}

		if ( ! isset( $_GET['page'] ) ) { //phpcs:ignore
			return;
		}

		if ( 'xts_dashboard' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-welcome', WOODMART_ASSETS . '/css/parts/page-welcome.min.css', array(), WOODMART_VERSION );
		}

		if ( 'xts_theme_settings' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-theme-settings', WOODMART_ASSETS . '/css/parts/page-theme-settings.min.css', array(), WOODMART_VERSION );
		}

		if ( 'xts_theme_settings_presets' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-presets', WOODMART_ASSETS . '/css/parts/page-presets.min.css', array(), WOODMART_VERSION );
		}

		if ( 'xts_theme_settings_backup' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-backup', WOODMART_ASSETS . '/css/parts/page-backup.min.css', array(), WOODMART_VERSION );
		}

		if ( 'xts_patcher' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-patcher', WOODMART_ASSETS . '/css/parts/page-patcher.min.css', array(), WOODMART_VERSION );
		}

		if ( 'xts_status' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-status', WOODMART_ASSETS . '/css/parts/page-status.min.css', array(), WOODMART_VERSION );
		}

		if ( 'xts_wpb_css_generator' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-css-generator', WOODMART_ASSETS . '/css/parts/page-css-generator.min.css', array(), WOODMART_VERSION );
		}

		if ( 'xts_header_builder' === $_GET['page'] ) { //phpcs:ignore
			wp_enqueue_style( 'wd-admin-page-header-builder', WOODMART_ASSETS . '/css/parts/page-header-builder.min.css', array(), WOODMART_VERSION );
		}
	}

	add_action( 'admin_enqueue_scripts', 'woodmart_enqueue_admin_styles' );
}

if ( ! function_exists( 'woodmart_admin_custom_css_file' ) ) {
	/**
	 * This function creates and includes a custom CSS for the WordPress admin panel when the css_backend option is passed.
	 *
	 * @return void
	 */
	function woodmart_admin_custom_css_file() {
		$css_backend = woodmart_get_opt( 'css_backend' );

		if ( ! $css_backend ) {
			return;
		}

		$storage = new WOODMART_Stylesstorage( 'admin-custom' );
		$storage->write( $css_backend, false );
		$storage->inline_css();
	}

	add_action( 'xts_after_theme_settings', 'woodmart_admin_custom_css_file', 100 );
}

if ( ! function_exists( 'woodmart_get_html_block_links' ) ) {
	/**
	 * Get html block links.
	 *
	 * @return false|string
	 */
	function woodmart_get_html_block_links() {
		wp_enqueue_script( 'woodmart-admin-html-block-edit-link', WOODMART_ASSETS . '/js/htmlBlockEditLink.js', array(), WOODMART_VERSION, true );

		ob_start();
		?>
		<span class="xts-block-link-wrap">
			<a href="<?php echo esc_url( admin_url( 'post.php?post=' ) ); ?>" class="xts-block-link xts-edit-block-link xts-i-edit-write" style="display:none;" target="_blank">
				<?php esc_html_e( 'Edit this block with Page Builder', 'woodmart' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cms_block' ) ); ?>" class="xts-block-link xts-add-block-link xts-i-expand" target="_blank">
				<?php esc_html_e( 'Create new HTML Block', 'woodmart' ); ?>
			</a>
		</span>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_update_tgmpa_link' ) ) {
	/**
	 * Update tgmpa link actions.
	 *
	 * @param string $action_link Action link.
	 * @return string|void
	 */
	function woodmart_update_tgmpa_link( $action_link ) {
		return admin_url( 'admin.php?page=xts_plugins' );
	}

	add_filter( 'woodmart_tgmpa_install_link', 'woodmart_update_tgmpa_link' );
	add_filter( 'woodmart_tgmpa_update_link', 'woodmart_update_tgmpa_link' );
	add_filter( 'woodmart_tgmpa_activate_link', 'woodmart_update_tgmpa_link' );
}

if ( ! function_exists( 'woodmart_get_compatible_plugin_btn' ) ) {
	/**
	 * Get data button action from plugins status.
	 *
	 * @param string $plugin Plugins slug.
	 * @return array
	 */
	function woodmart_get_compatible_plugin_btn( $plugin ) {
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$btn_text = esc_html__( 'Install', 'woodmart' );
		$btn_url  = '#';
		$classes  = 'xts-install';
		$status   = install_plugin_install_status(
			plugins_api(
				'plugin_information',
				array(
					'slug'   => $plugin,
					'fields' => array(
						'sections' => false,
					),
				)
			)
		);

		switch ( $status['status'] ) {
			case 'install':
				if ( $status['url'] ) {
					$btn_url = $status['url'];
				}
				break;

			case 'update_available':
				if ( $status['url'] ) {
					$btn_text = esc_html__( 'Update', 'woodmart' );
					$btn_url  = $status['url'];
					$classes  = 'xts-update';
				}
				break;

			case 'latest_installed':
			case 'newer_installed':
				if ( is_plugin_active( $status['file'] ) ) {
					$btn_text = esc_html__( 'Deactivate', 'woodmart' );
					$btn_url  = add_query_arg(
						array(
							'_wpnonce' => wp_create_nonce( 'deactivate-plugin_' . $status['file'] ),
							'action'   => 'deactivate',
							'plugin'   => $status['file'],
						),
						network_admin_url( 'plugins.php' )
					);
					$classes  = 'xts-deactivate';
				} elseif ( current_user_can( 'activate_plugin', $status['file'] ) ) {
					$btn_text = esc_html__( 'Activate', 'woodmart' );
					$btn_url  = add_query_arg(
						array(
							'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $status['file'] ),
							'action'   => 'activate',
							'plugin'   => $status['file'],
						),
						network_admin_url( 'plugins.php' )
					);
					$classes  = 'xts-activate';

					if ( is_network_admin() ) {
						$btn_text = esc_html__( 'Network Activate' );
						$btn_url  = add_query_arg( array( 'networkwide' => 1 ), $btn_url );
					}
				}
				break;
		}

		return array(
			'name'        => $btn_text,
			'url'         => $btn_url,
			'extra-class' => $classes,
		);
	}
}

if ( ! function_exists( 'woodmart_get_update_enqueue_icons_fonts' ) ) {
	/**
	 * AJAX update enqueue icons fonts.
	 *
	 * @return void
	 */
	function woodmart_get_update_enqueue_icons_fonts() {
		check_ajax_referer( 'woodmart-get-theme-settings-data-nonce', 'security' );

		$enqueue = '';
		$font    = sanitize_text_field( $_GET['font'] );
		$weight  = sanitize_text_field( $_GET['weight'] );

		if ( $font && $weight ) {
			$icon_font_name = 'woodmart-font-' . $font . '-' . $weight;

			ob_start();
			?>
			<style id="wd-icon-font">
				@font-face {
					font-weight: normal;
					font-style: normal;
					font-family: "woodmart-font";
					src: url("<?php echo esc_url( woodmart_remove_https( WOODMART_THEME_DIR . '/fonts/' . $icon_font_name . '.woff2' ) . '?v=' . woodmart_get_theme_info( 'Version' ) ); ?>") format("woff2");
				}
			</style>
			<?php

			$enqueue = ob_get_clean();
		}

		wp_send_json(
			array(
				'enqueue' => $enqueue,
			)
		);

	}

	add_action( 'wp_ajax_woodmart_get_enqueue_custom_icon_fonts', 'woodmart_get_update_enqueue_icons_fonts' );
}
