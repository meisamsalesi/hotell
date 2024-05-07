<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * Generate css file for wpbakery
 */

class WOODMART_Wpbcssgenerator {
	private $_generator_url = 'https://woodmart.xtemos.com/';

	private $_options = array();

	function __construct() {
		$this->_notices = WOODMART_Registry()->notices;

		$this->_options = woodmart_get_config( 'wpbcss-parts' );
	}

	private function _get_options_from_section( $section ) {
		return array_filter(
			$this->_options,
			function( $el ) use ( $section ) {
				return $el['section'] == $section;
			}
		);
	}

	private function _checked( $opt ) {

		$checked = $opt['checked'];

		if ( isset( $_POST['generate-css'] ) ) {
			$checked = isset( $_POST[ $opt['id'] ] ) && $_POST[ $opt['id'] ];
		}

		$css_data = $this->_get_data();

		if ( ! empty( $css_data ) && is_array( $css_data ) ) {
			$checked = isset( $css_data[ $opt['id'] ] ) && $css_data[ $opt['id'] ];
		}

		checked( $checked );
	}

	private function _render_option( $opt ) {
		?>
			<div class="css-checkbox" data-parent="<?php echo ( isset( $opt['parent'] ) ) ? $opt['parent'] : 'none'; ?>">
				<input type="checkbox" id="<?php echo esc_attr( $opt['id'] ); ?>" name="<?php echo esc_attr( $opt['id'] ); ?>" <?php $this->_checked( $opt ); ?> <?php disabled( isset( $opt['disabled'] ) && $opt['disabled'], true ); ?> value="true">
				<label for="<?php echo esc_attr( $opt['id'] ); ?>"><?php echo esc_html( $opt['title'] ); ?>
				<?php if ( isset( $opt['image'] ) || isset( $opt['description'] ) ) : ?>
					<div class="xts-tooltip xts-right">
						<?php if ( isset( $opt['image'] ) ) : ?>
							<img src="<?php echo esc_attr( $opt['image'] ); ?>">
						<?php endif ?>
						<?php if ( isset( $opt['description'] ) ) : ?>
							<p class="css-description"><?php echo esc_html( $opt['description'] ); ?></p>
						<?php endif ?>
					</div>
				<?php endif; ?>
				</label>
				<?php $this->_render_children( $opt['id'] ); ?>
			</div>
		<?php
	}

	private function _render_children( $id ) {
		$children = $this->_get_children( $id );

		if ( empty( $children ) ) {
			return;
		}

		echo '<div class="css-checkbox-children">';

		foreach ( $children as $id => $option ) {
			$this->_render_option( $option );
		}

		echo '</div>';
	}

	private function _get_children( $id ) {
		return array_filter(
			$this->_options,
			function( $el ) use ( $id ) {
				return isset( $el['parent'] ) && $el['parent'] == $id;
			}
		);
	}

	private function _render_section( $name ) {
		foreach ( $this->_get_options_from_section( $name ) as $id => $option ) {
			if ( ! isset( $option['parent'] ) ) {
				$this->_render_option( $option );
			}
		}
	}

	public function form() {
		$this->process_form();

		$file  = get_option( 'woodmart-generated-wpbcss-file' );
		$theme = wp_get_theme( get_template() );
		?>
		<div class="xts-box xts-css-generator xts-theme-style xts-tooltip-mirror">
			<div class="xts-box-header">
				<h3>
					<?php esc_html_e( 'WPBakery CSS generator', 'woodmart' ); ?>
				</h3>
			</div>

			<div class="xts-box-content">
				<?php $this->_notices->show_msgs(); ?>
				<p>
					<?php esc_html_e( 'WPBakery CSS file is huge and due to the fact that we are not using 99% them on our demo versions we suggest you to generate a CSS file without them. Check all elements and see which ones you are using and which not. It may decrease your page size by 200-400 KB.', 'woodmart' ); ?>
				</p>

				<form action="" method="post" class="xts-form xts-generator-form">
					<div class="xts-row">
						<div class="xts-col-12 xts-col-xl-6">
							<div class="css-options-box">
								<h4>Basic elements</h4>

								<?php $this->_render_section( 'Basic elements' ); ?>
							</div>
						</div>
						<div class="xts-col-12 xts-col-xl-6">
							<div class="css-options-box">
								<h4>Galleries</h4>
								<?php $this->_render_section( 'Galleries' ); ?>
							</div>
							<div class="css-options-box">
								<h4>Extras</h4>
								<?php $this->_render_section( 'Extras' ); ?>
							</div>
						</div>
					</div>

					<input type="hidden" name="css-data">

					<input class="xts-btn xts-generate-btn xts-color-primary" name="generate-css" type="submit" value="<?php esc_attr_e( 'Generate file', 'woodmart' ); ?>" />

				</form>

				<?php if ( isset( $file['name'] ) && $file['name'] ) : ?>
					<?php
					$uploads   = wp_upload_dir();
					$file_path = set_url_scheme( $uploads['basedir'] . $file['name'] );
					$file_url  = set_url_scheme( $uploads['baseurl'] . $file['name'] );
					$data      = file_exists( $file_path ) ? get_file_data( $file_path, array( 'Version' => 'Version' ) ) : array();
					$version   = isset( $data['Version'] ) ? $data['Version'] : 'unknown';
					?>

					<div class="css-file-information">

						<h4>Custom CSS file is <span>generated</span></h3>

						<div class="xts-table xts-odd">
							<div class="xts-table-row">
								<div>
									File:
								</div>
								<div>
									<a href="<?php echo esc_url( $file_url ); ?>" target="_blank"><?php echo esc_html( $file['name'] ); ?></a>
								</div>
							</div>
							<div class="xts-table-row">
								<div>
									CSS Version:
								</div>
								<div>
									<strong><?php echo esc_html( $version ); ?></strong>
								</div>
							</div>
							<div class="xts-table-row">
								<div>
									Actual version:
								</div>
								<div>
									<strong><?php echo esc_html( WOODMART_WPB_CSS_VERSION ); ?></strong>
								</div>
							</div>
						</div>

						<div class="css-file-actions">
							<?php if ( version_compare( $version, WOODMART_WPB_CSS_VERSION, '<' ) ) : ?>
								<input class="xts-btn css-update-button" name="deactivate-css" type="submit" value="<?php esc_attr_e( 'Update', 'woodmart' ); ?>" />
							<?php endif ?>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_wpb_css_generator&deactivate-css=1' ) ); ?>" class="xts-btn xts-color-warning xts-i-trash" name="deactivate-css" type="submit">
								<?php esc_attr_e( 'Delete', 'woodmart' ); ?>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="xts-box-footer">
				<p>
					<?php esc_html_e( 'This section allows you to generate a custom CSS file based on our core theme styles. It means that you can reduce your CSS file size if you are not using some part of the functionality. Useful for performance and loading time optimization.', 'woodmart' ); ?>
				</p>
			</div>
		</div>
		<?php
	}

