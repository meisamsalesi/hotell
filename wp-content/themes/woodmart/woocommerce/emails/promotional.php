<?php
/**
 * Customer "promotional" email.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
	<?php echo wp_kses_post( $email_content ); ?>

	<p>
		<small>
			<?php echo wp_kses( sprintf( __( 'If you don\'t want to receive any further notification, please %s', 'woodmart' ), '<a href="' . woodmart_get_unsubscribe_link( $email->user->ID ) . '">' . esc_html__( 'unsubscribe', 'woodmart' ) . '</a>' ), true ); ?>
		</small>
	</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
