<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_wpml_js_data' ) ) {
	function woodmart_wpml_js_data() {
		if ( ! woodmart_get_opt( 'ajax_shop' ) || ! defined( 'WCML_VERSION' ) || ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
			return;
		}

		$data = array(
			'languages' => apply_filters( 'wpml_active_languages', null ),
		);

		echo '<script>';
		echo 'var woodmart_wpml_js_data = ' . wp_json_encode( $data );
		echo '</script>';
	}

	add_action( 'woodmart_after_header', 'woodmart_wpml_js_data' );
}

if ( ! function_exists( 'woodmart_wpml_compatibility' ) ) {
	function woodmart_wpml_compatibility( $ajax_actions ) {
		$ajax_actions[] = 'woodmart_ajax_add_to_cart';
		$ajax_actions[] = 'woodmart_quick_view';
		$ajax_actions[] = 'woodmart_ajax_search';
		$ajax_actions[] = 'woodmart_get_products_shortcode';
		$ajax_actions[] = 'woodmart_get_products_tab_shortcode';
		$ajax_actions[] = 'woodmart_update_cart_item';
		$ajax_actions[] = 'woodmart_load_html_dropdowns';
		$ajax_actions[] = 'woodmart_quick_shop';

		return $ajax_actions;
	}

	add_filter( 'wcml_multi_currency_ajax_actions', 'woodmart_wpml_compatibility', 10, 1 );
}

if ( ! function_exists( 'woodmart_wpml_variation_gallery_data' ) ) {
	function woodmart_wpml_variation_gallery_data( $post_id_from, $post_id_to, $meta_key ) {
		if ( 'woodmart_variation_gallery_data' === $meta_key ) {
			$translated_lang  = apply_filters( 'wpml_post_language_details', '', $post_id_to );
			$translated_lang  = isset( $translated_lang['language_code'] ) ? $translated_lang['language_code'] : '';
			$original_value   = get_post_meta( $post_id_from, 'woodmart_variation_gallery_data', true );
			$translated_value = $original_value;
			if ( ! empty( $original_value ) && is_array( $original_value ) ) {
				foreach ( $original_value as $key => $value ) {
					$translated_variation_id = apply_filters( 'wpml_object_id', $key, 'product_variation', false, $translated_lang );

					$translated_value[ $translated_variation_id ] = $value;
					unset( $translated_value[ $key ] );
				}
				update_post_meta( $post_id_to, 'woodmart_variation_gallery_data', $translated_value );
			}
		}
	}

	add_action( 'wpml_after_copy_custom_field', 'woodmart_wpml_variation_gallery_data', 10, 3 );
}

if ( ! function_exists( 'woodmart_wpml_register_header_builder_strings' ) ) {
	function woodmart_wpml_register_header_builder_strings( $file ) {
		global $wpdb;

		if ( is_string( $file ) && 'woodmart' === basename( dirname( $file ) ) && class_exists( 'WPML_Admin_Text_Configuration' ) ) {
			$file       .= ':whb';
			$admin_texts = array();
			$headers     = get_option( 'whb_saved_headers', [] );
			foreach ( $headers as $key => $header ) {
				$admin_texts[] = array(
					'value' => '',
					'attr'  => array( 'name' => 'whb_' . $key ),
					'key'   => array(
						array(
							'value' => '',
							'attr'  => array( 'name' => 'structure' ),
							'key'   => array(
								array(
									'value' => '',
									'attr'  => array( 'name' => 'content' ),
									'key'   => array(
										array(
											'value' => '',
											'attr'  => array( 'name' => '*' ),
											'key'   => array(
												array(
													'value' => '',
													'attr' => array( 'name' => 'content' ),
													'key'  => array(
														array(
															'value' => '',
															'attr' => array( 'name' => '*' ),
															'key' => array(
																array(
																	'value' => '',
																	'attr' => array( 'name' => 'content' ),
																	'key' => array(
																		array(
																			'value' => '',
																			'attr' => array( 'name' => '*' ),
																			'key' => array(
																				array(
																					'value' => '',
																					'attr' => array( 'name' => 'params' ),
																					'key' => array(
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'content' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'title' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'subtitle' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'btn_text' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'image' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'link' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'categories_title' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'primary_menu_title' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																						array(
																							'value' => '',
																							'attr' => array( 'name' => 'secondary_menu_title' ),
																							'key' => array(
																								array(
																									'value' => '',
																									'attr' => array( 'name' => 'value' ),
																									'key' => array(),
																								),
																							),
																						),
																					),
																				),
																			),
																		),
																	),
																),
															),
														),
													),
												),
											),
										),
									),
								),
							),
						),
					),
				);
			}

			$object = (object) array(
				'config'             => array(
					'wpml-config' => array(
						'admin-texts' => array(
							'value' => '',
							'key'   => $admin_texts,
						),
					),
				),
				'type'               => 'theme',
				'admin_text_context' => 'woodmart-header-builder',
			);

			$config       = new WPML_Admin_Text_Configuration( $object );
			$config_array = $config->get_config_array();

			if ( ! empty( $config_array ) ) {
				$st_records          = new WPML_ST_Records( $wpdb );
				$import              = new WPML_Admin_Text_Import( $st_records, new WPML_WP_API() );
				$config_handler_hash = md5( serialize( 'whb' ) );
				$import->parse_config( $config_array, $config_handler_hash );
			}
		}
	}

	add_filter( 'wpml_parse_config_file', 'woodmart_wpml_register_header_builder_strings' );
}

