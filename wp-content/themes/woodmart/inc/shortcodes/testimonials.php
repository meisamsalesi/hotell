<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}




if ( ! function_exists( 'woodmart_shortcode_testimonials' ) ) {
	function woodmart_shortcode_testimonials( $atts = array(), $content = null ) {
		global $woodmart_testimonials_style;

		$class           = '';
		$wrapper_classes = '';
		$owl_atts        = '';

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_owl_atts(),
				array(
					'layout'                 => 'slider',
					'style'                  => 'standard',
					'woodmart_color_scheme'  => '',
					'align'                  => 'center',
					'text_size'              => '',
					'slides_per_view'        => 3,
					'slides_per_view_tablet' => 'auto',
					'slides_per_view_mobile' => 'auto',
					'columns'                => 3,
					'columns_tablet'         => 'auto',
					'columns_mobile'         => 'auto',
					'spacing'                => 30,
					'name'                   => '',
					'title'                  => '',
					'stars_rating'           => 'yes',
					'el_class'               => '',
					'woodmart_css_id'        => '',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		ob_start();

		if ( ! $woodmart_css_id ) {
			$woodmart_css_id = uniqid();
		}
		$id = 'wd-' . $woodmart_css_id;

		$wrapper_classes .= ' testimonials-' . $layout;
		$wrapper_classes .= ' testimon-style-' . $style;
		$wrapper_classes .= ' color-scheme-' . $woodmart_color_scheme;

		$wrapper_classes .= ' ' . woodmart_get_new_size_classes( 'testimonials', $text_size, 'text' );

		if ( 'info-top' !== $style ) {
			$wrapper_classes .= ' testimon-align-' . $align;
		}

		if ( 'yes' === $stars_rating ) {
			woodmart_enqueue_inline_style( 'mod-star-rating' );

			$wrapper_classes .= ' testimon-with-rating';
		}

		$wrapper_classes .= ' ' . $el_class;

		if ( 'slider' === $layout ) {
			woodmart_enqueue_inline_style( 'owl-carousel' );
			$custom_sizes = apply_filters( 'woodmart_testimonials_shortcode_custom_sizes', false );

			$parsed_atts['carousel_id']  = $id;
			$parsed_atts['custom_sizes'] = $custom_sizes;

			if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
				$parsed_atts['custom_sizes'] = array(
					'desktop'          => $slides_per_view,
					'tablet_landscape' => $slides_per_view_tablet,
					'tablet'           => $slides_per_view_mobile,
					'mobile'           => $slides_per_view_mobile,
				);
			}

			$owl_atts = woodmart_get_owl_attributes( $parsed_atts );
			$class   .= ' owl-carousel wd-owl ' . woodmart_owl_items_per_slide( $slides_per_view, array(), false, false, $parsed_atts['custom_sizes'] );

			$wrapper_classes .= ' wd-carousel-container';
			$wrapper_classes .= ' wd-carousel-spacing-' . $spacing;

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$wrapper_classes .= ' disable-owl-mobile';
			}
		} else {
			$items_classes = woodmart_get_grid_el_class_new( 0, false, $columns, $columns_tablet, $columns_mobile );

			$content = str_replace( '[testimonial', '[testimonial class_grid="' . $items_classes . '"', $content );

			$class .= ' row';
			$class .= ' wd-spacing-' . $spacing;
		}

		$woodmart_testimonials_style = $style;
		?>
			<?php if ( $title ) : ?>
				<h2 class="title slider-title"><span><?php echo esc_html( $title ); ?></span></h2>
			<?php endif ?>

			<div id="<?php echo esc_attr( $id ); ?>" class="testimonials testimonials-wrapper<?php echo esc_attr( $wrapper_classes ); ?>" <?php echo 'slider' === $layout ? $owl_atts : ''; ?>>
				<div class="<?php echo esc_attr( $class ); ?>" >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		$woodmart_testimonials_style = '';

		return $output;
	}
}

if ( ! function_exists( 'woodmart_shortcode_testimonial' ) ) {
	function woodmart_shortcode_testimonial( $atts, $content ) {
		if ( ! function_exists( 'wpb_getImageBySize' ) ) {
			return;
		}

		global $woodmart_testimonials_style;

		$class = '';

		extract(
			shortcode_atts(
				array(
					'image'      => '',
					'img_size'   => '100x100',
					'name'       => '',
					'title'      => '',
					'el_class'   => '',
					'class_grid' => '',
				),
				$atts
			)
		);

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$class .= ' ' . $el_class;

		if ( isset( $class_grid ) && $class_grid ) {
			$class .= $class_grid;
		}

		ob_start();

		if ( 'info-top' === $woodmart_testimonials_style ) {
			woodmart_enqueue_inline_style( 'testimonial' );
		} else {
			woodmart_enqueue_inline_style( 'testimonial-old' );
		}

		$image_output = '';

		if ( $img_id ) {
			$image_output = wpb_getImageBySize(
				array(
					'attach_id'  => $img_id,
					'thumb_size' => $img_size,
					'class'      => 'testimonial-avatar-image',
				)
			)['thumbnail'];
		}

		$template_name = 'default.php';

		if ( 'info-top' === $woodmart_testimonials_style ) {
			$template_name = 'info-top.php';
		}

		woodmart_get_element_template(
			'testimonials',
			[
				'image'        => $image_output,
				'title'        => $title,
				'name'         => $name,
				'content'      => $content,
				'item_classes' => $class,
			],
			$template_name
		);

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
