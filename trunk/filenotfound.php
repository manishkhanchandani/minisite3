<?php
try {
	$body = $smarty->fetch('filenotfound.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('home.html');
}
?>