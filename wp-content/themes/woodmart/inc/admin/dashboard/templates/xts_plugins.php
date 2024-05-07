<?php
wp_enqueue_script( 'wd-setup-wizard', WOODMART_ASSETS . '/js/wizard.js', array(), WOODMART_VERSION, true );
?>

<div class="xts-box xts-theme-style">
	<div class="xts-box-header">
		<h3>
			<?php esc_html_e( 'Theme plugins', 'woodmart' ); ?>
		</h3>
	</div>

	<div class="xts-box-content">
		<?php
		get_template_part(
			'inc/admin/setup-wizard/templates/plugins',
			'',
			array( 'show_plugins' => 'theme_plugin' )
		);
		?>
	</div>
	<?php if ( ! woodmart_get_opt( 'white_label' ) ) : ?>
		<div class="xts-box-footer">
			<p>Plugins marked with "Required" label are needed for the smooth operation of the WoodMart theme. Other plugins provide additional functionality but may be deleted if they are not necessary.</p>
		</div>
	<?php endif; ?>
</div>

<div class="xts-box xts-theme-style">
	<div class="xts-box-header">
		<h3>
			<?php esc_html_e( 'Compatible plugins', 'woodmart' ); ?>
		</h3>
	</div>

	<div class="xts-box-content">
		<?php
		get_template_part(
			'inc/admin/setup-wizard/templates/plugins',
			'',
			array( 'show_plugins' => 'compatible' )
		);
		?>
	</div>
	<?php if ( ! woodmart_get_opt( 'white_label' ) ) : ?>
		<div class="xts-box-footer">
			<p>Didn't find a compatible plugin? <a href="https://xtemos.com/forums/forum/woodmart-premium-template/">Get help</a></p>
		</div>
	<?php endif; ?>
</div>
