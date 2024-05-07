<?php
/**
 * Login messages
 */

$message = wp_cache_get( 'jet-login-messages' );

if ($message) {
	wp_cache_delete( 'jet-login-messages' );
	wp_cache_flush();
}

if ( ! $message ) {
	return;
}

?>
<div class="jet-login-message"><?php
	echo $message;
?></div>