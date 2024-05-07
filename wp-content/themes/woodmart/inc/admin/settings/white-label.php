<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

Options::add_field(
	array(
		'id'          => 'white_label',
		'name'        => esc_html__( 'White label', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'dashboard-white-lable.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Hide most of the "WoodMart" and "Xtemos" attributions.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'white_label_section',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_theme_name',
		'name'        => esc_html__( 'Theme name', 'woodmart' ),
		'description' => esc_html__( 'Replaces all instances of "Woodmart"', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'white_label_section',
		'default'     => '',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'dummy_import',
		'name'        => esc_html__( 'Prebuilt websites page', 'woodmart' ),
		'description' => esc_html__( 'Show prebuilt websites page in the dashboard.', 'woodmart' ),
		'group'       => esc_html__( 'Settings', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'white_label_section',
		'default'     => '1',
		'priority'    => 40,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_theme_license_tab',
		'name'        => esc_html__( 'Theme license page', 'woodmart' ),
		'description' => esc_html__( 'Show theme license page in the dashboard.', 'woodmart' ),
		'group'       => esc_html__( 'Settings', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'white_label_section',
		'default'     => '1',
		'priority'    => 41,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_changelog_tab',
		'name'        => esc_html__( 'Changelog page', 'woodmart' ),
		'description' => esc_html__( 'Show changelog page in the dashboard.', 'woodmart' ),
		'group'       => esc_html__( 'Settings', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'white_label_section',
		'default'     => '1',
		'priority'    => 42,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'theme_admin_bar_menu',
		'name'        => esc_html__( 'Theme admin bar menu', 'woodmart' ),
		'group'       => esc_html__( 'Settings', 'woodmart' ),
		'description' => esc_html__( 'Show theme menu in the WordPress admin bar.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'white_label_section',
		'default'     => '1',
		'priority'    => 43,
		'class'       => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_theme_hints',
		'name'        => esc_html__( 'Theme settings hints', 'woodmart' ),
		'description' => esc_html__( 'Show hints displayed next to the theme settings option name.', 'woodmart' ),
		'group'       => esc_html__( 'Settings', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'white_label_section',
		'default'     => '1',
		'priority'    => 44,
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_sidebar_icon_logo',
		'name'        => esc_html__( 'Dashboard sidebar & admin bar logo', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'dashboard-sidebar-admin-bar-logo.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Recommended size: 20x20 (px). Icons that will be displayed in Wordpress dashboard admin bar and sidebar.', 'woodmart' ),
		'group'       => esc_html__( 'Images', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'white_label_section',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_dashboard_logo',
		'name'        => esc_html__( 'Dashboard header logo', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'dashboard-white-lable.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Recommended size: 170x45 (px). Logo image that will be displayed in dashboard header on theme pages.', 'woodmart' ),
		'group'       => esc_html__( 'Images', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'white_label_section',
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_appearance_screenshot',
		'name'        => esc_html__( 'Appearance screenshot', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'appearance-screenshot.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Recommended size: 1200×900 (px). Theme preview image that will be displayed in Dashboard -> Appearance -> Themes.', 'woodmart' ),
		'group'       => esc_html__( 'Images', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'white_label_section',
		'priority'    => 80,
	)
);


Options::add_field(
	array(
		'id'          => 'white_label_dashboard_title',
		'name'        => esc_html__( 'Welcome page title', 'woodmart' ),
		'description' => esc_html__( 'Heading displayed in Dashboard -> WoodMart.', 'woodmart' ),
		'group'       => esc_html__( 'Content', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'white_label_section',
		'default'     => '',
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'white_label_dashboard_text',
		'name'        => esc_html__( 'Welcome page text', 'woodmart' ),
		'description' => esc_html__( 'Text displayed in Dashboard -> WoodMart.', 'woodmart' ),
		'group'       => esc_html__( 'Content', 'woodmart' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'white_label_section',
		'default'     => '',
		'priority'    => 100,
	)
);