<?php

class TestVerifyNonce extends PHPUnit_Framework_TestCase {

	static $time = 1458891857;
	static $nonce = 'c9b9978685';
	static $actionNonce = '296101f60a';

	public function setUp() {
		RouvenHurling\Nonces\time( self::$time );
		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	public function testVerfication() {
		$user     = new stdClass();
		$user->ID = 1;
		\WP_Mock::wpFunction(
			'wp_get_current_user',
			[
				'times'  => 5,
				'return' => $user
			]
		);

		\WP_Mock::wpFunction(
			'wp_salt',
			[
				'args'   => [ 'nonce' ],
				'times'  => 5,
				'return' => 'salt'
			]
		);

		\WP_Mock::wpFunction(
			'wp_get_session_token',
			[
				'times' => 5,
				'return' => 'session-1'
			]
		);

		$this->assertFalse( wp_verify_nonce( '' ), 'Empty Nonce' );
		$this->assertEquals( 1, wp_verify_nonce( self::$actionNonce, 'action' ), 'Nonce with action' );

		$this->assertEquals( 1, wp_verify_nonce( self::$nonce ), 'Nonce less than 12 hours old' );

		RouvenHurling\Nonces\time( self::$time + 3600 * 12 );

		$this->assertEquals( 2, wp_verify_nonce( self::$nonce ), 'Nonce less than 24 hours old' );

		RouvenHurling\Nonces\time( self::$time + 3600 * 24 );

		$this->assertFalse( wp_verify_nonce( self::$nonce ), 'Nonce older than 24 hours' );
	}

}
