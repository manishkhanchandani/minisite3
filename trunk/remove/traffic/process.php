<?php require_once('Connections/conn.php'); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
		
$colname_Site = "-1";
if (isset($_GET['site_id'])) {
  $colname_Site = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_Site = sprintf("SELECT * FROM traffic_sites WHERE site_id = %s", $colname_Site);
$Site = mysql_query($query_Site, $conn) or die(mysql_error());
$row_Site = mysql_fetch_assoc($Site);
$totalRows_Site = mysql_num_rows($Site);
?>
<?php
if($totalRows_Site > 0) {
$query = "INSERT INTO `traffic_stats` ( `id` , `site_id` , `page_url` , `referrer` , `cdate` , `ctime` , `cday` , `cmonth` , `cyear` , `ip` ) VALUES ('".$row_Site['id']."', '".$row_Site['site_id']."', '".addslashes(stripslashes(trim($_GET['page'])))."', '".addslashes(stripslashes(trim($_GET['ref'])))."', '".date('Y-m-d H:i:s')."', '".time()."', '".date('d')."', '".date('m')."', '".date('Y')."', '".$_SERVER['REMOTE_ADDR']."')";
mysql_query($query) or die('error');
}
/*
$filename = "spacer.gif";
$size = getimagesize($filename);
$fp=fopen($filename, "rb");
if ($size && $fp) {
  header("Content-type: {$size['mime']}");
  fpassthru($fp);
  exit;
} else {
  // error
}
*/
?>
<?php
mysql_free_result($Site);
?>