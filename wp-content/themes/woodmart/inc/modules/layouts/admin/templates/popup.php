<?php
/**
 * Popup template.
 *
 * @package Woodmart
 *
 * @var string $btn_text     Button text.
 * @var string $btn_classes  Button classes.
 * @var string $title_text   Title text.
 * @var string $content      Content.
 */

$btn_classes = isset( $btn_classes ) ? $btn_classes : '';

wp_enqueue_style( 'wd-admin-page-layouts', WOODMART_ASSETS . '/css/parts/page-layouts.min.css', array(), WOODMART_VERSION );
?>
<div class="xts-popup-holder">
	<div class="xts-popup-overlay"></div>
	<?php if ( $btn_text ) : ?>
		<a href="javascript:void(0);" class="xts-popup-opener xts-btn xts-color-primary<?php echo esc_attr( $btn_classes ); ?>">
			<?php echo esc_html( $btn_text ); ?>
		</a>
	<?php endif; ?>

	<div class="xts-popup xts-theme-style">
		<div class="xts-popup-inner">
			<div class="xts-popup-header">
				<div class="xts-popup-title">
					<?php echo esc_html( $title_text ); ?>
				</div>

				<a href="javascript:void(0);" class="xts-popup-close xts-i-close">
					<?php esc_html_e( 'Close', 'woodmart' ); ?>
				</a>
			</div>

			<div class="xts-popup-content">
				<div class="xts-notices-wrapper xts-layout-popup-notices"></div>

				<?php echo $content; // phpcs:ignore ?>
			</div>
		</div>
	</div>
</div>
