<?php require_once('Connections/conn.php'); ?>
<?php
if(!$_COOKIE['id']) {
	header("Location: index.php");
	exit;
}
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Report = 25;
$pageNum_Report = 0;
if (isset($_GET['pageNum_Report'])) {
  $pageNum_Report = $_GET['pageNum_Report'];
}
$startRow_Report = $pageNum_Report * $maxRows_Report;

$colid_Report = "-1";
if (isset($_COOKIE['id'])) {
  $colid_Report = (get_magic_quotes_gpc()) ? $_COOKIE['id'] : addslashes($_COOKIE['id']);
}
$colname_Report = "-1";
if (isset($_GET['site_id'])) {
  $colname_Report = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_Report = sprintf("SELECT * FROM traffic_stats WHERE traffic_stats.site_id = %s AND traffic_stats.id = '%s' ORDER BY traffic_stats.sid DESC", $colname_Report,$colid_Report);
$query_limit_Report = sprintf("%s LIMIT %d, %d", $query_Report, $startRow_Report, $maxRows_Report);
$Report = mysql_query($query_limit_Report, $conn) or die(mysql_error());
$row_Report = mysql_fetch_assoc($Report);

if (isset($_GET['totalRows_Report'])) {
  $totalRows_Report = $_GET['totalRows_Report'];
} else {
  $all_Report = mysql_query($query_Report);
  $totalRows_Report = mysql_num_rows($all_Report);
}
$totalPages_Report = ceil($totalRows_Report/$maxRows_Report)-1;

$colid_Site = "-1";
if (isset($_COOKIE['id'])) {
  $colid_Site = (get_magic_quotes_gpc()) ? $_COOKIE['id'] : addslashes($_COOKIE['id']);
}
$colname_Site = "-1";
if (isset($_GET['site_id'])) {
  $colname_Site = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_Site = sprintf("SELECT * FROM traffic_sites WHERE site_id = %s AND traffic_sites.id = '%s'", $colname_Site,$colid_Site);
$Site = mysql_query($query_Site, $conn) or die(mysql_error());
$row_Site = mysql_fetch_assoc($Site);
$totalRows_Site = mysql_num_rows($Site);

$queryString_Report = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Report") == false && 
        stristr($param, "totalRows_Report") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Report = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Report = sprintf("&totalRows_Report=%d%s", $totalRows_Report, $queryString_Report);
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
        <td><h3>Reports For Site <?php echo $row_Site['sitename']; ?></h3>
          <p><a href="mysites.php">Back</a></p>
          <?php if ($totalRows_Report > 0) { // Show if recordset not empty ?>
          <p> Records <?php echo ($startRow_Report + 1) ?> to <?php echo min($startRow_Report + $maxRows_Report, $totalRows_Report) ?> of <?php echo $totalRows_Report ?>
          <table border="0" width="50%" align="center">
              <tr>
                <td width="23%" align="center"><?php if ($pageNum_Report > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Report=%d%s", $currentPage, 0, $queryString_Report); ?>">First</a>
                  <?php } // Show if not first page ?>
                                </td>
                <td width="31%" align="center"><?php if ($pageNum_Report > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Report=%d%s", $currentPage, max(0, $pageNum_Report - 1), $queryString_Report); ?>">Previous</a>
                  <?php } // Show if not first page ?>
                                </td>
                <td width="23%" align="center"><?php if ($pageNum_Report < $totalPages_Report) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Report=%d%s", $currentPage, min($totalPages_Report, $pageNum_Report + 1), $queryString_Report); ?>">Next</a>
                  <?php } // Show if not last page ?>
                                </td>
                <td width="23%" align="center"><?php if ($pageNum_Report < $totalPages_Report) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Report=%d%s", $currentPage, $totalPages_Report, $queryString_Report); ?>">Last</a>
                  <?php } // Show if not last page ?>
                                </td>
              </tr>
                    </table>
          </p>
          <table border="1">
              <tr>
                <td><strong>Page Visited </strong></td>
                <td><strong>Referred By </strong></td>
                <td><strong>Date</strong></td>
                <td><strong>IP</strong></td>
              </tr>
              <?php do { ?>
              <tr>
                <td><a href="<?php echo $row_Report['page_url']; ?>" target="_blank" title="<?php echo $row_Report['page_url']; ?>"><?php echo substr($row_Report['page_url'],0,50)."..."; ?></a></td>
                <td><a href="<?php echo $row_Report['referrer']; ?>" target="_blank" title="<?php echo $row_Report['referrer']; ?>"><?php echo substr($row_Report['referrer'],0,50)."..."; ?></a></td>
                <td><?php echo $row_Report['cdate']; ?></td>
                <td><?php echo $row_Report['ip']; ?></td>
              </tr>
              <?php } while ($row_Report = mysql_fetch_assoc($Report)); ?>
                    </table>
          <?php } // Show if recordset not empty ?>
          <?php if ($totalRows_Report == 0) { // Show if recordset empty ?>
          <p>No Report Found. </p>
          <?php } // Show if recordset empty ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Report);

mysql_free_result($Site);

mysql_close();
?>
