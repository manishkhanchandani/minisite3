<?php
class Users {

	private $cacheSecs = CACHETIME;
	private static $instance;
	
	public function __construct($dbFrameWork, $Common) {
		if(self::$instance) {
			return self::$instance;
		} else {
			self::$instance = $this;
			$this->dbFrameWork = $dbFrameWork;
			$this->Common = $Common;
		}
	}
	public function viewHomePage($ID, $data, $settings) {
		return true;
	}
	public function validateLoginForm($post) {
		if(!trim($post['email'])) {
			$msg = "Email field is blank.";
			throw new Exception($msg);
		}
		if(!trim($_POST['password'])) {
			$msg = "Password field is blank.";
			throw new Exception($msg);
		}
		return true;
	}
	public function validateRegisterForm($post) {
		if(!trim($post['email'])) {
			$msg = "Email field is blank.";
			throw new Exception($msg);
		}
		if(!trim($_POST['password'])) {
			$msg = "Password field is blank.";
			throw new Exception($msg);
		}
		if(trim($_POST['password'])!=trim($_POST['confirm_password'])) {
			$msg = "Password and confirm password field are not matching.";
			throw new Exception($msg);
		}
		return true;
	}
	public function login($post) {
		$sql = "select * from users where email = ".$this->dbFrameWork->qstr(trim($post['email']),get_magic_quotes_gpc())." and password = ".$this->dbFrameWork->qstr(md5($post['password']),get_magic_quotes_gpc());
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$num1 = $rs->RecordCount();
		if($num1==0) {
			throw new Exception("Email and Password Does Not Matches");
		} else {
			$rec = $rs->FetchRow();
			if($rec['status']==0) {
				throw new Exception("You have not yet confirmed your email address. Click a link on your email address to confirm your email address.");
			}
			if($post['rem']) $time = time()+(60*60*24*365);
			else $time = 0;
			setcookie("user_id", $rec['user_id'], $time, "/");
			setcookie("email", $rec['email'], $time, "/");	
			setcookie("role", $rec['role'], $time, "/");	
			setcookie("name", $rec['name'], $time, "/");				
		}
		return true;
	}
	public function logout() {
		setcookie("user_id", '', (time()-300), "/");
		setcookie("email", '', (time()-300), "/");	
		setcookie("role", '', (time()-300), "/");	
		setcookie("name", $rec['name'], $time, "/");
		return true;	
	}
	public function addNewUser($post) {
		$sql = "select * from users where email = ".$this->dbFrameWork->qstr(trim($post['email']),get_magic_quotes_gpc());
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$num = $rs->RecordCount();
		if($num==0) {
			// register this user
			$post['verify_code'] = md5($post['email']);
			$noencrypt = $post['password'];
			$post['password'] = md5($post['password']);
			$post['role'] = "User";
			$id = $this->Common->phpinsert('users', 'user_id', $post);
			// email
			$Emailtemplate = new Emailtemplate;
			$patterns[0] = "{PASSWORD}";
			$replacements[0] = $noencrypt;		
			$patterns[1] = "{SITEURL}";
			$replacements[1] = SITEURL;
			$patterns[2] = "{EMAIL}";
			$replacements[2] = $post['email'];
			$patterns[3] = "{LINK}";
			$replacements[4] = HTTPPATH."/index.php?action=confirm&vc=".$post['verify_code']."&email=".$post['email'];
			$to = $post['email'];
			$Emailtemplate->template($to, 'register', $patterns, $replacements);
			// email ends
		} else {
			throw new Exception("Users Email already exists on our database.");
		}
		return true;
	}
	public function confirmation($e, $vc) {
		$sql = "select * from users where email = ".$this->dbFrameWork->qstr(trim($e),get_magic_quotes_gpc())." AND verify_code = ".$this->dbFrameWork->qstr(trim($vc),get_magic_quotes_gpc());
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$num = $rs->RecordCount();
		if($num==0) {
			throw new Exception("Verify Link is not correct. Please check the link and try again.");
		} else {
			$rec = $rs->FetchRow();
			if($rec['status']==1) {
				throw new Exception("You have already verified your email address.");
			}
			$sql = "update users set status = 1 WHERE email = ".$this->dbFrameWork->qstr(trim($e),get_magic_quotes_gpc());
			$rs = $this->dbFrameWork->Execute($sql);
			if($this->dbFrameWork->ErrorMsg()) {
				throw new Exception($this->dbFrameWork->ErrorMsg());
			}			
		}
		return true;
	}
	public function validate_email($email) {
		if(!trim($email)) {
			throw new Exception("Email field is blank.");
		}
		if(!$this->Common->emailvalidity(trim($email))) {
			throw new Exception("Email field is not valid.");
		}
		return true;
	}
	public function validate_change_password($post, $email) {
		if(!trim($oldpassword)) {
			throw new Exception("Old password field is blank.");
		}
		if(!trim($newpassword)) {
			throw new Exception("New password field is blank.");
		}
		if(!trim($cpassword)) {
			throw new Exception("Confirm password field is blank.");
		}
		if(trim($newpassword)!=trim($cpassword)) {
			throw new Exception("New password does not match with confirm new password.");
		}
		$sql = "select * from jal_users where email = '".addslashes(stripslashes(trim($email)))."' and password = '".addslashes(stripslashes(trim($oldpassword)))."'";
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$num = $rs->RecordCount();
		if($num) {
			$rec = $rs->FetchRow();
			$sql = "update jal_users set password = '".addslashes(stripslashes(trim($post['newpassword'])))."' where user_id = '".$rec['user_id']."'";
			$rs = $this->dbFrameWork->Execute($sql);
			$msg = "Password updated successfully.";
		} else {
			throw new Exception("Old password does not matches with our record.");
		}
		return $msg;
	}
	public function send_forgot_password($email) {
		$sql = "select * from jal_users where email = '".addslashes(stripslashes(trim($email)))."'";
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$num = $rs->RecordCount();
		if($num) {
			$rec = $rs->FetchRow();
			$pass = $rec['password'];
			// email
			$Emailtemplate = new Emailtemplate;
			$patterns[0] = "{PASSWORD}";
			$replacements[0] = $rec['password'];		
			$patterns[1] = "{SITEURL}";
			$replacements[1] = SITEURL;
			$to = $rec['email'];
			$Emailtemplate->template($to, 'forgot', $patterns, $replacements);
			// email ends
			$msg = "Password successfully sent to your email.";
		} else {
			$msg = "Email is not valid. Our database does not contain this email. Please verify your email and try again.";
		}
		return $msg;
	}
}
?>
