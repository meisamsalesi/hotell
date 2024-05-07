<?php
/**
 * Create metabox object with fields.
 *
 * @package xts
 */

namespace XTS;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

/**
 * Metabox class to store all fields for particular metaboxes created.
 */
class Metabox {

	/**
	 * Metabox ID.
	 *
	 * @var int
	 */
	private $_id;

	/**
	 * Metabox title.
	 *
	 * @var string
	 */
	private $_title;

	/**
	 * Taxonomies that we add this metabox to.
	 *
	 * @var array
	 */
	private $_taxonomies;

	/**
	 * Post type array where this metabox will be displayed.
	 *
	 * @var array
	 */
	private $_post_types;

	/**
	 * Fields array for this metabox. Array of Field objects.
	 *
	 * @var array
	 */
	private $_fields = array();

	/**
	 * Metaboxes may have sections as well.
	 *
	 * @var array
	 */
	private $_sections = array();

	/**
	 * Basic arguments array.
	 *
	 * @var array
	 */
	private $_args;

	/**
	 * Can be post or term.
	 *
	 * @var array
	 */
	private $_object;

	/**
	 * Array of field type and controls mapping.
	 *
	 * @var array
	 */
	private $_controls_classes = array(
		'select'            => 'XTS\Options\Controls\Select',
		'text_input'        => 'XTS\Options\Controls\Text_Input',
		'switcher'          => 'XTS\Options\Controls\Switcher',
		'color'             => 'XTS\Options\Controls\Color',
		'checkbox'          => 'XTS\Options\Controls\Checkbox',
		'buttons'           => 'XTS\Options\Controls\Buttons',
		'upload'            => 'XTS\Options\Controls\Upload',
		'upload_list'       => 'XTS\Options\Controls\Upload_List',
		'background'        => 'XTS\Options\Controls\Background',
		'textarea'          => 'XTS\Options\Controls\Textarea',
		'typography'        => 'XTS\Options\Controls\Typography',
		'custom_fonts'      => 'XTS\Options\Controls\Custom_Fonts',
		'range'             => 'XTS\Options\Controls\Range',
		'editor'            => 'XTS\Options\Controls\Editor',
		'import'            => 'XTS\Options\Controls\Import',
		'notice'            => 'XTS\Options\Controls\Notice',
		'select_with_table' => 'XTS\Options\Controls\Select_With_Table',
	);

	/**
	 * Create an object from args.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Basic arguments for the object.
	 */
	public function __construct( $args ) {
		$this->_id         = $args['id'];
		$this->_title      = $args['title'];
		$this->_post_types = $args['post_types'];
		$this->_taxonomies = $args['taxonomies'];
		$this->_object     = $args['object'];
		$this->_args       = $args;

		add_action( 'wp_enqueue_scripts', array( $this, 'fields_css_output' ), 20000 );
	}

	/**
	 * Get the metabox ID.
	 *
	 * @since 1.0.0
	 *
	 * @return int Metabox id field.
	 */
	public function get_id() {
		return $this->_id;
	}

	/**
	 * Getter for the metabox title.
	 *
	 * @since 1.0.0
	 *
	 * @return string The metabox title.
	 */
	public function get_title() {
		return $this->_title;
	}

	/**
	 * Getter for the metaboxes taxonomies.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomies array for this metabox.
	 */
	public function get_taxonomies() {
		return $this->_taxonomies;
	}

	/**
	 * Getter for the metabox object.
	 *
	 * @since 1.0.0
	 *
	 * @return string The metabox object.
	 */
	public function get_object() {
		return $this->_object;
	}

	/**
	 * Getter for the metaboxes post types array.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post types array for this metabox.
	 */
	public function get_post_types() {
		return $this->_post_types;
	}

	/**
	 * Adds the Field object to this metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Field arguments.
	 */
	public function add_field( $args ) {

		$control_classname = $this->_controls_classes[ $args['type'] ];

		$control = new $control_classname( $args, false, 'metabox', $this->get_object() );

		$this->_fields[] = $control;

		// Override theme setting option based on the meta value for this post and field.
		if ( isset( $args['option_override'] ) ) {
			Options::register_meta_override( $args['option_override'] );
		}
	}

