<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'general' => array(
		'title'   => __( 'General', 'unyson' ),
		'type'    => 'tab',
		'options' => array(
			'general-box' => array(
				'title'   => __( 'General Settings', 'unyson' ),
				'type'    => 'box',
				'options' => array(
					'logo'    => array(
						'label' => __( 'Logo', 'unyson' ),
						'desc'  => __( 'Write your website logo name', 'unyson' ),
						'type'  => 'text',
						'value' => get_bloginfo( 'name' )
					),
					'favicon' => array(
						'label' => __( 'Favicon', 'unyson' ),
						'desc'  => __( 'Upload a favicon image', 'unyson' ),
						'type'  => 'upload'
					)
				)
			),
		)
		),
		'general' => array(
			'title'   => __( 'صفحه اصلی', 'unyson' ),
			'type'    => 'tab',
			'options' => array(
				'general-box' => array(
					'title'   => __( 'عمومی', 'unyson' ),
					'type'    => 'box',
					'options' => array(
						'top_title'                      => array(
							'label' => __( 'عنوان صفحه', 'unyson' ),
							'type'  => 'text',
							'value' => 'بزرگ ترین هاستینگ ایران',
						),
						'logo_site' => array(
							'label' => __( 'لوگو وبسایت', 'unyson' ),
							'type'  => 'upload',
					),
				)
				)
				)
		)

);