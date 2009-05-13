<?php require_once('../Connections/conn.php'); ?>
<?php 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=utf-8"); 
?>
<?php
$colname_rsCity = "-1";
if (isset($_GET['province_id'])) {
  $colname_rsCity = (get_magic_quotes_gpc()) ? $_GET['province_id'] : addslashes($_GET['province_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsCity = sprintf("SELECT * FROM geo_cities WHERE sta_id = %s ORDER BY name ASC", $colname_rsCity);
$rsCity = mysql_query($query_rsCity, $conn) or die(mysql_error());
$row_rsCity = mysql_fetch_assoc($rsCity);
$totalRows_rsCity = mysql_num_rows($rsCity);
?>
<?php
$xml = '<?xml version="1.0" encoding="utf-8" ?>
<root>'; 
if($totalRows_rsCity) {
	do { 
		$id = $row_rsCity['cty_id'];
		$xml .= '<message id="' . $row_rsCity['cty_id'] . '">'; 
		$xml .= '<id>' . $row_rsCity['cty_id'] . '</id>';
		$xml .= '<name>' . htmlspecialchars($row_rsCity['name']) . '</name>'; 
		$xml .= '</message>'; 
	} while ($row_rsCity = mysql_fetch_assoc($rsCity)); 
}
$xml .= '</root>'; 
echo $xml; 
?>
<?php
mysql_free_result($rsCity);
?>