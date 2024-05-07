<?php
/**
 * Predefined layouts template.
 *
 * @package Woodmart
 *
 * @var array $layouts Layouts.
 */

?>
<?php foreach ( $layouts as $layout_type => $values ) : ?>
	<div class="xts-layout-predefined-layouts xts-images-set xts-hidden" data-type="<?php echo esc_attr( $layout_type ); ?>">
		<label><?php esc_html_e( 'Predefined layouts', 'woodmart' ); ?></label>
		<div class="xts-btns-set">
			<?php foreach ( $values as $layout => $data ) : ?>
				<div class="xts-layout-predefined-layout xts-set-item xts-set-btn-img" data-name="<?php echo esc_attr( $layout ); ?>">
					<img src="<?php echo esc_url( WOODMART_THEME_DIR . '/inc/modules/layouts/admin/predefined/' . $layout_type . '/' . $layout . '/preview.jpg' ); ?>" alt="<?php echo esc_attr__( 'Layout preview', 'woodmart' ); ?>">
					<?php if ( ! empty( $data['url'] ) ) : ?>
						<div class="xts-import-preview-wrap">
							<a href="<?php echo esc_url( $data['url'] ); ?>" class="xts-btn xts-color-primary xts-import-item-preview xts-i-view" target="_blank">
								<?php esc_html_e( 'Live preview', 'woodmart' ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endforeach; ?>
