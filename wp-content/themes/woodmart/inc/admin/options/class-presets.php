<?php

namespace XTS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Presets extends Singleton {
	/**
	 * All presets.
	 *
	 * @var array
	 */
	private static $presets;

	/**
	 * Construct.
	 */
	public function init() {
		$this->load_presets();

		$this->new_preset_action();
		$this->remove_preset_action();
		$this->search_preset_action();

		add_action( 'wp_ajax_xts_save_preset_action', array( $this, 'save_preset_action' ) );
		add_action( 'wp_ajax_xts_get_entity_ids_action', array( $this, 'get_entity_ids_action' ) );
	}

	/**
	 * Load presets from the database.
	 */
	public function load_presets() {
		$presets = get_option( 'xts-options-presets' );

		if ( empty( $presets ) ) {
			$presets = array();
		}

		self::$presets = $presets;
	}

	/**
	 * Create new preset action.
	 */
	public function search_preset_action() {
		if ( empty( $_GET['search_preset'] ) ) { // phpcs:ignore
			return;
		}

		$presets = self::get_all();
		$search  = sanitize_text_field( wp_unslash( $_GET['search_preset'] ) ); // phpcs:ignore

		foreach ( $presets as $id => $preset ) {
			if ( ! str_contains( strtolower( $preset['name'] ), strtolower( $search ) ) ) {
				unset( self::$presets[ $id ] );
			}
		}
	}

	/**
	 * Create new preset action.
	 */
	public function new_preset_action() {
		if ( ! isset( $_POST['xts_presets_add_new'] ) || ! isset( $_POST['_wp_http_referer'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['xts_presets_add_new'] ) ), 'xts_presets' ) ) {
			return;
		}

		$id = $this->add_preset( 'New preset' );

