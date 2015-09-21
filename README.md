# dynamic-enqueue-scripts.php
Plugin that demonstrates how to enqueue dynamic CSS and JavaScript in WordPress.


## Excerpt from the [plugin code](https://github.com/soderlind/dynamic-enqueue-scripts/blob/master/dynamic-enqueue-scripts.php)

```php
function dynamic_enqueue_scripts() {
    wp_enqueue_style(
        'dynamic-css', //handle
        admin_url( 'admin-ajax.php' ) . '?action=dynamic_css_action&wpnonce=' . wp_create_nonce( 'dynamic-css-nonce' ), // src
        array(), // dependencies
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
add_action( 'wp_enqueue_scripts', 'dynamic_enqueue_scripts' );

add_action( 'wp_ajax_dynamic_css_action', 'dynamic_css_loader' );
add_action( 'wp_ajax_nopriv_dynamic_css_action', 'dynamic_css_loader' );

```

## A simple example [dynamic CSS](https://github.com/soderlind/dynamic-enqueue-scripts/blob/master/dynamic-css.php)

```php
<?php
//prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
header( "Content-type: text/css; charset: UTF-8" );
//get color from options, settings etc
$color = 'blue';
?>

a {
	color: <?php echo $color;?> !important;
}
```
