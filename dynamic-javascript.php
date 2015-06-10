<?php
//prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
header( "Content-type: application/javascript; charset: UTF-8" );

//get message from options, settings etc
$message = 'Hello from Dynamic Enqueue Scripts';

?>

( function( $ ) {

	var message = "<?php echo $message; ?>";

	alert(message);

} )( jQuery );
