<?php
$ADODB_CACHE_DIR = '../ADODB_cache'; 
?>
<!-- #BeginLibraryItem "/Library/config.lbi" -->
<?php
// adodb connection
include('../includes/adodb/adodb-exceptions.inc.php'); # load code common to ADOdb
include('../includes/adodb/adodb.inc.php'); # load code common to ADOdb 
try { 
	include_once('../Connections/connection.php');
	$dbFrameWork = &ADONewConnection('mysql');  # create a connection 
	$dbFrameWork->Connect($hostname_conn,$username_conn,$password_conn,$database_conn);# connect to MySQL, framework db
} catch (exception $e) { 
	ob_end_clean();
	echo 'Loading in 15 seconds. If page does not refresh in 5 seconds, please refresh manually.<meta http-equiv="refresh" content="15">';
	exit;
} 

function __autoload($classname) {
	include("../Classes/{$classname}.php");
}
spl_autoload_register('spl_autoload');
if (function_exists('__autoload')) {
	spl_autoload_register('__autoload');
}
$Common = new Common($dbFrameWork);
?>
<!-- #EndLibraryItem -->
<?php
class Location {
	private $cacheSecs = -300;
	private static $instance;
	
	public function __construct($dbFrameWork, $Common) {
		if(self::$instance) {
			return self::$instance;
		} else {
			self::$instance = $this;
			$this->dbFrameWork = $dbFrameWork;
			$this->Common = $Common;
		}
	}
	
	public function getLocationSelBox($params=array()) {
		$selbox = "<div class=\"country\"><span class=\"countryLabel\">Country:</span> <span class=\"countryValue\"><select name=\"country_id\" id=\"country_id\" onchange=\"doAjaxXMLSelectBox('getProvince.php','GET','country_id='+this.value,'',document.form1.province_id);//removeAllOptions(city);\"><option value=\"0\">Select</option>";
		$sql = "select * from geo_countries order by name";
		$countrys = $this->Common->selectCacheRecord($sql);
		if($countrys) {
			foreach($countrys as $v) {
				$countryId = $v['con_id'];
				$country = $v['name'];
				$selbox .= "<option value=\"".$countryId."\">".$country."</option>";
			}
		}
		$selbox .= "</select></span></div>";
		$selbox .= $seperator;
		$selbox .= "
";
		$selbox .= "<div class=\"province\"><span class=\"provinceLabel\">Province:</span> <span class=\"provinceValue\"><select name=\"province_id\" id=\"province_id\" onchange=\"doAjaxXMLSelectBox('getCity.php','GET','country_id='+document.form1.country_id.value+'&province_id='+this.value,'',document.form1.city);\"><option value=\"0\">Select</option>";
		$selbox .= "</select></span></div>";
		$selbox .= $seperator;
		$selbox .= '';
		echo $selbox;
	}
}
$Location = new Location($dbFrameWork, $Common);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
echo "<form name='form1'>";
$Location->getLocationSelBox();
echo "</form>";
?>
<script language="javascript" src="../js/script.js"></script>
</body>
</html>