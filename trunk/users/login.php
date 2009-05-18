<?php
try {
	$PAGETITLE = "Login";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	if (isset($_GET['accesscheck'])) {
		$_SESSION['PrevUrl'] = $_GET['accesscheck'];
	}	
	include_once('Classes/Users.php');
	$users = new Users($dbFrameWork, $Common);
	if($_POST['MM_Type']=="login") {
		try {
			$loginUsername=$_POST['email'];
			$password=$_POST['password'];
			$MM_fldUserAuthorization = "role";
			$MM_redirectLoginSuccess = HTTPPATH."/index.php?p=users/loginSuccess&ID=".$ID;
			$MM_redirectLoginFailed = HTTPPATH."/index.php?p=users/login&ID=".$ID;
			$MM_redirecttoReferrer = true;
			
			$LoginRS__query=sprintf("SELECT email, password, role, name, user_id FROM users WHERE email='%s' AND password='%s'", get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
			$LoginRS = $dbFrameWork->Execute($LoginRS__query);
			if($dbFrameWork->ErrorMsg()) {
				throw new Exception($dbFrameWork->ErrorMsg());
			}
	
			$loginFoundUser = $LoginRS->RecordCount();
			if ($loginFoundUser) {
				$LoginRecord = $LoginRS->FetchRow();				
				$loginStrGroup  = $LoginRecord['role'];				
				//declare two session variables and assign them
				if($_POST['remember']==1) {
					$time = time()+(60*60*24*365);
				} else {
					$time = 0;
				}
				setcookie('MM_Username',$loginUsername,$time,"/");
				setcookie('MM_UserGroup',$loginStrGroup,$time,"/");
				setcookie('user_id',$LoginRecord['user_id'],$time,"/");
				setcookie('name',$LoginRecord['name'],$time,"/");	       
			
				if (isset($_SESSION['PrevUrl']) && true) {
					$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
				}
				header("Location: ".$MM_redirectLoginSuccess);
				exit;
			} else {
				throw new Exception("Login failed. Username and Password does not match with our record. Please try again");
			}	
		} catch (exception $e) { 
			$errorMessage = $e->getMessage();
			$smarty->assign('errorMessage', $errorMessage);
			$body = $smarty->fetch('users/login.html');
		} 
	}	
	$body = $smarty->fetch('users/login.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}

?>