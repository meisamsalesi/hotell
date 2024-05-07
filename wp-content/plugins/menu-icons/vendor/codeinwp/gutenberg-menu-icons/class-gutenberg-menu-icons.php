<?php
/**
 * Class for Menu Icons logic.
 *
 * @package gutenberg-menu-icons
 */

namespace ThemeIsle;

use WP_Block_Type_Registry;

/**
 * Class GutenbergMenuIcons
 */
class GutenbergMenuIcons {

	/**
	 * The main instance var.
	 *
	 * @var GutenbergMenuIcons
	 */
	public static $instance = null;

	/**
	 * Holds the module slug.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var     string $slug The module slug.
	 */
	protected $slug = 'gutenberg-menu-icons';

	/**
	 * Initialize the class
	 */
	public function init() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_frontend_assets' ) );
	}

	/**
	 * Load Gutenberg editor assets.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function enqueue_editor_assets() {
		$block_registered = WP_Block_Type_Registry::get_instance()->is_registered( 'core/navigation' );

		if ( ! $block_registered ) {
			return;
		}

		$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

		wp_enqueue_script(
			'themeisle-gutenberg-menu-icons',
			plugin_dir_url( $this->get_dir() ) . $this->slug . '/build/index.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_enqueue_style(
			'themeisle-gutenberg-menu-icons',
			plugin_dir_url( $this->get_dir() ) . $this->slug . '/build/index.css',
			array( 'font-awesome-5' ),
			$asset_file['version']
		);

		wp_enqueue_style(
			'themeisle-gutenberg-menu-icons-font-awesome',
			plugins_url( '/', __FILE__ ) . 'assets/css/font-awesome.min.css',
			array( 'font-awesome-5' ),
			$asset_file['version']
		);

		wp_set_script_translations( 'themeisle-gutenberg-menu-icons', 'otter-blocks' );
	}

	/**
	 * Load Gutenberg assets.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function enqueue_block_frontend_assets() {
		if ( ! has_block( 'core/navigation' ) ) {
			return;
		}

		if ( is_admin() ) {
			return;
		}

		$asset_file = include plugin_dir_path( __FILE__ ) . 'build/frontend.asset.php';

		wp_enqueue_script(
			'themeisle-gutenberg-menu-icons-frontend',
			plugin_dir_url( $this->get_dir() ) . $this->slug . '/build/frontend.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_enqueue_style(
			'themeisle-gutenberg-menu-icons-frontend',
			plugin_dir_url( $this->get_dir() ) . $this->slug . '/build/style-frontend.css',
			array( 'font-awesome-5' ),
			$asset_file['version']
		);
	}

	/**
	 * Method to return path to child class in a Reflective Way.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @return  string
	 */
	protected function get_dir() {
		return dirname( __FILE__ );
	}

	/**
	 * The instance method for the static class.
	 * Defines and returns the instance of the static class.
	 *
	 * @static
	 * @since 1.0.0
	 * @access public
	 * @return GutenbergMenuIcons
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'otter-blocks' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'otter-blocks' ), '1.0.0' );
	}
}
