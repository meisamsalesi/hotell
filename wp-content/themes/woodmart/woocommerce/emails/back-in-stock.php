<?php
/**
 * Customer "back in stock" email
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>
	<?php esc_html_e( sprintf( 'Hi, %s!', $email->user->user_login ), 'woodmart' ); ?>
</p>

<p>
	<?php esc_html_e( 'The product on your wishlist is back in stock!', 'woodmart' ); ?>
</p>

<?php if ( $product_lists ) : ?>
	<?php $text_align = is_rtl() ? 'right' : 'left'; ?>

	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; margin: 0 0 16px;" border="1">
		<thead>
		<tr>
			<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'woodmart' ); ?></th>
			<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'woodmart' ); ?></th>
			<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $product_lists as $product ) : ?>
			<tr>
				<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?> vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word; flex-wrap: wrap;">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" style="display: flex; align-items: center; border-bottom: none; text-decoration: none;">
						<?php echo get_the_post_thumbnail( $product->get_id(), array( '70', '70' ), array( 'style' => 'margin-right: 15px; max-width:70px;' ) ); ?>
						<span>
							<?php echo esc_html( $product->get_title() ); ?>
						</span>
					</a>
				</td>
				<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
					<?php echo wp_kses( $product->get_price_html(), true ); ?>
				</td>
				<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
					<?php $button_link = $product->is_type( 'simple' ) ? add_query_arg( 'add-to-cart', $product->get_id(), $product->get_permalink() ) : $product->get_permalink(); ?>
					<a style="display: inline-block; background-color: #ebe9eb; color: #515151; white-space: nowrap; padding: .618em 1em; border-radius: 3px; text-decoration: none;" href="<?php echo esc_url( $button_link ); ?>">
						<?php echo esc_html( $product->add_to_cart_text() ); ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<p>
	<?php esc_html_e( 'We only have limited stock, so don\'t wait any longer, and take this chance to make it yours!', 'woodmart' ); ?>
</p>

<p>
	<small>
		<?php echo wp_kses( sprintf( __( 'If you don\'t want to receive any further notification, please %s', 'woodmart' ), '<a href="' . woodmart_get_unsubscribe_link( $email->user->ID ) . '">' . esc_html__( 'unsubscribe', 'woodmart' ) . '</a>' ), true ); ?>
	</small>
</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