	/**
	 * Static method to add a section to the array.
	 *
	 * @since 1.0.0
	 *
	 * @param array $section Arguments array for new section.
	 */
	public function add_section( $section ) {
		$this->_sections[ $section['id'] ] = $section;
	}
	/**
	 * Static method to get all fields objects.
	 *
	 * @since 1.0.0
	 *
	 * @return array Field objects array.
	 */
	public function get_fields() {
		$fields = $this->_fields;

		usort(
			$fields,
			function ( $item1, $item2 ) {

				if ( ! isset( $item1->args['priority'] ) ) {
					return 1;
				}

				if ( ! isset( $item2->args['priority'] ) ) {
					return -1;
				}

				return $item1->args['priority'] - $item2->args['priority'];
			}
		);

		return $fields;

	}

	/**
	 * Output fields CSS code based on its controls and values.
	 *
	 * @since 1.0.0
	 */
	public function fields_css_output() {
		$output = '';
		$post   = get_post();

		foreach ( $this->get_fields() as $field ) {
			$field->set_post( $post );
			$output .= $field->css_output();
		}

		wp_add_inline_style( 'woodmart-style', $output );
	}

	/**
	 * Static method to get all sections.
	 *
	 * @since 1.0.0
	 *
	 * @return array Section array.
	 */
	public function get_sections() {
		global $current_screen;

		$sections = $this->_sections;

		usort(
			$sections,
			function ( $item1, $item2 ) {

				if ( ! isset( $item1['priority'] ) ) {
					return 1;
				}

				if ( ! isset( $item2['priority'] ) ) {
					return -1;
				}

				return $item1['priority'] - $item2['priority'];
			}
		);

		$sections_assoc = array();

		foreach ( $sections as $key => $section ) {
			if ( isset( $section['post_types'] ) && ! in_array( $current_screen->post_type, $section['post_types'], true ) ) {
				continue;
			}

			$sections_assoc[ $section['id'] ] = $section;
		}

		return $sections_assoc;
	}

	/**
	 * Load all field objects and add them to the sections set.
	 *
	 * @since 1.0.0
	 */
	private function load_fields() {
		foreach ( $this->get_fields() as $key => $field ) {
			$this->_sections[ $field->args['section'] ]['fields'][] = $field;
		}
	}

	/**
	 * Generate a unique nonce for each registered meta_box
	 *
	 * @since  2.0.0
	 * @return string unique nonce string.
	 */
	public function nonce() {
		return sanitize_html_class( 'wd-metabox-nonce_' . basename( __FILE__ ) );
	}

