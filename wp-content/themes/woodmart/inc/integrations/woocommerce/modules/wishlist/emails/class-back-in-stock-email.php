<?php
/**
 * Send back in stock status product.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Send back in stock status product.
 */
class Back_In_Stock_Email extends WC_Email {

	/**
	 * Receiver user
	 *
	 * @var WP_User
	 */
	public $user = null;

	/**
	 * Items that will be used for product table rendering
	 *
	 * @var $items
	 */
	public $items = array();

	/**
	 * True when the email notification is sent to customers.
	 *
	 * @var bool
	 */
	protected $customer_email = true;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id          = 'woodmart_back_in_stock_email';
		$this->title       = esc_html__( 'Wishlist "Back in stock" email', 'woodmart' );
		$this->description = esc_html__( 'This email is sent to customers when an item of their wishlist is back in stock', 'woodmart' );

		$this->heading = esc_html__( 'An item of your wishlist is back in stock!', 'woodmart' );
		$this->subject = esc_html__( 'An item of your wishlist is back in stock!', 'woodmart' );

		$this->template_html  = 'emails/back-in-stock.php';
		$this->template_plain = 'emails/plain/back-in-stock.php';

		// Triggers for this email.
		add_action( 'woodmart_send_back_in_stock_mail_notification', array( $this, 'trigger' ), 10, 2 );

		// Call parent constructor.
		parent::__construct();
	}

	/**
	 * Method triggered to send email
	 *
	 * @param integer $user_id User object.
	 * @param array   $product_lists List of wishlist items.
	 *
	 * @return void
	 */
	public function trigger( $user_id, $product_lists ) {
		if ( ! $user_id || is_wp_error( $user_id ) ) {
			return;
		}

		$user            = get_user_by( 'id', $user_id );
		$this->user      = $user;
		$this->recipient = $user->user_email;

		$product_exclusions  = $this->get_option( 'product_exclusions', array() );
		$category_exclusions = $this->get_option( 'category_exclusions', array() );

		foreach ( $product_lists as $product_id ) {
			$product = wc_get_product( $product_id );

			if ( in_array( $product_id, $product_exclusions ) || array_intersect( $product->get_category_ids(), $category_exclusions ) || 'instock' !== $product->get_stock_status() ) { //phpcs:ignore
				continue;
			}

			$this->items[] = $product;
		}

		if ( ! $this->items ) {
			return;
		}

		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
	}

	/**
	 * Get content html.
	 *
	 * @return string
	 */
	public function get_content_html() {
		ob_start();

		wc_get_template(
			$this->template_html,
			array(
				'email'         => $this,
				'email_heading' => $this->get_heading(),
				'product_lists' => $this->items,
				'sent_to_admin' => false,
				'plain_text'    => false,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Get content plain.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		ob_start();

		wc_get_template(
			$this->template_plain,
			array(
				'email'         => $this,
				'email_heading' => $this->get_heading(),
				'product_lists' => $this->items,
				'sent_to_admin' => false,
				'plain_text'    => true,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Admin Panel Options Processing.
	 */
	public function process_admin_options() {
		$post_data = $this->get_post_data();

		// Save templates.
		if ( isset( $post_data['template_html_code'] ) ) {
			$this->save_template( $post_data['template_html_code'], $this->template_html );
		}
		if ( isset( $post_data['template_plain_code'] ) ) {
			$this->save_template( $post_data['template_plain_code'], $this->template_plain );
		}

		// Save regular options.
		$this->init_settings();

		$post_data = $this->get_post_data();

		foreach ( $this->get_form_fields() as $key => $field ) {
			if ( 'title' !== $this->get_field_type( $field ) ) {
				try {
					$this->settings[ $key ] = $this->get_field_value( $key, $field, $post_data );
				} catch ( Exception $e ) {
					$this->add_error( $e->getMessage() );
				}
			}
		}

		$option_key = $this->get_option_key();

		do_action( 'woocommerce_update_option', array( 'id' => $option_key ) );

		return update_option( $option_key, apply_filters( 'woocommerce_settings_api_sanitized_fields_' . $this->id, $this->settings ), false );
	}

	/**
	 * Init fields that will store admin preferences
	 *
	 * @return void
	 */
	public function init_form_fields() {
		$product_categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'number'     => 0,
				'fields'     => 'id=>name',
			)
		);

		$saved_exclusions   = $this->get_option( 'product_exclusions', array() );
		$exclusions_options = array();

		if ( $saved_exclusions ) {
			foreach ( $saved_exclusions as $product_id ) {
				$product = wc_get_product( $product_id );

				if ( ! $product ) {
					continue;
				}

				$exclusions_options[ $product_id ] = $product->get_formatted_name();
			}
		}

		$this->form_fields = array(
			'enabled'             => array(
				'title'   => esc_html__( 'Enable/Disable', 'woodmart' ),
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Enable this email notification', 'woodmart' ),
				'default' => 'no',
			),

			'subject'             => array(
				'title'       => esc_html__( 'Subject', 'woodmart' ),
				'type'        => 'text',
				// translators: 1. Default subject.
				'description' => sprintf( __( 'This field lets you modify the email subject line. Leave blank to use the default subject: <code>%s</code>.', 'woodmart' ), $this->subject ),
				'placeholder' => '',
				'default'     => '',
			),

			'heading'             => array(
				'title'       => esc_html__( 'Email Heading', 'woodmart' ),
				'type'        => 'text',
				// translators: 1. Default email heading.
				'description' => sprintf( __( 'This field lets you modify the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', 'woodmart' ), $this->heading ),
				'placeholder' => '',
				'default'     => '',
			),

			'product_exclusions'  => array(
				'title'       => esc_html__( 'Product exclusions', 'woodmart' ),
				'type'        => 'multiselect',
				'description' => esc_html__( 'Select the products for which you don\'t want to send a reminder email', 'woodmart' ),
				'class'       => 'wc-product-search',
				'options'     => $exclusions_options,
			),

			'category_exclusions' => array(
				'title'       => esc_html__( 'Category exclusions', 'woodmart' ),
				'type'        => 'multiselect',
				'class'       => 'wc-enhanced-select',
				'description' => esc_html__( 'Select the product categories for which you don\'t want to send a reminder email', 'woodmart' ),
				'options'     => $product_categories,
			),

			'email_type'          => array(
				'title'       => esc_html__( 'Email type', 'woodmart' ),
				'type'        => 'select',
				'description' => esc_html__( 'Choose which type of email to send.', 'woodmart' ),
				'default'     => 'html',
				'class'       => 'email_type',
				'options'     => array(
					'plain'     => esc_html__( 'Plain text', 'woodmart' ),
					'html'      => esc_html__( 'HTML', 'woodmart' ),
					'multipart' => esc_html__( 'Multipart', 'woodmart' ),
				),
			),
		);
	}
}

return new Back_In_Stock_Email();
