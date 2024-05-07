<?php if ( ! defined("WOODMART_THEME_DIR")) exit("No direct script access allowed");

/**
 * ------------------------------------------------------------------------------------------------
 * Default header builder settings
 * ------------------------------------------------------------------------------------------------
 */

$header_settings = array(
    'overlap' => array(
        'id' => 'overlap',
        'title' => 'همپوشانی سربرگ روی محتوا',
        'type' => 'switcher',
        'tab' => 'General',
        'value' => false,
        'description' => 'سربرگ را روی محتوای برگه همپوشانی کن.'
    ),
	'boxed' => array(
		'id' => 'boxed',
		'title' => 'جعبه ای کن',
		'type' => 'switcher',
		'tab' => 'General',
		'value' => false,
		'description' => 'سربرگ به جای حالت تمام عرض، جعبه ای خواهد بود.',
		'requires' => array(
			'overlap' => array(
				'comparison' => 'equal',
				'value' => true
			),
	  	),
	),
	'full_width' => array(
        'id' => 'full_width',
        'title' => 'سربرگ تمام عرض',
        'type' => 'switcher',
        'tab' => 'General',
        'value' => false,
        'description' => 'چیدمان تمام عرض برای شامل شونده ی محتوای سربرگ'
    ),
	'dropdowns_dark' => array(
        'id' => 'dropdowns_dark',
        'title' => 'آبشاری تیره',
        'type' => 'switcher',
        'tab' => 'General',
        'value' => false,
        'description' => 'همه ی قسمت های آبشاری سربرگ را تیره کن.'
    ),
    'sticky_shadow' => array(
        'id' => 'sticky_shadow',
        'title' => 'سایه سربرگ چسبان',
        'type' => 'switcher',
        'tab' => 'سربرگ چسبان',
        'value' => true,
        'description' => 'یک سایه برای سربرگ چسبان اضافه کن.'
    ),
	'hide_on_scroll' => array(
		'id' => 'hide_on_scroll',
		'title' => esc_html__( 'مخفی کردن هنگام اسکرول به پایین', 'woodmart' ),
		'type' => 'switcher',
		'tab' => 'سربرگ چسبان',
		'value' => false,
		'description' => esc_html__( 'Make this row sticky on scroll.', 'woodmart' ),
	),
	'sticky_effect' => array(
	  'id' => 'sticky_effect',
	  'title' => 'افکت چسبان',
	  'type' => 'selector',
	  'tab' => 'سربرگ چسبان',
	  'value' => 'stick',
	  'options' => array(
		'stick' => array(
		  'value' => 'stick',
		  'label' => 'چسبان هنگام اسکرول',
		),
		'slide' => array(
		  'value' => 'slide',
		  'label' => 'ظاهر شدن بعد از اسکرول به پایین',
		),
	  ),
	  'description' => 'You can choose between two types of sticky header effects.'
	),
	'sticky_clone' => array(
        'id' => 'sticky_clone',
        'title' => 'کپی کردن سربرگ چسبان',
        'type' => 'switcher',
        'tab' => 'سربرگ چسبان',
        'value' => false,
        'requires' => array(
          'sticky_effect' => array(
            'comparison' => 'equal',
            'value' => 'slide'
          )
        ),
        'description' => 'سربرگ چسبان عناصرش را از سربرگ اصلی دوبل میکند.'
    ),
	'sticky_height' => array(
      'id' => 'sticky_height',
      'title' => 'ارتفاع سربرگ چسبان',
      'type' => 'slider',
      'tab' => 'سربرگ چسبان',
      'from' => 0,
      'to'=> 200,
      'value' => 50,
      'units' => 'px',
      'description' => 'ارتفاع سربرگ چسبان را به پیکسل وارد کنید.',
      'requires' => array(
        'sticky_clone' => array(
          'comparison' => 'equal',
          'value' => true
        ),
        'sticky_effect' => array(
          'comparison' => 'equal',
          'value' => 'slide'
        )
      ),
    ),
);

return apply_filters( 'woodmart_default_header_settings', $header_settings );
