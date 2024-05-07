<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

Options::add_field(
	array(
		'id'          => 'login_tabs',
		'name'        => esc_html__( 'Login page tabs', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'login-page-tabs.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Enable tabs for login and register forms', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'login_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'reg_title',
		'name'     => esc_html__( 'Registration title', 'woodmart' ),
		'group'    => esc_html__( 'Registrer', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'default'  => 'Register',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'reg_text',
		'name'        => esc_html__( 'Registration text', 'woodmart' ),
		'description' => esc_html__( 'Show some information about registration on your web-site', 'woodmart' ),
		'group'    => esc_html__( 'Registrer', 'woodmart' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'login_section',
		'default'     => 'Registering for this site allows you to access your order status and history. Just fill in the fields below, and we\'ll get a new account set up for you in no time. We will only ask you for information necessary to make the purchase process faster and easier.',
		'priority'    => 30,
	)
);


Options::add_field(
	array(
		'id'       => 'login_title',
		'name'     => esc_html__( 'Login title', 'woodmart' ),
		'group'    => esc_html__( 'Login', 'woodmart' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'default'  => 'Login',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'login_text',
		'name'        => esc_html__( 'Login text', 'woodmart' ),
		'description' => esc_html__( 'Show some information about login on your web-site', 'woodmart' ),
		'group'    => esc_html__( 'Login', 'woodmart' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'login_section',
		'default'     => '',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'my_account_links',
		'name'        => esc_html__( 'Dashboard icons menu', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'dashboard-icons-menu.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Adds icons blocks to the my account page as a navigation.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'dashboard_section',
		'default'     => '1',
		'priority'    => 60,
	)
);