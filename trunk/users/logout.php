<?php
try {
	$PAGETITLE = "Logout";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	$errorMessage = "You are successfully logged out of the site.";
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('users/logout.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>