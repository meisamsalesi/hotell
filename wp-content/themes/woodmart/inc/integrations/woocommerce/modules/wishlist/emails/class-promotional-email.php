<?php
/**
 * Send promotional email.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Send promotional.
 */
class Promotional_Email extends WC_Email {

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
	 * Strings to find/replace in subjects/headings.
	 *
	 * @var array|string[]
	 */
	protected $loop_placeholders = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id          = 'woodmart_promotional_email';
		$this->title       = esc_html__( 'Wishlist "Promotional" email', 'woodmart' );
		$this->description = esc_html__( 'This email is sent to the customer that has a product on his wishlist. You can send these emails via Dashboard -> Products -> Wishlists -> Popular products -> Create promotion.', 'woodmart' );

		$this->heading = esc_html__( 'There is a deal for you!', 'woodmart' );
		$this->subject = esc_html__( 'A product of your wishlist is on sale!', 'woodmart' );

		$this->template_html  = 'emails/promotional.php';
		$this->template_plain = 'emails/plain/promotional.php';

		$this->content_html = $this->get_option( 'content_html' );
		$this->content_text = $this->get_option( 'content_text' );

		if ( $this->get_option( 'coupon_code' ) ) {
			$this->coupon = new WC_Coupon( $this->get_option( 'coupon_code' ) );
		}

		// Triggers for this email.
		add_action( 'woodmart_send_promotional_mail_notification', array( $this, 'trigger' ), 10, 4 );

