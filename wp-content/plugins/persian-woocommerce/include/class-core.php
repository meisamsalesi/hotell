<?php

defined( 'ABSPATH' ) || exit;

/**
 *
 */
class Persian_Woocommerce_Core {

	/**
	 * @var array
	 */
	protected $options = [];

	// sub classes
	public $tools, $translate, $address, $gateways;

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {

		$this->activated_plugin();

		$this->options = get_option( 'PW_Options' );

		//add_filter( 'woocommerce_show_addons_page', '__return_false', 100 );
		add_action( 'admin_menu', [ $this, 'admin_menus' ], 59 );
		add_action( 'admin_head', [ $this, 'admin_head' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ], 10 );
		add_filter( 'woocommerce_screen_ids', [ $this, 'pw_screen_ids' ], 110, 1 );

		add_filter( "plugin_action_links_persian-woocommerce/woocommerce-persian.php", function ( $actions, $plugin_file, $plugin_data, $context ) {
			$woo = [ 'woo_ir' => sprintf( '<a href="%s" target="blank" style="background: #763ec2;color: white;padding: 0px 5px;border-radius: 2px;">%s</a>', 'https://woosupport.ir', 'ووکامرس فارسی' ) ];
			return $woo + $actions;
		}, 100, 4 );
	}

	public function plugins_loaded() {
		require_once( 'class-gateways.php' );
	}

	public function admin_menus() {

		add_menu_page( 'ووکامرس فارسی', 'ووکامرس فارسی', 'manage_options', 'persian-wc', [
			$this->translate,
			'translate_page',
		], $this->plugin_url( 'assets/images/logo.png' ), '55.6' );

		$submenus = [
			10 => [
				'title'      => 'حلقه های ترجمه',
				'capability' => 'manage_options',
				'slug'       => 'persian-wc',
				'callback'   => [ $this->translate, 'translate_page', ],
			],
			15 => [
				'title'      => 'تاریخ شمسی',
				'capability' => 'manage_options',
				'slug'       => admin_url( 'admin.php?page=persian-wc-tools&tab=date' ),
				'callback'   => '',
			],
			20 => [
				'title'      => 'ابزار ها',
				'capability' => 'manage_options',
				'slug'       => 'persian-wc-tools',
				'callback'   => [ $this->tools, 'tools_page', ],
			],
			25 => [
				'title'      => 'سوپر ادمین',
				'capability' => 'manage_options',
				'slug'       => admin_url( 'admin.php?page=persian-wc-tools&tab=super_admin' ),
				'callback'   => '',
			],
			30 => [
				'title'      => 'افزونه ها',
				'capability' => 'manage_woocommerce',
				'slug'       => 'persian-wc-plugins',
				'callback'   => [ $this, 'plugins_page', ],
			],
			45 => [
				'title'      => 'ملی پیامک',
				'capability' => 'manage_woocommerce',
				'slug'       => 'persian-wc-melipayamak',
				'callback'   => [ $this, 'melipayamak_page', ],
			],
			50 => [
				'title'      => 'پیشخوان پست تاپین',
				'capability' => 'manage_woocommerce',
				'slug'       => 'https://yun.ir/pwtm',
				'callback'   => '',
			],
			60 => [
				'title'      => 'درباره ما',
				'capability' => 'manage_options',
				'slug'       => 'persian-wc-about',
				'callback'   => [ $this, 'about_page', ],
			],
		];

		$submenus = apply_filters( 'pw_submenu', $submenus );

		foreach ( $submenus as $submenu ) {
			add_submenu_page( 'persian-wc', $submenu['title'], $submenu['title'], $submenu['capability'], $submenu['slug'], $submenu['callback'] );
		}

		add_submenu_page( 'woocommerce', 'افزونه های پارسی', 'افزونه های پارسی', 'manage_woocommerce', 'wc-persian-plugins', [
			$this,
			'plugins_page',
		] );
	}

	public function admin_head() {
		?>
		<script type="text/javascript">
            jQuery(document).ready(function ($) {
                $("ul#adminmenu a[href$='https://yun.ir/pwtm']").attr('target', '_blank');
            });
		</script>
		<?php
	}

	public function plugins_page() {
		wp_enqueue_style( 'woocommerce_admin_styles' );
		include( 'view/html-admin-page-plugins.php' );
	}

	public function about_page() {
		include( 'view/html-admin-page-about.php' );
	}

	public function melipayamak_page() {
		include( 'view/html-admin-page-melipayamak.php' );
	}

	public function pw_screen_ids( array $screen_ids ): array {

		$_screen_ids = $screen_ids;

		foreach ( $screen_ids as $screen_id ) {
			$_screen_ids[] = str_replace( 'WooCommerce', 'woocommerce', $screen_id );
			$_screen_ids[] = str_replace( 'ووکامرس', 'woocommerce', urldecode( $screen_id ) );
		}

		return array_unique( $_screen_ids );

	}

	public function activated_plugin() {
		global $wpdb;

		if ( ! file_exists( PW_DIR . '/.activated' ) ) {
			return false;
		}

		$woocommerce_ir_sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}woocommerce_ir` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`text1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
			`text2` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
			PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $woocommerce_ir_sql );

		//delete deprecated tables-----------------------------
		$deprecated_tables = [
			'woocommerce_ir_cities',
			'Woo_Iran_Cities_By_HANNANStd',
		];

		foreach ( $deprecated_tables as $deprecated_table ) {
			$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}{$deprecated_table}" );
		}

		//delete deprecated Options-----------------------------
		$deprecated_options = [
			'is_cities_installed',
			'pw_delete_city_table_2_5',
			'woocommerce_persian_feed',
			'redirect_to_woo_persian_about_page',
			'enable_woocommerce_notice_dismissed',
			'Persian_Woocommerce_rename_old_table',
		];

		foreach ( $deprecated_options as $deprecated_option ) {
			delete_option( $deprecated_option );
		}

		for ( $i = 0; $i < 10; $i ++ ) {
			delete_option( 'persian_woo_notice_number_' . $i );
		}

		unlink( PW_DIR . '/.activated' );

		if ( ! headers_sent() ) {
			wp_redirect( admin_url( 'admin.php?page=persian-wc-about' ) );
			die();
		}
	}

	public function enqueue_scripts() {
		$pages = [
			'persian-wc-about',
			'persian-wc-plugins',
			'wc-persian-plugins',
			'persian-wc-themes',
			'wc-persian-themes',
			'persian-wc-tools',
		];

		$page = sanitize_text_field( $_GET['page'] ?? null );

		if ( in_array( $page, $pages ) ) {
			wp_enqueue_style( 'pw-admin-style', $this->plugin_url( 'assets/css/admin-style.css' ) );
		}
	}

	public function plugin_url( $path = null ): string {
		return untrailingslashit( plugins_url( is_null( $path ) ? '/' : $path, PW_FILE ) );
	}

	public function get_options( $option_name = null, $default = false ) {

		if ( is_null( $option_name ) ) {
			return $this->options;
		}

		return $this->options[ $option_name ] ?? $default;
	}

}

if ( ! class_exists( 'Persian_Woocommerce_Plugin' ) ) {
	class Persian_Woocommerce_Plugin extends Persian_Woocommerce_Core {

	}
}
