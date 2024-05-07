<?php

defined( 'ABSPATH' ) || exit;

class PW_Super_Admin {

	// @todo add custom url for blocking
	// @todo add notice in plugin, theme, core update pages
	private $blocked_url = [];

	public function __construct() {

		if ( function_exists( 'is_plugin_active' ) && is_plugin_active( 'super-admin/super-admin.php' ) ) {
			deactivate_plugins( 'super-admin/super-admin.php' );
		}

		// Woocommerce.com - Not working and useful in IRAN
		if ( 'yes' === get_option( 'woocommerce_allow_tracking', 'no' ) ) {
			update_option( 'woocommerce_allow_tracking', 'no', 'yes' );
		}

		add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );
		// Woocommerce.com

		if ( PW()->get_options( 'super_admin_boost_woo', 'no' ) == 'yes' ) {

			add_action( 'admin_menu', function () {
				foreach ( get_post_types( '', 'names' ) as $post_type ) {
					remove_meta_box( 'postcustom', $post_type, 'normal' );
				}
			} );

			$this->blocked_url['woocommerce.com/wp-json/wccom-extensions/1.0/featured']                                        = '[]';
			$this->blocked_url['woocommerce.com/wp-json/wccom-extensions/2.0/featured']                                        = '[]';
			$this->blocked_url['woocommerce.com/wp-json/wccom-extensions/1.0/search']                                          = '{}';
			$this->blocked_url['woocommerce.com/wp-json/wccom/obw-free-extensions/3.0/extensions.json']                        = '[]';
			$this->blocked_url['woocommerce.com/wp-json/wccom/payment-gateway-suggestions/1.0/payment-method/promotions.json'] = '[]';
			$this->blocked_url['woocommerce.com/wp-json/wccom/payment-gateway-suggestions/1.0/suggestions.json']               = '[]';
		}

		if ( PW()->get_options( 'super_admin_boost_dashboard', 'no' ) == 'yes' ) {
			$this->blocked_url['api.wordpress.org/core/browse-happy/1.1'] = '[]';
			$this->blocked_url['api.wordpress.org/core/serve-happy/1.0']  = '[]';
		}

		if ( $this->blocked_url ) {
			add_filter( 'pre_http_request', [ $this, 'pre_http_request' ], 1000, 3 );
		}

		if ( PW()->get_options( 'super_admin_disable_core', 'no' ) == 'yes' ) {
			add_filter( 'pre_site_transient_update_core', [ $this, '__return_null' ] );
			remove_action( 'admin_init', '_maybe_update_core' );
			remove_action( 'wp_version_check', 'wp_version_check' );

			add_filter( 'admin_menu', function () {
				remove_submenu_page( 'index.php', 'update-core.php' );
			} );
		}

		if ( PW()->get_options( 'super_admin_disable_plugins', 'no' ) == 'yes' ) {
			remove_action( 'load-plugins.php', 'wp_update_plugins' );
			remove_action( 'load-update.php', 'wp_update_plugins' );
			remove_action( 'load-update-core.php', 'wp_update_plugins' );
			remove_action( 'admin_init', '_maybe_update_plugins' );
			remove_action( 'wp_update_plugins', 'wp_update_plugins' );
			add_filter( 'pre_site_transient_update_plugins', [ $this, '__return_null' ] );
		}

		if ( PW()->get_options( 'super_admin_disable_themes', 'no' ) == 'yes' ) {
			remove_action( 'load-themes.php', 'wp_update_themes' );
			remove_action( 'load-update.php', 'wp_update_themes' );
			remove_action( 'load-update-core.php', 'wp_update_themes' );
			remove_action( 'admin_init', '_maybe_update_themes' );
			remove_action( 'wp_update_themes', 'wp_update_themes' );
			add_filter( 'pre_site_transient_update_themes', [ $this, '__return_null' ] );
		}

		add_filter( 'PW_Tools_tabs', [ $this, 'tabs' ] );
		add_filter( 'PW_Tools_settings', [ $this, 'settings' ] );
	}

	public function tabs( array $tabs ): array {

		$tabs['super_admin'] = 'سوپر ادمین';

		return $tabs;
	}

	public function settings( array $settings ): array {

		$settings['super_admin'] = [
			[
				'title' => 'تنظیمات عمومی',
				'type'  => 'title',
				'id'    => 'super_admin_general',
			],
			[
				'title'   => 'افزایش سرعت ووکامرس',
				'id'      => 'PW_Options[super_admin_boost_woo]',
				'type'    => 'checkbox',
				'default' => 'no',
				'desc'    => 'بهبود سرعت هسته و سفارشات ووکامرس',
			],
			[
				'title'   => 'افزایش سرعت پیشخوان',
				'id'      => 'PW_Options[super_admin_boost_dashboard]',
				'type'    => 'checkbox',
				'default' => 'no',
				'desc'    => 'افزایش سرعت آنالیزهای پیشخوان وردپرس',
			],
			[
				'title'   => 'افزایش سرعت هسته',
				'id'      => 'PW_Options[super_admin_disable_core]',
				'type'    => 'checkbox',
				'default' => 'no',
				'desc'    => 'غیرفعالسازی موقت بروزرسانی هسته وردپرس',
			],
			[
				'title'   => 'افزایش سرعت افزونه‌ها',
				'id'      => 'PW_Options[super_admin_disable_plugins]',
				'type'    => 'checkbox',
				'default' => 'no',
				'desc'    => 'غیرفعالسازی موقت بروزرسانی افزونه‌های وردپرس',
			],
			[
				'title'   => 'افزایش سرعت قالب‌ها',
				'id'      => 'PW_Options[super_admin_disable_themes]',
				'type'    => 'checkbox',
				'default' => 'no',
				'desc'    => 'غیرفعالسازی موقت بروزرسانی قالب‌های وردپرس',
			],

			[
				'type' => 'sectionend',
				'id'   => 'super_admin_general',
			],
		];

		return $settings;
	}

	public function __return_null() {
		return null;
	}

	public function pre_http_request( $preempt, $parsed_args, $url ) {

		$url = trim( parse_url( $url, PHP_URL_HOST ) . parse_url( $url, PHP_URL_PATH ), '/' );

		if ( isset( $this->blocked_url[ $url ] ) ) {
			return [
				'headers'       => [],
				'body'          => $this->blocked_url[ $url ],
				'response'      => [
					'code'    => 200,
					'message' => false,
				],
				'cookies'       => [],
				'http_response' => null,
			];
		}

		return $preempt;
	}
}

new PW_Super_Admin();