if ( ! function_exists( 'woodmart_get_wpml_languages_in_mobile_menu' ) ) {
	/**
	 * Output WPML languages in mobile menu.
	 *
	 * @param string  $items Items.
	 * @param array   $args Args.
	 * @param boolean $return Return.
	 *
	 * @return mixed|string
	 */
	function woodmart_get_wpml_languages_in_mobile_menu( $items = '', $args = array(), $return = false ) {
		$is_mobile_menu = ! empty( $args ) && 'mobile-menu' === $args->theme_location;

		if ( $is_mobile_menu || $return ) {
			$settings = whb_get_settings();

			if ( ! empty( $settings['burger']['languages'] ) ) {
				$languages    = apply_filters( 'wpml_active_languages', array() );
				$current_lang = esc_html__( 'Languages', 'woodmart' );
				$flag_url     = '';
				$current_url  = '';

				if ( $languages ) {
					foreach ( $languages as $key => $language ) {
						if ( $language['active'] ) {
							$flag_url     = $language['country_flag_url'];
							$current_lang = $language['native_name'];
							$current_url  = $language['url'];

							unset( $languages[ $key ] );
						}
					}
				}

				ob_start();
				?>
				<li class="menu-item menu-item-languages <?php echo esc_attr( $languages || ! $flag_url ? ' menu-item-has-children' : '' ); ?>">
					<a href="<?php echo esc_url( $current_url ); ?>" class="woodmart-nav-link">
						<?php if ( $flag_url && $settings['burger']['show_language_flag'] ) : ?>
							<img src="<?php echo esc_url( $flag_url ); ?>" alt="<?php echo esc_attr( $current_lang ); ?>" class="wd-nav-img">
						<?php endif; ?>
						<span class="nav-link-text">
							<?php echo esc_html( $current_lang ); ?>
						</span>
					</a>
					<ul class="wd-sub-menu">
						<?php if ( $languages ) : ?>
							<?php foreach ( $languages as $language ) : ?>
								<li>
									<a href="<?php echo esc_url( $language['url'] ); ?>" hreflang="<?php echo esc_attr( $language['language_code'] ); ?>" class="woodmart-nav-link">
										<?php if ( $language['country_flag_url'] && $settings['burger']['show_language_flag'] ) : ?>
											<img src="<?php echo esc_url( $language['country_flag_url'] ); ?>" alt="<?php echo esc_attr( $language['native_name'] ); ?>" class="wd-nav-img">
										<?php endif; ?>
										<span class="nav-link-text">
											<?php echo esc_html( $language['native_name'] ); ?>
										</span>
									</a>
								</li>
							<?php endforeach; ?>
						<?php elseif ( ! $flag_url ) : ?>
							<li>
								<a href="#">
									<?php esc_html_e( 'You need WPML plugin for this to work. You can remove it from Header builder.', 'woodmart' ); ?>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
				<?php

				$items .= ob_get_clean();
			}
		}

		return $items;
	}

	add_filter( 'wp_nav_menu_items', 'woodmart_get_wpml_languages_in_mobile_menu', 40, 2 );
}

if ( ! function_exists( 'woodmart_wpml_product_video_attachment_id' ) ) {
	function woodmart_wpml_product_video_attachment_id( $attachment_id, $product ) {
		return apply_filters( 'wpml_object_id', $attachment_id, 'attachment', true, apply_filters( 'wpml_default_language', null ) );
	}

	add_filter( 'woodmart_single_product_image_thumbnail_id', 'woodmart_wpml_product_video_attachment_id', 10, 2 );
}

if ( class_exists( 'woocommerce_wpml' ) && ! function_exists( 'woodmart_wpml_shipping_progress_bar_amount' ) ) {
	function woodmart_wpml_shipping_progress_bar_amount( $limit ) {
		global $woocommerce_wpml;

		$multi_currency = $woocommerce_wpml->get_multi_currency();

		if ( ! empty( $multi_currency->prices ) && method_exists( $multi_currency->prices, 'convert_price_amount' ) ) {
			$limit = $multi_currency->prices->convert_price_amount( $limit );
		}

		return $limit;
	}

	add_filter( 'woodmart_shipping_progress_bar_amount', 'woodmart_wpml_shipping_progress_bar_amount' );
}
