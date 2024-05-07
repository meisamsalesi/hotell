<?php
/**
 * Object that handles theme options page.
 *
 * @package xts
 */

namespace XTS;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Create page and display the form with all sections and fields.
 */
class Page extends Singleton {

	/**
	 * Options set prefix.
	 *
	 * @var array
	 */
	public $opt_name = 'woodmart';

	/**
	 * Options array loaded from the database.
	 *
	 * @var array
	 */
	private $_options;

	/**
	 * Array of all the available sections.
	 *
	 * @var array
	 */
	private $_sections;

	/**
	 * Array of all the available Field objects.
	 *
	 * @var array
	 */
	private $_fields;

	/**
	 * Array of all the available Presets.
	 *
	 * @var array
	 */
	private $_presets;

	/**
	 * Register hooks and load base data.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'init', array( $this, 'load_fields' ), 100 );
		$this->_presets = Presets::get_all();
	}

	/**
	 * Load all field objects and add them to the sections set.
	 *
	 * @since 1.0.0
	 */
	public function load_fields() {
		$this->_sections = Options::get_sections();
		$this->_fields   = Options::get_fields();

		foreach ( $this->_fields as $key => $field ) {
			$this->_sections[ $field->args['section'] ]['fields'][] = $field;
		}

		$this->_options = Options::get_options();
	}

	/**
	 * Render the options page content.
	 *
	 * @since 1.0.0
	 */
	public function page_content() {
		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'xts-helpers', WOODMART_SCRIPTS . '/scripts/global/helpers.min.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'xts-tabs', WOODMART_SCRIPTS . '/scripts/elements/tabs.js', array(), WOODMART_VERSION, true );

		$wrapper_classes = '';

		if ( isset( $_GET['preset'] ) ) { // phpcs:ignore
			$wrapper_classes .= ' xts-preset-active';
		}

		$current_preset_id = Presets::get_current_preset();
		$all_presets       = Presets::get_all();

		if ( $current_preset_id ) {
			$title = $all_presets[ $current_preset_id ]['name'];
		} else {
			$title = esc_html__( 'Theme settings', 'woodmart' );
		}

		$wrapper_classes .= ' xts-builder-' . woodmart_get_current_page_builder();

		do_action( 'xts_before_theme_settings' );

		if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore
			do_action( 'xts_theme_settings_save' );
		}
		?>
		<script>
			var woodmart_settings = {
				product_gallery    : {
					thumbs_slider: {
						position: true
					}
				},
				lazy_loading_offset: 0
			};
		</script>
		<div class="xts-box xts-options xts-theme-style<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="xts-box-header">
				<div class="xts-row">
					<div class="xts-col">
						<h3>
							<?php echo esc_html( $title ); ?>
						</h3>
						<div class="xts-options-search xts-search xts-i-search">
							<input aria-label="<?php esc_html_e( 'Search', 'woodmart' ); ?>" type="text" placeholder="<?php esc_html_e( 'Start typing to find options...', 'woodmart' ); ?>">
						</div>
					</div>
					<div class="xts-col-auto">
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_theme_settings_presets' ) ); ?>" class="xts-bordered-btn xts-color-primary xts-i-cog">
							<?php esc_html_e( 'Settings presets' ); ?>
						</a>
					</div>
				</div>
			</div>

			<div class="xts-box-content">
				<form action="options.php" method="post">
					<div class="xts-row xts-sp-30">
						<div class="xts-col-12 xts-col-lg-3 xts-col-xl-2">
							<ul class="xts-nav xts-nav-vertical">
								<?php $this->display_sections_tree(); ?>
							</ul>
						</div>
						<div class="xts-col">
							<div class="xts-sections">
								<?php $this->display_message(); ?>
								<?php $this->display_sections(); ?>
								<div class="xts-options-actions">
									<input type="hidden" class="xts-last-tab-input" name="xts-<?php echo esc_attr( $this->opt_name ); ?>-options[last_tab]" value="<?php echo esc_attr( $this->get_last_tab() ); ?>" />
									<button class="xts-save-options-btn xts-i-save xts-btn xts-color-primary"><?php esc_html_e( 'Save options', 'woodmart' ); ?></button>

									<?php if ( isset( $_GET['preset'] ) ) : // phpcs:ignore ?>
										<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_theme_settings' ) ); ?>" class="xts-btn xts-color-warning xts-i-global">
											<?php esc_html_e( 'To global settings', 'woodmart' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="page_options" value="xts-<?php echo esc_attr( $this->opt_name ); ?>-options" />
					<input type="hidden" name="action" value="update" />
					<?php if ( Presets::get_current_preset() ) : ?>
						<input type="hidden" class="xts-fields-to-save" name="xts-<?php echo esc_attr( $this->opt_name ); ?>-options[fields_to_save]" value="<?php echo esc_attr( $this->get_fields_to_save() ); ?>" />
						<input type="hidden" name="xts-<?php echo esc_attr( $this->opt_name ); ?>-options[preset]" value="<?php echo esc_attr( Presets::get_current_preset() ); ?>" />
					<?php endif; ?>
					<?php settings_fields( 'xts-options-group' ); ?>
				</form>
			</div>
		</div>

		<?php do_action( 'xts_after_theme_settings' ); ?>
		<?php
	}

