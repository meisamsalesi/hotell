<?php

$classes         = array();
$woodmart_loop   = woodmart_loop_prop( 'woodmart_loop' );
$blog_design     = woodmart_loop_prop( 'blog_design' );
$desktop_columns = woodmart_loop_prop( 'blog_columns' );
$tablet_columns  = woodmart_loop_prop( 'blog_columns_tablet' );
$mobile_columns  = woodmart_loop_prop( 'blog_columns_mobile' );
$blog_style      = woodmart_get_opt( 'blog_style', 'shadow' );
$classes[]       = 'blog-design-' . $blog_design;
$classes[]       = 'blog-post-loop';

if ( 'shadow' === $blog_style ) {
	$classes[] = 'blog-style-bg';

	if ( woodmart_get_opt( 'blog_with_shadow', true ) ) {
		$classes[] = 'wd-add-shadow';
	}
} else {
	$classes[] = 'blog-style-' . $blog_style;
}

if ( 'grid' === woodmart_loop_prop( 'blog_layout' ) ) {
	if ( ( 'auto' !== $tablet_columns && ! empty( $tablet_columns ) ) || ( 'auto' !== $mobile_columns && ! empty( $mobile_columns ) ) ) {
		$classes[] = woodmart_get_grid_el_class_new( $woodmart_loop, false, $desktop_columns, $tablet_columns, $mobile_columns );
	} else {
		$classes[] = woodmart_get_grid_el_class( $woodmart_loop, $desktop_columns, false, 12 );
	}
}

if ( ! get_the_title() ) {
	$classes[] = 'post-no-title';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<?php if ( 'shadow' === $blog_style ) : ?>
		<div class="wd-post-inner">
	<?php endif; ?>

	<div class="wd-post-thumb<?php echo has_post_thumbnail() ? ' color-scheme-light' : ''; ?>">
		<div class="wd-post-img">
			<?php echo woodmart_get_post_thumbnail( 'large' ); // phpcs:ignore ?>
		</div>

		<?php /* translators: %s: Post title */ ?>
		<a class="wd-post-link wd-fill" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" aria-label="<?php echo esc_attr( sprintf( __( 'Link on post %s', 'woodmart' ), esc_attr( get_the_title() ) ) ); ?>"></a>

		<div class="wd-post-header">
			<?php if ( woodmart_loop_prop( 'parts_meta' ) ) : ?>
				<div class="wd-meta-author">
					<?php woodmart_post_meta_author( true, false ); ?>
				</div>
			<?php endif ?>

			<div class="wd-post-actions">
				<?php if ( woodmart_is_social_link_enable( 'share' ) ) : ?>
					<div class="wd-post-share wd-tltp <?php echo is_rtl() ? 'wd-tltp-right' : 'wd-tltp-left'; ?>">
						<div class="wd-tooltip-label">
							<?php
							if ( function_exists( 'woodmart_shortcode_social' ) ) {
								echo woodmart_shortcode_social( // phpcs:ignore
									array(
										'size'  => 'small',
										'color' => 'light',
									)
								);}
							?>
						</div>
					</div>
				<?php endif ?>

				<?php if ( comments_open() ) : ?>
					<div class="wd-meta-reply">
						<?php woodmart_post_meta_reply(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="wd-post-content">
		<div class="wd-post-entry-meta">
			<?php if ( is_sticky() ) : ?>
				<div class="wd-featured-post">
					<?php esc_html_e( 'Featured', 'woodmart' ); ?>
				</div>
			<?php endif; ?>
			<?php if ( woodmart_loop_prop( 'parts_meta' ) && get_the_category_list( ', ' ) ) : ?>
				<div class="wd-post-cat wd-style-default">
					<?php echo get_the_category_list( ', ' ); // phpcs:ignore ?>
				</div>
			<?php endif ?>

			<div class="wd-modified-date">
				<?php woodmart_post_modified_date(); ?>
			</div>

			<div class="wd-meta-date">
				<?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
			</div>
		</div>

		<?php if ( woodmart_loop_prop( 'parts_title' ) ) : ?>
			<h3 class="wd-entities-title title post-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_title(); ?>
				</a>
			</h3>
		<?php endif ?>

		<div class="wd-entry-content">
			<?php if ( is_search() && woodmart_loop_prop( 'parts_text' ) ) : ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php elseif ( woodmart_loop_prop( 'parts_text' ) ) : ?>
				<?php woodmart_get_content( false ); ?>
				<?php
				wp_link_pages(
					array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'woodmart' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					)
				);
				?>
			<?php endif; ?>
		</div>

		<?php if ( woodmart_loop_prop( 'parts_btn' ) ) : ?>
			<div class="wd-read-more">
				<?php echo woodmart_read_more_tag(); // phpcs:ignore ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( 'shadow' === $blog_style ) : ?>
		</div>
	<?php endif; ?>
</article>
