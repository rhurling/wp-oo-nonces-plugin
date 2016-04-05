<?php

class TestCreateNonce extends PHPUnit_Framework_TestCase {

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

	public function testCreation() {
		$nonce = wp_create_nonce();
		$this->assertEquals( self::$nonce, $nonce );

		$nonce = wp_create_nonce( 'action' );
		$this->assertEquals( self::$actionNonce, $nonce );
	}

	public static function tearDownAfterClass() {
		\wp_salt( '', null );
		\wp_get_current_user( null );
		\wp_get_session_token( null );
	}

}