	/**
	 * Get last visited tab by visitor.
	 *
	 * @since 1.0.0
	 */
	private function get_last_tab() {

		reset( $this->_sections );

		$first_tab = key( $this->_sections );

		$current_tab = $first_tab;

		if ( isset( $this->_options['last_tab'] ) && isset( $_GET['settings-updated'] ) ) {
			$current_tab = $this->_options['last_tab'];
		} elseif ( isset( $_GET['tab'] ) ) {
			$current_tab = $_GET['tab'];
		}

		if ( ! isset( $this->_sections[ $current_tab ]['fields'] ) ) {
			$parent_id = $this->_sections[ $current_tab ]['id'];

			foreach ( $this->_sections as $section ) {
				if ( ! empty( $section['parent'] ) && $section['parent'] === $parent_id ) {
					$current_tab = $section['id'];
					break;
				}
			}
		}

		return $current_tab;
	}

	/**
	 * Display saved/imported message.
	 *
	 * @since 1.0.0
	 */
	private function display_message() {
		$message = $this->get_last_message();

		$text = false;

		if ( 'save' === $message ) {
			$text = esc_html__( 'Settings are successfully saved.', 'woodmart' );
		} elseif ( 'import' === $message ) {
			$text = esc_html__( 'New options are successfully imported.', 'woodmart' );
		} elseif ( 'reset' === $message ) {
			$text = esc_html__( 'All options are set to default values.', 'woodmart' );
		}

		if ( $text ) {
			echo '<div class="xts-notice xts-success">' . $text . '</div>'; // phpcs:ignore
		}
	}

	/**
	 * Get last message.
	 *
	 * @since 1.0.0
	 */
	private function get_last_message() {

		return ( isset( $this->_options['last_message'] ) && isset( $_GET['settings-updated'] ) ) ? $this->_options['last_message'] : ''; // phpcs:ignore
	}

	/**
	 * Display sections navigation tree.
	 *
	 * @since 1.0.0
	 */
	private function display_sections_tree() {
		$current_tab   = $this->get_last_tab();
		$active_parent = '';

		if ( isset( $this->_sections[ $current_tab ]['parent'] ) ) {
			$active_parent = $this->_sections[ $current_tab ]['parent'];
		}

		foreach ( $this->_sections as $key => $section ) {
			if ( isset( $section['parent'] ) ) {
				continue;
			}

			$subsections = array_filter(
				$this->_sections,
				function( $el ) use ( $section ) {
					return isset( $el['parent'] ) && $el['parent'] === $section['id'];
				}
			);

			$classes = '';

			if ( $key === $current_tab || $key === $active_parent ) {
				$classes .= ' xts-active-nav';
			}
			if ( is_array( $subsections ) && count( $subsections ) > 0 ) {
				$classes .= ' xts-has-child';
			}

			?>
				<li class="<?php echo esc_attr( $classes ); ?>">
					<a class="<?php echo esc_html( $section['icon'] ); ?>" href="javascript:void(0);" data-id="<?php echo esc_attr( $key ); ?>" data-id="<?php echo esc_attr( $key ); ?>">
						<span>
							<?php echo $section['name']; // phpcs:ignore ?>
						</span>
					</a>

					<?php if ( is_array( $subsections ) && count( $subsections ) > 0 ) : ?>
						<ul class="xts-sub-menu">
							<?php foreach ( $subsections as $key => $subsection ) : ?>
								<li class="xts-sub-menu-item <?php echo ( $key === $current_tab ) ? 'xts-active-nav' : ''; ?>">
									<a href="javascript:void(0);" data-id="<?php echo esc_attr( $key ); ?>">
										<span>
											<?php echo $subsection['name']; // phpcs:ignore ?>
										</span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

				</li>
			<?php
		}
	}

