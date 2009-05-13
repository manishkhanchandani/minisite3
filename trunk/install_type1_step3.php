<?php require_once('Connections/conn.php'); ?>
<?php
$colname_rsSite = "-1";
if (isset($_GET['site_id'])) {
  $colname_rsSite = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsSite = sprintf("SELECT * FROM sites WHERE site_id = %s", $colname_rsSite);
$rsSite = mysql_query($query_rsSite, $conn) or die(mysql_error());
$row_rsSite = mysql_fetch_assoc($rsSite);
$totalRows_rsSite = mysql_num_rows($rsSite);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<p>Step 3: Template Mangement</p>
<form id="form1" name="form1" method="post" action="">
  <input name="Button" type="button" onclick="MM_goToURL('parent','install_type1_step_payment.php?site_id=<?php echo $_GET['site_id']; ?>');return document.MM_returnValue" value="Button" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsSite);
?>
