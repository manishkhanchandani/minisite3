<?php
try {
	$PAGETITLE = "Edit Details";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	if($_POST['MM_Type']=="edit") {
		try {
			
		} catch (exception $e) { 
			
		} 
	}
	$body = $smarty->fetch('users/edit.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>