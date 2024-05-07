<?php

function style_function(){
    wp_enqueue_style( 'style-name', get_template_directory_uri());
    wp_enqueue_style( "style1", get_template_directory_uri() ."/assets/css/animate.min.css");
    wp_enqueue_style( "style2", get_template_directory_uri() ."/assets/css/bootstrap.min.css");
    wp_enqueue_style( "style3", get_template_directory_uri() ."/assets/css/default.css");
    wp_enqueue_style( "style4", get_template_directory_uri() ."/assets/css/fontawesome-all.min.css");
    wp_enqueue_style( "style5", get_template_directory_uri() ."/assets/css/magnific-popup.css");
    wp_enqueue_style( "style6", get_template_directory_uri() ."/assets/css/meanmenu.css");
    wp_enqueue_style( "style7", get_template_directory_uri() ."/assets/css/nice-select.css");
    wp_enqueue_style( "style8", get_template_directory_uri() ."/assets/css/owl.carousel.min.css");
    wp_enqueue_style( "style9", get_template_directory_uri() ."/assets/css/responsive.css");
    wp_enqueue_style( "style10", get_template_directory_uri() ."/assets/css/slick.css");
    wp_enqueue_style( "style11", get_template_directory_uri() ."/assets/css/style.css");
    
    wp_enqueue_script("script1",get_template_directory_uri() . "/assets/js/vendor/jquery-1.12.4.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script2",get_template_directory_uri() . "/assets/js/ajax-form.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script3",get_template_directory_uri() . "/assets/js/bootstrap.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script4",get_template_directory_uri() . "/assets/js/imagesloaded.pkgd.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script5",get_template_directory_uri() . "/assets/js/isotope.pkgd.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script6",get_template_directory_uri() . "/assets/js/jquery.magnific-popup.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script7",get_template_directory_uri() . "/assets/js/jquery.meanmenu.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script8",get_template_directory_uri() . "/assets/js/jquery.nice-select.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script9",get_template_directory_uri() . "/assets/js/jquery.scrollUp.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script10",get_template_directory_uri() . "/assets/js/main.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script11",get_template_directory_uri() . "/assets/js/owl.carousel.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script12",get_template_directory_uri() . "/assets/js/plugins.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script13",get_template_directory_uri() . "/assets/js/popper.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script14",get_template_directory_uri() . "/assets/js/slick.min.js",array() ,'1.0.0' , true);
    wp_enqueue_script("script15",get_template_directory_uri() . "/assets/js/wow.min.js",array() ,'1.0.0' , true);
}


add_action("wp_enqueue_scripts","style_function");

function features(){

    register_nav_menus(array(
        'primary_menu'=>'منو اصلی',
        'footer_menu'=>'منو فوتر' 
    )) ;

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme','features');

/**
 * Add a sidebar.
 */
function Min_SideBar() {
	register_sidebar( array(
		'name'          => 'ساید بار اصلی',
		'id'            => 'sidebar-1'
	) );
}
add_action( 'widgets_init', 'Min_SideBar' );
?>