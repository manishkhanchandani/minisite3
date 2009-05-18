<?php require_once('Connections/conn.php'); ?>
<?php
$colname_rsView = "-1";
if (isset($_GET['tid'])) {
  $colname_rsView = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);
}
mysql_select_db($database_conn, $conn);
$query_rsView = sprintf("SELECT * FROM templates WHERE tid = %s", $colname_rsView);
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);

header("Content-Type: text/xml; charset=utf-8");
$xml = '<?xml version="1.0" ?><root>';
if ($totalRows_rsView > 0) { // Show if recordset not empty 
	$xml .= '<message id="' . $id . '">';
	$xml .= '<template><![CDATA[' . $row_rsView['template'] . ']]></template>';
	$xml .= '<css><![CDATA[' . $row_rsView['css'] . ']]></css>';
	$xml .= '<js><![CDATA[' . $row_rsView['js'] . ']]></js>';
	$xml .= '</message>';
} // Show if recordset not empty 
$xml .= '</root>';
echo $xml;
exit;
mysql_free_result($rsView);
?>