		wp_safe_redirect(
			add_query_arg(
				array(
					'preset_id' => $id,
					'action'    => 'add_new',
				),
				remove_query_arg( [ 'preset_id', 'action', 'preset_page', 'search_preset' ], sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) ) )
			)
		);
	}

	/**
	 * Remove preset action.
	 *
	 * @since 1.0.0
	 */
	public function remove_preset_action() {
		if ( ! isset( $_POST['preset_id'] ) || ! isset( $_POST['xts_presets_remove'] ) || ! isset( $_POST['_wp_http_referer'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['xts_presets_remove'] ) ), 'xts_presets' ) ) {
			return;
		}

		$this->remove_preset( (int) sanitize_text_field( wp_unslash( $_POST['preset_id'] ) ) );

		$presets_pages = self::get_paginated_presets();
		$preset_page   = isset( $_GET['preset_page'] ) ? sanitize_text_field( wp_unslash( $_GET['preset_page'] ) ) : 0;

		if ( ! isset( $presets_pages[ $preset_page ] ) ) {
			--$preset_page;
		}

		wp_safe_redirect(
			add_query_arg(
				array(
					'action'      => 'removed',
					'preset_page' => $preset_page,
				),
				remove_query_arg( [ 'preset_id', 'action' ], sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) ) )
			)
		);
	}

	/**
	 * AJAX action for saving preset conditions.
	 */
	public function save_preset_action() {
		check_ajax_referer( 'xts_presets_nonce', 'security' );

		$preset_id = isset( $_POST['preset_id'] ) ? (int) sanitize_text_field( wp_unslash( $_POST['preset_id'] ) ) : false;
		$name      = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : false;
		$priority  = isset( $_POST['priority'] ) ? sanitize_text_field( wp_unslash( $_POST['priority'] ) ) : false;

		$condition = array(
			'relation' => 'OR',
			'rules'    => array(),
		);

		if ( $preset_id && isset( $_POST['data'] ) && is_array( $_POST['data'] ) ) {
			foreach ( $_POST['data'] as $rule ) { // phpcs:ignore
				$condition['rules'][] = wp_parse_args(
					$rule,
					array(
						'type'       => '',
						'comparison' => '=',
						'post_type'  => '',
						'taxonomy'   => '',
						'custom'     => '',
						'value_id'   => '',
						'user_role'  => '',
					)
				);
			}
		}

		$this->update_preset_conditions( $preset_id, $condition );
		$this->update_preset_priority( $preset_id, $priority );
		$this->update_preset_name( $preset_id, $name );

		wp_send_json_success(
			array(
				'message' => esc_html__( 'Preset edited successfully.', 'woodmart' ),
			)
		);
	}

	/**
	 * Update preset conditions.
	 *
	 * @param integer $id        Preset id.
	 * @param array   $condition Conditions array.
	 */
	public function update_preset_conditions( $id, $condition ) {
		self::$presets[ $id ]['condition'] = $condition;

		$this->update_presets();
	}

	/**
	 * Update preset priority.
	 *
	 * @param integer $id       Preset id.
	 * @param string  $priority Priority.
	 */
	public function update_preset_priority( $id, $priority ) {
		self::$presets[ $id ]['priority'] = $priority;

		$this->update_presets();
	}

	/**
	 * Update preset name.
	 *
	 * @param integer $id   Preset id.
	 * @param string  $name Name.
	 */
	public function update_preset_name( $id, $name ) {
		self::$presets[ $id ]['name'] = $name;

		$this->update_presets();
	}

	/**
	 * Create a preset in the database.
	 *
	 * @param integer $name Preset name.
	 *
	 * @return int|string|null
	 */
	public function add_preset( $name ) {
		$all = self::get_all();

		ksort( $all );

		end( $all );

		$last_id = key( $all );

		if ( empty( $all ) ) {
			$last_id = apply_filters( 'xts_presets_start_id', 0 );
		}

		$id = $last_id + 1;

		$new_preset = array(
			'id'        => $id,
			'name'      => $name,
			'condition' => array(),
		);

		self::$presets[ $id ] = $new_preset;

		$this->update_presets();

		return $id;
	}

	/**
	 * Remove preset from the database.
	 *
	 * @param integer $id Remove preset by id.
	 */
	public function remove_preset( $id ) {
		if ( ! isset( self::$presets[ $id ] ) ) {
			return;
		}

		unset( self::$presets[ $id ] );

		$this->update_presets();
	}

	/**
	 * Update presets option.
	 */
	public function update_presets() {
		update_option( 'xts-options-presets', self::$presets );
	}

	/**
	 * AJAX action to load entities names.
	 */
	public function get_entity_ids_action() {
		check_ajax_referer( 'xts_presets_nonce', 'security' );

		$type = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : false; // phpcs:ignore
		$name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : false; // phpcs:ignore

		$items = array();

		switch ( $type ) {
			case 'term_id':
			case 'single_posts_term_id':
				$args = array(
					'hide_empty' => false,
					'fields'     => 'all',
					'name__like' => $name,
				);

				$terms = get_terms( $args );

				if ( count( $terms ) > 0 ) {
					foreach ( $terms as $term ) {
						$items[] = array(
							'id'   => $term->term_id,
							'text' => $term->name . ' (ID:' . $term->term_id . ')',
						);
					}
				}
				break;
			case 'post_id':
				$args = array(
					's'              => $name,
					'post_type'      => get_post_types( array( 'public' => true ) ),
					'posts_per_page' => 100,
				);

				$posts = get_posts( $args );

				if ( count( $posts ) > 0 ) {
					foreach ( $posts as $post ) {
						$items[] = array(
							'id'   => $post->ID,
							'text' => $post->post_title . ' (ID:' . $post->ID . ')',
						);
					}
				}
				break;
		}

		echo wp_json_encode(
			array(
				'results' => $items,
			)
		);

		wp_die();
	}

	/**
	 * Get paginated presets.
	 */
	public static function get_paginated_presets() {
		return array_chunk( self::get_all(), 10, true );
	}

	/**
	 * Enqueue scripts.
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script( 'wd-presets', WOODMART_ASSETS . '/js/presets.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'select2', WOODMART_ASSETS . '/js/libs/select2.full.min.js', array(), WOODMART_VERSION, true );
	}

	/**
	 * User interface.
	 */
	public static function output_ui() {
		self::enqueue_scripts();

		$presets_pages = self::get_paginated_presets();
		$current_page  = isset( $_GET['preset_page'] ) ? sanitize_text_field( wp_unslash( $_GET['preset_page'] ) ) : 0; // phpcs:ignore

		?>
		<div class="xts-box xts-theme-style">
			<div class="xts-box-header">
				<div class="xts-row">
					<div class="xts-col">
						<h3>
							<?php esc_html_e( 'Options presets', 'woodmart' ); ?>
						</h3>
						<form class="xts-search xts-i-search" action="" method="GET">
							<input type="hidden" name="page" value="xts_theme_settings_presets">
							<div class="xts-search-inner">
								<input aria-label="<?php esc_html_e( 'Search', 'woodmart' ); ?>" type="text" name="search_preset" placeholder="<?php esc_html_e( 'Search for presets', 'woodmart' ); ?>" value="<?php echo isset( $_GET['search_preset'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['search_preset'] ) ) ) : ''; // phpcs:ignore ?>">

								<?php if ( isset( $_GET['search_preset'] ) ) : // phpcs:ignore ?>
									<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_theme_settings_presets' ) ); // phpcs:ignore ?>" class="xts-i-close"></a>
								<?php endif; ?>
							</div>

							<button class="xts-btn xts-color-primary" type="submit">
								<?php esc_html_e( 'Search', 'woodmart' ); ?>
							</button>
						</form>
					</div>
					<div class="xts-col-auto">
						<form action="" method="POST">
							<?php wp_nonce_field( 'xts_presets', 'xts_presets_add_new' ); ?>
							<button class="xts-bordered-btn xts-color-primary xts-i-add" type="submit">
								<?php esc_html_e( 'Add a new preset', 'woodmart' ); ?>
							</button>
						</form>
					</div>
				</div>
			</div>

			<div class="xts-box-content">
				<div class="xts-condition-template">
					<?php self::condition_template(); ?>
				</div>

				<div class="xts-notices-wrapper xts-notices-sticky">
					<?php if ( ! isset( $presets_pages[ $current_page ] ) && isset( $_GET['search_preset'] ) ) : ?>
						<div class="xts-notice xts-info">
							<?php esc_html_e( 'Apologies, but no results were found.', 'woodmart' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! isset( $presets_pages[ $current_page ] ) && ! isset( $_GET['search_preset'] ) ) : ?>
						<div class="xts-notice xts-info">
							<?php esc_html_e( 'There are currently no existing presets.', 'woodmart' ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( isset( $presets_pages[ $current_page ] ) ) : ?>
					<?php foreach ( $presets_pages[ $current_page ] as $id => $preset ) : ?>
						<?php
						$classes = 'xts-preset';

						if ( isset( $_GET['preset_id'] ) && isset( $_GET['action'] ) && (int) $id === (int) $_GET['preset_id'] && 'add_new' === $_GET['action'] ) { // phpcs:ignore
							$classes = wd_add_cssclass( 'xts-opened', $classes );
						}

						?>
						<div class="<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $id ); ?>">
							<div class="xts-preset-header">
								<div class="xts-row xts-sp-10">
									<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_theme_settings&preset=' . $id ) ); ?>" class="xts-preset-link"></a>
									<div class="xts-col">
										<?php self::display_name( $preset ); ?>
									</div>

									<div class="xts-col-auto">
										<div class="xts-preset-actions">
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_theme_settings&preset=' . $id ) ); ?>" class="xts-edit-preset xts-btn xts-color-primary xts-i-cog">
												<?php esc_html_e( 'Edit theme settings', 'woodmart' ); ?>
											</a>

											<a href="#" class="xts-preset-edit xts-preset-close xts-btn xts-color-default xts-i-close">
												<?php esc_html_e( 'Close conditions', 'woodmart' ); ?>
											</a>

											<a href="#" class="xts-preset-edit xts-bordered-btn xts-color-primary xts-i-edit-write">
												<?php esc_html_e( 'Edit conditions', 'woodmart' ); ?>
											</a>

											<form action="" method="POST" class="xts-preset-remove-form">
												<?php wp_nonce_field( 'xts_presets', 'xts_presets_remove' ); ?>
												<input type="hidden" name="preset_id" value="<?php echo esc_attr( $id ); ?>">
												<button class="xts-bordered-btn xts-color-warning xts-i-trash xts-style-icon" title="<?php esc_html_e( 'Remove preset', 'woodmart' ); ?>" type="submit"></button>
											</form>
										</div>
									</div>
								</div>
							</div>

							<div class="xts-preset-content">
								<label>
									<?php esc_html_e( 'Conditions', 'woodmart' ); ?>
								</label>
								<?php self::display_current_conditions( $preset ); ?>
							</div>

							<div class="xts-preset-footer">
								<div class="xts-row">
									<div class="xts-col">
										<a href="#" class="xts-preset-save xts-btn xts-color-primary xts-i-save">
											<?php esc_html_e( 'Save preset', 'woodmart' ); ?>
										</a>
									</div>

									<div class="xts-col-auto">
										<?php self::display_priority( $preset ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php if ( count( $presets_pages ) > 1 ) : ?>
					<ul class="xts-pagination">
						<?php foreach ( $presets_pages as $page_id => $presets ) : ?>
							<?php
							$classes = '';

							if ( (int) $page_id === (int) $current_page ) {
								$classes = wd_add_cssclass( 'xts-current', $classes );
							}
							?>
							<li class="<?php echo esc_attr( $classes ); ?>">
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_theme_settings_presets&preset_page=' . $page_id ) ); ?>">
									<?php echo esc_html( $page_id + 1 ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Display current preset conditions form.
	 *
	 * @param array $preset Preset data.
	 */
	public static function display_current_conditions( $preset ) {
		$condition = $preset['condition'];

		?>
		<div class="xts-preset-conditions">
			<?php if ( ! empty( $condition['rules'] ) ) : ?>
				<?php foreach ( $condition['rules'] as $rule ) : ?>
					<?php self::condition_template( false, $rule ); ?>
				<?php endforeach; ?>
			<?php else : ?>
				<?php self::condition_template( false ); ?>
			<?php endif; ?>

			<a href="#" class="xts-preset-add-condition xts-inline-btn xts-color-primary xts-i-add">
				<?php esc_html_e( 'Add new condition', 'woodmart' ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Display priority input.
	 *
	 * @param array $preset Preset data.
	 */
	public static function display_priority( $preset ) {
		$priority = isset( $preset['priority'] ) ? $preset['priority'] : '';

		?>
		<div class="xts-preset-priority">
			<label for="priority">
				<?php esc_html_e( 'Priority', 'woodmart' ); ?>
			</label>
			<input class="xts-priority" type="number" id="priority" value="<?php echo esc_attr( $priority ); ?>" name="priority" placeholder="<?php esc_html_e( '0', 'woodmart' ); ?>">
		</div>
		<?php
	}

	/**
	 * Display preset name.
	 *
	 * @param array $preset Preset data.
	 */
	public static function display_name( $preset ) {
		$name = $preset['name'];

		if ( ! empty( $preset['priority'] ) ) {
			$name = $name . ' - ' . $preset['priority'];
		}

		?>
		<div class="xts-preset-name">
			<input type="text" aria-label="<?php echo esc_html__( 'Preset name', 'woodmart' ); ?>" name="preset_name" value="<?php echo esc_html( $preset['name'] ); ?>">
			<h4>
				<?php echo esc_html( $name ); ?>
			</h4>
		</div>
		<?php
	}

	/**
	 * HTML template for one rule.
	 *
	 * @param bool  $hidden Is this template hidden.
	 * @param array $rule   Rule array.
	 */
	public static function condition_template( $hidden = true, $rule = array() ) {
		$rule = wp_parse_args(
			$rule,
			array(
				'type'       => '',
				'comparison' => '=',
				'post_type'  => '',
				'taxonomy'   => '',
				'custom'     => '',
				'value_id'   => '',
				'user_role'  => '',
			)
		);

		$post_types = get_post_types(
			array(
				'public' => true,
			)
		);

		$taxonomies = get_taxonomies(
			array(
				'public' => true,
			)
		);

		$custom_conditions = apply_filters(
			'xts_get_custom_conditions_for_preset',
			array(
				'search'         => 'Search results',
				'blog'           => 'Default "Your Latest Posts" screen',
				'front'          => 'Front page',
				'archives'       => 'All archives',
				'author'         => 'Author archives',
				'error404'       => '404 error screens',
				'shop'           => 'Shop page',
				'single_product' => 'Single product',
				'cart'           => 'Cart page',
				'checkout'       => 'Checkout page',
				'account'        => 'Account pages',
				'is_mobile'      => 'Is mobile device',
				'is_rtl'         => 'Is RTL',
			)
		);

		$user_roles = get_editable_roles();

		$title = false;

		if ( 'post_id' === $rule['type'] && ! empty( $rule['value_id'] ) ) {
			$title = get_the_title( $rule['value_id'] );
		}

		if ( ( 'term_id' === $rule['type'] || 'single_posts_term_id' === $rule['type'] ) && ! empty( $rule['value_id'] ) ) {
			$taxonomies = get_taxonomies();

			foreach ( $taxonomies as $taxonomy ) {
				$term_object = get_term_by( 'id', $rule['value_id'], $taxonomy );

				if ( $term_object ) {
					$title = $term_object->name . ' (ID:' . $term_object->term_id . ')';
				}
			}
		}

		?>
		<div class="xts-condition<?php echo $hidden ? ' xts-hidden' : ''; ?>">
			<div class="xts-condition-type">
				<select id="condition_type">
					<option value="">
						<?php esc_html_e( 'Select type', 'woodmart' ); ?>
					</option>
					<option value="post_type" <?php selected( 'post_type', $rule['type'] ); ?>>
						<?php esc_html_e( 'Post type', 'woodmart' ); ?>
					</option>
					<option value="post_id" <?php selected( 'post_id', $rule['type'] ); ?>>
						<?php esc_html_e( 'Post ID', 'woodmart' ); ?>
					</option>
					<option value="taxonomy" <?php selected( 'taxonomy', $rule['type'] ); ?>>
						<?php esc_html_e( 'Taxonomy', 'woodmart' ); ?>
					</option>
					<option value="term_id" <?php selected( 'term_id', $rule['type'] ); ?>>
						<?php esc_html_e( 'Term ID', 'woodmart' ); ?>
					</option>
					<option value="single_posts_term_id" <?php selected( 'single_posts_term_id', $rule['type'] ); ?>>
						<?php esc_html_e( 'Single posts from term', 'woodmart' ); ?>
					</option>
					<option value="custom" <?php selected( 'custom', $rule['type'] ); ?>>
						<?php esc_html_e( 'Custom', 'woodmart' ); ?>
					</option>
					<option value="user_role" <?php selected( 'user_role', $rule['type'] ); ?>>
						<?php esc_html_e( 'User role', 'woodmart' ); ?>
					</option>
				</select>
			</div>

			<div class="xts-condition-comparison">
				<select id="condition_comparison">
					<option value="equals" <?php selected( 'equals', $rule['comparison'] ); ?>>
						<?php esc_html_e( 'Equals', 'woodmart' ); ?>
					</option>
					<option value="not_equals" <?php selected( 'not_equals', $rule['comparison'] ); ?>>
						<?php esc_html_e( 'Not equals', 'woodmart' ); ?>
					</option>
				</select>
			</div>

			<div class="xts-condition-post-type<?php echo 'post_type' !== $rule['type'] ? ' xts-hidden' : ''; ?>">
				<select id="condition_post_type">
					<?php foreach ( $post_types as $type ) : ?>
						<option value="<?php echo esc_attr( $type ); ?>" <?php selected( $type, $rule['post_type'] ); ?>>
							<?php echo esc_html( $type ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="xts-condition-taxonomy<?php echo 'taxonomy' !== $rule['type'] ? ' xts-hidden' : ''; ?>">
				<select id="condition_taxonomy">
					<?php foreach ( $taxonomies as $taxonomy ) : ?>
						<option value="<?php echo esc_attr( $taxonomy ); ?>" <?php selected( $taxonomy, $rule['taxonomy'] ); ?>>
							<?php echo esc_html( $taxonomy ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="xts-condition-custom<?php echo 'custom' !== $rule['type'] ? ' xts-hidden' : ''; ?>">
				<select id="condition_custom">
					<?php foreach ( $custom_conditions as $key => $condition ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $rule['custom'] ); ?>>
							<?php echo esc_html( $condition ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="xts-condition-value-wrapper<?php echo 'post_id' !== $rule['type'] && 'term_id' !== $rule['type'] && 'single_posts_term_id' !== $rule['type'] ? ' xts-hidden' : ''; ?>">
				<select id="condition_value_id" data-placeholder="<?php esc_attr_e( 'Start typing...', 'woodmart' ); ?>" class="xts-condition-value-id" data-value="<?php echo esc_attr( $rule['value_id'] ); ?>">
					<?php if ( $title ) : ?>
						<option value="<?php echo esc_attr( $rule['value_id'] ); ?>" selected="selected">
							<?php echo esc_html( $title ); ?>
						</option>
					<?php endif; ?>
				</select>
			</div>

			<div class="xts-condition-user-role<?php echo 'user_role' !== $rule['type'] ? ' xts-hidden' : ''; ?>">
				<select id="user_role">
					<?php foreach ( $user_roles as $user_role_id => $user_role ) : ?>
						<option value="<?php echo esc_html( $user_role_id ); ?>" <?php selected( $user_role_id, $rule['user_role'] ); ?>>
							<?php echo esc_html( $user_role['name'] ); ?>
						</option>
					<?php endforeach ?>
				</select>
			</div>

			<a href="#" class="xts-bordered-btn xts-color-warning xts-i-close xts-style-icon xts-condition-remove" title="<?php esc_html_e( 'Remove condition', 'woodmart' ); ?>"></a>
		</div>
		<?php
	}

	/**
	 * Get currently editing preset.
	 */
	public static function get_current_preset() {
		return isset( $_REQUEST['preset'] ) && isset( self::$presets[ $_REQUEST['preset'] ] ) ? intval( $_REQUEST['preset'] ) : false; // phpcs:ignore
	}

	/**
	 * Presets getter.
	 */
	public static function get_all() {
		return array_reverse( self::$presets, true );
	}

	/**
	 * Get presets that active for the current page.
	 */
	public static function get_active_presets() {
		$all            = self::get_all();
		$active_presets = array();

		foreach ( $all as $preset ) {
			if ( empty( $preset['condition'] ) || empty( $preset['condition']['rules'] ) ) {
				continue;
			}

			$rules = $preset['condition']['rules'];
			foreach ( $rules as $rule ) {
				$is_active = false;
				switch ( $rule['type'] ) {
					case 'post_type':
						$condition = get_post_type() === $rule['post_type'];
						$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
						break;
					case 'post_id':
						if ( $rule['value_id'] && ! is_admin() ) {
							$condition = (int) woodmart_get_the_ID() === (int) $rule['value_id'];
							$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
						}
						break;
					case 'single_posts_term_id':
						if ( is_singular() ) {
							$terms = wp_get_post_terms( woodmart_get_the_ID(), get_taxonomies(), array( 'fields' => 'ids' ) );

							if ( $terms ) {
								$condition = in_array( $rule['value_id'], $terms, false ); // phpcs:ignore
								$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
							}
						}
						break;
					case 'term_id':
						$object  = get_queried_object();
						$term_id = false;

						if ( is_object( $object ) && property_exists( $object, 'term_id' ) ) {
							$term_id = get_queried_object()->term_id;
							$type    = get_queried_object()->taxonomy;

							$ancestors = get_ancestors( $term_id, $type );

							if ( in_array( $rule['value_id'], $ancestors, false ) ) { // phpcs:ignore
								$term_id = $rule['value_id'];
							}
						}

						if ( $term_id ) {
							$condition = (int) $term_id === (int) $rule['value_id'];
							$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
						}
						break;
					case 'taxonomy':
						$object = get_queried_object();

						$taxonomy = is_object( $object ) && property_exists( $object, 'taxonomy' ) ? get_queried_object()->taxonomy : false;

						if ( $taxonomy ) {
							$condition = (int) $taxonomy === (int) $rule['taxonomy'];
							$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
						}
						break;
					case 'custom':
						switch ( $rule['custom'] ) {
							case 'search':
								$is_active = 'equals' === $rule['comparison'] ? is_search() : ! is_search();
								break;
							case 'blog':
								$condition = (int) woodmart_get_the_ID() === (int) get_option( 'page_for_posts' );
								$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
								break;
							case 'front':
								$condition = (int) woodmart_get_the_ID() === (int) get_option( 'page_on_front' );
								$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
								break;
							case 'archives':
								$is_active = 'equals' === $rule['comparison'] ? is_archive() : ! is_archive();
								break;
							case 'author':
								$is_active = 'equals' === $rule['comparison'] ? is_author() : ! is_author();
								break;
							case 'error404':
								$is_active = 'equals' === $rule['comparison'] ? is_404() : ! is_404();
								break;
							case 'shop':
								if ( woodmart_woocommerce_installed() ) {
									$is_active = 'equals' === $rule['comparison'] ? is_shop() : ! is_shop();
								}
								break;
							case 'single_product':
								if ( woodmart_woocommerce_installed() ) {
									$is_active = 'equals' === $rule['comparison'] ? is_product() : ! is_product();
								}
								break;
							case 'cart':
								if ( woodmart_woocommerce_installed() ) {
									$is_active = 'equals' === $rule['comparison'] ? is_cart() : ! is_cart();
								}
								break;
							case 'checkout':
								if ( woodmart_woocommerce_installed() ) {
									$is_active = 'equals' === $rule['comparison'] ? is_checkout() : ! is_checkout();
								}
								break;
							case 'account':
								if ( woodmart_woocommerce_installed() ) {
									$is_active = 'equals' === $rule['comparison'] ? is_account_page() : ! is_account_page();
								}
								break;
							case 'is_mobile':
								$is_active = 'equals' === $rule['comparison'] ? wp_is_mobile() : ! wp_is_mobile();
								break;
							case 'is_rtl':
								$is_active = 'equals' === $rule['comparison'] ? is_rtl() : ! is_rtl();
								break;
						}
						break;
					case 'user_role':
						$condition = in_array( $rule['user_role'], woodmart_get_current_user_roles(), true );
						$is_active = 'equals' === $rule['comparison'] ? $condition : ! $condition;
						break;
				}

				if ( isset( $_GET['page'] ) && isset( $_GET['preset'] ) && 'xts_theme_settings' === $_GET['page'] ) { // phpcs:ignore
					$is_active    = true;
					$preset['id'] = $_GET['preset']; // phpcs:ignore
				}

				if ( $is_active ) {
					$priority                    = isset( $preset['priority'] ) ? $preset['priority'] : '';
					$active_presets[ $priority ] = $preset['id'];
				}
			}
		}

		foreach ( $all as $preset ) {
			if ( isset( $_GET['opts'] ) && $preset['name'] === $_GET['opts'] ) { // phpcs:ignore
				$active_presets[] = $preset['id'];
			}
		}

		ksort( $active_presets );

		return apply_filters( 'xts_active_options_presets', array_unique( $active_presets ), $all );
	}
}

Presets::get_instance();
