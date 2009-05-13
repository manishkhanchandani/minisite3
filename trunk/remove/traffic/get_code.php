<?php require_once('Connections/conn.php'); ?>
<?php
$colname_rsSite = "-1";
if (isset($_GET['site_id'])) {
  $colname_rsSite = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsSite = sprintf("SELECT * FROM traffic_sites WHERE site_id = %s", $colname_rsSite);
$rsSite = mysql_query($query_rsSite, $conn) or die(mysql_error());
$row_rsSite = mysql_fetch_assoc($rsSite);
$totalRows_rsSite = mysql_num_rows($rsSite);
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><h3>Get Code For Site</h3>
          <p><a href="mysites.php">Back</a></p>
          <form name="form1" id="form1" method="post" action="">
            <textarea name="code" cols="45" rows="10" id="code">
<script language="javascript">
	var mkgxyCode = <?php echo $row_rsSite['site_id']; ?>;
</script>
<script language="javascript" type="text/javascript" src="http://10000projects.info/traffic/mkgxy.js"></script>
			</textarea>
          </form>          <p>&nbsp;</p>
          <p>&nbsp; </p></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsSite);

mysql_close();
?>
