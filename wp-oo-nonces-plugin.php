<?php

/*
Plugin Name: WordPress Object Oriented Nonces Plugin
Version: 1.1.1
Author: Rouven Hurling
License: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// function to output PHP Version error if its needed
function wp_oo_nonces_php_version_error() {
	echo '<tr><th scope="row" class="check-column"></th><td class="plugin-title" colspan="10">'
	     . '<span style="padding: 3px; color: white; background-color: red; font-weight: bold">&nbsp;&nbsp;' . sprintf(
		     __( 'FEHLER: Das maklerACCESS Plugin benötigt mindestens PHP Version %s oder höher!', 'makleraccess' ),
		     '5.4'
	     )
	     . '  ' . __( 'Deine aktuelle PHP Version ist', 'makleraccess' ) . ' ' . phpversion()
	     . '.&nbsp;&nbsp;</span></td></tr>';
}

// check if PHP Version is compatible
if ( ! version_compare( phpversion(), '5.4', '>=' ) ) {
	add_action(
		'after_plugin_row_' . plugin_basename( __FILE__ ),
		'wp_oo_nonces_php_version_error',
		10,
		2
	);

	return;
}

// function to output Composer error
function wp_oo_nonces_composer_error() {
	echo '<tr><th scope="row" class="check-column"></th><td class="plugin-title" colspan="10">'
	     . '<span style="padding: 3px; color: white; background-color: red; font-weight: bold">&nbsp;&nbsp;'
	     . sprintf(
		     'Please run <code>composer install</code> in the <code>%1$s</code> directory to install dependencies and generate autoloading files',
		     __DIR__
	     )
	     . '.&nbsp;&nbsp;</span></td></tr>';
}

// check if composer autoloading file exists
if ( ! file_exists( 'vendor/autoload.php' ) ) {
	add_action(
		'after_plugin_row_' . plugin_basename( __FILE__ ),
		'wp_oo_nonces_php_version_error',
		10,
		2
	);

	return;
}

require 'vendor/autoload.php';