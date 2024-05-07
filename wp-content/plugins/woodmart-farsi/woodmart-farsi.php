<?php
/*
Plugin Name: فارسی ساز وودمارت
Plugin URI: http://i-wp.ir/
Description: این یک افزووه برای آپدیت ترجمه های فارسی قالب وودمارت نسخه ژاکت می باشد.
Version: 1.0
Author: وردپرس من
Author URI: http://i-wp.ir/
*/

register_activation_hook( __FILE__, 'copy_file_on_activation' );
function copy_file_on_activation() {
    $filename = 'woodmart-fa_IR.mo';
    $source = plugin_dir_path( __FILE__ ) . $filename;
    $destination = ABSPATH . '/wp-content/languages/themes/' . $filename;
    copy( $source, $destination );  
}
?>