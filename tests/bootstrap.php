<?php

namespace {

	require 'vendor/autoload.php';

	define( 'DAY_IN_SECONDS', 86400 );
}

namespace RouvenHurling\Nonces {

	function time( $setTime = false ) {
		static $time;
		if ( $setTime !== false ) {
			$time = $setTime;
		}

		return $time;
	}

}