	/**
	 * Render this metabox and all its fields.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $object Post or Term object to render with its meta values.
	 */
	public function render( $object ) {
		$this->load_fields();

		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'xts-helpers', WOODMART_SCRIPTS . '/scripts/global/helpers.min.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'xts-tabs', WOODMART_SCRIPTS . '/scripts/elements/tabs.js', array(), WOODMART_VERSION, true );

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
		<div class="xts-box xts-options xts-metaboxes xts-theme-style">
			<?php wp_nonce_field( $this->nonce(), $this->nonce(), false, true ); ?>
			<div class="xts-box-content">
				<div class="xts-row xts-sp-20">
					<?php if ( count( $this->get_sections() ) > 1 ) : ?>
						<div class="xts-col-12 xts-col-xl-2">
							<ul class="xts-nav xts-nav-vertical">
								<?php $this->display_sections_tree(); ?>
							</ul>
						</div>
					<?php endif; ?>
					<div class="xts-col">
						<?php $this->display_sections( $object ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Display sections navigation tree.
	 *
	 * @since 1.0.0
	 */
	private function display_sections_tree() {
		foreach ( $this->get_sections() as $key => $section ) {
			if ( isset( $section['parent'] ) ) {
				continue;
			}

			$subsections = array_filter(
				$this->get_sections(),
				function( $el ) use ( $section ) {
					return isset( $el['parent'] ) && $el['parent'] === $section['id'];
				}
			);


			if ( ! isset( $section['icon'] ) ) {
				ar($section);
			}
			?>
				<li class="<?php echo ( $key === $this->get_last_tab() ) ? 'xts-active-nav' : ''; ?>">
					<a class="<?php echo esc_html( $section['icon'] ); ?>" href="" data-id="<?php echo esc_attr( $key ); ?>"  data-id="<?php echo esc_attr( $key ); ?>">
						<span>
							<?php echo $section['name']; // phpcs:ignore ?>
						</span>
					</a>

					<?php if ( is_array( $subsections ) && count( $subsections ) > 0 ) : ?>
						<ul class="xts-sub-menu">
							<?php foreach ( $subsections as $key => $subsection ) : ?>
								<li class="xts-sub-menu-item">
									<a href="" data-id="<?php echo esc_attr( $key ); ?>">
										<?php echo $subsection['name']; // phpcs:ignore ?>
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
	 * Get last visited tab by visitor.
	 *
	 * @since 1.0.0
	 */
	private function get_last_tab() {
		reset( $this->_sections );

		$first_tab = key( $this->_sections );

		return $first_tab;
	}

	/**
	 * Loop through all the sections and render all the fields.
	 *
	 * @since 1.0.0
	 *
	 * @param object $object Object.
	 */
	private function display_sections( $object ) {
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
					foreach ( $section['fields'] as $field ) {
						if ( isset( $field->args['t_tab'] ) ) {
							$tabs[ $field->args['t_tab']['id'] ][ $field->args['t_tab']['tab'] ] = [
								'icon'  => isset( $field->args['t_tab']['icon'] ) ? $field->args['t_tab']['icon'] : '',
								'title' => $field->args['t_tab']['tab'],
							];
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

							$field->render( $object );
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
     * Save all fields to the metadata database table for posts.
     *
     * @since 1.0.0
     *
     * @param int $post_id Post id.
     * @return bool
     */
	public function save_posts_fields( $post_id ) {
		if ( ! isset( $_POST[ $this->nonce() ] ) || ! wp_verify_nonce( $_POST[ $this->nonce() ], $this->nonce() ) ) {
			return;
		}

		foreach ( $this->_fields as $key => $field ) {
			if ( 'checkbox' === $field->args['type'] && ! isset( $_POST[ $field->get_input_name() ] ) ) { // phpcs:ignore
				delete_metadata(
					'post',
					$post_id,
					$field->get_input_name()
				);

				continue;
			}

			if ( ! array_key_exists( $field->get_input_name(), $_POST ) ) { // phpcs:ignore
				continue;
			}

			$value = $field->sanitize( $_POST[ $field->get_input_name() ] ); // phpcs:ignore

			do_action( 'woodmart_metabox_before_update_metadata', $post_id, $field->get_input_name(), $value );

			update_metadata(
				'post',
				$post_id,
				$field->get_input_name(),
				$value
			);
		}
	}

    /**
     * Save all fields to the metadata database table for terms.
     *
     * @since 1.0.0
     *
     * @param int $term_id Term id.
     * @return bool
     */
	public function save_terms_fields( $term_id ) {
		foreach ( $this->_fields as $key => $field ) {
			if ( 'checkbox' === $field->args['type'] && ! isset( $_POST[ $field->get_input_name() ] ) ) { // phpcs:ignore
				delete_metadata(
					'term',
					$term_id,
					$field->get_input_name()
				);
				
				continue;
			}
			
			if ( ! array_key_exists( $field->get_input_name(), $_POST ) ) { // phpcs:ignore
				continue;
			}

			$value = $field->sanitize( $_POST[ $field->get_input_name() ] ); // phpcs:ignore

			update_metadata(
				'term',
				$term_id,
				$field->get_input_name(),
				$value
			);
		}
	}
	
	/**
	 * Save all fields to the metadata database table for terms.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $comment_id Comment id.
	 */
	public function save_comments_fields( $comment_id ) {
		foreach ( $this->_fields as $key => $field ) {
			if ( ( 'checkbox' === $field->args['type'] || 'select' === $field->args['type'] ) && ! isset( $_POST[ $field->get_input_name() ] ) ) { // phpcs:ignore
				delete_comment_meta(
					$comment_id,
					$field->get_input_name()
				);
				
				continue;
			}
			
			if ( ! array_key_exists( $field->get_input_name(), $_POST ) ) { // phpcs:ignore
				continue;
			}
			
			$value = $field->sanitize( $_POST[ $field->get_input_name() ] ); // phpcs:ignore
			
			update_comment_meta(
				$comment_id,
				$field->get_input_name(),
				$value
			);
		}
	}
}
