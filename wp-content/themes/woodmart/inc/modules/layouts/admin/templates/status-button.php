<?php

$classes = '';

if ( 'publish' === $status ) {
	$classes .= ' xts-active';
}
?>


<div class="xts-switcher-btn<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>" data-status="<?php echo esc_attr( $status ); ?>">
	<div class="xts-switcher-dot-wrap">
		<div class="xts-switcher-dot"></div>
	</div>
	<div class="xts-switcher-labels">
		<span class="xts-switcher-label xts-on">
			<?php esc_html_e( 'On', 'woodmart' ); ?>
		</span>

		<span class="xts-switcher-label xts-off">
			<?php esc_html_e( 'Off', 'woodmart' ); ?>
		</span>
	</div>
</div>
