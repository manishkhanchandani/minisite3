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

$colname_rsModules = "-1";
if (isset($_GET['site_id'])) {
  $colname_rsModules = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsModules = sprintf("SELECT * FROM site_modules as a LEFT JOIN modules as m ON a.module_id = m.module_id WHERE a.site_id = %s", $colname_rsModules);
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
<h1>Payment Details For Site &quot;<?php echo $row_rsSite['sitename']; ?>&quot; </h1>
  <table border="1" cellspacing="1" cellpadding="5">
    <tr>
      <td><strong>Module Name </strong></td>
      <td><strong>Charges</strong></td>
      <td><strong>Recurring Type </strong></td>
    </tr>
      <?php do { ?>
    <tr>
        <td><?php echo $row_rsModules['module_name']; ?></td>
        <td>$ <?php echo number_format($row_rsModules['charges'],2); $ch += $row_rsModules['charges']; ?></td>
        <td>Monthly</td>
      </tr><?php } while ($row_rsModules = mysql_fetch_assoc($rsModules)); ?>
    <tr>
      <td>&nbsp;</td>
      <td>Free for the first 15 days
        <br />
      Then $<?php echo number_format($ch,2); ?> USD for each month&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
<p><strong>Note: 15 Days Free Trial. We charge you after 15 days. You can cancel anytime before 15 days and you wont be charged.</strong></p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_xclick-subscriptions" />
  <input type="hidden" name="bn" value="webassist.dreamweaver.4_5_0" />
  <input type="hidden" name="business" value="mkgxy@mkgalaxy.com" />
  <input type="hidden" name="item_name" value="Subscription to Ready Site Maker" />
  <input type="hidden" name="item_number" value="<?php echo $row_rsSite['site_id']; ?>" />
  <input type="hidden" name="custom" value="1">
  <input type="hidden" name="currency_code" value="USD" />
  <input type="hidden" name="a1" value="0.00" />
  <input type="hidden" name="p1" value="15" />
  <input type="hidden" name="t1" value="D" />
  <input type="hidden" name="a3" value="<?php echo number_format($ch,2); ?>" />
  <input type="hidden" name="p3" value="1" />
  <input type="hidden" name="t3" value="M" />
  <input type="hidden" name="return" value="<?php echo $row_rsSite['siteurl']; ?>/install_type1_step_success.php" />
  <input type="hidden" name="cancel_return" value="<?php echo $row_rsSite['siteurl']; ?>/install_type1_step_failure.php" />
  <input type="hidden" name="notify_url" value="<?php echo $row_rsSite['siteurl']; ?>/install_type1_step_ipn.php">
  <input type="hidden" name="src" value="1" />
  <input type="hidden" name="sra" value="1" />
  <input type="hidden" name="receiver_email" value="mkgxy@mkgalaxy.com" />
  <input type="hidden" name="mrb" value="R-3WH47588B4505740X" />
  <input type="hidden" name="pal" value="ANNSXSLJLYR2A" />
  <input type="hidden" name="no_shipping" value="1" />
  <input type="hidden" name="no_note" value="1" />	  
  <input type="image" name="submit" src="http://images.paypal.com/images/x-click-but20.gif" border="0" alt="Make payments with PayPal, it's fast, free, and secure!" />
</form>
</body>
</html>
<?php
mysql_free_result($rsSite);

mysql_free_result($rsModules);
?>
