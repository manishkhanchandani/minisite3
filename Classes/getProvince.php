<?php require_once('../Connections/conn.php'); ?>
<?php 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=utf-8"); 
?>
<?php
$colname_rsProvince = "-1";
if (isset($_GET['country_id'])) {
  $colname_rsProvince = (get_magic_quotes_gpc()) ? $_GET['country_id'] : addslashes($_GET['country_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsProvince = sprintf("SELECT * FROM geo_states WHERE con_id = %s", $colname_rsProvince);
$rsProvince = mysql_query($query_rsProvince, $conn) or die(mysql_error());
$row_rsProvince = mysql_fetch_assoc($rsProvince);
$totalRows_rsProvince = mysql_num_rows($rsProvince);
?>
<?php
$xml = '<?xml version="1.0" encoding="utf-8" ?>
<root>'; 
if($totalRows_rsProvince) {
	do { 
		$id = $row_rsProvince['sta_id'];
		$xml .= '<message id="' . $row_rsProvince['sta_id'] . '">'; 
		$xml .= '<id>' . $row_rsProvince['sta_id'] . '</id>';
		$xml .= '<name>' . htmlspecialchars($row_rsProvince['name']) . '</name>'; 
		$xml .= '</message>'; 
	} while ($row_rsProvince = mysql_fetch_assoc($rsProvince)); 
}
$xml .= '</root>'; 
echo $xml; 
?>
<?php
mysql_free_result($rsProvince);
?>