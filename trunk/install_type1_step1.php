<?php require_once('Connections/conn.php'); ?>
<?php
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
  $insertSQL = sprintf("INSERT INTO sites (sitename, user_id, sitebaseurl, siteurl, sitepath, siteemail, docpath) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['sitename'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['sitebaseurl'], "text"),
                       GetSQLValueString($_POST['siteurl'], "text"),
                       GetSQLValueString($_POST['sitepath'], "text"),
                       GetSQLValueString($_POST['siteemail'], "text"),
                       GetSQLValueString($_POST['docpath'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

$colname_rsView = "1";
if (isset($_SESSION['user_id'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_SESSION['user_id'] : addslashes($_SESSION['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM sites WHERE user_id = %s", $colname_rsView);
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Step1: Choosing Site Details</h1>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td nowrap align="right">Site Name:</td>
      <td><input type="text" name="sitename" value="" size="32"></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Site Base Url: </td>
      <td><input name="sitebaseurl" type="text" id="sitebaseurl" value="http://" size="32" /></td>
      <td>http:// or https:// </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site Url:</td>
      <td><input type="text" name="siteurl" size="32"></td>
      <td>Hostname (dont start with www.) </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site Path: </td>
      <td><input name="sitepath" type="text" id="sitepath" size="32" /></td>
      <td>folder starting with / </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Site Email:</td>
      <td><input type="text" name="siteemail" value="" size="32"></td>
      <td>Site Email Address </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Document path:</td>
      <td><input type="text" name="docpath" value="<?php echo $_SERVER['DOCUMENT_ROOT']."/".basename(dirname(__FILE__)); ?>" size="32"></td>
      <td>Physical Location to www </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Go To Step"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="user_id" value="1">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <h3>View My Sites </h3>
  <table border="1">
    <tr>
      <td><strong>Sitename</strong></td>
      <td><strong>Siteurl</strong></td>
      <td><strong>Siteemail</strong></td>
      <td><strong>Docpath</strong></td>
      <td><strong>Step 2 </strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsView['sitename']; ?></td>
        <td><?php echo $row_rsView['siteurl']; ?></td>
        <td><?php echo $row_rsView['siteemail']; ?></td>
        <td><?php echo $row_rsView['docpath']; ?></td>
        <td><a href="install_type1_step2.php?site_id=<?php echo $row_rsView['site_id']; ?>">Step 2</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
      </table>
  <?php } // Show if recordset not empty ?></body>
</html>
<?php
mysql_free_result($rsView);
?>
