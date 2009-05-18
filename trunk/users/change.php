<?php
try {
	$PAGETITLE = "Change Password";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	if($_POST['MM_Type']=="change") {
		try {
			
		} catch (exception $e) { 
			
		} 
	}
	$body = $smarty->fetch('users/change.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>