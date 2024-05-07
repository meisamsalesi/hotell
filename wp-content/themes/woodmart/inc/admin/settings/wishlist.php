<?php
/**
 * This is Wishlist options file for Theme settings.
 *
 * @package Woodmart.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

Options::add_field(
	array(
		'id'          => 'wishlist',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Enable wishlist', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-wishlist.jpg" alt="">', 'woodmart' ), true ),
		'description' => wp_kses( __( 'Enable wishlist functionality built in with the theme. Read more information in our <a href="https://xtemos.com/docs/woodmart/woodmart-wishlist/">documentation</a>.', 'woodmart' ), true ),
		'section'     => 'wishlist_section',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'           => 'wishlist_page',
		'type'         => 'select',
		'name'         => esc_html__( 'Wishlist page', 'woodmart' ),
		'description'  => esc_html__( 'Select a page for the wishlist table. It should contain the shortcode: [woodmart_wishlist]', 'woodmart' ),
		'section'      => 'wishlist_section',
		'empty_option' => true,
		'select2'      => true,
		'options'      => '',
		'callback'     => 'woodmart_get_pages_array',
		'default'      => 267,
		'priority'     => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_logged',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Only for logged in', 'woodmart' ),
		'description' => esc_html__( 'Disable wishlist for guests customers.', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '0',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_bulk_action',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Bulk actions', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'bulk-action-move-or-remove-to-wishlist.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Enable the ability to bulk move or remove products in the wishlist.', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '1',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_empty_text',
		'type'        => 'textarea',
		'name'        => esc_html__( 'Empty wishlist text', 'woodmart' ),
		'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'empty-wishlist-text.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Text will be displayed if user don\'t add any products to wishlist.', 'woodmart' ),
		'section'     => 'wishlist_section',
		'wysiwyg'     => false,
		'default'     => 'You don\'t have any products in the wishlist yet. <br> You will find a lot of interesting products on our "Shop" page.',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_expanded',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Enable multiple wishlists', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'multiple-wishlists.mp4" autoplay loop muted></video>',
		'group'       => esc_html__( 'Multiple wishlists', 'woodmart' ),
		'description' => esc_html__( 'Allows customers to organize favorite products into multiple wishlists based on their interest', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '0',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'wishlist_show_popup',
		'name'     => esc_html__( 'Show wishlists popup', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'add-to-wishlist-popup.mp4" autoplay loop muted></video>',
		'group'    => esc_html__( 'Multiple wishlists', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'wishlist_section',
		'options'  => array(
			'disable'  => array(
				'name'  => esc_html__( 'Never', 'woodmart' ),
				'value' => 'disable',
			),
			'enable'   => array(
				'name'  => esc_html__( 'Always', 'woodmart' ),
				'value' => 'enable',
			),
			'more_one' => array(
				'name'  => esc_html__( 'If more than one wishlist', 'woodmart' ),
				'value' => 'more_one',
			),
		),
		'default'  => 'enable',
		'priority' => 70,
		'requires' => array(
			array(
				'key'     => 'wishlist_expanded',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'product_loop_wishlist',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Show button on products in loop', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-button-on-products-in-loop.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Display wishlist product button on all products grids and lists.', 'woodmart' ),
		'group'       => esc_html__( 'Buttons', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'wishlist_save_button_state',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Save button state after adding to the wishlist', 'woodmart' ),
		'description' => esc_html__( 'You can enable this option to show the "Browse wishlist" button when you visit the product that has been already added to the wishlist.  IMPORTANT: It will not work if you use some full-page cache like WP Rocket or WP Total Cache.', 'woodmart' ),
		'group'       => esc_html__( 'Buttons', 'woodmart' ),
		'section'     => 'wishlist_section',
		'default'     => '0',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 90,
	)
);