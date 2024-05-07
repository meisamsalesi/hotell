<?php

add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 1000 );

function woodmart_child_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
}

