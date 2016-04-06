<?php

use WP_Mock\Tools\TestCase;

class TestCreateNonce extends TestCase {

	static $time = 1458891857;
	static $nonce = 'c9b9978685';
	static $actionNonce = '296101f60a';

	public function setUp() {
		parent::setUp();
		
		RouvenHurling\Nonces\time( self::$time );
	}

	public function testCreation() {
		$user     = new stdClass();
		$user->ID = 1;
		WP_Mock::wpFunction(
			'wp_get_current_user',
			[
				'times'  => 2,
				'return' => $user
			]
		);

		WP_Mock::wpFunction(
			'wp_salt',
			[
				'args'   => [ 'nonce' ],
				'times'  => 2,
				'return' => 'salt'
			]
		);

		WP_Mock::wpFunction(
			'wp_get_session_token',
			[
				'times' => 2,
				'return' => 'session-1'
			]
		);

		$nonce = wp_create_nonce();
		$this->assertEquals( self::$nonce, $nonce );

		$nonce = wp_create_nonce( 'action' );
		$this->assertEquals( self::$actionNonce, $nonce );
	}

}
