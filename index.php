<?php
ini_set('memory_limit','500M');
ini_set('max_execution_time','-1'); 
//error_reporting(0);
ob_start();
session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" ); 

if($_GET['ct']) {
	define('CACHETIME', $_GET['ct']); // seconds
} else {
	define('CACHETIME', 300); // seconds
}

// set cookie
if($_GET['rn']) {
	setcookie('rn', $_GET['rn'], time()+(60*60*24*365), "/");
}

// ini settings
if ( ! defined( "PATH_SEPARATOR" ) ) {
  if ( strpos( $_ENV[ "OS" ], "Win" ) !== false )
    define( "PATH_SEPARATOR", ";" );
  else define( "PATH_SEPARATOR", ":" );
}
ini_set("include_path", ini_get('include_path').PATH_SEPARATOR."Connections/".PATH_SEPARATOR."includes/pear/");

// put full path to Smarty.class.php
require('includes/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = 'tpls';
$smarty->compile_dir = 'tpls_c';
$smarty->cache_dir = 'tpls_cache';
$smarty->config_dir = 'tpls_conf';
if($_SERVER['HTTP_HOST']=="localhost") {
	$smarty->force_compile = true;
}

// adodb connection
include('includes/adodb/adodb-exceptions.inc.php'); # load code common to ADOdb
include('includes/adodb/adodb.inc.php'); # load code common to ADOdb 

$ADODB_CACHE_DIR = 'ADODB_cache'; 
//$dbFrameWork = &ADONewConnection('mysql');  # create a connection 
//$dbFrameWork->Connect('remote-mysql3.servage.net','framework2008','framework2008','framework2008');# connect to MySQL, framework db
try { 
	include_once('Connections/connection.php');
	$dbFrameWork = &ADONewConnection('mysql');  # create a connection 
	$dbFrameWork->Connect($hostname_conn,$username_conn,$password_conn,$database_conn);# connect to MySQL, framework db
} catch (exception $e) { 
	ob_end_clean();
	echo 'Loading in 5 seconds. If page does not refresh in 5 seconds, please refresh manually.<meta http-equiv="refresh" content="5">';
	//echo "<pre>";var_dump($e); adodb_backtrace($e->gettrace());
	exit;
} 

include_once('Classes/Common.php');
$Common = new Common($dbFrameWork);
$ID = $_GET['ID'];
if(!$ID) {
	$sites = $Common->getSiteDetails();
	$ID = $sites['sites']['site_id'];
} else {
	$sites = $Common->getSiteDetails($ID);
}
define('ADMINEMAIL', $sites['sites']['siteemail']); 
define('ADMINNAME', 'Administrator'); 
define('ID', $ID);
define('HTTPPATH', $sites['sites']['url']);
define('DOCPATH', $sites['sites']['docpath']);
$smarty->assign('ID', $ID);
$smarty->assign('globalSiteDetails', $GLOBALS['sitedetails']);
$smarty->assign('HTTPPATH', HTTPPATH);
$smarty->assign('DOCPATH', DOCPATH);
$smarty->assign('CACHETIME', CACHETIME);
$smarty->assign('SITENAME', $sites['sites']['sitename']);
$smarty->assign('SITEURL', $sites['sites']['url']);
$smarty->assign('SITEEMAIL', $sites['sites']['siteemail']);
$smarty->assign('ADMINEMAIL', ADMINEMAIL);
$smarty->assign('ADMINNAME', ADMINNAME);

/*
function __autoload($classname) {
	include(DOCPATH."/Classes/{$classname}.php");
}
spl_autoload_register('spl_autoload');
if (function_exists('__autoload')) {
	spl_autoload_register('__autoload');
}
*/
if($_GET['p']) $p = $_GET['p'].".php";
if(!$p) {
	$p = "home.php";
}
if($_GET['MID']) {
	$MIDDetails = $GLOBALS['sitedetails']['modules'][$_GET['MID']];
	if(!$MIDDetails) {
		$p = "error.php";
	}
	$menuItems = json_decode($MIDDetails['pages']);
	if($_GET['pg']) {
		$p = $MIDDetails['ref']."/".$menuItems->$_GET['pg'].".php";
	} else {
		$p = $MIDDetails['ref']."/index.php";
	}
	$MID = $_GET['MID'];
	define('MID', $MID);
	$pg = $_GET['pg'];
	define('pg', $pg);
	$smarty->assign('MID', $_GET['MID']);
	$smarty->assign('pg', $_GET['pg']);
	$smarty->assign('MIDDetails', $MIDDetails);
} 
if(!file_exists($p)) $p = "filenotfound.php";

include_once($p);

if(!$body) $body = "Content Will be Displayed Here.";
if(!$PAGEHEADING) $PAGEHEADING = "Welcome to ".$sites['sites']['sitename'];
$smarty->assign('PAGEHEADING', $PAGEHEADING);
/*
ob_start();
include("includes/sitetemplate/".$ID."_head.php");
$head = ob_get_clean();
ob_start();
include("includes/sitetemplate/".$ID."_foot.php");
$foot = ob_get_clean();
ob_flush();
$smarty->assign('HEAD', $head);
$smarty->assign('FOOT', $foot);
*/
$header = $smarty->fetch("header.html");
$footer = $smarty->fetch("footer.html");
echo $header.$body.$footer;

//echo "<pre>";
//echo "<hr>";
//print_r($GLOBALS['sitedetails']);
//print_r($GLOBALS['sitedetails']['modules'][$_GET['MID']]);
//echo "</pre>";
//echo "<hr>";
?>