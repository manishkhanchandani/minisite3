<?php
try { 
	$dbFrameWork = &ADONewConnection('mysql');  # create a connection 
	$dbFrameWork->Connect($hostname_conn,$username_conn,$password_conn,$database_conn);# connect to MySQL, framework db
} catch (exception $e) { 
	ob_end_clean();
	echo 'Loading in 5 seconds. If page does not refresh in 5 seconds, please refresh manually.<meta http-equiv="refresh" content="5">';
	//echo "<pre>";var_dump($e); adodb_backtrace($e->gettrace());
	exit;
} 
?>