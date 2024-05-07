<?php
/**
 * Banner template function.
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_elementor_banner_template' ) ) {
	function woodmart_elementor_banner_carousel_template( $settings ) {
		$default_settings = array(
			'content_repeater'        => array(),

			// Carousel.
			'speed'                   => '5000',
			'slides_per_view'         => array( 'size' => 4 ),
			'slides_per_view_tablet'  => array( 'size' => '' ),
			'slides_per_view_mobile'  => array( 'size' => '' ),
			'slider_spacing'          => 30,
			'wrap'                    => '',
			'autoplay'                => 'no',
			'center_mode'             => 'no',
			'hide_pagination_control' => '',
			'hide_prev_next_buttons'  => '',
			'scroll_per_page'         => 'yes',
			'scroll_carousel_init'    => 'no',
			'custom_sizes'            => apply_filters( 'woodmart_promo_banner_shortcode_custom_sizes', false ),
		);

		$settings         = wp_parse_args( $settings, $default_settings );
		$carousel_classes = '';
		$wrapper_classes  = '';

		$settings['slides_per_view'] = $settings['slides_per_view']['size'];

		if ( ! empty( $settings['slides_per_view_tablet']['size'] ) || ! empty( $settings['slides_per_view_mobile']['size'] ) ) {
			$settings['custom_sizes'] = array(
				'desktop'          => $settings['slides_per_view'],
				'tablet_landscape' => $settings['slides_per_view_tablet']['size'],
				'tablet'           => $settings['slides_per_view_tablet']['size'],
				'mobile'           => $settings['slides_per_view_mobile']['size'],
			);
		}

		$carousel_classes .= ' ' . woodmart_owl_items_per_slide(
			$settings['slides_per_view'],
			array(),
			false,
			false,
			$settings['custom_sizes']
		);

		if ( 'yes' === $settings['scroll_carousel_init'] ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$wrapper_classes .= ' scroll-init';
		}

		if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
			$wrapper_classes .= ' disable-owl-mobile';
		}

		$wrapper_classes .= ' wd-carousel-spacing-' . $settings['slider_spacing'];

		woodmart_enqueue_inline_style( 'owl-carousel' );

		?>
		<div class="wd-carousel-container banners-carousel-wrapper<?php echo esc_attr( $wrapper_classes ); ?>" <?php echo woodmart_get_owl_attributes( $settings ); ?>>
			<div class="owl-carousel wd-owl banners-carousel<?php echo esc_attr( $carousel_classes ); ?>">
				<?php foreach ( $settings['content_repeater'] as $index => $banner ) : ?>
					<?php
					$banner                    = $banner + $settings;
					$banner['wrapper_classes'] = ' elementor-repeater-item-' . $banner['_id'];
					?>
					<?php woodmart_elementor_banner_template( $banner ); ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_elementor_banner_template' ) ) {
	function woodmart_elementor_banner_template( $settings ) {
		$default_settings = array(
			'image'                    => '',
			'image_height'             => array( 'size' => 0 ),
			'link'                     => '',
			'text_alignment'           => 'left',
			'vertical_alignment'       => 'top',
			'horizontal_alignment'     => 'left',
			'style'                    => '',
			'hover'                    => 'zoom',
			'increase_spaces'          => '',
			'woodmart_color_scheme'    => 'light',

			// Countdown.
			'show_countdown'           => 'no',
			'countdown_color_scheme'   => 'dark',
			'countdown_size'           => 'medium',
			'countdown_style'          => 'standard',
			'hide_countdown_on_finish' => 'no',

			// Button
			'btn_text'                 => '',
			'btn_position'             => 'hover',
			'btn_color'                => 'default',
			'btn_style'                => 'default',
			'btn_shape'                => 'rectangle',
			'btn_size'                 => 'default',
			'hide_btn_tablet'          => 'no',
			'hide_btn_mobile'          => 'no',
			'title_decoration_style'   => 'default',

			// Title
			'custom_title_color'       => '',
			'title'                    => '',
			'title_tag'                => 'h4',
			'title_size'               => 'default',

			// Subtitle
			'subtitle'                 => '',
			'subtitle_color'           => 'default',
			'custom_subtitle_color'    => '',
			'custom_subtitle_bg_color' => '',
			'subtitle_style'           => 'default',

			// Text
			'custom_text_color'        => '',
			'content_text_size'        => 'default',

			// Extra.
			'wrapper_classes'          => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		if ( 'parallax' === $settings['hover'] ) {
			woodmart_enqueue_js_library( 'panr-parallax-bundle' );
			woodmart_enqueue_js_script( 'banner-element' );
		}

		// Classes.
		$banner_classes            = '';
		$subtitle_classes          = '';
		$title_classes             = '';
		$content_classes           = '';
		$inner_classes             = '';
		$countdown_wrapper_classes = '';
		$countdown_timer_classes   = '';
		$btn_wrapper_classes       = '';
		$image_url                 = '';
		$wrapper_content_classes   = '';

		$timezone = 'GMT';

		// Banner classes.
		$banner_classes .= ' banner-' . $settings['style'];
		$banner_classes .= ' banner-hover-' . $settings['hover'];
		$banner_classes .= ' color-scheme-' . $settings['woodmart_color_scheme'];
		$banner_classes .= ' banner-btn-size-' . $settings['btn_size'];
		$banner_classes .= ' banner-btn-style-' . $settings['btn_style'];
		if ( 'yes' === $settings['increase_spaces'] ) {
			$banner_classes .= ' banner-increased-padding';
		}
		if ( 'content-background' === $settings['style'] ) {
			$settings['btn_position'] = 'static';
		}
		if ( $settings['btn_text'] ) {
			$banner_classes .= ' with-btn';
			$banner_classes .= ' banner-btn-position-' . $settings['btn_position'];
		}

		// Subtitle classes.
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$subtitle_classes .= ' elementor-inline-editing';
		}
		$subtitle_classes .= ' subtitle-style-' . $settings['subtitle_style'];
		if ( ! $settings['custom_subtitle_color'] && ! $settings['custom_subtitle_bg_color'] ) {
			$subtitle_classes .= ' subtitle-color-' . $settings['subtitle_color'];
		}
		$subtitle_classes .= ' ' . woodmart_get_new_size_classes( 'banner', $settings['title_size'], 'subtitle' );

		// Content classes.
		$content_classes .= ' text-' . $settings['text_alignment'];

		// Wrapper content classes.
		$wrapper_content_classes .= ' wd-items-' . $settings['vertical_alignment'];
		$wrapper_content_classes .= ' wd-justify-' . $settings['horizontal_alignment'];
		$banner_classes          .= woodmart_get_old_classes( ' banner-vr-align-' . $settings['vertical_alignment'] );
		$banner_classes          .= woodmart_get_old_classes( ' banner-hr-align-' . $settings['horizontal_alignment'] );

		// Title classes.
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$title_classes .= ' elementor-inline-editing';
		}
		if ( 'default' !== $settings['title_decoration_style'] ) {
			$title_classes .= ' wd-underline-' . $settings['title_decoration_style'];
			woodmart_enqueue_inline_style( 'mod-highlighted-text' );
		}

		$title_classes         .= ' ' . woodmart_get_new_size_classes( 'banner', $settings['title_size'], 'title' );

		// Content classes.
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$inner_classes .= ' elementor-inline-editing';
		}
		$inner_classes .= ' ' . woodmart_get_new_size_classes( 'banner', $settings['content_text_size'], 'content' );

		// Countdown classes.
		if ( 'yes' === $settings['show_countdown'] ) {
			$timezone = apply_filters( 'woodmart_wp_timezone_element', false ) ? get_option( 'timezone_string' ) : 'GMT';

			$countdown_wrapper_classes .= ' wd-countdown-timer';
			$countdown_wrapper_classes .= ! empty( $settings['countdown_color_scheme'] ) ? ' color-scheme-' . $settings['countdown_color_scheme'] : '';
			$countdown_wrapper_classes .= ' timer-size-' . $settings['countdown_size'];
			$countdown_wrapper_classes .= ' timer-style-' . $settings['countdown_style'];

			$countdown_timer_classes .= 'wd-timer';

			woodmart_enqueue_js_library( 'countdown-bundle' );
			woodmart_enqueue_js_script( 'countdown-element' );
			woodmart_enqueue_inline_style( 'countdown' );
		}

		// Button classes.
		if ( 'yes' === $settings['hide_btn_tablet'] ) {
			$btn_wrapper_classes .= ' wd-hide-md-sm';
		}
		if ( 'yes' === $settings['hide_btn_mobile'] ) {
			$btn_wrapper_classes .= ' wd-hide-sm';
		}

		// Link settings.
		if ( $settings['link'] && $settings['link']['url'] ) {
			$banner_classes .= ' cursor-pointer';
		}
		if ( isset( $settings['link']['is_external'] ) && 'on' === $settings['link']['is_external'] ) {
			$onclick = 'window.open(\'' . esc_url( $settings['link']['url'] ) . '\',\'_blank\')';
		} else {
			$onclick = 'window.location.href=\'' . esc_url( $settings['link']['url'] ) . '\'';
		}

		// Image settings.
		if ( $settings['image']['id'] ) {
			$image_url = woodmart_get_image_url( $settings['image']['id'], 'image', $settings );
		} elseif ( $settings['image']['url'] ) {
			$image_url = $settings['image']['url'];
		}

		woodmart_enqueue_inline_style( 'banner' );

		if ( in_array( $settings['style'], array( 'mask', 'shadow' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-style-mask-and-shadow' );
		} elseif ( in_array( $settings['style'], array( 'border', 'background' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-style-bg-and-border' );
		} elseif ( 'content-background' === $settings['style'] ) {
			woodmart_enqueue_inline_style( 'banner-style-bg-cont' );
		}

		if ( in_array( $settings['hover'], array( 'background', 'border' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-hover-bg-and-border' );
		} elseif ( in_array( $settings['hover'], array( 'zoom', 'zoom-reverse' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-hover-zoom' );
		}

		if ( 'hover' === $settings['btn_position'] ) {
			woodmart_enqueue_inline_style( 'banner-btn-hover' );
		}

		$banner_image_classes = '';

		if ( ! isset( $settings['image_height']['size'] ) || ( isset( $settings['image_height']['size'] ) && 0 === $settings['image_height']['size'] ) ) {
			$banner_image_classes = ' wd-without-height';
		}
		?>
		<div class="promo-banner-wrapper<?php echo esc_attr( $settings['wrapper_classes'] ); ?>">
			<div class="promo-banner<?php echo esc_attr( $banner_classes ); ?>" <?php echo $settings['link']['url'] && ! woodmart_elementor_is_edit_mode() ? 'onclick="' . $onclick . '"' : ''; ?>>
				<div class="main-wrapp-img">
					<div class="banner-image<?php echo esc_attr( $banner_image_classes ); ?>">
						<?php if ( 'parallax' !== $settings['hover'] ) : ?>
							<?php echo woodmart_get_image_html( $settings, 'image' ); ?>
						<?php else : ?>
							<?php echo apply_filters( 'woodmart_image', '<img src="' . esc_url( $image_url ) . '" class="promo-banner-image" alt="promo-banner-image">' ); ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="wrapper-content-banner wd-fill<?php echo esc_attr( $wrapper_content_classes ); ?>">
					<div class="content-banner <?php echo esc_attr( $content_classes ); ?>">
						<?php if ( $settings['subtitle'] ) : ?>
							<div class="banner-subtitle<?php echo esc_attr( $subtitle_classes ); ?>" data-elementor-setting-key="subtitle">
								<?php echo nl2br( $settings['subtitle'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $settings['title'] ) : ?>
							<<?php echo esc_attr( $settings['title_tag'] ); ?> class="banner-title<?php echo esc_attr( $title_classes ); ?>" data-elementor-setting-key="title">
								<?php echo nl2br( $settings['title'] ); ?>
							</<?php echo esc_attr( $settings['title_tag'] ); ?>>
						<?php endif; ?>

						<?php if ( $settings['content'] ) : ?>
							<div class="banner-inner set-cont-mb-s reset-last-child<?php echo esc_attr( $inner_classes ); ?>" data-elementor-setting-key="content">
								<?php echo do_shortcode( wpautop( $settings['content'] ) ); ?>
							</div>
						<?php endif ?>

						<?php if ( 'yes' === $settings['show_countdown'] ) : ?>
							<div class="<?php echo esc_attr( trim( $countdown_wrapper_classes ) ); ?>">
								<div class="<?php echo esc_attr( $countdown_timer_classes ); ?>" data-end-date="<?php echo esc_attr( $settings['date'] ); ?>" data-timezone="<?php echo esc_attr( $timezone ); ?>" data-hide-on-finish="<?php echo esc_attr( $settings['hide_countdown_on_finish'] ); ?>">
									<span class="countdown-days">
										0
										<span>
											<?php esc_html_e( 'days', 'woodmart' ); ?>
										</span>
									</span>
									<span class="countdown-hours">
										00
										<span>
											<?php esc_html_e( 'hr', 'woodmart' ); ?>
										</span>
									</span>
									<span class="countdown-min">
										00
										<span>
											<?php esc_html_e( 'min', 'woodmart' ); ?>
										</span>
									</span>
									<span class="countdown-sec">
										00
										<span>
											<?php esc_html_e( 'sc', 'woodmart' ); ?>
										</span>
									</span>
								</div>
							</div>
						<?php endif ?>

						<?php if ( $settings['btn_text'] ) : ?>
							<div class="banner-btn-wrapper<?php echo esc_attr( $btn_wrapper_classes ); ?>">
								<?php
								unset( $settings['inline_editing_key'] );
								unset( $settings['link'] );
								woodmart_elementor_button_template(
									array(
										'title'       => $settings['btn_text'],
										'color'       => $settings['btn_color'],
										'style'       => $settings['btn_style'],
										'size'        => $settings['btn_size'],
										'align'       => $settings['text_alignment'],
										'shape'       => $settings['btn_shape'],
										'text'        => $settings['btn_text'],
										'inline_edit' => false,
									) + $settings
								);
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
