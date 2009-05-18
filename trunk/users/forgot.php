<?php
try {
	$PAGETITLE = "Forgot Password";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	if($_POST['MM_Type']=="forgot") {
		try {
			
		} catch (exception $e) { 
			
		} 
	}
	$body = $smarty->fetch('users/forgot.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>
