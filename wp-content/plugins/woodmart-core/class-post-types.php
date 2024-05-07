<?php
/**
 * Post types file.
 *
 * @package Woodmart
 */

namespace WOODCORE;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Post types class.
 */
class Post_Types {
	/**
	 * Instance.
	 *
	 * @var null
	 */
	public static $instance = null;

	/**
	 * Instance.
	 *
	 * @return Post_Types|null
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_layout' ), 1 );
		add_action( 'init', array( $this, 'linked_variations' ), 1 );
		add_action( 'init', array( $this, 'bought_together' ), 1 );
	}

	/**
	 * Register layout post type.
	 */
	public function register_layout() {
		register_post_type(
			'woodmart_layout',
			array(
				'label'              => esc_html__( 'Layouts', 'woodmart' ),
				'labels'             => array(
					'name'          => esc_html__( 'Layouts', 'woodmart' ),
					'singular_name' => esc_html__( 'Layout', 'woodmart' ),
					'menu_name'     => esc_html__( 'Layouts', 'woodmart' ),
				),
				'supports'           => array( 'title', 'editor' ),
				'hierarchical'       => false,
				'public'             => true,
				'menu_position'      => 32,
				'menu_icon'          => 'dashicons-format-gallery',
				'publicly_queryable' => is_user_logged_in(),
				'show_in_rest'       => true,
				'capability_type'    => 'page',
			)
		);
	}

	/**
	 * Register layout post type.
	 */
	public function linked_variations() {
		if ( ! function_exists( 'woodmart_get_opt' ) || ! woodmart_get_opt( 'linked_variations', 1 ) ) {
			return;
		}

		register_post_type(
			'woodmart_woo_lv',
			array(
				'label'              => esc_html__( 'Linked Variations', 'woodmart' ),
				'labels'             => array(
					'name'          => esc_html__( 'Linked Variations', 'woodmart' ),
					'singular_name' => esc_html__( 'Linked Variations', 'woodmart' ),
					'menu_name'     => esc_html__( 'Linked Variations', 'woodmart' ),
				),
				'supports'           => array( 'title' ),
				'hierarchical'       => false,
				'public'             => true,
				'show_in_menu'       => 'edit.php?post_type=product',
				'publicly_queryable' => false,
				'show_in_rest'       => true,
			)
		);
	}

	/**
	 * Register frequently bought together post type.
	 */
	public function bought_together() {
		if ( ! function_exists( 'woodmart_get_opt' ) || ! woodmart_get_opt( 'bought_together_enabled', 1 ) ) {
			return;
		}

		register_post_type(
			'woodmart_woo_fbt',
			array(
				'label'              => esc_html__( 'Frequently Bought Together', 'woodmart' ),
				'labels'             => array(
					'name'          => esc_html__( 'Frequently Bought Together', 'woodmart' ),
					'singular_name' => esc_html__( 'Frequently Bought Together', 'woodmart' ),
					'menu_name'     => esc_html__( 'Frequently Bought Together', 'woodmart' ),
					'add_new_item'  => esc_html__( 'Add New', 'woodmart' ),
				),
				'supports'           => array( 'title' ),
				'hierarchical'       => false,
				'public'             => true,
				'show_in_menu'       => 'edit.php?post_type=product',
				'publicly_queryable' => false,
				'show_in_rest'       => true,
			)
		);
	}
}

Post_Types::get_instance();