	/**
	 * Loop through all the sections and render all the fields.
	 *
	 * @since 1.0.0
	 */
	private function display_sections() {
		foreach ( $this->_sections as $key => $section ) {
			?>
			<div class="xts-section <?php echo ( $this->get_last_tab() !== $key ) ? 'xts-hidden' : 'xts-active-section'; ?>" data-id="<?php echo esc_attr( $key ); ?>">
				<div class="xts-section-title">
					<?php if ( ! empty( $section['icon'] ) ) : ?>
						<div class="xts-title-icon <?php echo esc_html( $section['icon'] ); ?>"></div>
					<?php endif; ?>
					<h3><?php echo esc_html( $section['name'] ); ?></h3>
				</div>
				<div class="xts-fields">
					<?php

					$tabs = [];
					if ( isset( $section['fields'] ) ) {
						foreach ( $section['fields'] as $field ) {
							if ( isset( $field->args['t_tab'] ) ) {
								$tabs[ $field->args['t_tab']['id'] ][ $field->args['t_tab']['tab'] ] = [
									'icon'  => isset( $field->args['t_tab']['icon'] ) ? $field->args['t_tab']['icon'] : '',
									'title' => $field->args['t_tab']['tab'],
								];
							}
						}
					}

					$printed_tabs  = false;
					$printed_tab   = false;
					$printed_group = false;

					if ( isset( $section['fields'] ) ) {
						foreach ( $section['fields'] as $field ) {
							if ( $printed_tab && ( ! isset( $field->args['t_tab'] ) || $printed_tab !== $field->args['t_tab']['tab'] ) ) {
								echo '</div>';
								$printed_tab = false;
							}

							if ( $printed_tabs && ( ! isset( $field->args['t_tab'] ) || $printed_tabs !== $field->args['t_tab']['id'] ) ) {
								echo '</div>';
								echo '</div>';
								$printed_tabs = false;
							}

							if ( $printed_group && ( ! isset( $field->args['group'] ) || $printed_group !== $field->args['group'] ) ) {
								echo '</div>';
								$printed_group = false;
							}

							if ( isset( $field->args['group'] ) && $printed_group !== $field->args['group'] ) {
								$printed_group = $field->args['group'];
								echo '<div class="xts-group-title"><span>' . esc_html( $printed_group ) . '</span></div>';
								echo '<div class="xts-fields-group xts-group">';
							}

							if ( isset( $field->args['t_tab'] ) && $printed_tabs !== $field->args['t_tab']['id'] ) {
								$attrs = '';

								if ( isset( $field->args['t_tab']['requires'] ) ) {
									$data = '';
									foreach ( $field->args['t_tab']['requires'] as $dependency ) {
										if ( is_array( $dependency['value'] ) ) {
											$dependency['value'] = implode( ',', $dependency['value'] );
										}
										$data .= $dependency['key'] . ':' . $dependency['compare'] . ':' . $dependency['value'] . ';';
									}

									$attrs .= 'data-dependency="' . esc_attr( $data ) . '"';
								}

								echo '<div class="wd-tabs xts-tabs wd-style-' . $field->args['t_tab']['style'] . '" ' . $attrs . '>';

								echo '<div class="xts-tabs-header">';
								if ( isset( $field->args['t_tab']['title'] ) ) {
									echo '<h3>' . $field->args['t_tab']['title'] . '</h3>';
								}
								echo '<div class="wd-nav-wrapper wd-nav-tabs-wrapper xts-nav-wrapper xts-nav-tabs-wrapper">';
								echo '<ul class="wd-nav wd-nav-tabs xts-nav xts-nav-tabs">';
								foreach ( $tabs[ $field->args['t_tab']['id'] ] as $tab ) {
									$classes = '';

									if ( ! empty( $tab['icon'] ) ) {
										$classes .= ' ' . $tab['icon'];
									}
									echo '<li><a href="#" class="wd-nav-link xts-nav-link' . $classes . '"><span class="nav-link-text wd-tabs-title xts-tabs-title">' . $tab['title'] . '</span></a></li>'; // phpcs:ignore
								}
								echo '</ul>';
								echo '</div>';
								echo '</div>';

								echo '<div class="wd-tab-content-wrapper xts-tab-content-wrapper xts-group">';

								$printed_tabs = $field->args['t_tab']['id'];
							}

							if ( isset( $field->args['t_tab'] ) && $printed_tab !== $field->args['t_tab']['tab'] ) {
								echo '<div class="wd-tab-content xts-tab-content">';

								$printed_tab = $field->args['t_tab']['tab'];
							}

							if ( $this->is_inherit_field( $field->get_id() ) ) {
								$field->inherit_value( true );
							}

							$field->render( null, Presets::get_current_preset() );
						}

						if ( $printed_tab ) {
							echo '</div>';
							$printed_tab = false;
						}

						if ( $printed_tabs ) {
							echo '</div>';
							echo '</div>';
							$printed_tabs = false;
						}

						if ( $printed_group ) {
							echo '</div>';
							$printed_group = false;
						}
					}
					?>
				</div>
			</div>
			<?php
		}

	}

	/**
	 * Get fields to save value.
	 *
	 * @since 1.0.0
	 */
	private function get_fields_to_save() {
		if ( ! isset( $this->_options[ Presets::get_current_preset() ] ) || ! isset( $this->_options[ Presets::get_current_preset() ]['fields_to_save'] ) ) {
			return '';
		}

		return $this->_options[ Presets::get_current_preset() ]['fields_to_save'];
	}

	/**
	 * Is field by id inherits value.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id Field's id.
	 *
	 * @return bool
	 */
	private function is_inherit_field( $id ) {
		return false === strpos( $this->get_fields_to_save(), $id );
	}
}

Page::get_instance();
