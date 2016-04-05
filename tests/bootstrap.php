<?php

namespace {

	require 'vendor/autoload.php';

	define( 'DAY_IN_SECONDS', 86400 );

	function apply_filters( $filter, $item ) {
		return $item;
	}

	function do_action() {
		return;
	}

	function wp_get_current_user( $setUserId = false ) {
		static $user;
		if ( $setUserId !== false ) {
			$user     = new stdClass();
			$user->ID = 1;
		}

		return $user;
	}

	function wp_get_session_token( $setToken = false ) {
		static $token;
		if ( $setToken !== false ) {
			$token = $setToken;
		}

		return $token;
	}

	function wp_salt( $name, $setSalt = false ) {
		static $salt;
		if ( $setSalt !== false ) {
			$salt = $setSalt;
		}

		return $salt;
	}
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