<?php
/**
 * The template for displaying slide.
 *
 * @package xts
 */

get_header();

global $post;

$slider_term      = wp_get_post_terms( $post->ID, 'woodmart_slider' );
$slider_id        = $slider_term ? $slider_term[0]->term_id : '';
$carousel_id      = 'slider-' . $slider_id;
$animation        = get_term_meta( $slider_id, 'animation', true );
$arrows_style     = get_term_meta( $slider_id, 'arrows_style', true );
$pagination_style = get_term_meta( $slider_id, 'pagination_style', true );

woodmart_enqueue_inline_style( 'slider' );
woodmart_enqueue_inline_style( 'animations' );
woodmart_enqueue_js_script( 'animations' );
woodmart_enqueue_js_library( 'waypoints' );

if ( 'distortion' === $animation ) {
	woodmart_enqueue_inline_style( 'slider-anim-distortion' );
}

if ( '' === $pagination_style ) {
	$pagination_style = 1;
}

if ( '' === $arrows_style ) {
	$arrows_style = 1;
}

if ( $arrows_style ) {
	woodmart_enqueue_inline_style( 'slider-arrows' );
}

if ( $pagination_style ) {
	woodmart_enqueue_inline_style( 'slider-dots' );
	woodmart_enqueue_inline_style( 'slider-dots-style-' . $pagination_style );
}

?>
<div class="container">
	<div class="row">
		<div class="site-content col-lg-12 col-12 col-md-12">
			<?php woodmart_get_slider_css( $slider_id, $carousel_id, array( $post ) ); ?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="wd-slider-wrapper<?php echo woodmart_get_slider_class( $slider_id ); ?>">
				<div class="wd-slider<?php echo woodmart_get_old_classes( ' woodmart-slider' ); ?>">
					<?php
					$slide_id        = 'slide-' . $post->ID;
					$slide_animation = get_post_meta( $post->ID, 'slide_animation', true );
					?>

					<div id="<?php echo esc_attr( $slide_id ); ?>" class="wd-slide woodmart-loaded active<?php echo woodmart_get_old_classes( ' woodmart-slide' ); ?>">
						<div class="container wd-slide-container<?php echo woodmart_get_old_classes( ' woodmart-slide-container' ); ?><?php echo woodmart_get_slide_class( $post->ID ); ?>">
							<div class="wd-slide-inner<?php echo woodmart_get_old_classes( ' woodmart-slide-inner' ); ?> <?php echo ( ! empty( $slide_animation ) && $slide_animation != 'none' ) ? 'wd-animation-normal  wd-animation-' . esc_attr( $slide_animation ) : ''; ?>">
								<?php while ( have_posts() ) : ?>
									<?php the_post(); ?>
									<?php the_content(); ?>
								<?php endwhile; ?>
							</div>
						</div>

						<div class="wd-slide-bg wd-fill"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
