<?php require_once('Connections/conn.php'); ?>
<?php
$colname_rsSite = "-1";
if (isset($_GET['site_id'])) {
  $colname_rsSite = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsModules1 = sprintf("SELECT * FROM site_modules WHERE site_id = %s", $colname_rsSite);
$rsModules1 = mysql_query($query_rsModules1, $conn) or die(mysql_error());
$row_rsModules1 = mysql_fetch_assoc($rsModules1);
$totalRows_rsModules1 = mysql_num_rows($rsModules1);

$ids = array();
if($totalRows_rsModules1) {
	do {
		$ids[] = $row_rsModules1['module_id'];
		$data['setting_category_type'][$row_rsModules1['module_id']] = $row_rsModules1['setting_category_type'];
	} while ($row_rsModules1 = mysql_fetch_assoc($rsModules1));
}
if($_POST['MM_Insert']==1) {
	
	$array1 = $ids;
	$array2 = $_POST['module_id'];
	if(!$array2) $array2 = array();
	$result = array_diff($array1, $array2);
	if($result) {
		foreach($result as $value) {
			$sql = "delete from site_modules WHERE `site_id` = '".$_POST['site_id']."' and `module_id` = '".$value."' and user_id = '".$_POST['user_id']."'";
			mysql_query($sql) or die('error '.__LINE__);
			$key = array_search($value, $ids); 			
			array_splice($ids, $key, 1);
		}
	}
	
	$result = array_diff($array2, $array1);
	if($result) {
		$sql = "insert into site_modules (`site_id`, `module_id`, `user_id`, `setting_category_type`) VALUES ";
		foreach($result as $k=>$value) {
			$sql .= "('".$_POST['site_id']."', '".$value."', '".$_POST['user_id']."', '".$_POST['setting_category_type'][$k]."'), ";
			array_push($ids, $value);
		}
		$sql = substr($sql, 0, -2);
		mysql_query($sql) or die('error '.__LINE__);
	}
	
	header("Location: install_type1_step3.php?site_id=".$_GET['site_id']);
	exit;
}
?>
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

mysql_select_db($database_conn, $conn);
$query_rsModules = "SELECT * FROM modules WHERE active = 1";
$rsModules = mysql_query($query_rsModules, $conn) or die(mysql_error());
$row_rsModules = mysql_fetch_assoc($rsModules);
$totalRows_rsModules = mysql_num_rows($rsModules);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<h1>Step 2: Modules Selection For Site &quot;<?php echo $row_rsSite['sitename']; ?>&quot;</h1>
<form id="form1" name="form1" method="post" action="">
<table border="0" cellspacing="1" cellpadding="5">
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><strong>Module Name </strong></td>
    <td valign="top"><strong>Charges</strong></td>
    <td valign="top"><strong>Charges Recurring Type </strong></td>
    <td valign="top"><strong>Category Type</strong> </td>
  </tr>
    <?php do { ?>
  <tr>
      <td valign="top"><input type="checkbox" name="module_id[<?php echo $row_rsModules['module_id']; ?>]" id="module_id_<?php echo $row_rsModules['module_id']; ?>" value="<?php echo $row_rsModules['module_id']; ?>" <?php if(in_array($row_rsModules['module_id'],$ids)) echo ' checked'; ?> /></td>
      <td valign="top"><?php echo $row_rsModules['module_name']; ?></td>
      <td valign="top">$ <?php echo number_format($row_rsModules['charges'],2); ?></td>
      <td valign="top"><?php echo $row_rsModules['charges_recurring_type']; ?></td>
      <td valign="top"><select name="setting_category_type[<?php echo $row_rsModules['module_id']; ?>]" id="setting_category_type_<?php echo $row_rsModules['module_id']; ?>">
        <option value="" <?php if (!(strcmp("", $data['setting_category_type'][$row_rsModules['module_id']]))) {echo "selected=\"selected\"";} ?>>Select</option>
        <option value="Single" <?php if (!(strcmp("Single", $data['setting_category_type'][$row_rsModules['module_id']]))) {echo "selected=\"selected\"";} ?>>Single</option>
        <option value="Multiple" <?php if (!(strcmp("Multiple", $data['setting_category_type'][$row_rsModules['module_id']]))) {echo "selected=\"selected\"";} ?>>Multiple</option>
        <option value="None" <?php if (!(strcmp("None", $data['setting_category_type'][$row_rsModules['module_id']]))) {echo "selected=\"selected\"";} ?>>None</option>
	  </select>&nbsp;</td>
  </tr> <?php } while ($row_rsModules = mysql_fetch_assoc($rsModules)); ?>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input type="submit" name="Submit" value="Go To Step 3" />
      <input name="site_id" type="hidden" id="site_id" value="<?php echo $row_rsSite['site_id']; ?>" />
      <input name="MM_Insert" type="hidden" id="MM_Insert" value="1" />
      <input name="user_id" type="hidden" id="user_id" value="1" /></td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
  
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsSite);

mysql_free_result($rsModules);
?>
