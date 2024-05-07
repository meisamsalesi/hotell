<?php

namespace XTS\Modules\Linked_Variations;

use XTS\Singleton;

class Main extends Singleton {
	/**
	 * Construct.
	 */
	public function init() {
		$this->include_files();
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		$files = [
			'class-admin',
			'class-frontend',
		];

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/linked-variations/' . $file . '.php' );
		}
	}
}

Main::get_instance();
