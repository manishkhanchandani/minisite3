<?php
try {
	if(!$errorMessage) $errorMessage = "Error Found.";
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('home.html');
}
?>