<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.8.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

woodmart_enqueue_js_script( 'woocommerce-quantity' );

$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );

// Transfer for WooCommerce 7.4.0.
if ( ! isset( $readonly ) ) {
	if ( $max_value && $min_value === $max_value ) {
		$readonly    = true;
		$input_value = $min_value;
	} else {
		$readonly = false;
	}
}

if ( ! isset( $type ) ) {
	$type = $min_value > 0 && $min_value === $max_value ? 'hidden' : 'number';
	$type = $readonly && 'hidden' !== $type ? 'text' : $type;
}
?>

<div class="quantity<?php echo 'hidden' === $type ? ' hidden' : ''; ?>">
	<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>

	<?php if ( 'number' === $type ) : ?>
		<input type="button" value="-" class="minus" />
	<?php endif; ?>

	<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
	<input
		type="<?php echo esc_attr( $type ); ?>"
		<?php wp_readonly( $readonly ); ?>
		id="<?php echo esc_attr( $input_id ); ?>"
		class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		aria-label="<?php esc_attr_e( 'Product quantity', 'woocommerce' ); ?>"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"

		<?php if ( ! $readonly ) : ?>
			step="<?php echo esc_attr( $step ); ?>"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>"
			autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
		<?php endif; ?>
	>

	<?php if ( 'number' === $type ) : ?>
		<input type="button" value="+" class="plus" />
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
</div>
