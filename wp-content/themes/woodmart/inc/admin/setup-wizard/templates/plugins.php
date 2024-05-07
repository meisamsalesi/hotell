<?php
/**
 * Plugins template.
 *
 * @package woodmart
 */

use XTS\Install_Plugins;
use XTS\Setup_Wizard;

if ( isset( $_GET['wd_builder'] ) ) {
	$builder = esc_html( $_GET['wd_builder'] );
} elseif ( woodmart_get_current_page_builder() ) {
	$builder = woodmart_get_current_page_builder();
} else {
	$builder = 'elementor';
}

$dashboard       = Setup_Wizard::get_instance();
$install_plugins = Install_Plugins::get_instance();

if ( isset( $args['show_plugins'] ) && 'compatible' === $args['show_plugins'] ) {
	$plugins_list = woodmart_get_config( 'compatible-plugins' );
} else {
	$plugins_list = $install_plugins->get_plugins();
}

if ( $dashboard->is_setup() ) {
	$button_item_class = 'xts-inline-btn xts-style-underline';
} else {
	$button_item_class = 'xts-btn';
}

?>
<div class="xts-plugins<?php echo $install_plugins->is_all_activated() ? ' xts-all-active' : ''; ?>">
	<div class="xts-plugin-response"></div>

	<?php if ( $dashboard->is_setup() ) : ?>
		<h3>
			<?php esc_html_e( 'Plugins activation', 'woodmart' ); ?>
		</h3>

		<p>
			<?php esc_html_e( 'Install and activate plugins for you website.', 'woodmart' ); ?>
		</p>
	<?php endif; ?>

	<ul>
		<?php foreach ( $plugins_list as $slug => $plugin_data ) : ?>
			<?php $image_url = isset( $plugin_data['image'] ) ? $plugin_data['image'] : $slug . '.svg'; ?>
			<li class="xts-plugin-wrapper<?php echo isset( $plugin_data['description'] ) ? ' xts-large' : ''; ?>">
				<div class="xts-plugin-heading">
					<div class="xts-plugin-img">
						<img src="<?php echo esc_url( $dashboard->get_plugin_image_url( $image_url ) ); ?>" alt="plugin logo">
					</div>

					<span class="xts-plugin-name">
						<?php echo esc_html( $plugin_data['name'] ); ?>
					</span>
				</div>

					<span class="xts-plugin-required">
						<?php if ( ! empty( $plugin_data['required'] ) || 'elementor' === $slug || 'js_composer' === $slug ) : ?>
							<span class="xts-plugin-required-dot"></span>
							<span class="xts-plugin-required-text">
								<?php esc_html_e( 'Required', 'woodmart' ); ?>
							</span>
						<?php endif; ?>
					</span>

				<?php if ( ! empty( $plugin_data['description'] ) ) : ?>
					<div class="xts-plugin-description">
						<?php echo esc_html( $plugin_data['description'] ); ?>
					</div>
				<?php endif; ?>

				<span class="xts-plugin-version">
					<?php if ( ! empty( $plugin_data['version'] ) ) : ?>
						<span>
							<?php echo esc_html( $plugin_data['version'] ); ?>
						</span>
					<?php endif; ?>
				</span>

				<div class="xts-plugin-btn-wrapper">
					<?php if ( is_multisite() && is_plugin_active_for_network( $plugin_data['file_path'] ) ) : ?>
						<span class="xts-plugin-btn-text">
							<?php esc_html_e( 'Plugin activated globally.', 'woodmart' ); ?>
						</span>
					<?php elseif ( isset( $plugin_data['status'] ) && 'require_update' !== $plugin_data['status'] ) : ?>
						<a class="<?php echo esc_attr( $button_item_class ); ?> xts-ajax-plugin xts-<?php echo esc_html( $plugin_data['status'] ); ?>"
							href="<?php echo esc_url( $install_plugins->get_action_url( $slug, $plugin_data['status'] ) ); ?>"
							data-plugin="<?php echo esc_attr( $slug ); ?>"
							data-builder="<?php echo esc_attr( $builder ); ?>"
							data-action="<?php echo esc_attr( $plugin_data['status'] ); ?>">
							<span><?php echo esc_html( $install_plugins->get_action_text( $plugin_data['status'] ) ); ?></span>
						</a>
					<?php elseif ( $dashboard->is_setup() ) : ?>
						<span class="xts-plugin-btn-text">
							<?php esc_html_e( 'Required update not available', 'woodmart' ); ?>
						</span>
					<?php endif; ?>

					<?php if ( isset( $plugin_data['buttons'] ) ) : ?>
						<?php foreach ( $plugin_data['buttons'] as $button ) : ?>
							<a href="<?php echo esc_url( $button['url'] ); ?>" class="xts-btn<?php echo isset( $button['extra-class'] ) ? ' ' . esc_attr( $button['extra-class'] ) : ''; ?>">
								<?php echo esc_html( $button['name'] ); ?>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php if ( $plugins_list && ( ! isset( $args['show_plugins'] ) || 'compatible' !== $args['show_plugins'] ) ) : ?>
		<script>
			var xtsPluginsData = <?php echo wp_json_encode( $plugins_list ); ?>
		</script>
	<?php endif; ?>
</div>

<?php if ( $dashboard->is_setup() ) : ?>
	<div class="xts-wizard-footer">
			<?php $dashboard->get_prev_button( 'page-builder' ); ?>
		<div>
			<a class="xts-inline-btn xts-style-underline xts-wizard-all-plugins" href="#">
				<?php esc_html_e( 'Install & activate all', 'woodmart' ); ?>
			</a>
			<?php $dashboard->get_next_button( 'prebuilt-websites', '', count( $install_plugins->get_required_plugins_to_activate() ) > 0 ); ?>
		</div>
	</div>
<?php endif; ?>
