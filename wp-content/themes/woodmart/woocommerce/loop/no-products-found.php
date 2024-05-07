<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 7.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="woocommerce-no-products-found">
	<?php wc_print_notice( esc_html__( 'No products were found matching your selection.', 'woocommerce' ), 'notice' ); ?>
</div>

<div class="no-products-footer">
	<?php get_product_search_form(); ?>
</div>

<?php do_action( 'woodmart_after_no_product_found' ); ?>