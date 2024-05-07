<?php
/**
 * Dummy content template.
 *
 * @package woodmart
 */

use XTS\Import\Remove;
use XTS\Import\Import;

$wrapper_classes = '';

if ( Import::get_instance()->is_imported( 'base' ) && Remove::get_instance()->has_data_to_remove() ) {
	$wrapper_classes .= ' imported-base';
}
?>

<div class="xts-wizard-content-inner xts-wizard-dummy<?php echo esc_attr( $wrapper_classes ); ?>">
	<?php Import::get_instance()->render(); ?>

	<p class="xts-note">
		<?php
		echo wp_kses(
			'You can import any of the demo versions that will include a home page, a few products, posts, projects, images and menus. You will be able to switch to any demo at any time or just skip this step for now.',
			woodmart_get_allowed_html()
		);
		?>
	</p>
</div>

<div class="xts-wizard-footer">
	<?php $this->get_prev_button( 'plugins' ); ?>
	<div>
		<?php $this->get_next_button( 'done' ); ?>
		<?php $this->get_skip_button( 'done' ); ?>
	</div>
</div>


<div class="xts-wizard-content-inner xts-wizard-done">
	<div class="xts-wizard-logo">
		<img src="<?php echo esc_url( $this->get_image_url( 'logo.svg' ) ); ?>" alt="logo">
	</div>

	<h3>
		<?php esc_html_e( 'Everything is ready!', 'woodmart' ); ?>
	</h3>

	<p>
		<?php
		esc_html_e(
			'Congratulations! You have successfully installed our theme. Now you can start creating your amazing website with a help of our theme. It provides you with a full control on your website layout style.',
			'woodmart'
		);
		?>
	</p>

	<div class="xts-wizard-buttons">
		<a class="xts-btn xts-color-primary xts-i-view" href="<?php echo esc_url( get_home_url() ); ?>">
			<?php esc_html_e( 'View home page', 'woodmart' ); ?>
		</a>

		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a class="xts-inline-btn xts-i-cart" href="<?php echo esc_url( wc_admin_url( '&path=/setup-wizard' ) ); ?>">
				<?php esc_html_e( 'WooCommerce setup', 'woodmart' ); ?>
			</a>
		<?php endif; ?>

		<a class="xts-inline-btn xts-i-theme-settings" href="<?php echo esc_url( admin_url( 'admin.php?page=xts_theme_settings' ) ); ?>">
			<?php esc_html_e( 'Theme settings', 'woodmart' ); ?>
		</a>

		<a class="xts-inline-btn xts-i-header-builder" href="<?php echo esc_url( admin_url( 'admin.php?page=xts_header_builder' ) ); ?>">
			<?php esc_html_e( 'Header builder', 'woodmart' ); ?>
		</a>
	</div>
</div>