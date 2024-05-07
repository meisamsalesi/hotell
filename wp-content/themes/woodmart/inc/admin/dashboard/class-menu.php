<?php

namespace XTS\Inc\Admin\Dashboard;

class Menu {
	/**
	 * Constructor.
	 */
	public function __construct( $config ) {
		$this->get_menu( $config );
	}

	protected function get_menu( $config, $child_menu = false ) {
		$classes = '';

		if ( $child_menu ) {
			$classes = wd_add_cssclass( 'xts-dropdown xts-sub-menu', $classes );
		} else {
			$classes = wd_add_cssclass( 'xts-nav', $classes );
		}

		?>
		<ul class="<?php echo esc_attr( $classes ); ?>">
			<?php foreach ( $config['items'] as $item_data ) : ?>
				<?php $this->get_menu_item( $item_data ); ?>
			<?php endforeach; ?>
		</ul>
		<?php
	}

	protected function get_menu_item( $item_data ) {
		$classes      = 'xts-nav-item';
		$link_classes = 'xts-nav-link';

		if ( isset( $item_data['condition'] ) && ! $item_data['condition'] ) {
			return;
		}

		if ( ! empty( $item_data['icon'] ) ) {
			$link_classes = wd_add_cssclass( 'xts-i-' . $item_data['icon'], $link_classes );
		}

		if ( ! empty( $item_data['class'] ) ) {
			$classes = wd_add_cssclass( $item_data['class'], $classes );
		}

		if ( isset( $item_data['child_menu'] ) ) {
			$classes = wd_add_cssclass( 'xts-has-child', $classes );

			foreach ( $item_data['child_menu']['items'] as $child_item_data ) {
				$classes .= $this->get_active_classes( $child_item_data, 'xts-active' );
			}
		}

		$classes .= $this->get_active_classes( $item_data, 'xts-active' );

		$link_target = ! empty( $item_data['link']['new_window'] ) ? '_blank' : '_self';

		?>
		<li class="<?php echo esc_attr( $classes ); ?>">
			<a class="<?php echo esc_attr( $link_classes ); ?>" href="<?php echo esc_url( $item_data['link']['url'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
				<span>
					<?php echo esc_html( $item_data['text'] ); ?>
				</span>
			</a>

			<?php if ( isset( $item_data['child_menu'] ) ) : ?>
				<?php $this->get_menu( $item_data['child_menu'], true ); ?>
			<?php endif; ?>
		</li>
		<?php
	}

	protected function get_active_classes( $item_data, $active_class ) {
		$classes = '';

		if ( ! empty( $item_data['type'] ) && 'page' === $item_data['type'] && isset( $_GET['page'] ) && $item_data['slug'] === $_GET['page'] ) { // phpcs:ignore
			$classes = ' ' . add_cssclass( $active_class, $classes );
		} else if ( ! empty( $item_data['type'] ) && 'tab' === $item_data['type'] && ( isset( $_GET['tab'] ) && $item_data['slug'] === $_GET['tab'] ) || ( ! empty( $item_data['parentPage'] ) && $item_data['parentPage'] === $_GET['page'] && empty( $_GET['tab'] ) )  ) { // phpcs:ignore
			$classes = ' ' . add_cssclass( $active_class, $classes );
		} elseif ( ! empty( $item_data['type'] ) && 'post_type' === $item_data['type'] && isset( $_GET['post_type'] ) && $item_data['slug'] === $_GET['post_type'] && ! isset( $_GET['taxonomy'] ) ) { // phpcs:ignore
			$classes = ' ' . add_cssclass( $active_class, $classes );
		} elseif ( ! empty( $item_data['type'] ) && 'post_type_taxonomy' === $item_data['type'] && isset( $_GET['post_type'] ) && $item_data['slug'] === $_GET['post_type'] && isset( $_GET['taxonomy'] ) ) { // phpcs:ignore
			$classes = ' ' . add_cssclass( $active_class, $classes );
		}

		return $classes;
	}
}