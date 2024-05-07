<div class="xts-box xts-status xts-theme-style">
	<div class="xts-box-header">
		<h3>
			<?php esc_html_e( 'Status', 'woodmart' ); ?>
		</h3>
	</div>

	<div class="xts-box-content">
		<h4>
			<?php esc_html_e( 'WordPress', 'woodmart' ); ?>
		</h4>
		<div class="xts-table xts-odd">
			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'Theme Name', 'woodmart' ); ?>:
				</div>
				<div>
					<?php if ( woodmart_get_opt( 'white_label', '0' ) ) : ?>
						<?php echo esc_html( woodmart_get_opt( 'white_label_theme_name' ) ); ?>
					<?php else : ?>
						<?php echo esc_html( woodmart_get_theme_info( 'Name' ) ); ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'Theme Version', 'woodmart' ); ?>:
				</div>
				<div>
					<?php echo esc_html( WOODMART_VERSION ); ?>
				</div>
			</div>

			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'WP Version', 'woodmart' ); ?>:
				</div>
				<div>
					<?php echo esc_html( get_bloginfo( 'version' ) ); ?>
				</div>
			</div>

			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'WP Multisite', 'woodmart' ); ?>:
				</div>
				<div>
					<?php echo is_multisite() ? esc_html__( 'Yes', 'woodmart' ) : esc_html__( 'No', 'woodmart' ); ?>
				</div>
			</div>

			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'WP Debug Mode', 'woodmart' ); ?>:
				</div>
				<div>
					<?php echo defined( 'WP_DEBUG' ) && WP_DEBUG ? esc_html__( 'Enabled', 'woodmart' ) : esc_html__( 'Disabled', 'woodmart' ); ?>
				</div>
			</div>
		</div>
		<h4>
			<?php esc_html_e( 'Server', 'woodmart' ); ?>
		</h4>
		<div class="xts-table xts-odd">

			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'PHP Version', 'woodmart' ); ?>:
				</div>
				<div>
					<?php if ( version_compare( PHP_VERSION, '7.2', '<' ) ) : ?>
						<div class="xts-status-error">
							<span>
								<?php echo esc_html( PHP_VERSION ); ?>
							</span>
							<span>
								<?php esc_html_e( 'Minimum required PHP version 7.2', 'woodmart' ); ?>
							</span>
						</div>
					<?php else : ?>
						<?php echo esc_html( PHP_VERSION ); ?>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( function_exists( 'ini_get' ) ) : ?>
				<div class="xts-table-row">
					<div>
						<?php $post_max_size = ini_get( 'post_max_size' ); ?>

						<?php esc_html_e( 'PHP Post Max Size', 'woodmart' ); ?>:
					</div>

					<div>
						<?php if ( wp_convert_hr_to_bytes( $post_max_size ) < 64000000 ) : ?>
							<div class="xts-status-error">
								<span>
									<?php echo esc_html( $post_max_size ); ?>
								</span>
								<span>
									<?php esc_html_e( 'Minimum required value 64M.', 'woodmart' ); ?>
								</span>
							</div>
						<?php else : ?>
							<?php echo esc_html( $post_max_size ); ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="xts-table-row">
					<div>
						<?php $max_execution_time = ini_get( 'max_execution_time' ); ?>
						<?php esc_html_e( 'PHP Time Limit', 'woodmart' ); ?>:
					</div>

					<div>
						<?php if ( $max_execution_time < 180 ) : ?>
							<div class="xts-status-error">
								<span>
									<?php echo esc_html( $max_execution_time ); ?>
								</span>
								<span>
									<?php esc_html_e( 'Minimum required value 180.', 'woodmart' ); ?>
								</span>
							</div>
						<?php else : ?>
							<?php echo esc_html( $max_execution_time ); ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="xts-table-row">
					<div>
						<?php $max_input_vars = ini_get( 'max_input_vars' ); ?>
						<?php esc_html_e( 'PHP Max Input Vars', 'woodmart' ); ?>:
					</div>

					<div>
						<?php if ( $max_input_vars < 10000 ) : ?>
							<div class="xts-status-error">
								<span>
									<?php echo esc_html( $max_input_vars ); ?>
								</span>
								<span>
									<?php esc_html_e( 'Minimum required value 10000.', 'woodmart' ); ?>
								</span>
							</div>
						<?php else : ?>
							<?php echo esc_html( $max_input_vars ); ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="xts-table-row">
					<div>
						<?php $memory_limit = ini_get( 'memory_limit' ); ?>
						<?php esc_html_e( 'PHP Memory Limit', 'woodmart' ); ?>:
					</div>

					<div>
						<?php if ( wp_convert_hr_to_bytes( $memory_limit ) < 128000000 ) : ?>
							<div class="xts-status-error">
								<span>
									<?php echo esc_html( $memory_limit ); ?>
								</span>
								<span>
									<?php esc_html_e( 'Minimum required value 128M.', 'woodmart' ); ?>
								</span>
							</div>
						<?php else : ?>
							<?php echo esc_html( $memory_limit ); ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="xts-table-row">
					<div>
						<?php $upload_max_filesize = ini_get( 'upload_max_filesize' ); ?>
						<?php esc_html_e( 'PHP Upload Max Size', 'woodmart' ); ?>:
					</div>
					<div>

						<?php if ( wp_convert_hr_to_bytes( $upload_max_filesize ) < 64000000 ) : ?>
							<div class="xts-status-error">
								<span>
									<?php echo esc_html( $upload_max_filesize ); ?>
								</span>
								<span>
									<?php esc_html_e( 'Minimum required value 64M.', 'woodmart' ); ?>
								</span>
							</div>
						<?php else : ?>
							<?php echo esc_html( $upload_max_filesize ); ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="xts-table-row">
					<div>
						<?php esc_html_e( 'PHP Function "file_get_content"', 'woodmart' ); ?>:
					</div>
					<div>
						<?php if ( ! ini_get( 'allow_url_fopen' ) || 'Off' === ini_get( 'allow_url_fopen' ) ) : ?>
							<div class="xts-status-error">
								<?php esc_html_e( 'Off', 'woodmart' ); ?>
							</div>
						<?php else : ?>
							<?php esc_html_e( 'On', 'woodmart' ); ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'DOMDocument', 'woodmart' ); ?>:
				</div>
				<div>
					<?php if ( ! class_exists( 'DOMDocument' ) ) : ?>
						<div class="xts-status-error">
							<?php esc_html_e( 'No', 'woodmart' ); ?>
						</div>
					<?php else : ?>
						<?php esc_html_e( 'Yes', 'woodmart' ); ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="xts-table-row">
				<div>
					<?php esc_html_e( 'Active Plugins', 'woodmart' ); ?>:
				</div>
				<div>
					<?php if ( is_multisite() ) : ?>
						<?php echo esc_html( count( (array) wp_get_active_and_valid_plugins() ) + count( (array) wp_get_active_network_plugins() ) ); ?>
					<?php else : ?>
						<?php echo esc_html( count( (array) wp_get_active_and_valid_plugins() ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
