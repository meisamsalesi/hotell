<?php

namespace XTS\Modules\Linked_Variations;

use XTS\Metaboxes;
use XTS\Options;
use XTS\Singleton;

class Admin extends Singleton {
	/**
	 * Construct.
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'init', [ $this, 'add_metaboxes' ] );
		add_action( 'init', [ $this, 'add_options' ] );
	}

	/**
	 * Add option.
	 *
	 * @return void
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'linked_variations',
				'name'        => esc_html__( 'Enable linked variations', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'enable-linked-variations.mp4" autoplay loop muted></video>',
				'description' => wp_kses( __( 'This feature allows you to create a new kind of variable product based on simple products. You can create linked variations bundles via Dashboard -> Products -> Linked variations. Read more information in our <a href="https://xtemos.com/docs-topic/linked-variations/" target="_blank">documentation</a>.', 'woodmart' ), true ),
				'group'       => esc_html__( 'Linked variations', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'variable_products_section',
				'default'     => true,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 190,
			)
		);
	}

	/**
	 * Add metaboxes.
	 */
	public function add_metaboxes() {
		$metabox = Metaboxes::add_metabox(
			[
				'id'         => 'xts_woo_lv_metaboxes',
				'title'      => esc_html__( 'Settings', 'woodmart' ),
				'post_types' => [ 'woodmart_woo_lv' ],
			]
		);

		$metabox->add_section(
			[
				'id'       => 'general',
				'name'     => esc_html__( 'General', 'woodmart' ),
				'icon'     => 'xts-i-footer',
				'priority' => 10,
			]
		);

		$metabox->add_field(
			[
				'id'           => '_woodmart_linked_products',
				'type'         => 'select',
				'section'      => 'general',
				'name'         => esc_html__( 'Products', 'woodmart' ),
				'description'  => esc_html__( 'Select products that will be a part of the bundle as variations.', 'woodmart' ),
				'select2'      => true,
				'multiple'     => true,
				'empty_option' => true,
				'autocomplete' => [
					'type'   => 'post',
					'value'  => 'product',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				],
				'priority'     => 10,
			]
		);

		$metabox->add_field(
			[
				'id'           => '_woodmart_linked_attrs',
				'type'         => 'select',
				'section'      => 'general',
				'name'         => esc_html__( 'Attributes', 'woodmart' ),
				'description'  => esc_html__( 'These attributes will be used to connect selected products with each other.', 'woodmart' ),
				'select2'      => true,
				'multiple'     => true,
				'empty_option' => true,
				'callback'     => 'woodmart_product_attributes_array',
				'priority'     => 20,
			]
		);

		$metabox->add_field(
			[
				'id'           => '_woodmart_linked_use_product_image',
				'type'         => 'select',
				'section'      => 'general',
				'name'         => esc_html__( 'Attribute for the product image', 'woodmart' ),
				'description'  => esc_html__( 'Select an attribute that will be shown as product images.', 'woodmart' ),
				'select2'      => true,
				'multiple'     => true,
				'empty_option' => true,
				'callback'     => 'woodmart_product_attributes_array',
				'priority'     => 30,
			]
		);
	}
}

Admin::get_instance();
