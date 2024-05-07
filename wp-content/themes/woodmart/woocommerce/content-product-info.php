<?php 
	global $product;
	
	
	do_action( 'woocommerce_before_shop_loop_item' ); 
?>

<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="product-image-link">
			<?php
			/**
			 * Hook woocommerce_before_shop_loop_item_title.
			 *
			 * @hooked woodmart_template_loop_product_thumbnails_gallery - 5
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

		<div class="top-information">
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
				woodmart_stock_status_after_title();
				do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div>
		<div class="bottom-information">
			<?php echo wp_kses_post( woodmart_get_product_rating() ); ?>
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
			<?php 
				echo woodmart_swatches_list();
			?>
		</div> 
		<div class="wd-buttons wd-pos-r-b<?php echo woodmart_get_old_classes( ' woodmart-buttons' ); ?>">
			<?php woodmart_enqueue_js_script( 'btns-tooltip' ); ?>
			<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon<?php echo woodmart_get_old_classes( ' wd-add-cart-btn woodmart-add-btn' ); ?>">
				<?php do_action( 'woodmart_add_loop_btn' ); ?>
			</div>
			<?php woodmart_add_to_compare_loop_btn(); ?>
			<?php woodmart_quick_view_btn( get_the_ID() ); ?>
			<?php do_action( 'woodmart_product_action_buttons' ); ?>
		</div>

	</div>
</div>
