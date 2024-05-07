<?php
	global $product;


	do_action( 'woocommerce_before_shop_loop_item' );
?>

	<div class="product-wrapper">
		<div class="product-element-top wd-quick-shop">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="product-image-link">
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woodmart_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</a>

			<?php
			if ( 'no' === woodmart_loop_prop( 'grid_gallery' ) || ! woodmart_loop_prop( 'grid_gallery' ) ) {
				woodmart_hover_image();
			}
			?>

			<div class="wd-buttons wd-pos-r-t<?php echo woodmart_get_old_classes( ' woodmart-buttons' ); ?>">
				<?php woodmart_enqueue_js_script( 'btns-tooltip' ); ?>
				<?php woodmart_quick_view_btn( get_the_ID() ); ?>
				<?php woodmart_add_to_compare_loop_btn(); ?>
				<?php do_action( 'woodmart_product_action_buttons' ); ?>
			</div>
		</div>

		<div class="product-list-content wd-scroll">
			<?php
				/**
				 * woocommerce_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
				do_action( 'woocommerce_shop_loop_item_title' );
			?>
			<?php
				woodmart_product_categories();
				woodmart_product_brands_links();
				woodmart_product_sku();
			?>
			<?php echo wp_kses_post( woodmart_get_product_rating() ); ?>
			<?php woodmart_stock_status_after_title(); ?>
			<?php woocommerce_template_loop_price(); ?>
			<?php
				echo woodmart_swatches_list();
			?>
			<?php
			if ( woodmart_get_opt( 'base_hover_content' ) == 'additional_info' ) {
				wc_display_product_attributes( $product );
			} else {
				woocommerce_template_single_excerpt();
			}
			?>
			<?php woodmart_swatches_list(); ?>

			<?php if ( woodmart_loop_prop( 'progress_bar' ) ) : ?>
				<?php woodmart_stock_progress_bar(); ?>
			<?php endif ?>

			<?php if ( woodmart_loop_prop( 'timer' ) ) : ?>
				<?php woodmart_product_sale_countdown(); ?>
			<?php endif ?>

			<div class="wd-add-btn wd-add-btn-replace<?php echo woodmart_get_old_classes( ' woodmart-add-btn' ); ?>">
				<?php if ( woodmart_loop_prop( 'product_quantity' ) ): ?>
					<?php woodmart_product_quantity( $product ); ?>
				<?php endif ?>

				<?php do_action( 'woodmart_add_loop_btn' ); ?>
			</div>

			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		</div>
	</div>
