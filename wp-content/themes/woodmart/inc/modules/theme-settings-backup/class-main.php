<?php

namespace XTS\Modules\Theme_Settings_Backup;

use WOODMART_Stylesstorage;
use XTS\Options as ThemeSettingsOptions;
use XTS\Presets;
use XTS\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

class Main extends Singleton {
	/**
	 * Register hooks.
	 */
	public function init() {
		add_action( 'wp_ajax_xts_create_backup', array( $this, 'create_backup' ) );
		add_action( 'wp_ajax_xts_delete_backup', array( $this, 'delete_backup' ) );
		add_action( 'wp_ajax_xts_download_backup', array( $this, 'download_backup' ) );
		add_action( 'wp_ajax_xts_apply_backup', array( $this, 'apply_backup' ) );
		add_action( 'xts_dashboard_before_page', array( $this, 'auto_backup' ) );
	}

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render() {
		wp_enqueue_script( 'xts-backup-scripts', WOODMART_ASSETS . '/js/backup.js', array(), WOODMART_VERSION, true );

		$all_backups  = array();
		$auto_backups = get_option( 'xts_backups_auto' );
		$backups      = get_option( 'xts_backups' );

		if ( $auto_backups ) {
			$all_backups += $auto_backups;
		}

		if ( $backups ) {
			$all_backups += $backups;
		}

		ksort( $all_backups );
		$all_backups = array_reverse( $all_backups, true );

		?>
		<div class="xts-box xts-backups xts-theme-style">
			<div class="xts-box-header">
				<div class="xts-row">
					<div class="xts-col">
						<h3>
							<?php esc_html_e( 'Backup', 'woodmart' ); ?>
						</h3>
					</div>

					<div class="xts-col-auto">
						<a class="xts-bordered-btn xts-color-primary xts-i-add xts-create-backup" href="#">
							<?php esc_html_e( 'Create backup', 'woodmart' ); ?>
						</a>
					</div>
				</div>
			</div>

			<div class="xts-box-content">
				<div class="xts-notices-wrapper xts-notices-sticky">
					<?php if ( ! $all_backups ) : ?>
						<div class="xts-notice xts-info">
							<?php esc_html_e( 'There are currently no existing backups.', 'woodmart' ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $all_backups ) : ?>
					<div class="xts-table xts-even">
						<div class="xts-table-row-heading xts-backup-header">
							<div class="xts-backup-title">
								<?php esc_html_e( 'Title', 'woodmart' ); ?>
							</div>
							<div class="xts-backup-date">
								<?php esc_html_e( 'Date', 'woodmart' ); ?>
							</div>
							<div class="xts-backup-action"></div>
						</div>
						<?php foreach ( $all_backups as $id => $backup ) : ?>
							<?php $this->get_item_backup( $id, $backup ); ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Output HTML codes for item backup.
	 *
	 * @param  int   $id  ID backup.
	 * @param  array $backup  Backup data.
	 */
	public function get_item_backup( $id, $backup ) {
		?>
		<div class="xts-table-row xts-backup-item" data-id="<?php echo esc_attr( $id ); ?>">
			<div class="xts-backup-title">
				<?php echo esc_html( $backup['title'] ); ?>
			</div>

			<div class="xts-backup-date">
				<?php echo esc_html( $backup['date'] ); ?>
			</div>

			<div class="xts-backup-action">
				<a href="#" class="xts-btn xts-color-primary xts-apply-backup xts-i-check">
					<?php esc_html_e( 'Apply', 'woodmart' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=xts_download_backup&id=<?php echo esc_attr( $id ); ?>&security=<?php echo esc_attr( wp_create_nonce( 'xts_backup_nonce' ) ); ?>" class="xts-bordered-btn xts-color-default xts-i-export xts-export-backup">
					<?php esc_html_e( 'Export', 'woodmart' ); ?>
				</a>
				<a href="#" class="xts-bordered-btn xts-color-warning xts-style-icon xts-i-trash xts-delete-backup" title="<?php esc_html_e( 'Delete', 'woodmart' ); ?>"></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Create backup.
	 */
	public function create_backup() {
		check_ajax_referer( 'xts_backup_nonce', 'security' );

		$backups     = get_option( 'xts_backups' );
		$backup_time = time();
		$options     = get_option( 'xts-woodmart-options' );
		$presets     = get_option( 'xts-options-presets' );

		if ( isset( $options['last_message'] ) ) {
			unset( $options['last_message'] );
		}

		if ( isset( $options['last_tab'] ) ) {
			unset( $options['last_tab'] );
		}

		$backups[ $backup_time ] = array(
			'title'   => esc_html__( 'Manual backup', 'woodmart' ),
			'date'    => gmdate( 'Y-m-d H:i:s', $backup_time ),
			'auto'    => false,
			'options' => $options,
			'presets' => $presets,
		);

		update_option( 'xts_backups', $backups );

		ob_start();

		$this->render();

		$content = ob_get_clean();

		wp_send_json_success(
			array(
				'content' => $content,
				'message' => esc_html__( 'Backup successfully created.', 'woodmart' ),
			)
		);
	}

	/**
	 * Delete backup.
	 */
	public function delete_backup() {
		check_ajax_referer( 'xts_backup_nonce', 'security' );

		if ( ! isset( $_POST['id'] ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__(
						'Something went wrong during backup deleted. ID is missing. Please, try again later.',
						'woodmart'
					),
				)
			);
		}

		$backups      = get_option( 'xts_backups' );
		$auto_backups = get_option( 'xts_backups_auto' );
		$backup_id    = sanitize_text_field( wp_unslash( $_POST['id'] ) );

		if ( ! isset( $backups[ $backup_id ] ) && ! isset( $auto_backups[ $backup_id ] ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Something went wrong during backup deleted. ID is missing. Please, try again later.', 'woodmart' ),
				)
			);
		}

		if ( isset( $backups[ $backup_id ] ) ) {
			unset( $backups[ $backup_id ] );
			update_option( 'xts_backups', $backups );
		}

		if ( isset( $auto_backups[ $backup_id ] ) ) {
			unset( $auto_backups[ $backup_id ] );
			update_option( 'xts_backups_auto', $auto_backups );
		}

		ob_start();

		$this->render();

		$content = ob_get_clean();

		wp_send_json_success(
			array(
				'content' => $content,
				'message' => esc_html__( 'Backup successfully deleted.', 'woodmart' ),
			)
		);
	}

	/**
	 * Download options export.
	 *
	 * @since 1.0.0
	 */
	public function download_backup() {
		check_ajax_referer( 'xts_backup_nonce', 'security' );

		header( 'Content-Description: File Transfer' );
		header( 'Content-type: application/txt' );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );

		$file_name = '';
		$content   = '';

		if ( ! isset( $_GET['id'] ) ) {
			$file_name = 'Error';
			$content   = esc_html__( 'Something went wrong during backup download. ID is missing. Please, try again later.', 'woodmart' );
		}

		$backups      = get_option( 'xts_backups' );
		$auto_backups = get_option( 'xts_backups_auto' );
		$backup_id    = sanitize_text_field( wp_unslash( $_GET['id'] ) );

		if ( ! isset( $backups[ $backup_id ] ) && ! isset( $auto_backups[ $backup_id ] ) ) {
			$file_name = 'Error';
			$content   = esc_html__( 'Something went wrong during backup download. ID is missing. Please, try again later.', 'woodmart' );
		}

		if ( isset( $backups[ $backup_id ] ) ) {
			$backup    = $backups[ $backup_id ];
			$file_name = $backup['title'] . '-' . $backup['date'];
			$content   = wp_json_encode(
				array(
					'options' => $backup['options'],
					'presets' => $backup['presets'],
				)
			);
		}

		if ( isset( $auto_backups[ $backup_id ] ) ) {
			$backup    = $auto_backups[ $backup_id ];
			$file_name = $backup['title'] . '-' . $backup['date'];
			$content   = wp_json_encode(
				array(
					'options' => $backup['options'],
					'presets' => $backup['presets'],
				)
			);
		}

		header( 'Content-Disposition: attachment; filename="' . $file_name . '.json"' );

		echo $content; //phpcs:ignore

		wp_die();
	}

