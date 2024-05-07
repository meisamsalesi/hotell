<?php
/**
 * Product image gallery with video.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Product_Gallery_Video;

use XTS\Options;
use XTS\Singleton;

/**
 * Product image gallery with video.
 */
class Main extends Singleton {
	/**
	 * Default settings.
	 *
	 * @var array
	 */
	public $default_settings = array(
		'video_type'       => 'mp4',
		'upload_video_id'  => '',
		'upload_video_url' => '',
		'youtube_url'      => '',
		'vimeo_url'        => '',
		'autoplay'         => '0',
		'video_size'       => 'contain',
		'video_control'    => 'theme',
		'hide_gallery_img' => '0',
		'hide_information' => '0',
		'audio_status'     => 'unmute',
	);

	/**
	 * Thumbnails settings.
	 *
	 * @var array
	 */
	public $thumbnails_settings = array();

	/**
	 * Init.
	 */
	public function init() {
		add_action( 'init', array( $this, 'add_options' ) );
		add_action( 'init', array( $this, 'hooks' ), 20 );
	}

	/**
	 * Ноокs.
	 *
	 * @return void
	 */
	public function hooks() {
		if ( ! woodmart_get_opt( 'single_product_main_gallery_video', true ) ) {
			return;
		}

		add_filter( 'admin_post_thumbnail_html', array( $this, 'get_main_image_video_btn' ), 10, 3 );
		add_action( 'woocommerce_admin_after_product_gallery_item', array( $this, 'get_gallery_product_video_btn' ), 10, 2 );

		add_action( 'edit_form_advanced', array( $this, 'get_product_thumbnail_popup' ) );

		add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_gallery' ), 10, 2 );

		add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'product_image_thumbnail' ), 10, 2 );
		add_filter( 'woodmart_single_product_thumbnail_classes', array( $this, 'product_thumbnails_classes' ), 10, 2 );

		add_filter( 'woodmart_get_single_product_image_data', array( $this, 'get_single_image_data' ), 10, 2 );

		add_filter( 'woodmart_admin_localized_string_array', array( $this, 'admin_localized_settings' ) );
		add_filter( 'woodmart_localized_string_array', array( $this, 'localized_settings' ) );
	}

	/**
	 * Add options in theme settings.
	 *
	 * @return void
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'single_product_main_gallery_video',
				'name'        => esc_html__( 'Main carousel with video', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'video-display-type-simplified.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Enable the ability to add videos to the main product gallery carousel.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'product_images',
				'default'     => true,
				'group'       => esc_html__( 'Main image', 'woodmart' ),
				'priority'    => 45,
			)
		);
	}

	/**
	 * Get button for gallery image.
	 *
	 * @param string $post_id Post ID.
	 * @param string $attachment_id Attachment id.
	 * @return void
	 */
	public function get_gallery_product_video_btn( $post_id, $attachment_id ) {
		$product_settings = get_post_meta( $post_id, 'woodmart_wc_video_gallery', true );
		$settings         = $this->default_settings;

		if ( ! empty( $product_settings[ $attachment_id ] ) && is_array( $product_settings[ $attachment_id ] ) ) {
			$settings = array_merge( $settings, $product_settings[ $attachment_id ] );
		}

		if ( $this->check_is_available_video( $settings ) ) {
			$classes = ' xts-edit-video';
		} else {
			$classes = ' xts-add-video';
		}

		?>
		<div class="xts-product-video-wrapp">
			<a href="#" class="xts-btn xts-color-primary xts-product-gallery-video xts-i-add<?php echo esc_attr( $classes ); ?>">
				<?php esc_html_e( 'Video', 'woodmart' ); ?>
			</a>
			<input type="hidden" name="xts-product-gallery-video[<?php echo esc_attr( $attachment_id ); ?>]" value='<?php echo wp_json_encode( $settings ); ?>'>
		</div>
		<?php
	}

	/**
	 * Get button for main product image.
	 *
	 * @param string  $content Image content.
	 * @param integer $post_id Post ID.
	 * @param integer $attachment_id Attachment ID.
	 * @return string
	 */
	public function get_main_image_video_btn( $content, $post_id, $attachment_id ) {
		if ( ! woodmart_woocommerce_installed() || 'product' !== get_post_type( $post_id ) ) {
			return $content;
		}

		ob_start();

		$this->get_gallery_product_video_btn( $post_id, $attachment_id );

		return $content . ob_get_clean();
	}

	/**
	 * Get product video gallery popup.
	 *
	 * @param object $post Post object.
	 */
	public function get_product_thumbnail_popup( $post ) {
		if ( empty( $post->post_type ) || 'product' !== $post->post_type ) {
			return;
		}

		wp_enqueue_script( 'wd-product-gallery-videos', WOODMART_ASSETS . '/js/productGalleryVideo.js', array(), woodmart_get_theme_info( 'Version' ), true );
		wp_enqueue_script( 'wd-tooltips', WOODMART_ASSETS . '/js/tooltip.js', array(), woodmart_get_theme_info( 'Version' ), true );

		include WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/product-gallery-video/template/popup.php';
	}

	/**
	 * Save settings for gallery image item.
	 *
	 * @param integer $product_id Product ID.
	 * @param object  $post Post object.
	 * @return void
	 */
	public function save_product_gallery( $product_id, $post ) {
		if ( 'product' !== $post->post_type || empty( $_POST['xts-product-gallery-video'] ) ) { //phpcs:ignore
			return;
		}

		$attachments_settings = (array) woodmart_clean( $_POST['xts-product-gallery-video'] ); //phpcs:ignore
		$product_settings     = array();

		foreach ( $attachments_settings as $attachment_id => $settings ) {
			$settings = json_decode( wp_unslash( $settings ), true );

			if ( empty( $settings['video_type'] ) || 'custom' === $settings['video_type'] && empty( $settings['custom_url'] ) || 'upload' === $settings['video_type'] && empty( $settings['upload_video_id'] ) ) {
				continue;
			}

			$product_settings[ $attachment_id ] = $settings;
		}

		update_post_meta( $product_id, 'woodmart_wc_video_gallery', $product_settings );
	}

	/**
	 * Output product image thumbnails.
	 *
	 * @param string  $content Gallery thumbnail content.
	 * @param integer $attachment_id Thumbnail ID.
	 * @return false|string
	 */
	public function product_image_thumbnail( $content, $attachment_id ) {
		global $product;

		if ( empty( $product ) || ! woodmart_get_opt( 'single_product_main_gallery_video', true ) ) {
			return $content;
		}

		$attachment_id             = apply_filters( 'woodmart_single_product_image_thumbnail_id', $attachment_id, $product );
		$product_settings          = (array) get_post_meta( $product->get_id(), 'woodmart_wc_video_gallery', true );
		$this->thumbnails_settings = $product_settings;

		if ( empty( $product_settings[ $attachment_id ] ) || ! $this->check_is_available_video( $product_settings[ $attachment_id ] ) ) {
			return $content;
		}

		$settings          = array_merge( $this->default_settings, $product_settings[ $attachment_id ] );
		$classes           = $this->get_wrapper_classes( $settings );
		$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
		$thumbnail_size    = apply_filters(
			'woocommerce_gallery_thumbnail_size',
			array(
				$gallery_thumbnail['width'],
				$gallery_thumbnail['height'],
			)
		);
		$full_size_image   = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail         = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
		$attributes        = array(
			'title'                   => get_post_field( 'post_title', $attachment_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
			'data-src'                => isset( $full_size_image[0] ) ? $full_size_image[0] : '',
			'data-large_image'        => isset( $full_size_image[0] ) ? $full_size_image[0] : '',
			'data-large_image_width'  => isset( $full_size_image[1] ) ? $full_size_image[1] : '',
			'data-large_image_height' => isset( $full_size_image[2] ) ? $full_size_image[2] : '',
			'class'                   => apply_filters( 'woodmart_single_product_gallery_image_class', '' ),
		);

		$settings['attachment_id'] = $attachment_id;

		ob_start();

		woodmart_enqueue_js_script( 'single-product-video-gallery' );

		?>
		<div class="product-image-wrap wd-with-video<?php echo esc_attr( $classes ); ?>">
			<?php
			woodmart_enqueue_inline_style( 'woo-single-prod-opt-gallery-video' );
			if ( woodmart_get_opt( 'photoswipe_icon' ) || 'popup' === woodmart_get_opt( 'image_action' ) ) {
				woodmart_enqueue_inline_style( 'woo-single-prod-opt-gallery-video-pswp' );
			}

			$this->get_video_buttons( $settings );
			?>

			<figure data-thumb="<?php echo esc_url( isset( $thumbnail[0] ) ? $thumbnail[0] : '' ); ?>" class="woocommerce-product-gallery__image">
				<a data-elementor-open-lightbox="no" href="<?php echo esc_url( isset( $full_size_image[0] ) ? $full_size_image[0] : '' ); ?>">
					<?php
					if ( $attachment_id === $product->get_image_id() ) {
						echo get_the_post_thumbnail( $product->get_id(), 'woocommerce_single', $attributes );
					} else {
						echo wp_get_attachment_image( $attachment_id, 'woocommerce_single', false, $attributes );
					}
					?>
				</a>
				<?php $this->get_video_content( $settings ); ?>
			</figure>
		</div>
		<?php

		return ob_get_clean();
	}

	/**
	 * Output video content.
	 *
	 * @param array $settings Video settings.
	 * @return void
	 */
	public function get_video_content( $settings ) {
		$classes    = '';
		$attributes = array();

		if ( 'mp4' === $settings['video_type'] ) {
			$attributes = array( 'loop', 'type="video/mp4"', 'playsinline' );

			if ( $settings['autoplay'] ) {
				$attributes[] = 'autoplay';
				$attributes[] = 'muted';
			}

			if ( $settings['autoplay'] || 'native' === $settings['video_control'] && $settings['hide_gallery_img'] ) {
				$attributes[] = 'src="' . $settings['upload_video_url'] . '"';
			} else {
				$attributes[] = 'data-lazy-load="' . $settings['upload_video_url'] . '"';
			}

			if ( 'native' === $settings['video_control'] ) {
				$attributes[] = 'controls';

				if ( $settings['hide_gallery_img'] ) {
					$image_src = wp_get_attachment_image_src( $settings['attachment_id'], 'woocommerce_single' );

					if ( $image_src ) {
						$attributes[] = 'poster="' . reset( $image_src ) . '"';
						$attributes[] = 'preload="none"';
					}
				}
			}

			?>
			<div class="wd-product-video wd-product-video-mp4 wd-fill">
				<video <?php echo wp_kses( implode( ' ', $attributes ), true ); ?>></video>
			</div>
			<?php
		} elseif ( 'youtube' === $settings['video_type'] && $settings['youtube_url'] && ( false !== stripos( $settings['youtube_url'], 'youtu.be/' ) || false !== stripos( $settings['youtube_url'], 'youtube.com/' ) ) ) {
			if ( false !== stripos( $settings['youtube_url'], 'youtube.com/shorts/' ) ) {
				$video_id = explode( 'youtube.com/shorts/', $settings['youtube_url'] );
				$classes .= ' wd-youtube-shorts';
			} elseif ( false !== stripos( $settings['youtube_url'], 'youtu.be/' ) ) {
				$video_id = explode( 'youtu.be/', $settings['youtube_url'] );
			} else {
				$video_id = explode( 'v=', $settings['youtube_url'] );
			}

			if ( empty( $video_id[1] ) ) {
				return;
			}

			$video_id = $video_id[1];

			if ( strpos( $video_id, '?' ) ) {
				$video_id = strstr( $video_id, '?', true );
			}

			if ( strpos( $video_id, '&' ) ) {
				$video_id = strstr( $video_id, '&', true );
			}

			$player_url = 'https://www.youtube.com/embed/' . $video_id;
			$attrs      = 'rel=0&showinfo=0&enablejsapi=1&loop=1&modestbranding=1&autohide=0&playsinline=1';
			$classes   .= ' wd-product-video-youtube';

			if ( 'theme' === $settings['video_control'] ) {
				$attrs .= '&playlist=' . $video_id;
				$attrs .= '&controls=0&iv_load_policy=3';
			} else {
				$attrs .= '&controls=1';
			}

			$attrs .= '&origin=' . get_site_url();

			if ( $settings['autoplay'] ) {
				$attrs .= '&autoplay=1&mute=1';
			}

			if ( $settings['autoplay'] || 'native' === $settings['video_control'] && $settings['hide_gallery_img'] ) {
				$attributes[] = 'src="' . $player_url . '?' . $attrs . '"';
			} else {
				$attributes[] = 'data-lazy-load="' . $player_url . '?' . $attrs . '"';
			}

			$attributes[] = 'loading="lazy"';

			wp_enqueue_script( 'wd-youtube', 'https://www.youtube.com/iframe_api', array(), WOODMART_VERSION ); //phpcs:ignore

			$this->get_iframe_template( $classes, $attributes );
		} elseif ( 'vimeo' === $settings['video_type'] && $settings['vimeo_url'] && false !== stripos( $settings['vimeo_url'], 'vimeo.com/' ) ) {
			$video_id = explode( 'vimeo.com/', $settings['vimeo_url'] );

			if ( empty( $video_id[1] ) ) {
				return;
			}

			$player_url = 'https://player.vimeo.com/video/' . $video_id[1];
			$attrs      = 'loop=1&transparent=0';
			$classes   .= ' wd-product-video-vimeo';

			if ( 'theme' === $settings['video_control'] ) {
				$attrs .= '&background=1';
			}

			if ( $settings['autoplay'] ) {
				$attrs .= '&autoplay=1&muted=1';
			}

			if ( $settings['autoplay'] || 'native' === $settings['video_control'] && $settings['hide_gallery_img'] ) {
				$attributes[] = 'src="' . $player_url . '?' . $attrs . '"';
			} else {
				$attributes[] = 'data-lazy-load="' . $player_url . '?' . $attrs . '"';
			}

			if ( 'theme' === $settings['video_control'] && $settings['autoplay'] ) {
				woodmart_enqueue_js_library( 'vimeo_player' );
			}

			$attributes[] = 'loading="lazy"';

			$this->get_iframe_template( $classes, $attributes );
		}
	}

	/**
	 * Get iframe template.
	 *
	 * @param string $classes Wrapper classes.
	 * @param array  $attributes HTML attribute.
	 * @return void
	 */
	private function get_iframe_template( $classes, $attributes ) {
		?>
		<div class="wd-product-video wd-fill wd-product-video-iframe<?php echo esc_attr( $classes ); ?>">
			<iframe <?php echo wp_kses( implode( ' ', $attributes ), true ); ?> allow="accelerometer; autoplay; clipboard-write; gyroscope; encrypted-media; picture-in-picture;" webkitallowfullscreen mozallowfullscreen allowfullscreen playsinline frameborder="0" width="100%" height="100%"></iframe>
		</div>
		<?php
	}

	/**
	 * Get video controls content.
	 *
	 * @param array $settings Video controls settings.
	 * @return void
	 */
	public function get_video_buttons( $settings ) {
		if ( 'native' === $settings['video_control'] && $settings['hide_gallery_img'] ) {
			return;
		}

		?>
		<div class="wd-video-actions">
			<div class="wd-play-video wd-action-btn wd-style-icon-bg-text wd-play-icon">
				<a href="#"></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Get thumbnails wrapper classes.
	 *
	 * @param array $settings Settings video.
	 * @return string
	 */
	private function get_wrapper_classes( $settings ) {
		$classes = '';

		if ( $settings['autoplay'] ) {
			$classes .= ' wd-video-playing';
		}

		if ( $settings['autoplay'] || 'mute' === $settings['audio_status'] ) {
			$classes .= ' wd-video-muted';
		}

		if ( $settings['video_size'] && 'theme' === $settings['video_control'] ) {
			$classes .= ' wd-video-' . $settings['video_size'];
		}

		if ( $settings['video_control'] ) {
			$classes .= ' wd-video-design-' . $settings['video_control'];
		}

		if ( 'native' === $settings['video_control'] && $settings['hide_gallery_img'] ) {
			$classes .= ' wd-video-hide-thumb';
		}

		if ( $settings['hide_information'] ) {
			$classes .= ' wd-overlay-hidden';
		}

		return $classes;
	}

	/**
	 * Added custom classes for thumbnails image.
	 *
	 * @param string  $classes Classes.
	 * @param integer $attachment_id Image ID.
	 * @return string
	 */
	public function product_thumbnails_classes( $classes, $attachment_id ) {
		global $product;

		$attachment_id = apply_filters( 'woodmart_single_product_image_thumbnail_id', $attachment_id, $product );

		if ( woodmart_get_opt( 'single_product_main_gallery_video', true ) && ! empty( $this->thumbnails_settings[ $attachment_id ] ) && $this->check_is_available_video( $this->thumbnails_settings[ $attachment_id ] ) ) {
			return $classes . ' wd-with-video';
		}

		return $classes;
	}

	/**
	 * Check is available video for gallery thumbnail.
	 *
	 * @param array $settings Settings video.
	 * @return bool
	 */
	private function check_is_available_video( $settings ) {
		if ( empty( $settings['video_type'] ) ) {
			return false;
		}

		if ( 'mp4' === $settings['video_type'] && ! empty( $settings['upload_video_id'] ) && wp_attachment_is( 'video', $settings['upload_video_id'] ) ) {
			return true;
		} elseif ( 'youtube' === $settings['video_type'] && ( false !== stripos( $settings['youtube_url'], 'youtu.be/' ) || false !== stripos( $settings['youtube_url'], 'youtube.com/' ) ) ) {
			return true;
		} elseif ( 'vimeo' === $settings['video_type'] && false !== stripos( $settings['vimeo_url'], 'vimeo.com/' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get video content for image gallery.
	 *
	 * @param array   $image_settings Image settings.
	 * @param integer $attachment_id Image ID.
	 * @return array
	 */
	public function get_single_image_data( $image_settings, $attachment_id ) {
		global $product, $post;

		if ( empty( $product ) || empty( $post ) || ! woodmart_get_opt( 'single_product_main_gallery_video', true ) ) {
			return $image_settings;
		}

		if ( ! is_object( $product ) ) {
			$product = wc_get_product( $post->ID );

			if ( ! is_object( $product ) ) {
				return $image_settings;
			}
		}

		$product_settings = (array) get_post_meta( $product->get_id(), 'woodmart_wc_video_gallery', true );

		if ( empty( $product_settings[ $attachment_id ] ) || ! $this->check_is_available_video( $product_settings[ $attachment_id ] ) ) {
			return $image_settings;
		}

		$video_settings                  = array_merge( $this->default_settings, $product_settings[ $attachment_id ] );
		$video_settings['attachment_id'] = $attachment_id;

		ob_start();

		$this->get_video_content( $video_settings );

		$video_content = ob_get_clean();

		ob_start();

		$this->get_video_buttons( $video_settings );

		$video_controls = ob_get_clean();

		$image_settings['video'] = array(
			'content'  => $video_content,
			'controls' => $video_controls,
			'classes'  => ' wd-with-video' . $this->get_wrapper_classes( $video_settings ),
		);

		return $image_settings;
	}

	/**
	 * Add settings in admin localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function admin_localized_settings( $settings ) {
		$settings['product_gallery_video_text'] = esc_html__( 'Video', 'woodmart' );

		return $settings;
	}

	/**
	 * Add settings in localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function localized_settings( $settings ) {
		$settings['vimeo_library_url'] = WOODMART_THEME_DIR . '/js/libs/vimeo-player.min.js';

		return $settings;
	}
}

Main::get_instance();
