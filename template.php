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
  $insertSQL = sprintf("INSERT INTO templates (name, template, css, js) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['template'], "text"),
                       GetSQLValueString($_POST['css'], "text"),
                       GetSQLValueString($_POST['js'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE templates SET name=%s, template=%s, css=%s, js=%s WHERE tid=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['template'], "text"),
                       GetSQLValueString($_POST['css'], "text"),
                       GetSQLValueString($_POST['js'], "text"),
                       GetSQLValueString($_POST['tid'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['did'])) && ($_GET['did'] != "")) {
  $deleteSQL = sprintf("DELETE FROM templates WHERE tid=%s",
                       GetSQLValueString($_GET['did'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

mysql_select_db($database_conn, $conn);
$query_rsView = "SELECT tid, name FROM templates";
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);

$colname_rsEdit = "-1";
if (isset($_GET['tid'])) {
  $colname_rsEdit = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);
}
mysql_select_db($database_conn, $conn);
$query_rsEdit = sprintf("SELECT * FROM templates WHERE tid = %s", $colname_rsEdit);
$rsEdit = mysql_query($query_rsEdit, $conn) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Template Management</title>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
//-->
</script>
</head>

<body>
<h1>Template Management</h1>
<p><a href="install_type1_step1.php">Back To Main Page </a></p>
<h3>Add New Template </h3>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onsubmit="MM_validateForm('name','','R');return document.MM_returnValue">
  <table>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Template:</td>
      <td><textarea name="template" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Css:</td>
      <td><textarea name="css" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Js:</td>
      <td><textarea name="js" cols="50" rows="5"></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <h3>View Templates </h3>
  <table border="1">
    <tr>
      <td><strong>ID</strong></td>
      <td><strong>Name</strong></td>
      <td><strong>Preview</strong></td>
      <td><strong>Edit</strong></td>
      <td><strong>Delete</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsView['tid']; ?></td>
        <td><?php echo $row_rsView['name']; ?></td>
        <td><a href="preview.php?tid=<?php echo $row_rsView['tid']; ?>" target="_blank">Preview</a></td>
        <td><a href="template.php?tid=<?php echo $row_rsView['tid']; ?>#edit">Edit</a></td>
        <td><a href="template.php?did=<?php echo $row_rsView['tid']; ?>" onclick="GP_popupConfirmMsg('Are you sure you want to delete this template?');return document.MM_returnValue">Delete</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsEdit > 0) { // Show if recordset not empty ?>
  <h3>Edit Template <a name="edit" id="edit"></a></h3>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form2">
    <table>
      <tr valign="baseline">
        <td nowrap align="right">Name:</td>
        <td><input type="text" name="name" value="<?php echo $row_rsEdit['name']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Template:</td>
        <td><textarea name="template" cols="50" rows="5"><?php echo $row_rsEdit['template']; ?></textarea>        </td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Css:</td>
        <td><textarea name="css" cols="50" rows="5"><?php echo $row_rsEdit['css']; ?></textarea>        </td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Js:</td>
        <td><textarea name="js" cols="50" rows="5"><?php echo $row_rsEdit['js']; ?></textarea>        </td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" value="Update record"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form2">
    <input type="hidden" name="tid" value="<?php echo $row_rsEdit['tid']; ?>">
  </form>
  <?php } // Show if recordset not empty ?><p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsView);

mysql_free_result($rsEdit);
?>