	/**
	 * Apply backup.
	 */
	public function apply_backup() {
		check_ajax_referer( 'xts_backup_nonce', 'security' );

		if ( ! isset( $_POST['id'] ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Something went wrong during backup installation. ID is missing. Please, try again later.', 'woodmart' ),
				)
			);
		}

		$backups      = get_option( 'xts_backups' );
		$auto_backups = get_option( 'xts_backups_auto' );
		$backup_id    = sanitize_text_field( wp_unslash( $_POST['id'] ) );
		$backup       = array();

		if ( ! isset( $backups[ $backup_id ] ) && ! isset( $auto_backups[ $backup_id ] ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Something went wrong during backup installation. ID is missing. Please, try again later.', 'woodmart' ),
				)
			);
		}

		if ( isset( $backups[ $backup_id ] ) ) {
			$backup = $backups[ $backup_id ];
		}

		if ( isset( $auto_backups[ $backup_id ] ) ) {
			$backup = $auto_backups[ $backup_id ];
		}

		$backup['options']['last_message'] = 'import';

		$options = ThemeSettingsOptions::get_instance();

		$pseudo_post_data = array(
			'import-btn'    => true,
			'import_export' => wp_json_encode( $backup['options'] ),
		);

		$sanitized_options = $options->sanitize_before_save( $pseudo_post_data );

		$options->update_options( $sanitized_options );

		update_option( 'xts-options-presets', $backup['presets'] );

		$presets = Presets::get_active_presets();
		array_unshift( $presets, 'default' );

		foreach ( $presets as $preset ) {
			$storage = new WOODMART_Stylesstorage( 'theme_settings_' . $preset );

			$storage->reset_data();
			$storage->delete_file();
		}

		wp_send_json_success(
			array(
				'message' => esc_html__( 'Backup successfully installed.', 'woodmart' ),
			)
		);
	}

	/**
	 * Create auto backup.
	 */
	public function auto_backup() {
		if ( get_transient( 'xts-woodmart-auto-backup-check' ) ) {
			return;
		}

		$auto_backups = get_option( 'xts_backups_auto' );
		$backup_time  = time();
		$options      = get_option( 'xts-woodmart-options' );
		$presets      = get_option( 'xts-options-presets' );

		set_transient( 'xts-woodmart-auto-backup-check', true, DAY_IN_SECONDS );

		if ( $auto_backups && 5 <= count( $auto_backups ) ) {
			foreach ( $auto_backups as $id => $backup ) {
				if ( $id <= strtotime( '-1 day' ) ) {
					unset( $auto_backups[ $id ] );
				}

				if ( apply_filters( 'woodmart_auto_backups_count', 10 ) > count( $auto_backups ) ) {
					break;
				}
			}
		}

		if ( isset( $options['last_message'] ) ) {
			unset( $options['last_message'] );
		}

		if ( isset( $options['last_tab'] ) ) {
			unset( $options['last_tab'] );
		}

		$auto_backups[ $backup_time ] = array(
			'title'   => esc_html__( 'Auto Backup ', 'woodmart' ),
			'date'    => gmdate( 'Y-m-d H:i:s', $backup_time ),
			'auto'    => true,
			'options' => $options,
			'presets' => $presets,
		);

		update_option( 'xts_backups_auto', $auto_backups, false );
	}
}

Main::get_instance();
