<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

// start Woodmart code.
use XTS\Modules\Layouts\Global_Data as Builder_Data;
use XTS\Modules\Layouts\Main as Builder;
// end Woodmart code.

defined( 'ABSPATH' ) || exit;

global $product;

if ( 'yes' === woodmart_loop_prop( 'hide_out_of_stock_products' ) && $available_variations ) {
	$available_variations_new = array();

	foreach ( $available_variations as $key => $available_variation ) {
		if ( ! empty( $available_variation['is_in_stock'] ) ) {
			$available_variations_new[] = $available_variation;
		}
	}

	$variations_json = wp_json_encode( $available_variations_new ) ;
} else {
	$variations_json = wp_json_encode( $available_variations );
}

$attribute_keys  = array_keys( $attributes );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

// start Woodmart code.
$is_builder                    = Builder::get_instance()->has_custom_layout( 'single_product' );
$is_quick_shop                 = wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'woodmart_quick_shop' === $_REQUEST['action'] && woodmart_get_opt( 'quick_shop_variable' ); // phpcs:ignore
$is_quick_shop2                = isset( $wd_swatches_limits );
$is_quick_view                 = woodmart_loop_prop( 'is_quick_view' );
$swatches_use_variation_images = woodmart_get_opt( 'swatches_use_variation_images' );
$grid_swatches_attribute       = woodmart_grid_swatches_attribute();
$form_classes                  = '';
$wd_reset_classes              = '';
$swatch_limit                  = false;
$is_single_product             = true;
$more_limit_swathes            = (int) apply_filters( 'woodmart_show_more_limit_swatches_count', 1 );

if ( $is_quick_shop2 ) {
	if ( ! empty( $wd_swatches_limits ) ) {
		$swatch_limit = (int) $wd_swatches_limits;
	}

	$is_single_product = false;
	$form_classes     .= ' wd-quick-shop-2';
	$form_classes     .= ' wd-clear-' . woodmart_get_opt( 'quick_shop_clear_action', 'none' );
} elseif ( ! $is_quick_shop && woodmart_get_opt( 'single_product_swatches_limit' ) ) {
	$swatch_limit = (int) woodmart_get_opt( 'single_product_swatches_limit_count', 10 );
}

if ( $is_quick_shop ) {
	$form_classes .= ' wd-reset-bottom-lg wd-reset-bottom-md wd-label-top-lg wd-label-top-md';
}

if ( woodmart_get_opt( 'swatches_labels_name' ) ) {
	$form_classes .= ' wd-swatches-name';
}

if ( ! $is_quick_shop && ! $is_quick_shop2 ) {
	if ( woodmart_get_opt( 'single_product_variations_price' ) ) {
		woodmart_enqueue_js_script( 'variations-price' );
		$form_classes .= ' wd-price-outside';
	}
}

if ( $is_builder ) {
	if ( ! empty( Builder_Data::get_instance()->get_data( 'form_classes' ) ) ) {
		$form_classes .= Builder_Data::get_instance()->get_data( 'form_classes' );
	}
} else {
	if ( 'default' === woodmart_get_opt( 'product_design' ) && ! $is_quick_shop ) {
		$form_classes .= ' wd-reset-side-lg';
	}
}

if ( ! $is_quick_shop && ! $is_builder && ! $is_quick_shop2 ) {
	if ( 'default' === woodmart_get_opt( 'product_design' ) ) {
		$form_classes .= ' wd-reset-bottom-md wd-label-top-md';

		if ( woodmart_get_opt( 'swatches_labels_name' ) ) {
			$form_classes .= ' wd-label-top-lg';
		}
	} elseif ( 'alt' === woodmart_get_opt( 'product_design' ) ) {
		$form_classes .= ' wd-reset-bottom-lg wd-reset-bottom-md wd-label-top-lg wd-label-top-md';
	}
}

if ( $is_quick_view ) {
	$form_classes = ' wd-reset-side-lg wd-reset-bottom-md wd-label-top-md';

	if ( 'default' === woodmart_get_opt( 'product_design' ) && woodmart_get_opt( 'swatches_labels_name' ) ) {
		$form_classes .= ' wd-label-top-lg';
	}
}

woodmart_enqueue_js_library( 'tooltips' );
woodmart_enqueue_js_script( 'btns-tooltips' );

if ( ! isset( $wd_swatches_limits ) ) {
	woodmart_enqueue_js_script( 'swatches-variations' );
}
// end Woodmart code.

woodmart_enqueue_inline_style( 'woo-mod-variation-form' );
woodmart_enqueue_inline_style( 'woo-mod-swatches-base' );

