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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE sites SET template=%s, css=%s, js=%s WHERE site_id=%s",
                       GetSQLValueString($_POST['template'], "text"),
                       GetSQLValueString($_POST['css'], "text"),
                       GetSQLValueString($_POST['js'], "text"),
                       GetSQLValueString($_POST['site_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}
?>
<?php
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$body = explode("[[BODY]]", $_POST['template']);
	$head = stripslashes($body[0]);
	$foot = stripslashes($body[1]);
	$css = stripslashes($_POST['css']);
	$js = stripslashes($_POST['js']);
	$site_id = stripslashes($_POST['site_id']);
	@file_put_contents("includes/sitetemplate/".$site_id."_head.php", $head);
	@file_put_contents("includes/sitetemplate/".$site_id."_foot.php", $foot);
	@file_put_contents("includes/sitetemplate/".$site_id."_css.css", $css);
	@file_put_contents("includes/sitetemplate/".$site_id."_js.js", $js);
	
  $updateGoTo = "install_type1_step1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  exit;
}
?>
<?php
$colname_rsKeyword = "-1";
if (isset($_GET['site_id'])) {
  $colname_rsKeyword = (get_magic_quotes_gpc()) ? $_GET['site_id'] : addslashes($_GET['site_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsKeyword = sprintf("SELECT * FROM sites WHERE site_id = %s", $colname_rsKeyword);
$rsKeyword = mysql_query($query_rsKeyword, $conn) or die(mysql_error());
$row_rsKeyword = mysql_fetch_assoc($rsKeyword);
$totalRows_rsKeyword = mysql_num_rows($rsKeyword);

mysql_select_db($database_conn, $conn);
$query_rsTemplate = "SELECT tid, name FROM templates ORDER BY name ASC";
$rsTemplate = mysql_query($query_rsTemplate, $conn) or die(mysql_error());
$row_rsTemplate = mysql_fetch_assoc($rsTemplate);
$totalRows_rsTemplate = mysql_num_rows($rsTemplate);
?>
<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Template Management</title>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<script type="text/JavaScript">
<!--

function getXmlHttpRequestObject() { 
	if (window.XMLHttpRequest) { 
		return new XMLHttpRequest(); 
	} else if(window.ActiveXObject) { 
		return new ActiveXObject("Microsoft.XMLHTTP"); 
	} else { 
		alert('Status: Cound not create XmlHttpRequest Object. Consider upgrading your browser.'); 
	} 
} 
function copyTemplate(id) { 
	var Req = getXmlHttpRequestObject(); 
	document.getElementById('mes').innerHTML = "Loading ...";
	url = "getTemplate.php";
	getStr = "tid="+id;
	if (Req.readyState == 4 || Req.readyState == 0) {  
		Req.open("GET", url+"?"+getStr, true);  
		Req.onreadystatechange = function() { 
			if (Req.readyState == 4) {  
				var xmldoc = Req.responseXML; 
				if(xmldoc) { 
					var message_nodes = xmldoc.getElementsByTagName("message"); 
					var n_messages = message_nodes.length;
					for (i = 0; i < n_messages; i++) {
						var template_node = message_nodes[i].getElementsByTagName("template");
						var css_node = message_nodes[i].getElementsByTagName("css");
						var js_node = message_nodes[i].getElementsByTagName("js");
						document.form1.template.value = template_node[0].firstChild.nodeValue;
						document.form1.css.value = css_node[0].firstChild.nodeValue;
						document.form1.js.value = js_node[0].firstChild.nodeValue;
						document.getElementById('mes').innerHTML = "";
					}
				} 
			}  
		}  
		Req.send(null); 
	} 
}
//-->
</script>
</head>

<body>
<h1>Choosing Templates for &quot;<?php echo $row_rsKeyword['sitename']; ?>&quot;</h1>
<p><a href="install_type1_step1.php">Back to templates</a></p>
<form id="form1" name="form1" method="POST" action="">
  <table border="1" cellspacing="1" cellpadding="5">
    <tr>
      <td valign="top">PreTemplate</td>
      <td colspan="2" valign="top"><select name="pretemplate" id="pretemplate">
        <?php
do {  
?>
        <option value="<?php echo $row_rsTemplate['tid']?>"><?php echo $row_rsTemplate['name']?></option>
        <?php
} while ($row_rsTemplate = mysql_fetch_assoc($rsTemplate));
  $rows = mysql_num_rows($rsTemplate);
  if($rows > 0) {
      mysql_data_seek($rsTemplate, 0);
	  $row_rsTemplate = mysql_fetch_assoc($rsTemplate);
  }
?>
      </select>
        <a href="#" onclick="MM_openBrWindow('preview.php?tid='+document.form1.pretemplate.value,'preview','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=800,height=800')">Preview</a> | <a href="#" onclick="copyTemplate(document.form1.pretemplate.value)">Copy</a> | <a href="template.php" target="_blank">Template Management</a>
        <div id="mes"></div>	  </td>
    </tr>
    <tr>
      <td valign="top">Template</td>
      <td valign="top"><textarea name="template" cols="45" rows="10" id="template"><?php echo $row_rsKeyword['template']; ?></textarea></td>
      <td valign="top">Sperate Header and Footer Area by [[BODY]]<br />
      Content can be any html or php tags. Site url is called by &lt;?php echo HTTPPATH; ?&gt;. ID of the Site is called as: &lt;?php echo $ID; ?&gt; </td>
    </tr>
    <tr>
      <td valign="top">CSS</td>
      <td valign="top"><textarea name="css" cols="45" rows="10" id="css"><?php echo $row_rsKeyword['css']; ?></textarea></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">JS</td>
      <td valign="top"><textarea name="js" cols="45" rows="10" id="js"><?php echo $row_rsKeyword['js']; ?></textarea></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" valign="top"><p>
        <input type="submit" name="Submit" value="Update" />
        <input name="site_id" type="hidden" id="site_id" value="<?php echo $row_rsKeyword['site_id']; ?>" />
          </p>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsKeyword);

mysql_free_result($rsTemplate);
?>