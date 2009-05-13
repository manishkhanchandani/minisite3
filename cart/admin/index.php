<?php
try {
	$PAGEHEADING = "Shopping Cart Administration";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	$body = $smarty->fetch('cart/admin/index.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>