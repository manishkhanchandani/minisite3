<?php
try {
	$PAGETITLE = "Register New User";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	$xtraFields = array(
					1=>array("xtra_field"=>"address", "xtra_field_label"=>"Address", "xtra_field_value"=>"", "type"=>"textarea"),
					2=>array("xtra_field"=>"city", "xtra_field_label"=>"City", "xtra_field_value"=>"", "type"=>"text"),
					3=>array("xtra_field"=>"state", "xtra_field_label"=>"State", "xtra_field_value"=>"", "type"=>"text"),
					4=>array("xtra_field"=>"country", "xtra_field_label"=>"Country", "xtra_field_value"=>"", "type"=>"text"),
					5=>array("xtra_field"=>"zipcode", "xtra_field_label"=>"Zipcode", "xtra_field_value"=>"", "type"=>"text"),
					6=>array("xtra_field"=>"phone", "xtra_field_label"=>"Phone", "xtra_field_value"=>"", "type"=>"text")
				);
	$smarty->assign('xtraFields', $xtraFields);
	if($_POST['MM_Type']=="register") {
		try {
			//$Users = new Users;
			//$Users->validate_email($_POST['email']);
			//$Users->validateRegisterForm($_POST);
			//$Users->addNewUser($_POST);
			//$msg = "You are successfully registerd on our site. Please check your email and click a link to confirm your email.";
			//$smarty->assign('msg', $msg);
		} catch (exception $e) { 
			//$errorMessage = $e->getMessage();
			//$smarty->assign('errorMessage', $errorMessage);
			//$body = $smarty->fetch('register.html');
		} 
	}
	$body = $smarty->fetch('users/register.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>