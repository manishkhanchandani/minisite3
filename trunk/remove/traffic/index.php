<?php
include('Connections/conn.php');
function setCookieTraffic($u, $p, $id, $t) {
	setcookie("u",$u,$t,"/");
	setcookie("p",$p,$t,"/");
	setcookie("id",$id,$t,"/");
}
if($_POST['u'] && $_POST['p']) {
	if($_POST['remember']==1) $t = time()+(60*60*24*365); else $t = 0;
	echo "select * from traffic_account where username = '".addslashes(stripslashes(trim($_POST['u'])))."'";
	$rs = mysql_query("select * from traffic_account where username = '".addslashes(stripslashes(trim($_POST['u'])))."'");
	if(mysql_num_rows($rs)>0) {		
		$rs1 = mysql_query("select * from traffic_account where username = '".addslashes(stripslashes(trim($_POST['u'])))."' and password = '".addslashes(stripslashes(trim($_POST['p'])))."'");
		if(mysql_num_rows($rs1)>0) {
			$rec = mysql_fetch_array($rs);
			$id = $rec['id'];
			setCookieTraffic($_POST['u'], $_POST['p'], $id, $t);
			header("Location: mysites.php");
			exit;
		} else {
			$error = "<p class=error>username and password not matching.</p>";
		}
	} else {
		mysql_query("insert into traffic_account set username = '".addslashes(stripslashes(trim($_POST['u'])))."', password = '".addslashes(stripslashes(trim($_POST['p'])))."'") or die("error");
		$id = mysql_insert_id();
		setCookieTraffic($_POST['u'], $_POST['p'], $id, $t);
		header("Location: mysites.php");
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Traffic Analysis</title>
<link href="styles/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" bgcolor="#000000"><h1><font color="#FFFF00">Traffic Analysis </font></h1></td>
      </tr>
      <tr>
        <td><?php echo $error; ?>&nbsp;</td>
      </tr>
      <tr>
        <td><form name="form1" id="form1" method="post" action="">
          <table border="0" align="center" cellpadding="5" cellspacing="0">
            <tr>
              <td align="right"><strong>Login:</strong></td>
              <td><input name="u" type="text" id="u" /></td>
            </tr>
            <tr>
              <td align="right"><strong>Password:</strong></td>
              <td><input name="p" type="password" id="p" /></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td><input name="remember" type="checkbox" id="remember" value="1" />
                Remember Me </td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td><input type="submit" name="Submit" value="Login / Register" /></td>
            </tr>
            <tr>
              <td colspan="2">If login is not available, it will be created for the new user. </td>
              </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php


mysql_close();
?>
