<?php
header( "Content-type: text/css; charset: UTF-8" );

//get color from option, settings etc
$color = 'blue';
?>

a {
	color: <?php echo $color;?> !important;
}