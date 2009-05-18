<?php
try {
	$PAGETITLE = "Login Success";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	$errorMessage = "You are successfully logged on our site.";
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('users/loginSuccess.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>