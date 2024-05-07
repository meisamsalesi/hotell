<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Array of versions for dummy content import section
 * ------------------------------------------------------------------------------------------------
 */
return apply_filters(
	'woodmart_get_versions_to_import',
	[
		'main'                  => [
			'title'      => 'Woodmart Main',
			'process'    => 'xml,home,options,widgets,headers,sliders,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/home/',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'food-delivery'            => [
			'title'      => 'Food Delivery',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'event-agency'            => [
			'title'      => 'Event Agency',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'developer'            => [
			'title'      => 'Developer',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'architecture-studio'            => [
			'title'      => 'Architecture Studio',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'mega-electronics'            => [
			'title'      => 'Mega Electronics',
			'process'    => 'xml,home,options,widgets,headers,sliders',
			'type'       => 'version',
			'base'       => 'mega-electronics_base',
			'link'       => 'https://woodmart.xtemos.com/mega-electronics/',
			'categories' => [
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'megamarket'            => [
			'title'      => 'Megamarket',
			'process'    => 'xml,home,options,widgets,headers,sliders',
			'type'       => 'version',
			'base'       => 'megamarket_base',
			'link'       => 'https://woodmart.xtemos.com/megamarket/',
			'categories' => [
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'accessories'            => [
			'title'      => 'Accessories',
			'process'    => 'xml,home,options,widgets,headers,sliders',
			'type'       => 'version',
			'base'       => 'accessories_base',
			'link'       => 'https://woodmart.xtemos.com/accessories/',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'smart-home'            => [
			'title'      => 'Smart Home',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'school'                => [
			'title'   => 'School',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'real-estate'           => [
			'title'   => 'Real Estate',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
			],
		],
		'beauty'                => [
			'title'      => 'Beauty',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'sweets-bakery'         => [
			'title'   => 'Sweets Bakery',
			'process' => 'xml,home,options,widgets,headers,sliders,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'decor'                 => [
			'title'      => 'Decor',
			'process'    => 'xml,home,options,widgets,wood_slider,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'retail'                => [
			'title'      => 'Retail',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'books'                 => [
			'title'   => 'Books',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'shoes'                 => [
			'title'      => 'Shoes',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'marketplace'           => [
			'title'      => 'Marketplace',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'electronics'           => [
			'title'      => 'Electronics',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'fashion-color'         => [
			'title'      => 'Fashion Color',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/demo-fashion-colored/demo/fashion-colored/',
			'categories' => [
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'fashion-minimalism'    => [
			'title'      => 'Fashion Minimalism',
			'process'    => 'xml,home,options,widgets,headers,sliders,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'tools'                 => [
			'title'      => 'Tools',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'grocery'               => [
			'title'   => 'Grocery',
			'process' => 'xml,home,options,widgets,headers,sliders,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'lingerie'              => [
			'title'      => 'Lingerie',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'glasses'               => [
			'title'      => 'Glasses',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'black-friday'          => [
			'title'      => 'Black Friday',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'retail-2'              => [
			'title'      => 'Retail 2',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'handmade'              => [
			'title'      => 'Handmade',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/handmade/',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'repair'                => [
			'title'      => 'Repair',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'lawyer'                => [
			'title'   => 'Lawyer',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
			],
		],
		'corporate-2'           => [
			'title'   => 'Corporate 2',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
			],
		],
		'drinks'                => [
			'title'   => 'Drinks',
			'process' => 'xml,home,options,widgets,headers,images,sliders',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'medical-marijuana'     => [
			'title'   => 'Medical Marijuana',
			'process' => 'xml,home,options,widgets,headers,sliders,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'electronics-2'         => [
			'title'      => 'Electronics 2',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'fashion'               => [
			'title'      => 'Fashion',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'medical'               => [
			'title'   => 'Medical',
			'process' => 'xml,home,options,widgets,headers,sliders,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'coffee'                => [
			'title'   => 'Coffee',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'camping'               => [
			'title'   => 'Camping',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'alternative-energy'    => [
			'title'      => 'Alternative Energy',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'flowers'               => [
			'title'   => 'Flowers',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'fashion-flat'          => [
			'title'      => 'Fashion Flat',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/demo-fashion-flat/demo/flat/',
			'categories' => [
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'bikes'                 => [
			'title'   => 'Bikes',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'wine'                  => [
			'title'   => 'Wine',
			'process' => 'xml,home,options,widgets,headers,sliders,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'landing-gadget'        => [
			'title'      => 'Landing Gadget',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'travel'                => [
			'title'   => 'Travel',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
			],
		],
		'corporate'             => [
			'title'   => 'Corporate',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
			],
		],
		'magazine'              => [
			'title'   => 'Magazine',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'link'    => 'https://woodmart.xtemos.com/magazine/',
			'categories' => [
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
			],
		],
		'hardware'              => [
			'title'      => 'Hardware',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/demo-hardware/?opt=hardware',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'food'                  => [
			'title'   => 'Food',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'cosmetics'             => [
			'title'      => 'Cosmetics',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'motorcycle'            => [
			'title'   => 'Motorcycle',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'sport'                 => [
			'title'   => 'Sport',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'minimalism'            => [
			'title'      => 'Minimalism',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'organic'               => [
			'title'   => 'Organic',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'watches'               => [
			'title'      => 'Watches',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/demo-watches/demo/watch/',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'digitals'              => [
			'title'      => 'Digital',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'jewellery'             => [
			'title'      => 'Jewellery',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
				[
					'name' => 'Fashion',
					'slug' => 'fashion',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'toys'                  => [
			'title'   => 'Toys',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'mobile-app'            => [
			'title'      => 'Mobile App',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/demo-mobile-app/?opt=mobile_app',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Corporate',
					'slug' => 'corporate',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'christmas'             => [
			'title'   => 'Christmas',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'dark'                  => [
			'title'   => 'Dark',
			'process' => 'xml,home,options,widgets,sliders,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'link'    => 'https://woodmart.xtemos.com/demo-dark/?opt=dark',
			'categories' => [
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'cars'                  => [
			'title'   => 'Cars',
			'process' => 'xml,home,options,widgets,headers,images',
			'type'    => 'version',
			'base'    => 'base',
			'link'    => 'https://woodmart.xtemos.com/home-cars/demo/cars/',
			'categories' => [
				[
					'name' => 'Business',
					'slug' => 'business',
				],
			],
		],
		'furniture'             => [
			'title'      => 'Furniture',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'base-light'            => [
			'title'      => 'Base Light',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/demo-light/?opt=light',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'base-rtl'              => [
			'title'      => 'Base rtl',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/home-rtl/?rtl/',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'basic'                 => [
			'title'      => 'Basic',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-basic/?opt=layout_basic',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'boxed'                 => [
			'title'      => 'Boxed',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-boxed/?opt=layout_boxed',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'categories'            => [
			'title'      => 'Categories',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-categories/?opt=layout_categories',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'landing'               => [
			'title'      => 'Landing',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/landing/?opt=layout_landing',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'lookbook'              => [
			'title'      => 'Lookbook',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-lookbook/?opt=layout_lookbook',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'fullscreen'            => [
			'title'      => 'Fullscreen',
			'process'    => 'xml,home,widgets,sliders,headers,images,options',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-fullscreen/?opt=layout_fullscreen',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'video'                 => [
			'title'      => 'Video',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-video/?opt=layout_video',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'parallax'              => [
			'title'      => 'Parallax',
			'process'    => 'xml,home,options,widgets,sliders,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-parallax/?opt=layout_parallax',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'infinite-scrolling'    => [
			'title'      => 'Infinite Scrolling',
			'process'    => 'xml,home,options,widgets,wood_slider,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/infinite-scrolling/?opt=layout_infinite',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'grid'                  => [
			'title'      => 'Grid',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-grid-2/?opt=layout_grid2',
			'categories' => [
				[
					'name' => 'Furniture',
					'slug' => 'furniture',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'digital-portfolio'     => [
			'title'      => 'Digital Portfolio',
			'process'    => 'xml,home,options,widgets,headers,images',
			'type'       => 'version',
			'base'       => 'base',
			'link'       => 'https://woodmart.xtemos.com/layout-digital-portfolio/?opt=layout_digital_portfolio',
			'categories' => [
				[
					'name' => 'Electronics',
					'slug' => 'electronics',
				],
				[
					'name' => 'Shop',
					'slug' => 'shop',
				],
			],
		],
		'base'                  => [
			'title'   => 'Base content (required)',
			'process' => 'xml,xml_images,widgets,options,headers',
			'type'    => 'base',
		],
		'megamarket_base'       => [
			'title'   => 'Base content megamarket (required)',
			'process' => 'xml,xml_images,widgets,options,headers',
			'type'    => 'base',
		],
		'accessories_base'      => [
			'title'   => 'Base content accessories (required)',
			'process' => 'xml,xml_images,widgets,options,headers',
			'type'    => 'base',
		],
		'mega-electronics_base' => [
			'title'   => 'Base content mega electronics (required)',
			'process' => 'xml,xml_images,widgets,options,headers',
			'type'    => 'base',
		],

		/**
		 * Pages.
		 */
		'contact-us'            => [
			'title'   => 'Contact Us',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Contact',
					'slug' => 'contact',
				],
			],
		],
		'contact-us-2'          => [
			'title'   => 'Contact Us 2',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Contact',
					'slug' => 'contact',
				],
			],
		],
		'contact-us-3'          => [
			'title'   => 'Contact Us 3',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Contact',
					'slug' => 'contact',
				],
			],
		],
		'contact-us-4'          => [
			'title'   => 'Contact Us 4',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Contact',
					'slug' => 'contact',
				],
			],
		],
		'about-us'              => [
			'title'   => 'Old About Us',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'About',
					'slug' => 'about',
				],
			],
		],
		'about-us-2'            => [
			'title'      => 'Old About Us 2',
			'process'    => 'xml',
			'type'       => 'page',
			'categories' => [
				[
					'name' => 'About',
					'slug' => 'about',
				],
			],
		],
		'about-us-3'            => [
			'title'   => 'About Us',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'About',
					'slug' => 'about',
				],
			],
		],
		'about-us-4'            => [
			'title'   => 'About Us 2',
			'process' => 'xml,headers',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'About',
					'slug' => 'about',
				],
			],
		],
		'about-me'              => [
			'title'   => 'Old About Me',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'About',
					'slug' => 'about',
				],
			],
		],
		'about-me-2'            => [
			'title'   => 'About Me',
			'process' => 'xml,headers',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'About',
					'slug' => 'about',
				],
			],
		],
		'about-factory'         => [
			'title'   => 'About Factory',
			'process' => 'xml',
			'type'    => 'page',
			'link'    => 'https://woodmart.xtemos.com/handmade/about-factory/',
			'categories' => [
				[
					'name' => 'About',
					'slug' => 'about',
				],
			],
		],
		'our-team'              => [
			'title'   => 'Old Our Team',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Team',
					'slug' => 'team',
				],
			],
		],
		'our-team-2'            => [
			'title'   => 'Our Team',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Team',
					'slug' => 'team',
				],
			],
		],
		'faqs'                  => [
			'title'   => 'FAQs',
			'process' => 'xml',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'FAQs',
					'slug' => 'faq',
				],
			],
		],
		'faqs-2'                => [
			'title'   => 'FAQs 2',
			'process' => 'xml',
			'type'    => 'page',
			'link'    => 'https://woodmart.xtemos.com/faqs-two/',
			'categories' => [
				[
					'name' => 'FAQs',
					'slug' => 'faq',
				],
			],
		],
		'custom-404'            => [
			'title'   => 'Custom-404',
			'process' => 'xml',
			'type'    => 'page',
			'link'    => 'https://woodmart.xtemos.com/custom-404-page/',
			'categories' => [
				[
					'name' => '404',
					'slug' => '404page',
				],
			],
		],
		'custom-404-2'          => [
			'title'   => 'Custom-404-2',
			'process' => 'xml',
			'type'    => 'page',
			'link'    => 'https://woodmart.xtemos.com/custom-404-page-2/',
			'categories' => [
				[
					'name' => '404',
					'slug' => '404page',
				],
			],
		],
		'christmas-maintenance' => [
			'title'   => 'Christmas maintenance',
			'process' => 'xml,options',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Maintenance',
					'slug' => 'maintenance',
				],
			],
		],
		'maintenance'           => [
			'title'   => 'Maintenance',
			'process' => 'xml,options',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Maintenance',
					'slug' => 'maintenance',
				],
			],
		],
		'maintenance-2'         => [
			'title'   => 'Maintenance 2',
			'process' => 'xml,options',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Maintenance',
					'slug' => 'maintenance',
				],
			],
		],
		'maintenance-3'         => [
			'title'   => 'Maintenance 3',
			'process' => 'xml,options',
			'type'    => 'page',
			'categories' => [
				[
					'name' => 'Maintenance',
					'slug' => 'maintenance',
				],
			],
		],
		'custom-privacy-policy' => [
			'title'   => 'Custom Privacy Policy',
			'process' => 'xml',
			'type'    => 'page',
			'link'    => 'https://woodmart.xtemos.com/privacy-policy/',
		],
		'track-order'           => [
			'title'   => 'Track Order',
			'process' => 'xml',
			'type'    => 'page',
		],

		/**
		 * Element.
		 */

		'product-filters'       => [
			'title'   => 'Product filters',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'parallax-scrolling'    => [
			'title'   => 'Parallax scrolling',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'animations'            => [
			'title'   => 'Animations',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'sliders'               => [
			'title'   => 'Sliders',
			'process' => 'xml,wood_slider',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'image-hotspot'         => [
			'title'   => 'Image Hotspot',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'list-element'          => [
			'title'   => 'List-element',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'buttons'               => [
			'title'   => 'Buttons',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'video-element'         => [
			'title'   => 'Video-element',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'timeline'              => [
			'title'   => 'Timeline',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'top-rated-products'    => [
			'title'   => 'Top Rated Products',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'sale-products'         => [
			'title'   => 'Sale Products',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'products-categories'   => [
			'title'   => 'Products Categories',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'products-category'     => [
			'title'   => 'Products Category',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'products-by-id'        => [
			'title'   => 'Products by ID',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'featured-products'     => [
			'title'   => 'Featured Products',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'recent-products'       => [
			'title'   => 'Recent Products',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'gradients'             => [
			'title'   => 'Gradients',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'section-dividers'      => [
			'title'   => 'Section Dividers',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'brands-element'        => [
			'title'   => 'Brands Element',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'button-with-popup'     => [
			'title'   => 'Button with popup',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'ajax-products-tabs'    => [
			'title'   => 'AJAX products tabs',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'animated-counter'      => [
			'title'   => 'Animated counter',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'products-widgets'      => [
			'title'   => 'Products widgets',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'products-grid'         => [
			'title'   => 'Products grid',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'blog-element'          => [
			'title'   => 'Blog element',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'portfolio-element'     => [
			'title'   => 'Portfolio element',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'menu-price'            => [
			'title'   => 'Menu price',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'360-degree-view'       => [
			'title'   => '360 degree view',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'countdown-timer'       => [
			'title'   => 'Countdown timer',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'testimonials'          => [
			'title'   => 'Testimonials',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'team-member'           => [
			'title'   => 'Team member',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'social-buttons'        => [
			'title'   => 'Social Buttons',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'instagram'             => [
			'title'   => 'Instagram',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'google-maps'           => [
			'title'   => 'Google maps',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'banners'               => [
			'title'   => 'Banners',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'carousels'             => [
			'title'   => 'Carousels',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'titles'                => [
			'title'   => 'Titles',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'images-gallery'        => [
			'title'   => 'Images gallery',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'pricing-tables'        => [
			'title'   => 'Pricing Tables',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
		'infobox'               => [
			'title'   => 'Infobox',
			'process' => 'xml',
			'type'    => 'element',
			'categories' => [
				[
					'name' => 'Element',
					'slug' => 'element',
				],
			],
		],
	]
);
