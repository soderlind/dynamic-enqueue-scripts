<?php
/*
Plugin Name: Dynamic Enqueue Scripts (CSS & JavaScript)
Plugin URI: https://github.com/soderlind/dynamic-enqueue-scripts
Description:
Author: Per Soderlind
Version: 0.1.0
Author URI: http://soderlind.no
GitHub Plugin URI: soderlind/dynamic-enqueue-scripts
*/

define('DYNAMICSCRIPTVERSION', '0.1.0');

function dynamic_enqueue_scripts() {

    wp_enqueue_style(
        'dynamic-css', //handle
        admin_url( 'admin-ajax.php' ) . '?action=dynamic_css_action&wpnonce=' . wp_create_nonce( 'dynamic-css-nonce' ), // src
        array(), // dependencies
        DYNAMICSCRIPTVERSION // version number
    );

    wp_enqueue_script(
        'dynamic-javascript', //handle
        admin_url( 'admin-ajax.php' ) . '?action=dynamic_javascript_action&wpnonce=' . wp_create_nonce( 'dynamic-javascript-nonce' ), // src
        array('jquery'), // dependencies, I use jquery in dynamic-javascript.php
        DYNAMICSCRIPTVERSION // version number
    );


}
function dynamic_css_loader() {
    $nonce = $_REQUEST['wpnonce'];
    if ( ! wp_verify_nonce( $nonce, 'dynamic-css-nonce' ) ) {
        die( 'invalid nonce' );
    } else {
        /**
         * NOTE: Using require or include to call an URL (created by plugins_url() or get_template_directory(), can create the following error:
         *       Warning: require(): http:// wrapper is disabled in the server configuration by allow_url_include=0
         *       Warning: require(http://domain/path/dynamic-javascript.php): failed to open stream: no suitable wrapper could be found
         *       Fatal error: require(): Failed opening required 'http://domain/path/dynamic-javascript.php'
         */
        require_once dirname( __FILE__ ) . '/dynamic-css.php';
    }
    exit;
}

function dynamic_javascript_loader() {
    $nonce = $_REQUEST['wpnonce'];
    if ( ! wp_verify_nonce( $nonce, 'dynamic-javascript-nonce' ) ) {
        die( 'invalid nonce' );
    } else {
        /**
         * NOTE: Using require or include to call an URL (created by plugins_url() or get_template_directory(), can create the following error:
         *       Warning: require(): http:// wrapper is disabled in the server configuration by allow_url_include=0
         *       Warning: require(http://domain/path/dynamic-javascript.php): failed to open stream: no suitable wrapper could be found
         *       Fatal error: require(): Failed opening required 'http://domain/path/dynamic-javascript.php'
         */
    	require_once dirname( __FILE__ ) . '/dynamic-javascript.php';
	}
	exit;
}

add_action( 'wp_enqueue_scripts', 'dynamic_enqueue_scripts' );

add_action( 'wp_ajax_dynamic_css_action', 'dynamic_css_loader' );
add_action( 'wp_ajax_nopriv_dynamic_css_action', 'dynamic_css_loader' );

add_action( 'wp_ajax_dynamic_javascript_action', 'dynamic_javascript_loader' );
add_action( 'wp_ajax_nopriv_dynamic_javascript_action', 'dynamic_javascript_loader' );