if ( is_product() || $is_quick_view ) {
	woodmart_enqueue_inline_style( 'woo-mod-variation-form-single' );
}

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart<?php echo esc_attr( $form_classes ); ?>" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // phpcs:ignore. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
			<?php $loop = 0; ?>
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<?php
				// start Woodmart code.
				$loop++;
				$swatches            = woodmart_has_swatches( $product->get_id(), $attribute_name, $options, $available_variations, $swatches_use_variation_images );
				$active_variations   = woodmart_get_active_variations( $attribute_name, $available_variations );
				$swatch_size         = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );
				$swatch_dis_style    = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_dis_style' );
				$swatch_style        = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_style' );
				$swatch_shape        = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_shape' );
				$swatch_change_image = woodmart_wc_get_attribute_term( $attribute_name, 'change_image' );
				$wrapper_class       = woodmart_get_old_classes( ' swatches-on-single' );

				if ( taxonomy_exists( $attribute_name ) ) {
					if ( ! $swatch_style ) {
						$swatch_style = '1';
					}
					if ( ! $swatch_dis_style ) {
						$swatch_dis_style = '1';
					}
					if ( ! $swatch_size ) {
						$swatch_size = 'default';
					}
					if ( ! $swatch_shape ) {
						$swatch_shape = 'round';
					}

					woodmart_enqueue_inline_style( 'woo-mod-swatches-style-' . $swatch_style );
					woodmart_enqueue_inline_style( 'woo-mod-swatches-dis-' . $swatch_dis_style );

					if ( $is_single_product ) {
						$wrapper_class .= ' wd-swatches-single';
					} else {
						$wrapper_class .= ' wd-swatches-grid';
					}

					$wrapper_class .= ' wd-bg-style-' . $swatch_style;
					$wrapper_class .= ' wd-text-style-' . $swatch_style;
					$wrapper_class .= ' wd-dis-style-' . $swatch_dis_style;
					$wrapper_class .= ' wd-size-' . $swatch_size;
					$wrapper_class .= ' wd-shape-' . $swatch_shape;

					if ( $swatch_limit && is_array( $options ) && ( array_key_first( $attributes ) === $attribute_name || $is_single_product ) && count( $options ) > $swatch_limit + $more_limit_swathes ) {
						$wrapper_class .= ' wd-swatches-limited';
					}
				}
				// end Woodmart code.
				?>
				<tr>
					<th class="label cell"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // phpcs:ignore. ?></label></th>
					<td class="value cell<?php echo ! empty( $swatches ) ? esc_attr( ' with-swatches' ) : ''; ?>">
						<?php // start Woodmart code. ?>
						<?php if ( ! empty( $swatches ) ) : ?>
							<div class="wd-swatches-product<?php echo esc_attr( $wrapper_class ); ?>" data-id="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
								<?php
								if ( is_array( $options ) ) {
									$_i = 0;
									$selected_value = '';

									if ( ! $is_quick_shop2 ) {
										if ( isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) {
											$selected_value = $_REQUEST[ 'attribute_' . $attribute_name ];
										} elseif ( isset( $selected_attributes[ $attribute_name ] ) ) {
											$selected_value = $selected_attributes[ $attribute_name ];
										}
									}

									// Get terms if this is a taxonomy - ordered.
									if ( taxonomy_exists( $attribute_name ) ) {
										$terms          = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );
										$options_fliped = array_flip( $options );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) ) {
												continue;
											}

											$key    = $options_fliped[ $term->slug ];
											$style  = '';
											$image  = '';
											$class  = 'wd-swatch';
											$class .= woodmart_get_old_classes( ' swatch-on-single woodmart-swatch' );

											if ( ! empty( $swatches[ $key ]['color'] ) ) {
												$class .= ' wd-bg';
												$class .= woodmart_get_old_classes( ' swatch-with-bg' );

												if ( ! woodmart_get_opt( 'swatches_labels_name' ) ) {
													$class .= ' wd-tooltip';
												}

												$style = 'background-color:' . $swatches[ $key ]['color'];

											} elseif ( $swatches_use_variation_images && $grid_swatches_attribute === $attribute_name && isset( $swatches[ $key ]['image_src'] ) ) {
												$image = wp_get_attachment_image( get_post_thumbnail_id( $swatches[ $key ]['variation_id'] ), 'woocommerce_thumbnail' );

												if ( ! empty( $image ) ) {
													$class .= ' wd-bg';
													$class .= woodmart_get_old_classes( ' swatch-with-bg' );

													if ( ! woodmart_get_opt( 'swatches_labels_name' ) ) {
														$class .= ' wd-tooltip';
													}
												}
											} elseif ( ! empty( $swatches[ $key ]['image'] ) && ( ! is_array( $swatches[ $key ]['image'] ) || ( is_array( $swatches[ $key ]['image'] ) && $swatches[ $key ]['image']['id'] ) ) ) {
												if ( is_array( $swatches[ $key ]['image'] ) ) {
													$image = wp_get_attachment_image( $swatches[ $key ]['image']['id'], 'woocommerce_thumbnail' );
												} elseif ( $swatches[ $key ]['image'] ) {
													$image = '<img src="' . $swatches[ $key ]['image'] . '" alt="' . esc_attr__( 'Swatch image', 'woodmart' ) . '">';
												}

												$class .= ' wd-bg';
												$class .= woodmart_get_old_classes( ' swatch-with-bg' );

												if ( ! woodmart_get_opt( 'swatches_labels_name' ) ) {
													$class .= ' wd-tooltip';
												}
											} else {
												$class .= ' wd-text';
												$class .= woodmart_get_old_classes( ' text-only' );
											}

											if ( in_array( $swatch_size, array( 'default', 'large', 'xlarge' ), true ) ) {
												$class .= woodmart_get_old_classes( ' swatch-size-' . $swatch_size );
											}

											if ( $selected_value === $term->slug ) {
												$class .= ' wd-active';
											}

											if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && $active_variations ) {
												if ( in_array( $term->slug, $active_variations ) ) {
													$class .= ' wd-enabled';
												} else {
													$class .= ' wd-disabled';
												}
											}

											$title = woodmart_get_opt( 'swatches_labels_name' ) ? ' title="' . $term->name . '"' : '';

											if ( $swatch_limit && count( $options ) > $swatch_limit + $more_limit_swathes && ( array_key_first( $attributes ) === $attribute_name || $is_single_product ) ) {
												if ( $_i >= $swatch_limit ) {
													$class .= ' wd-hidden';
												}

												if ( $_i === $swatch_limit ) {
													woodmart_enqueue_inline_style( 'woo-opt-limit-swatches' );
													woodmart_enqueue_js_script( 'swatches-limit' );

													?>
													<div class="wd-swatch-divider">
														<?php echo '+' . ( count( $options ) - (int) $swatch_limit ); ?>
													</div>
													<?php
												}
											}

											?>
												<div class="<?php echo esc_attr( $class ); ?>"<?php echo wp_kses( $title, true ); ?> data-value="<?php echo esc_attr( $term->slug ); ?>" data-title="<?php echo esc_attr( $term->name ); ?>" <?php echo selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ); ?>>
													<?php if ( $style || $image ) : ?>
														<span class="wd-swatch-bg" style="<?php echo esc_attr( $style ); ?>">
															<?php if ( $image ) : ?>
																<?php echo $image; //phpcs:ignore ?>
															<?php endif; ?>
														</span>
													<?php endif; ?>
													<span class="wd-swatch-text">
														<?php echo wp_kses( apply_filters( 'woocommerce_variation_option_name', $term->name ), true ); ?>
													</span>
												</div>
											<?php
											$_i++;
										}
									} else {
										foreach ( $options as $option ) {
											$class = '';

											if ( $selected_value === $option ) {
												$class .= ' wd-active';
											}

											if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && $active_variations ) {
												if ( in_array( $term->slug, $active_variations ) ) {
													$class .= ' wd-enabled';
												} else {
													$class .= ' wd-disabled';
												}
											}

											if ( $swatch_limit && array_key_first( $attributes ) === $attribute_name && count( $options ) > $swatch_limit + $more_limit_swathes ) {
												if ( $_i >= $swatch_limit ) {
													$class .= ' wd-hidden';
												}

												if ( $_i === $swatch_limit ) {
													woodmart_enqueue_inline_style( 'woo-opt-limit-swatches' );
													woodmart_enqueue_js_script( 'swatches-limit' );

													echo '<div class="wd-swatch-divider">+' . ( count( $options ) - (int) $swatch_limit ) . '</div>';
												}
											}

											$title = woodmart_get_opt( 'swatches_labels_name' ) ? 'title="' . $term->name . '"' : '';

											echo '<div class="' . esc_attr( $class ) . '" ' . $title . ' data-value="' . esc_attr( sanitize_title( $option ) ) . '" data-title="' . esc_attr( $term->name ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</div>';

											$_i++;
										}
									}
								}
								?>
							</div>
						<?php endif; ?>
						<?php // end Woodmart code. ?>
						<?php
						wc_dropdown_variation_attribute_options(
							array(
								'selected'  => $is_quick_shop2 ? '' : false,
								'options'   => $options,
								'attribute' => $attribute_name,
								'product'   => $product,
								'class'     => 'on' === $swatch_change_image ? 'wd-changes-variation-image' : '',
							)
						);
						echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<div class="wd-reset-var' . $wd_reset_classes . '"><a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a></div>' ) ) : '';
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_variations_table' ); ?>

	<div class="single_variation_wrap">
		<?php
			/**
			 * Hook: woocommerce_before_single_variation.
			 */
			do_action( 'woocommerce_before_single_variation' );

			/**
			 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
			 *
			 * @since 2.4.0
			 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
			 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
			 */
			do_action( 'woocommerce_single_variation' );

			/**
			 * Hook: woocommerce_after_single_variation.
			 */
			do_action( 'woocommerce_after_single_variation' );
		?>
	</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
