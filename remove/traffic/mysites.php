<?php require_once('Connections/conn.php'); ?>
<?php
if(!$_COOKIE['id']) {
	header("Location: index.php");
	exit;
}
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO traffic_sites (id, sitename) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['sitename'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "mysites.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['deleteID'])) && ($_GET['deleteID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM traffic_sites WHERE site_id=%s",
                       GetSQLValueString($_GET['deleteID'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['deleteID'])) && ($_GET['deleteID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM traffic_stats WHERE site_id=%s",
                       GetSQLValueString($_GET['deleteID'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$colname_rs = "-1";
if (isset($_COOKIE['id'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_COOKIE['id'] : addslashes($_COOKIE['id']);
}
mysql_select_db($database_conn, $conn);
$query_rs = sprintf("SELECT * FROM traffic_sites WHERE id = %s ORDER BY sitename ASC", $colname_rs);
$rs = mysql_query($query_rs, $conn) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Traffic Analysis :: My Sites</title>
<link href="styles/main.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
//-->
</script>
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
        <td><h3>Add New Site</h3>
          <form name="form1" id="form1" method="POST" action="<?php echo $editFormAction; ?>">
          Sitename: 
            <input name="sitename" type="text" id="sitename" />
            <input type="submit" name="Submit" value="Add New Site" />
            <input name="id" type="hidden" id="id" value="<?php echo $_COOKIE['id']; ?>" />
            <input type="hidden" name="MM_insert" value="form1">
          </form>          
          <?php if ($totalRows_rs > 0) { // Show if recordset not empty ?>
          <h3>My Sites </h3>
          <table border="1">
              <tr>
                <td><strong>Sitename</strong></td>
                <td><strong>View Report </strong></td>
                <td><strong>Get Code</strong> </td>
                <td><strong>Delete</strong></td>
              </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_rs['sitename']; ?></td>
                  <td><a href="report.php?site_id=<?php echo $row_rs['site_id']; ?>">View Report</a> </td>
                  <td><a href="get_code.php?site_id=<?php echo $row_rs['site_id']; ?>">Get Code </a></td>
                  <td><a href="mysites.php?deleteID=<?php echo $row_rs['site_id']; ?>" onclick="GP_popupConfirmMsg('Do you really want to delete?');return document.MM_returnValue">Delete</a></td>
              </tr>
              <?php } while ($row_rs = mysql_fetch_assoc($rs)); ?>
                    </table>
          <?php } // Show if recordset not empty ?>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rs);

mysql_close();
?>
