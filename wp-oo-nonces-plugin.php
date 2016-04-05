<?php

/*
Plugin Name: WordPress Object Oriented Nonces Plugin
Version: 1.1.0
Author: Rouven Hurling
License: GPL2
*/

require 'vendor/autoload.php';

use RouvenHurling\Nonces\Nonce;
use RouvenHurling\Nonces\Verifier;

function wp_create_nonce($action = -1)
{
	$user = wp_get_current_user();
	$uid  = (int) $user->ID;
	if ( ! $uid ) {
		/** This filter is documented in wp-includes/pluggable.php */
		$uid = apply_filters( 'nonce_user_logged_out', $uid, $action );
	}

	/**
	 * Filter the lifespan of nonces in seconds.
	 *
	 * @since 2.5.0
	 *
	 * @param int $lifespan Lifespan of nonces in seconds. Default 86,400 seconds, or one day.
	 */
	$nonce_life = apply_filters( 'nonce_life', DAY_IN_SECONDS );

	$token = wp_get_session_token();

	$nonce = new Nonce($action);
	$nonce->setUserId($uid);
	$nonce->setLifespan($nonce_life);
	$nonce->setSessionToken($token);
	$nonce->setSalt(wp_salt('nonce'));

	return $nonce->generate();
}

function wp_verify_nonce($nonce, $action = -1)
{
	$user = wp_get_current_user();
	$uid  = (int) $user->ID;
	if ( ! $uid ) {
		/** This filter is documented in wp-includes/pluggable.php */
		$uid = apply_filters( 'nonce_user_logged_out', $uid, $action );
	}

	/**
	 * Filter the lifespan of nonces in seconds.
	 *
	 * @since 2.5.0
	 *
	 * @param int $lifespan Lifespan of nonces in seconds. Default 86,400 seconds, or one day.
	 */
	$nonce_life = apply_filters( 'nonce_life', DAY_IN_SECONDS );

	$token = wp_get_session_token();

	$verifier = new Verifier();
	$verifier->setUserId($uid);
	$verifier->setLifespan($nonce_life);
	$verifier->setSessionToken($token);
	$verifier->setSalt(wp_salt('nonce'));

	$nonce    = (string)$nonce;
	$verified = $verifier->verify($nonce, $action);
	if (false !== $verified) {
		return $verified;
	}

	/**
	 * Fires when nonce verification fails.
	 *
	 * @since 4.4.0
	 *
	 * @param string $nonce The invalid nonce.
	 * @param string|int $action The nonce action.
	 * @param WP_User $user The current user object.
	 * @param string $token The user's session token.
	 */
	do_action('wp_verify_nonce_failed', $nonce, $action, $user, $token);

	return false;
}