		// Call parent constructor.
		parent::__construct();
	}

	/**
	 * Method triggered to send email.
	 *
	 * @param integer          $user_id User id.
	 * @param int|string|array $product_list Products id.
	 * @param string           $content_html Content html.
	 * @param string           $content_text Content text.
	 *
	 * @return void
	 */
	public function trigger( $user_id, $product_list, $content_html = '', $content_text = '' ) {
		if ( ! $user_id || is_wp_error( $user_id ) ) {
			return;
		}

		$this->content_html = ! empty( $content_html ) ? $content_html : $this->get_option( 'content_html' );
		$this->content_text = ! empty( $content_text ) ? $content_text : $this->get_option( 'content_text' );
		$this->items        = array();

		if ( is_array( $product_list ) ) {
			foreach ( $product_list as $product_id ) {
				$product = wc_get_product( $product_id );

				if ( 'instock' !== $product->get_stock_status() ) { //phpcs:ignore
					continue;
				}

				$this->items[] = $product;
			}
		} else {
			$product = wc_get_product( $product_list );

			if ( 'instock' !== $product->get_stock_status() ) { //phpcs:ignore
				return;
			}

			$this->items[] = $product;
		}

		$user            = get_user_by( 'id', $user_id );
		$this->user      = $user;
		$this->recipient = $user->user_email;

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
				'email_content' => $this->get_custom_content_html(),
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
				'email_content' => $this->get_custom_content_plain(),
				'product_lists' => $this->items,
				'sent_to_admin' => false,
				'plain_text'    => true,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Retrieve custom email html content
	 *
	 *  @return string custom content, with replaced values.
	 */
	public function get_custom_content_html() {
		if ( ! function_exists( 'wc_cart_round_discount' ) ) {
			include_once trailingslashit( WC()->plugin_path() ) . 'includes/wc-cart-functions.php';
		}

		$image_size = apply_filters( 'woodmart_promotional_email_thumbnail_item_size', array( 32, 32 ) );

		$this->loop_placeholders = array_merge(
			$this->loop_placeholders,
			array_merge(
				array(
					'{product_image}'   => '{product_image_%d}',
					'{product_name}'    => '{product_name_%d}',
					'{product_price}'   => '{product_price_%d}',
					'{product_url}'     => '{product_url_%d}',
					'{add_to_cart_url}' => '{add_to_cart_url_%d}',
				),
				! isset( $this->coupon ) ? array() : array(
					'{coupon_value}' => '{coupon_value_%d}',
				)
			)
		);

		$this->placeholders = array_merge(
			$this->placeholders,
			array_merge(
				array(
					'{user_name}'       => $this->user->user_login,
					'{user_email}'      => $this->user->user_email,
					'{user_first_name}' => $this->user->billing_first_name,
					'{user_last_name}'  => $this->user->billing_last_name,
					'{wishlist_url}'    => woodmart_get_wishlist_page_url(),
				),
				! isset( $this->coupon ) ? array() : array(
					'{coupon_code}'   => $this->get_option( 'coupon_code' ),
					'{coupon_amount}' => method_exists( $this->coupon, 'get_amount' ) ? $this->coupon->get_amount() : $this->coupon->coupon_amount,
				)
			)
		);

		foreach ( $this->items as $id => $product ) {
			$this->placeholders = array_merge(
				$this->placeholders,
				array_merge(
					array(
						'{product_image_' . $id . '}'   => $product ? apply_filters( 'woodmart_promotional_email_item_thumbnail', '<div style="margin-bottom: 5px"><img src="' . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woodmart' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . esc_attr( $image_size[0] ) . '" style="vertical-align:middle; margin-' . ( is_rtl() ? 'left' : 'right' ) . ': 10px;" /></div>', $product ) : '',
						'{product_name_' . $id . '}'    => $product ? $product->get_title() : '',
						'{product_price_' . $id . '}'   => $product ? $product->get_price_html() : '',
						'{product_url_' . $id . '}'     => $product ? $product->get_permalink() : '',
						'{add_to_cart_url_' . $id . '}' => $product ? esc_url( add_query_arg( 'add-to-cart', $product->get_id(), $product->get_permalink() ) ) : '',
					),
					! isset( $this->coupon ) ? array() : array(
						'{coupon_value_' . $id . '}'  => $product ? wc_price( $this->coupon->get_discount_amount( $product->get_price() ) ) : 0,
					)
				)
			);
		};

		return apply_filters( 'woodmart_custom_html_content_' . $this->id, $this->format_string( stripcslashes( $this->content_html ) ), $this->object );
	}

	/**
	 * Retrieve custom email text content
	 *
	 *  @return string custom content, with replaced values.
	 */
	public function get_custom_content_plain() {
		$this->loop_placeholders = array_merge(
			$this->loop_placeholders,
			array_merge(
				array(
					'{product_name}'    => '{product_name_%d}',
					'{product_price}'   => '{product_price_%d}',
					'{add_to_cart_url}' => '{add_to_cart_url_%d}',
				),
				! isset( $this->coupon ) ? array() : array(
					'{coupon_value}' => '{coupon_value_%d}',
				)
			)
		);

		$this->placeholders = array_merge(
			array(
				'{user_name}'       => $this->user->user_login,
				'{user_email}'      => $this->user->user_email,
				'{user_first_name}' => $this->user->billing_first_name,
				'{user_last_name}'  => $this->user->billing_last_name,
			),
			! isset( $this->coupon ) ? array() : array(
				'{coupon_code}'   => yit_get_prop( $this->coupon, 'code' ),
				'{coupon_amount}' => method_exists( $this->coupon, 'get_amount' ) ? $this->coupon->get_amount() : $this->coupon->coupon_amount,
			)
		);

		foreach ( $this->items as $id => $product ) {
			$this->placeholders = array_merge(
				$this->placeholders,
				array_merge(
					array(
						'{product_name_' . $id . '}'    => $product ? $product->get_title() : '',
						'{product_price_' . $id . '}'   => $product ? $product->get_price_html() : '',
						'{add_to_cart_url_' . $id . '}' => $product ? esc_url( add_query_arg( 'add-to-cart', $product->get_id(), $product->get_permalink() ) ) : '',
					),
					! isset( $this->coupon ) ? array() : array(
						'{coupon_value_' . $id . '}'  => $product ? wc_price( $this->coupon->get_discount_amount( $product->get_price() ) ) : 0,
					)
				)
			);
		};

		return apply_filters( 'woodmart_custom_text_content_' . $this->id, $this->format_string( stripcslashes( $this->content_text ) ), $this->object );
	}

	/**
	 * Format email string.
	 *
	 * @param mixed $string Text to replace placeholders in.
	 * @return string
	 */
	public function format_string( $string ) {
		$start = "{loop}";
		$end   = "{endloop}";

		if ( ! strpos($string, $start) || ! strpos($string, $end) ) {
			return parent::format_string( $string );
		}

		$startPos            = strpos($string, $start) + strlen($start);
		$endPos              = strpos($string, $end, $startPos);
		$default_loop_string = substr($string, $startPos, $endPos - $startPos);
		$loop_string         = $default_loop_string;

		foreach ( $this->items as $id => $product ) {
			$loop_string = str_replace(
				array_keys( $this->loop_placeholders ),
				array_map(
					'sprintf',
					array_values( $this->loop_placeholders ),
					array_fill( 0, count( $this->loop_placeholders ), $id )
				),
				$loop_string
			);

			if ( $id < count( $this->items ) - 1 ) {
				$loop_string .= $default_loop_string;
			}
		}

		$string = str_replace(
			array(
				'{loop}',
				'{endloop}',
				$default_loop_string
			),
			array(
				'',
				'',
				$loop_string
			),
			$string
		);

		return parent::format_string( $string );
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
	 * Init fields that will store admin preferences.
	 *
	 * @return void
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled'      => array(
				'title'   => esc_html__( 'Enable/Disable', 'woodmart' ),
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Enable this email notification', 'woodmart' ),
				'default' => 'yes',
			),
			'subject'      => array(
				'title'       => esc_html__( 'Subject', 'woodmart' ),
				'type'        => 'text',
				// translators: 1. Default subject.
				'description' => sprintf( __( 'This field lets you modify the email subject line. Leave blank to use the default subject: <code>%s</code>.', 'woodmart' ), $this->subject ),
				'placeholder' => '',
				'default'     => '',
			),
			'heading'      => array(
				'title'       => esc_html__( 'Email Heading', 'woodmart' ),
				'type'        => 'text',
				// translators: 1. Default email heading.
				'description' => sprintf( __( 'This field lets you modify the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', 'woodmart' ), $this->heading ),
				'placeholder' => '',
				'default'     => '',
			),
			'email_type'   => array(
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
			'coupon_code'  => array(
				'title'       => esc_html__( 'Coupon code', 'woodmart' ),
				'type'        => 'select',
				'description' => esc_html__( 'Choose which coupon code to send.', 'woodmart' ),
				'default'     => 'html',
				'options'     => array_merge(
					array(
						'' => '',
					),
					$this->get_available_coupon_codes()
				),
			),
			'content_html' => array(
				'title'       => esc_html__( 'Email HTML content', 'woodmart' ),
				'type'        => 'textarea',
				'description' => sprintf(
					esc_html__( 'This field lets you modify the main content of the HTML email. You can use the following placeholders: %s. Next placeholders you must use only within %s tags: %s', 'woodmart' ),
					self::get_placeholder_text( 'html' ),
					'<code>{loop}...{endloop}</code>',
					self::get_placeholder_text( 'html', 'loop' )
				),
				'placeholder' => '',
				'css'         => 'min-height: 250px;',
				'default'     => self::get_default_content( 'html' ),
			),
			'content_text' => array(
				'title'       => esc_html__( 'Email text content', 'woodmart' ),
				'type'        => 'textarea',
				'description' => sprintf(
					esc_html__( 'This field lets you modify the main content of the text email. You can use the following placeholders: %s. Next placeholders you must use only within %s tags: %s', 'woodmart' ),
					self::get_placeholder_text( 'plain' ),
					'<code>{loop}...{endloop}</code>',
					self::get_placeholder_text( 'plain', 'loop' )
				),
				'placeholder' => '',
				'css'         => 'min-height: 250px;',
				'default'     => self::get_default_content( 'plain' ),
			),
		);
	}

	/**
	 * Get available coupon codes list.
	 *
	 * @return array|false
	 */
	private function get_available_coupon_codes() {
		global $wpdb;

		$coupon_codes = $wpdb->get_col(
			"SELECT post_name
			FROM $wpdb->posts
			WHERE post_type = 'shop_coupon'
			  AND post_status = 'publish'
			ORDER BY post_name ASC"
		);

		return array_combine( $coupon_codes, $coupon_codes );
	}

	/**
	 * Returns text with placeholders that can be used in this email
	 *
	 * @param string $email_type Email type.
	 *
	 * @return string Placeholders
	 *
	 * @since 3.0.0
	 */
	public static function get_placeholder_text( $email_type, $placeholder_type = '' ) {
		if ( 'loop' === $placeholder_type ) {
			if ( 'plain' === $email_type ) {
				return '<code>{product_name}</code> <code>{product_price}</code> <code>{add_to_cart_url}</code> <code>{coupon_value}</code>';
			} else {
				return '<code>{product_image}</code> <code>{product_name}</code> <code>{product_price}</code> <code>{product_url}</code> <code>{add_to_cart_url}</code> <code>{coupon_value}</code>';
			}
		}

		if ( 'plain' === $email_type ) {
			return '<code>{user_name}</code> <code>{user_email}</code> <code>{user_first_name}</code> <code>{user_last_name}</code> <code>{coupon_code}</code> <code>{coupon_amount}</code>';
		} else {
			return '<code>{user_name}</code> <code>{user_email}</code> <code>{user_first_name}</code> <code>{user_last_name}</code> <code>{wishlist_url}</code> <code>{coupon_code}</code> <code>{coupon_amount}</code>';
		}
	}

	/**
	 * Returns default email content.
	 *
	 * @param string $email_type Email type.
	 *
	 * @return string Placeholders
	 *
	 * @since 3.0.10
	 */
	public static function get_default_content( $email_type ) {
		if ( 'plain' === $email_type ) {
			return __(
				'Hi {user_name}
A product of your wishlist is on sale!

{loop}
{product_name} {product_price}
{endloop}',
				'woodmart'
			);
		} else {
			return __(
				'<p>Hi {user_name}</p>
<p>A product of your wishlist is on sale!</p>
<p>
	<table>
		{loop}
			<tr>
				<td>
					<a href="{product_url}">
						{product_image}
					</a>
				</td>
				<td>
					<a href="{product_url}">
						{product_name}
					</a>
				</td>
				<td>{product_price}</td>
			</tr>
		{endloop}
	</table>
</p>',
				'woodmart'
			);
		}
	}
}

return new Promotional_Email();
