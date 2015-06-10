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