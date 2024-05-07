<?php

defined( 'ABSPATH' ) || exit;

class PW_Tools_Rank_Math {

	public function __construct() {
		add_filter( 'rank_math/replacements', [ $this, 'replacements' ], 10, 2 );
	}

	public function replacements( $replacements, $args ) {

		if ( isset( $replacements['%date(Y-m-d\TH:i:sP)%'] ) ) {
			$replacements['%date(Y-m-d\TH:i:sP)%'] = date( 'c', strtotime( $args->post_date ?? date( 'c' ) ) );
		}

		if ( isset( $replacements['%modified(Y-m-d\TH:i:sP)%'] ) ) {
			$replacements['%modified(Y-m-d\TH:i:sP)%'] = date( 'c', strtotime( $args->post_modified ?? date( 'c' ) ) );
		}

		return $replacements;
	}
}

new PW_Tools_Rank_Math();