	public function process_form() {
		$uploads = wp_upload_dir();

		if ( isset( $_GET['deactivate-css'] ) ) {
			$file = get_option( 'woodmart-generated-wpbcss-file' );

			if ( ! empty( $file['file'] ) ) {
				$file_path = set_url_scheme( $uploads['basedir'] . '/' . $file['name'] );
				unlink( $file_path );
			}

			delete_option( 'woodmart-generated-wpbcss-file' );
			delete_option( 'woodmart-wpbcss-data' );

		}

		if ( ! isset( $_POST['generate-css'] ) || empty( $_POST['generate-css'] ) ) {
			return;
		}

		$data = $_POST['css-data'];

		if ( function_exists( 'woodmart_decompress' ) && ! $json = woodmart_decompress( $data ) ) {
			$this->_notices->add_warning( 'Wrong data sent. Try to resend the form.' );
			return;
		}

		if ( ! $css_data = json_decode( $json, true ) ) {
			$this->_notices->add_warning( 'Wrong JSON data format. Try to resend the form.' );
			return;
		}

		/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
		$creds = request_filesystem_credentials( false, '', false, false, array_keys( $_POST ) );

		if ( ! $creds ) {
			return;
		}

		/* initialize the API */
		if ( ! WP_Filesystem( $creds ) ) {
			/* any problems and we exit */
			$this->_notices->add_warning( 'Can\'t access your file system. The FTP access is wrong.' );
			return false;
		}

		global $wp_filesystem;

		$wpb_url = '';

		if ( defined( 'WPB_PLUGIN_FILE' ) ) {
			$wpb_url = plugins_url( 'assets', WPB_PLUGIN_FILE );
		}

		$response = wp_remote_get( $this->_generator_url . '?generate_css=' . $data . '&wpbakery=1&wpb_url=' . urlencode( $wpb_url ) . '/', array( 'timeout' => 30 ) );

		// ar( $response );

		// return;

		if ( ! is_array( $response ) ) {
			$this->_notices->add_warning( 'Can\'t call xtemos server to generate the file.' );
			return false;
		}

		$header = $response['headers']; // array of http header lines
		$css    = $response['body']; // use the content

		$t         = time();
		$file_name = $uploads['subdir'] . '/' . 'js_composer-' . $t . '.css';
		$file_path = $uploads['basedir'] . '/' . $file_name;
		$res = $wp_filesystem->put_contents(
			$file_path,
			$css
		);

		if ( $res ) {

			$upload = array(
				'name' => $file_name,
			);

			$file = get_option( 'woodmart-generated-wpbcss-file' );

			if ( isset( $file['name'] ) && $file['name'] ) {
				$file_path = $uploads['basedir'] . '/' . $file['name'];
				$wp_filesystem->delete( $file_path );
			}

			update_option( 'woodmart-generated-wpbcss-file', $upload );
			update_option( 'woodmart-wpbcss-data', $css_data );

			$this->_notices->add_success( 'New CSS file is generated and saved.' );

		} else {
			$this->_notices->add_warning( 'Can\'t move file to uploads folder with wp_filesystem class.' );
			return false;
		}

	}

	private function _get_data() {
		$css_data = get_option( 'woodmart-wpbcss-data', array() );

		return $css_data;
	}

}
