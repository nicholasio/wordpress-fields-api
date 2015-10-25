<?php
/*
Plugin Name: WordPress Fields API
Plugin URI: https://github.com/sc0ttkclark/wordpress-fields-api
Description: WordPress Fields API prototype and proposal
Version: 0.0.1
Author: Scott Kingsley Clark
Author URI: http://scottkclark.com/
License: GPL2+
GitHub Plugin URI: https://github.com/sc0ttkclark/wordpress-fields-api
GitHub Branch: master
Requires WP: 4.1
*/

/**
 * @package    WordPress
 * @subpackage Fields_API
 *
 * @codeCoverageIgnore
 */

/**
 * The absolute server path to the fields API directory.
 */
define( 'WP_FIELDS_API_DIR', plugin_dir_path( __FILE__ ) );

/**
 * On `plugins_loaded`, create an instance of the Fields API manager class.
 */
function _wp_fields_api_include() {

	require_once( WP_FIELDS_API_DIR . 'includes/class-wp-fields-api.php' );

	// Init Customize class
	$GLOBALS['wp_fields'] = new WP_Fields_API;

}

add_action( 'plugins_loaded', '_wp_fields_api_include', 8 );

/**
 * Implement Fields API Customizer instead of WP Core Customizer.
 */
function _wp_fields_api_customize_include() {

	if ( ! ( ( isset( $_REQUEST['wp_customize'] ) && 'on' == $_REQUEST['wp_customize'] ) || ( is_admin() && 'customize.php' == basename( $_SERVER['PHP_SELF'] ) ) ) ) {
		return;
	}

	require_once( WP_FIELDS_API_DIR . 'implementation/wp-includes/class-wp-customize-manager.php' );

	// Init Customize class
	$GLOBALS['wp_customize'] = new WP_Customize_Manager;

}

remove_action( 'plugins_loaded', '_wp_customize_include' );
add_action( 'plugins_loaded', '_wp_fields_api_customize_include', 9 );

/**
 * Implement Fields API User edit to override WP Core.
 */
function _wp_fields_api_user_edit_include() {

	require_once( WP_FIELDS_API_DIR . 'implementation/user-profile.php' );

	return;

	// Load our overrides
	require_once( WP_FIELDS_API_DIR . 'implementation/wp-admin/includes/user.php' );
	require_once( WP_FIELDS_API_DIR . 'implementation/wp-admin/user-edit.php' );

	// Bail on original core file, don't run the rest
	exit;

}
add_action( 'load-user-edit.php', '_wp_fields_api_user_edit_include' );

function _wp_fields_api_widgets_include() {
	require_once( WP_FIELDS_API_DIR . 'implementation/widgets.php' );
}
add_action( 'load-widgets.php', '_wp_fields_api_widgets_include' );
