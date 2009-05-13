<?php
class Emailtemplate {
	public $fromemail = ADMINEMAIL;
	public $fromname = ADMINNAME; 
	public function template($to, $name, $patterns, $replacements) {
		switch($name) {
			case 'register':
				$sub = "Successfull Registeration";
				$template = "Dear User,
Your email is {EMAIL} and password is: '{PASSWORD}'. You can login on site {SITEURL} with this details. Click or copy and paste below link to confirm your email address.
{LINK}

Regards,
Administrator
";
				break;
			case 'forgot':
				$sub = "Password Reminder";
				$template = "Dear User,
Your password is: '{PASSWORD}'. You can login on site {SITEURL} with this password.

Regards,
Administrator
";
				break;
			case 'ratemyqualitysendlink':
				$sub = "Rate on Your Friend's Qualities";
				$template = "Dear Friend,
I have added my qualities on one of the site. Site URL is {MYLINK}
Please logon to the above url and give me vote on my qualities. Your response is highly appreciable.

Regards,
{USEREMAIL}
";
				$this->fromname = '';
				$eml = preg_replace($patterns, $replacements, '{USEREMAIL}');
				$eml = str_replace("{", "", $eml);
				$eml = str_replace("}", "", $eml);
				$this->fromemail = $eml;
				break;
			case 'referafriend':
				$sub = "Check out site {SITENAME}";
				$template = "Dear {TONAME},
Check out the site \"{SITENAME}\" at \"{SITEURL}\" 

Regards,
{MYNAME}
";
				break;
			
			case 'downtimealert':
				$sub = "Your site {SITENAME} is down.";
				$template = "Dear User,
Your site {SITENAME} is down. Site is down due to \"{REASON}\"

Regards,
Administrator
";
				break;
		}
		
		$body = preg_replace($patterns, $replacements, $template);
		$body = str_replace("{", "", $body);
		$body = str_replace("}", "", $body);
		@mail($to, $sub, $body, "From:".$this->fromname."<".$this->fromemail.">");
		return $body;
	}
}
?>