<?php

class TestVerifyNonce extends PHPUnit_Framework_TestCase {

	static $time = 1458891857;
	static $nonce = 'c9b9978685';
	static $actionNonce = '296101f60a';

	public static function setUpBeforeClass() {
		\wp_salt( '', 'salt' );
		\wp_get_current_user( 1 );
		\wp_get_session_token( 'session-1' );
	}

	public function setUp() {
		RouvenHurling\Nonces\time( self::$time );
	}

	public function testVerfication() {
		$this->assertFalse( wp_verify_nonce( '' ), 'Empty Nonce' );
		$this->assertEquals( 1, wp_verify_nonce( self::$actionNonce, 'action' ), 'Nonce with action' );

		$this->assertEquals( 1, wp_verify_nonce( self::$nonce ), 'Nonce less than 12 hours old' );

		RouvenHurling\Nonces\time( self::$time + 3600 * 12 );

		$this->assertEquals( 2, wp_verify_nonce( self::$nonce ), 'Nonce less than 24 hours old' );

		RouvenHurling\Nonces\time( self::$time + 3600 * 24 );

		$this->assertFalse( wp_verify_nonce( self::$nonce ), 'Nonce older than 24 hours' );
	}

	public static function tearDownAfterClass() {
		\wp_salt( '', null );
		\wp_get_current_user( null );
		\wp_get_session_token( null );
	}

}
