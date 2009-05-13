<?php
ini_set('memory_limit','500M');
ini_set('max_execution_time','-1'); 
//error_reporting(0);
ob_start();
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" ); 

define('CACHETIME', 60); // seconds
// set cookie
if($_GET['rn']) {
	setcookie('rn', $_GET['rn'], time()+(60*60*24*365), "/");
}
?>