<?php

namespace XTS\Modules\Linked_Variations;

use WP_Query;
use XTS\Singleton;

class Frontend extends Singleton {
	/**
	 * Data.
	 *
	 * @var array
	 */
	private $linked_data = [];

	/**
	 * Construct.
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'woocommerce_single_product_summary', [ $this, 'output' ], 25 );
	}

	/**
	 * Output,
	 *
	 * @param string $wrapper_classes Classes.
	 */
	public function output( $wrapper_classes = '' ) {
		if ( ! woodmart_get_opt( 'linked_variations' ) ) {
			return;
		}

		global $product;

		$this->set_linked_data( $product->get_id() );

		if ( empty( $this->linked_data ) || ! $this->linked_data['attrs'] || 1 === count( $this->linked_data['attrs'] ) && empty( reset( $this->linked_data['attrs'] ) ) ) {
			return;
		}

		woodmart_enqueue_js_library( 'tooltips' );
		woodmart_enqueue_js_script( 'btns-tooltips' );

		woodmart_enqueue_inline_style( 'woo-mod-variation-form-single' );
		woodmart_enqueue_inline_style( 'woo-mod-variation-form' );
		woodmart_enqueue_inline_style( 'woo-mod-swatches-base' );

		$current_attributes     = $this->get_product_attributes( $product->get_id() );
		$linked_variations_data = $this->get_linked_variations( $product->get_id() );

		if ( ! $wrapper_classes ) {
			$wrapper_classes = ' wd-label-top-md';
		}
		?>
		<div class="variations_form-linked<?php echo esc_attr( $wrapper_classes ); ?>">
			<table class="variations">
				<tbody>
					<?php foreach ( $linked_variations_data as $attr_slug => $attr_data ) : ?>
						<?php
						$swatch_size      = woodmart_wc_get_attribute_term( $attr_slug, 'swatch_size' );
						$swatch_dis_style = woodmart_wc_get_attribute_term( $attr_slug, 'swatch_dis_style' );
						$swatch_style     = woodmart_wc_get_attribute_term( $attr_slug, 'swatch_style' );
						$swatch_shape     = woodmart_wc_get_attribute_term( $attr_slug, 'swatch_shape' );

						$swatches_classes = '';

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

						$swatches_classes .= ' wd-bg-style-' . $swatch_style;
						$swatches_classes .= ' wd-text-style-' . $swatch_style;
						$swatches_classes .= ' wd-dis-style-' . $swatch_dis_style;
						$swatches_classes .= ' wd-size-' . $swatch_size;
						$swatches_classes .= ' wd-shape-' . $swatch_shape;
						?>
						<tr>
							<th class="label cell">
								<label>
									<?php echo esc_html( $current_attributes['taxonomy'][ $attr_slug ] ); ?>
								</label>
							</th>
							<td class="value cell with-swatches">
								<div class="wd-swatches wd-swatches-product <?php echo esc_attr( $swatches_classes ); ?>">
									<?php foreach ( $attr_data['terms'] as $term_slug => $term_data ) : ?>
										<?php
										$term_meta = $term_data['attributes']['meta'][ $attr_slug ];
										$classes   = 'wd-swatch wd-enabled';
										$styles    = '';
										$image     = '';

										if ( $this->linked_data['use_image'] && in_array( $attr_slug, $this->linked_data['use_image'], true ) ) {
											$image   = wp_get_attachment_image( get_post_thumbnail_id( $term_data['id'] ), 'woocommerce_thumbnail' );
											$classes = wd_add_cssclass( 'wd-bg wd-tooltip', $classes );
										} elseif ( ! empty( $term_meta['color'] ) ) {
											$styles  = 'background-color:' . $term_meta['color'];
											$classes = wd_add_cssclass( 'wd-bg wd-tooltip', $classes );
										} elseif ( ( ! empty( $term_meta['image'] ) && ! is_array( $term_meta['image'] ) ) || ( is_array( $term_meta['image'] ) && ! empty( $term_meta['image']['id'] ) ) ) {
											$classes = wd_add_cssclass( 'wd-bg wd-tooltip', $classes );

											if ( is_array( $term_meta['image'] ) ) {
												$image = wp_get_attachment_image( $term_meta['image']['id'], 'full' );
											} else {
												$image = '<img src="' . $term_meta['image'] . '" alt="' . esc_attr__( 'Swatch image', 'woodmart' ) . '">';
											}
										} else {
											$classes = wd_add_cssclass( 'wd-text', $classes );
										}

										if ( 'outofstock' === $term_data['stock_status'] || ! $term_data['is_purchasable'] ) {
											$classes = wd_add_cssclass( 'wd-disabled wd-linked', $classes );
										}

										if ( (string) $current_attributes['slugs'][ $attr_slug ] === (string) $term_slug ) {
											$classes = wd_add_cssclass( 'wd-active', $classes );
										}

										?>
										<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( $term_data['permalink'] ); ?>">
											<?php if ( $styles || $image ) : ?>
												<span class="wd-swatch-bg" style="<?php echo esc_attr( $styles ); ?>">
													<?php if ( $image ) : ?>
														<?php echo $image; //phpcs:ignore ?>
													<?php endif; ?>
												</span>
											<?php endif; ?>
											<span class="wd-swatch-text">
												<?php echo esc_html( $term_data['attributes']['labels'][ $attr_slug ] ); ?>
											</span>
										</a>
									<?php endforeach; ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Get linked variations data.
	 *
	 * @param int $product_id Product id.
	 *
	 * @return array
	 */
	public function get_linked_variations( $product_id ) {
		$attributes = $this->get_product_attributes( $product_id );
		$output     = array();

		if ( empty( $attributes['slugs'] ) ) {
			return $output;
		}

		foreach ( $attributes['slugs'] as $taxonomy => $attribute ) {
			$taxonomy_ids = array();

			foreach ( $this->linked_data['products'] as $current_product_id ) {
				$current_product = wc_get_product( $current_product_id );

				if ( ! $current_product || $current_product->get_status() !== 'publish' ) {
					continue;
				}

				$current_product_attrs = $current_product->get_attributes();

				if ( is_wp_error( $current_product_attrs ) || empty( $current_product_attrs[ $taxonomy ] ) || ! $current_product_attrs[ $taxonomy ]->get_options() ) {
					continue;
				}

				$taxonomy_ids = array_merge( $taxonomy_ids, $current_product_attrs[ $taxonomy ]->get_options() );
			}

			$terms = get_terms(
				[
					'taxonomy' => $taxonomy,
					'include'  => array_unique( $taxonomy_ids ),
				]
			);

			foreach ( $terms as $term ) {
				$data = $this->get_linked_variation_data_for_attribute( $product_id, $taxonomy, $term->slug );

				if ( ! $data ) {
					continue;
				}

				$output[ $taxonomy ]['terms'][ $term->slug ] = $data;
				$output[ $taxonomy ]['label'][ $term->slug ] = $term->name;
			}
		}

		return $output;
	}

	/**
	 * Set data.
	 *
	 * @param int $product_id Product id.
	 */
	private function set_linked_data( $product_id ) {
		$post = new WP_Query(
			[
				'post_type'   => 'woodmart_woo_lv',
				'numberposts' => 1,
				'meta_query'  => [ // phpcs:ignore
					[
						'key'     => '_woodmart_linked_products',
						'value'   => sprintf( '"%d"', $product_id ),
						'compare' => 'LIKE',
					],
				],
			]
		);

		if ( ! $post->posts ) {
			return;
		}

		$this->linked_data = [
			'products'  => get_post_meta( $post->posts[0]->ID, '_woodmart_linked_products', true ),
			'attrs'     => get_post_meta( $post->posts[0]->ID, '_woodmart_linked_attrs', true ),
			'use_image' => get_post_meta( $post->posts[0]->ID, '_woodmart_linked_use_product_image', true ),
		];
	}

	/**
	 * Get product attributes.
	 *
	 * @param int $product_id Product id.
	 *
	 * @return array
	 */
	private function get_product_attributes( $product_id ) {
		$attributes = [];

		foreach ( $this->linked_data['attrs'] as $attribute ) {
			$terms = get_the_terms( $product_id, $attribute );

			if ( ! $terms || is_wp_error( $terms ) ) {
				continue;
			}

			$first_term = array_pop( $terms );

			$attributes[ $product_id ]['slugs'][ $attribute ]    = $first_term->slug;
			$attributes[ $product_id ]['labels'][ $attribute ]   = $first_term->name;
			$attributes[ $product_id ]['taxonomy'][ $attribute ] = get_taxonomy( $attribute )->labels->singular_name;
			$attributes[ $product_id ]['meta'][ $attribute ]     = [
				'color' => get_term_meta( $first_term->term_id, 'color', true ),
				'image' => get_term_meta( $first_term->term_id, 'image', true ),
			];
		}

		return $attributes[ $product_id ];
	}

	/**
	 * Get linked variation data for attribute.
	 *
	 * @param int    $product_id Product id.
	 * @param string $taxonomy Taxonomy.
	 * @param string $term_slug Term slug.
	 *
	 * @return array
	 */
	public function get_linked_variation_data_for_attribute( $product_id, $taxonomy, $term_slug ) {
		$current_attributes = $this->get_product_attributes( $product_id );
		$linked_variations  = $this->get_linked_variations_data( $product_id );

		$current_attributes['slugs'][ $taxonomy ] = $term_slug;

		$output = [];

		foreach ( $linked_variations as $linked_variation ) {
			if ( ! array_diff_assoc( $current_attributes['slugs'], $linked_variation['attributes']['slugs'] ) ) {
				$output = $linked_variation;
			}
		}

		return $output;
	}

	/**
	 * Get product attributes.
	 *
	 * @param int $product_id Product id.
	 *
	 * @return array
	 */
	private function get_linked_variations_data( $product_id ) {
		$linked_products = [];

		foreach ( $this->linked_data['products'] as $linked_variation_id ) {
			$linked_variation = wc_get_product( $linked_variation_id );

			if ( ! $linked_variation || $linked_variation->get_status() !== 'publish' ) {
				continue;
			}

			$linked_products[ $product_id ][ $linked_variation_id ] = [
				'id'             => $linked_variation_id,
				'permalink'      => $linked_variation->get_permalink(),
				'image'          => $linked_variation->get_image( 'shop_thumbnail' ),
				'title'          => $linked_variation->get_title(),
				'stock_status'   => $linked_variation->get_stock_status(),
				'is_purchasable' => $linked_variation->is_purchasable(),
				'attributes'     => $this->get_product_attributes( $linked_variation_id ),
			];
		}

		return $linked_products[ $product_id ];
	}
}

Frontend::get_instance();
