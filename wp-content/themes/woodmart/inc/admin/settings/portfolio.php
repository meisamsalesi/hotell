<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Options;

Options::add_field(
	array(
		'id'          => 'portfolio',
		'name'        => esc_html__( 'Portfolio', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'portfolio.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Enable/disable portfolio on your website.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'portfolio_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'           => 'portfolio_page',
		'name'         => esc_html__( 'Portfolio page', 'woodmart' ),
		'description'  => esc_html__( 'You need to create an empty page and select from the dropdown. It will be used as a root page for your portfolio archives.', 'woodmart' ),
		'section'      => 'portfolio_section',
		'type'         => 'select',
		'empty_option' => true,
		'select2'      => true,
		'options'      => '',
		'callback'     => 'woodmart_get_pages_array',
		'priority'     => 19,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_item_slug',
		'name'        => esc_html__( 'Portfolio project URL slug', 'woodmart' ),
		'description' => esc_html__( 'IMPORTANT: You need to go to WordPress Settings -> Permalinks and resave them to apply these settings.', 'woodmart' ),
		'group'       => esc_html__( 'URL', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'portfolio_section',
		'priority'    => 20,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_cat_slug',
		'name'        => esc_html__( 'Portfolio category URL slug', 'woodmart' ),
		'description' => esc_html__( 'IMPORTANT: You need to go to WordPress Settings -> Permalinks and resave them to apply these settings.', 'woodmart' ),
		'group'       => esc_html__( 'URL', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'portfolio_section',
		'priority'    => 30,
		'class'    => 'xts-col-6',
	)
);


/**
 * Portfolio archive.
 */

Options::add_field(
	array(
		'id'          => 'portfolio_full_width',
		'name'        => esc_html__( 'Full width portfolio', 'woodmart' ),
		'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'full-width-portfolio.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Makes the container 100% width of the page.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'portfolio_archive_section',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'projects_columns',
		'name'        => esc_html__( 'Projects columns on desktop', 'woodmart' ),
		'description' => esc_html__( 'How many projects you want to show per row', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			1 => array(
				'name'  => '1',
				'value' => 1,
			),
			2 => array(
				'name'  => '2',
				'value' => 2,
			),
			3 => array(
				'name'  => '3',
				'value' => 3,
			),
			4 => array(
				'name'  => '4',
				'value' => 4,
			),
			5 => array(
				'name'  => '5',
				'value' => 5,
			),
			6 => array(
				'name'  => '6',
				'value' => 6,
			),
		),
		'default'     => 3,
		'priority'    => 12,
		't_tab'       => [
			'id'    => 'project_columns_tabs',
			'tab'   => esc_html__( 'Desktop', 'woodmart' ),
			'icon'  => 'xts-i-desktop',
			'style' => 'devices',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'projects_columns_tablet',
		'name'        => esc_html__( 'Projects columns on tablet', 'woodmart' ),
		'description' => esc_html__( 'How many projects you want to show per row', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			1      => array(
				'name'  => '1',
				'value' => 1,
			),
			2      => array(
				'name'  => '2',
				'value' => 2,
			),
			3      => array(
				'name'  => '3',
				'value' => 3,
			),
			4      => array(
				'name'  => '4',
				'value' => 4,
			),
			5      => array(
				'name'  => '5',
				'value' => 5,
			),
			6      => array(
				'name'  => '6',
				'value' => 6,
			),
		),
		'default'     => 'auto',
		'priority'    => 13,
		't_tab'       => [
			'id'   => 'project_columns_tabs',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
			'icon' => 'xts-i-tablet',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'projects_columns_mobile',
		'name'        => esc_html__( 'Projects columns on mobile', 'woodmart' ),
		'description' => esc_html__( 'How many projects you want to show per row', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			1      => array(
				'name'  => '1',
				'value' => 1,
			),
			2      => array(
				'name'  => '2',
				'value' => 2,
			),
			3      => array(
				'name'  => '3',
				'value' => 3,
			),
			4      => array(
				'name'  => '4',
				'value' => 4,
			),
			5      => array(
				'name'  => '5',
				'value' => 5,
			),
			6      => array(
				'name'  => '6',
				'value' => 6,
			),
		),
		'default'     => 'auto',
		'priority'    => 14,
		't_tab'       => [
			'id'   => 'project_columns_tabs',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
			'icon' => 'xts-i-phone',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_spacing',
		'name'        => esc_html__( 'Space between projects', 'woodmart' ),
		'description' => esc_html__( 'You can set different spacing between blocks on portfolio page', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			0  => array(
				'name'  => '0',
				'value' => 0,
			),
			2  => array(
				'name'  => '2',
				'value' => 2,
			),
			6  => array(
				'name'  => '5',
				'value' => 6,
			),
			10 => array(
				'name'  => '10',
				'value' => 10,
			),
			20 => array(
				'name'  => '20',
				'value' => 20,
			),
			30 => array(
				'name'  => '30',
				'value' => 30,
			),
		),
		'default'     => 0,
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_per_page',
		'name'        => esc_html__( 'Items per page', 'woodmart' ),
		'description' => esc_html__( 'Number of portfolio projects that will be displayed on one page.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'text_input',
		'attributes'  => array(
			'type' => 'number',
		),
		'section'     => 'portfolio_archive_section',
		'default'     => 6,
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_pagination',
		'name'        => esc_html__( 'Portfolio pagination', 'woodmart' ),
		'description' => esc_html__( 'Choose a type for the pagination on your portfolio page.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			'pagination' => array(
				'name'  => esc_html__( 'Pagination links', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'portfolio-pagination-pagination-links.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'pagination',
			),
			'load_more'  => array(
				'name'  => esc_html__( '"Load more" button', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'portfolio-pagination-load-more-button.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'load_more',
			),
			'infinit'    => array(
				'name'  => esc_html__( 'Infinit scrolling', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'portfolio-pagination-infinit.mp4" autoplay loop muted></video>',
				'value' => 'infinit',
			),
		),
		'default'     => 'load_more',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_orderby',
		'name'        => esc_html__( 'Portfolio order by', 'woodmart' ),
		'description' => esc_html__( 'Select a parameter for projects order.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'select',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			'date'       => array(
				'name'  => esc_html__( 'Date', 'woodmart' ),
				'value' => 'date',
			),
			'ID'         => array(
				'name'  => esc_html__( 'ID', 'woodmart' ),
				'value' => 'ID',
			),
			'title'      => array(
				'name'  => esc_html__( 'Title', 'woodmart' ),
				'value' => 'title',
			),
			'modified'   => array(
				'name'  => esc_html__( 'Modified', 'woodmart' ),
				'value' => 'modified',
			),
			'menu_order' => array(
				'name'  => esc_html__( 'Menu order', 'woodmart' ),
				'value' => 'menu_order',
			),
		),
		'default'     => 'date',
		'priority'    => 50,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_order',
		'name'        => esc_html__( 'Portfolio order', 'woodmart' ),
		'description' => esc_html__( 'Choose ascending or descending order.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'select',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			'DESC' => array(
				'name'  => esc_html__( 'DESC', 'woodmart' ),
				'value' => 'DESC',
			),
			'ASC'  => array(
				'name'  => esc_html__( 'ASC', 'woodmart' ),
				'value' => 'ASC',
			),
		),
		'default'     => 'DESC',
		'priority'    => 60,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_style',
		'name'        => esc_html__( 'Portfolio style', 'woodmart' ),
		'description' => esc_html__( 'You can use different styles for your projects.', 'woodmart' ),
		'group'       => esc_html__( 'Project options', 'woodmart' ),

		'type'        => 'buttons',
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			'hover'         => array(
				'name'  => esc_html__( 'Show text on mouse over', 'woodmart' ),
				'value' => 'hover',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/portfolio/hover.jpg',
			),
			'hover-inverse' => array(
				'name'  => esc_html__( 'Alternative', 'woodmart' ),
				'value' => 'hover-inverse',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/portfolio/hover-inverse.jpg',
			),
			'text-shown'    => array(
				'name'  => esc_html__( 'Text under image', 'woodmart' ),
				'value' => 'text-shown',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/portfolio/text-shown.jpg',
			),
			'parallax'      => array(
				'name'  => esc_html__( 'Mouse move parallax', 'woodmart' ),
				'value' => 'parallax',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/portfolio/hover.jpg',
			),
		),
		'default'     => 'hover',
		'priority'    => 70,
		'class'       => 'xts-btn-set-img-col-3',
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_image_size',
		'name'        => esc_html__( 'Images size', 'woodmart' ),
		'description' => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme.', 'woodmart' ),
		'group'       => esc_html__( 'Project options', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'portfolio_archive_section',
		'default'     => 'large',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_filters',
		'name'        => esc_html__( 'Show categories filters', 'woodmart' ),
		'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-categories-filters.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Display categories list that allows you to filter your portfolio projects.', 'woodmart' ),
		'group'       => esc_html__( 'Project options', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'portfolio_archive_section',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_filters_type',
		'type'        => 'buttons',
		'name'        => esc_html__( 'Categories filters', 'woodmart' ),
		'description' => esc_html__( 'You can switch between links that will lead to project categories and masonry filters within one page only. Or turn off the filters completely.', 'woodmart' ),
		'group'       => esc_html__( 'Project options', 'woodmart' ),
		'section'     => 'portfolio_archive_section',
		'options'     => array(
			'links'   => array(
				'name'  => esc_html__( 'Links', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'portfolio-categories-filters-links.mp4" autoplay loop muted></video>',
				'value' => 'links',
			),
			'masonry' => array(
				'name'  => esc_html__( 'Masonry', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'portfolio-categories-filters-masonry.mp4" autoplay loop muted></video>',
				'value' => 'masonry',
			),
		),
		'requires'    => array(
			array(
				'key'     => 'portoflio_filters',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'     => 'links',
		'priority'    => 100,
	)
);

Options::add_field(
	array(
		'id'          => 'ajax_portfolio',
		'type'        => 'switcher',
		'name'        => esc_html__( 'AJAX portfolio', 'woodmart' ),
		'description' => esc_html__( 'Use AJAX functionality for portfolio categories links.', 'woodmart' ),
		'group'       => esc_html__( 'Project options', 'woodmart' ),
		'section'     => 'portfolio_archive_section',
		'requires'    => array(
			array(
				'key'     => 'portfolio_filters_type',
				'compare' => 'equals',
				'value'   => 'links',
			),
			array(
				'key'     => 'portoflio_filters',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'     => '1',
		'priority'    => 110,
	)
);

/**
 * Portfolio single.
 */
Options::add_field(
	array(
		'id'          => 'single_portfolio_header',
		'name'        => esc_html__( 'Custom single project header', 'woodmart' ),
		'description' => esc_html__( 'You can use different header for your single portfolio page.', 'woodmart' ),
		'type'        => 'select',
		'section'     => 'portfolio_singe_project_section',
		'options'     => '',
		'callback'    => 'woodmart_get_theme_settings_headers_array',
		'select2'     => true,
		'default'     => 'none',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'single_portfolio_title_in_page_title',
		'name'        => esc_html__( 'Project name in page title', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'project-title-in-page-heading.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Display project title instead of portfolio page title in page heading', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'portfolio_singe_project_section',
		'default'     => false,
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_navigation',
		'name'        => esc_html__( 'Projects navigation', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'portfolio-projects-navigation.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Next and previous projects links on single project page', 'woodmart' ),
		'group'       => esc_html__( 'Elements', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'portfolio_singe_project_section',
		'default'     => '1',
		'priority'    => 30,
		'class'       => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_related',
		'name'        => esc_html__( 'Related projects', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'project-related-projects.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Show related projects carousel.', 'woodmart' ),
		'group'       => esc_html__( 'Elements', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'portfolio_singe_project_section',
		'default'     => '1',
		'priority'    => 40,
		'class'       => 'xts-col-6',
	)
);
