<?php
class Common {

	public $cacheSecs = CACHETIME;
	private static $instance;
	
	function __construct($dbFrameWork) {
		if(self::$instance) {
			return self::$instance;
		} else {
			self::$instance = $this;
			$this->dbFrameWork = $dbFrameWork;
		}
	}
	
	public function phpinsert($table_name, $pk, $record) {
		$sql = "SELECT * FROM $table_name WHERE $pk = -1";  
		# Select an empty record from the database 
		$rs = $this->dbFrameWork->Execute($sql); # Execute the query and get the empty recordset 
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		# Pass the empty recordset and the array containing the data to insert 
		# into the GetInsertSQL function. The function will process the data and return 
		# a fully formatted insert sql statement. 
		$insertSQL = $this->dbFrameWork->GetInsertSQL($rs, $record);
		$this->dbFrameWork->Execute($insertSQL); 
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$uid = $this->dbFrameWork->Insert_ID();
		return $uid;
	}
	
	public function phpedit($table_name, $pk, $record, $uid) {
		$sql = "SELECT * FROM `$table_name` WHERE `$pk` = $uid";  
		# Select a record to update 
		$rs = $this->dbFrameWork->Execute($sql); // Execute the query and get the existing record to update 
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		# Pass the single record recordset and the array containing the data to update 
		# into the GetUpdateSQL function. The function will process the data and return 
		# a fully formatted update sql statement with the correct WHERE clause. 
		# If the data has not changed, no recordset is returned 

		$updateSQL = $this->dbFrameWork->GetUpdateSQL($rs, $record); # Update the record in the database
		if($updateSQL) {
			$return = $this->dbFrameWork->Execute($updateSQL); 
			if($this->dbFrameWork->ErrorMsg()) {
				throw new Exception($this->dbFrameWork->ErrorMsg());
			}		
		}
	}
	public function selectCount($sql) {
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$arr = $rs->FetchRow();
		$cnt = $arr['cnt'];
		return $cnt;
	}
	
	public function selectCacheCount($sql) {
		$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$arr = $rs->FetchRow();
		$cnt = $arr['cnt'];
		return $cnt;
	}
	
	public function selectRecord($sql) {
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			$return[] = $arr;
		}
		return $return;
	}
	
	public function selectRecordFull($sql, $sqlCnt) {
		$rs = $this->dbFrameWork->Execute($sqlCnt);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$arr = $rs->FetchRow();
		$return['totalRows'] = $arr['cnt'];
		
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			$return['record'][] = $arr;
		}
		return $return;
	}
	
	public function selectLimitRecord($sql,$max=10,$start=0) {
		$rs = $this->dbFrameWork->SelectLimit($sql, $max, $start);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			$return[] = $arr;
		}
		return $return;
	}
	
	public function selectLimitRecordFull($sql, $sqlCnt, $max=10, $start=0) {
		$rs = $this->dbFrameWork->Execute($sqlCnt);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$arr = $rs->FetchRow();
		$return['totalRows'] = $arr['cnt'];
		
		if($return['totalRows']>0) {
			$rs = $this->dbFrameWork->SelectLimit($sql, $max, $start);
			if($this->dbFrameWork->ErrorMsg()) {
				throw new Exception($this->dbFrameWork->ErrorMsg());
			}
			while ($arr = $rs->FetchRow()) { 
				$return['record'][] = $arr;
			}
		}		
		return $return;
	}
	
	public function selectCacheRecord($sql) {
		$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			$return[] = $arr;
		}
		return $return;
	}
	
	public function selectCacheLimitRecord($sql, $max=10, $start=0) {
		$rs = $this->dbFrameWork->CacheSelectLimit($this->cacheSecs, $sql, $max, $start);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			$return[] = $arr;
		}
		return $return;
	}
	public function selectCacheLimitRecordFull($sql, $sqlCnt, $max=10, $start=0) {
		$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sqlCnt);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$arr = $rs->FetchRow();
		$return['totalRows'] = $arr['cnt'];
		if($return['totalRows']>0) {
			$rs = $this->dbFrameWork->CacheSelectLimit($this->cacheSecs, $sql, $max, $start);
			if($this->dbFrameWork->ErrorMsg()) {
				throw new Exception($this->dbFrameWork->ErrorMsg());
			}
			while ($arr = $rs->FetchRow()) { 
				$return['record'][] = $arr;
			}
		}
		return $return;
	}
		
	public function deleteRecord($table_name, $pk, $uid) {
		$sql = "DELETE FROM `$table_name` WHERE `$pk` = $uid";  
		# Select a record to update 
		$rs = $this->dbFrameWork->Execute($sql); // Execute the query and get the existing record to update 
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->db->ErrorMsg());
		}
		return true;
	}

	public function query($sql) {
		$rs = $this->dbFrameWork->Execute($sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->db->ErrorMsg());
		}
		return $rs;
	}
	
	public function emailvalidity($email) {
		if (eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $email)) {
			// this is a valid email domain!
			return 1;
		}
		return 0;
	}
	
	public function emailSimple($to,$subject,$message,$headers) {
		if(@mail($to, $subject, $message, $headers)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function emailHTML($to,$subject,$message,$additional) {
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $additional;
		if(@mail($to, $subject, $message, $headers)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function make_url_lookup($input) {
		$input = trim($input);
		$url_lookup = strip_tags($input);
		$url_lookup = str_replace(" ", "-", $url_lookup);
		$url_lookup = str_replace("&amp", "and", $url_lookup);
		$url_lookup = ereg_replace("[^a-zA-Z0-9]+", "-", $url_lookup);
		$url_lookup = ereg_replace("-+$", "", $url_lookup);
		$url_lookup = strtolower($url_lookup);
		return $url_lookup;
	}
			
	public function pagination($pageNum, $max, $totalRows, $divtag) {
		// pagination has to include include('../Classes/PaginateIt.php'); where it is called.
		// pagination			
		$PaginateIt = new PaginateIt();
		$PaginateIt->SetDivTag($divtag);
		$PaginateIt->SetCurrentPage(($pageNum+1));
		$PaginateIt->SetItemsPerPage($max);
		$PaginateIt->SetItemCount($totalRows);
		$paginate = $PaginateIt->GetPageLinksComplete();
		return $paginate;
	}
	
	
	public function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")  {
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
	
	public function editFormAction() {
		$editFormAction = $_SERVER['PHP_SELF'];
		if (isset($_SERVER['QUERY_STRING'])) {
		  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
		}
		return $editFormAction;
	}
	
	// thumbnail
	public function getThumbnailSize($ex_width, $ex_height, $maxheight=80, $maxwidth=80) {
		if($ex_width >= $ex_height){  
			if($ex_width > $maxwidth){   
				$ds_width_ex  = $maxwidth;   
				$ratio_ex     = $ex_width / $ds_width_ex;  
				$ds_height_ex = $ex_height / $ratio_ex;
				$ds_height_ex = round($ds_height_ex);  
				if($ds_height_ex > $maxheight)
					$ds_height_ex = $maxheight;    
			} else {   
				$ds_width_ex  = $ex_width;
				$ds_height_ex = $ex_height;   
				if($ds_height_ex > $maxheight)
					$ds_height_ex = $maxheight;    
			}  
		} else if($ex_width < $ex_height){  
			if($ex_height > $maxheight){  
				$ds_height_ex = $maxheight;
				$ratio_ex     = $ex_height / $ds_height_ex;
				$ds_width_ex  = $ex_width / $ratio_ex;
				$ds_width_ex  = round($ds_width_ex);  
				if($ds_width_ex > $maxwidth)
					$ds_width_ex = $maxwidth;   
			} else {   
				$ds_width_ex  = $ex_width;
				$ds_height_ex = $ex_height; 
				if($ds_width_ex > $maxwidth)
					$ds_width_ex = $maxwidth;   
			}  
		}  
		$size['width'] = $ds_width_ex;
		$size['height'] = $ds_height_ex;
		return $size;
	}
	public function buildThumbnail($url, $maxheight, $maxwidth, $format, $dest) {
		$format = strtolower($format);
		list($ex_width, $ex_height) = getimagesize($url);
		$size = $this->getThumbnailSize($ex_width, $ex_height, $maxheight, $maxwidth);
	
		// create a black image
		$image_p = @imagecreatetruecolor($size['width'], $size['height']);
		// create white background
		$background = @imagecolorallocate($image_p, 255, 255, 255);
		// create rectangle with backgournd white
		@imagefilledrectangle($image_p, 0, 0, $size['width'], $size['height'], $background);
	
		if($format=="png") {
			$image = @imagecreatefrompng($url);
		} else if($format=="jpg") {
			$image = @imagecreatefromjpeg($url);	
		} else if($format=="gif") {
			$image = @imagecreatefromgif($url);	
		}
	
		@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['width'], $size['height'], $ex_width, $ex_height);
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($image_p, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($image_p, $dest);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($image_p, $dest);
		}
		@imagedestroy($image_p);
	}
	public function buildThumbnailWithoutResize($url, $maxheight, $maxwidth, $format, $dest) {
		$format = strtolower($format);
		list($ex_width, $ex_height) = getimagesize($url);
		//$size = $this->getThumbnailSize($ex_width, $ex_height, $maxheight, $maxwidth);
		$size['width'] = $maxwidth;
		$size['height'] = $maxheight;
		// create a black image
		$image_p = @imagecreatetruecolor($size['width'], $size['height']);
		// create white background
		$background = @imagecolorallocate($image_p, 255, 255, 255);
		// create rectangle with backgournd white
		imagefilledrectangle($image_p, 0, 0, $size['width'], $size['height'], $background);
	
		if($format=="png") {
			$image = @imagecreatefrompng($url);
		} else if($format=="jpg") {
			$image = @imagecreatefromjpeg($url);	
		} else if($format=="gif") {
			$image = @imagecreatefromgif($url);	
		}
	
		@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['width'], $size['height'], $ex_width, $ex_height);
		if($format=="png") {
			//header('Content-Type: image/png');
			@imagepng($image_p, $dest);
		} else if($format=="jpg") {
			//header('Content-Type: image/jpeg');
			@imagejpeg($image_p, $dest);
		} else if($format=="gif") {
			//header('Content-Type: image/gif');
			@imagegif($image_p, $dest);
		}
		@imagedestroy($image_p);
	}
	public function getMenu($concept) {
		ob_start();
		include(DOCPATH."/includes/menu/".$concept.".php");
		$string = ob_get_clean();
		return $string;
	}
	public function validate($post, $validate) {
		if($validate) {
			foreach($validate as $valid) {
				if($valid['type']=="isreq") {
					if(!trim($post[$valid['field']])) {
						throw new Exception($valid['error']);
					}
				}
			}
		}
		return true;
	}
	public function getCountrySelBoxName($sel='') {
		$sql = "select * from geo_countries order by name";
		$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			$selbox .= "<option value='".$arr['name']."'";
			if($sel==$arr['name']) {
				$selbox .= " selected";
			}
			$selbox .= ">".$arr['name']."</option>
			";
		}
		return $selbox;
	}
	public function getCountrySelBoxID($sel='') {
		$sql = "select * from geo_countries order by name";
		$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			$selbox .= "<option value='".$arr['con_id']."'";
			if($sel==$arr['con_id']) {
				$selbox .= " selected";
			}
			$selbox .= ">".$arr['name']."</option>
			";
		}
		return $selbox;
	}
	
	public function getNewForm($site_id, $module_id, $post) {
		$sql = "select * from fields where site_id = '".$site_id."' and module_id = '".$module_id."'";
		$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		while ($arr = $rs->FetchRow()) { 
			switch($arr['field_type']) {
				case 'text':
					if($post[$arr['field_name']]) {
						$sel = $post[$arr['field_name']];
					} else {
						$sel = $arr['field_default_selected'];
					}
					$return['records'][$arr['field_id']]['label'] = $arr['field_label'];
					$return['records'][$arr['field_id']]['id'] = $arr['field_id'];
					$return['records'][$arr['field_id']]['name'] = $arr['field_name'];
					$return['records'][$arr['field_id']]['value'] = "<input type=\"text\" name=\"".$arr['field_name']."\" id=\"".$arr['field_name']."_".$arr['field_id']."\" value=\"".$sel."\" />";
					break;
				case 'textarea':
					if($post[$arr['field_name']]) {
						$sel = $post[$arr['field_name']];
					} else {
						$sel = $arr['field_default_selected'];
					}
					$return['records'][$arr['field_id']]['label'] = $arr['field_label'];
					$return['records'][$arr['field_id']]['id'] = $arr['field_id'];
					$return['records'][$arr['field_id']]['name'] = $arr['field_name'];
					$return['records'][$arr['field_id']]['value'] = "<textarea name=\"".$arr['field_name']."\" id=\"".$arr['field_name']."_".$arr['field_id']."\">".$sel."</textarea>";
					break;
				case 'rtextarea':
					if($post[$arr['field_name']]) {
						$sel = $post[$arr['field_name']];
					} else {
						$sel = $arr['field_default_selected'];
					}
					$return['records'][$arr['field_id']]['label'] = $arr['field_label'];
					$return['records'][$arr['field_id']]['id'] = $arr['field_id'];
					$return['records'][$arr['field_id']]['name'] = $arr['field_name'];
					$return['records'][$arr['field_id']]['value'] = "<textarea name=\"".$arr['field_name']."\" id=\"".$arr['field_name']."_".$arr['field_id']."\" rows=\"4\" cols=\"40\">".$sel."</textarea>";
					break;
			}
		}
		return $return;
	}
	public function getSiteDetails($site_id='') {
		if($site_id) {
			$sql = "select * from sites where site_id = '".$site_id."'";
		} else {
			$host = str_replace("www.","",$_SERVER['HTTP_HOST']);
			$sql = "select * from sites where siteurl  = '".$host."'";
		}
		$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sql);
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->dbFrameWork->ErrorMsg());
		}
		$arr = array();
		if($rs->RecordCount()>0) {
			$arr['sites'] = $rs->FetchRow();
			$site_id = $arr['sites']['site_id'];
			$arr['sites']['url'] = $arr['sites']['sitebaseurl'].$arr['sites']['siteurl'].$arr['sites']['sitepath'];
			define('site_id', $arr['sites']['site_id']);
			define('sitename', $arr['sites']['sitename']);
			define('sitebaseurl', $arr['sites']['sitebaseurl']);
			define('sitepath', $arr['sites']['sitepath']);
			define('siteurl', $arr['sites']['url']);
			define('url', $arr['sites']['url']);
			define('siteemail', $arr['sites']['siteemail']);
			define('docpath', $arr['sites']['docpath']);
			
			$sql = "select * from site_modules as a LEFT JOIN modules as m ON a.module_id = m.module_id where a.site_id = '".$site_id."' and m.active = 1";
			$rs = $this->dbFrameWork->CacheExecute($this->cacheSecs, $sql);
			if($this->dbFrameWork->ErrorMsg()) {
				throw new Exception($this->dbFrameWork->ErrorMsg());
			}
			while($rec = $rs->FetchRow()) {
				$arr['modules'][$rec['module_id']] = $rec;
			}
			$GLOBALS['sitedetails'] = $arr;
		}
		return $arr;
	}
	
	public function restrictAccess($user_id, $user_group) {
		// restrict access logic
		$MM_authorizedUsers = "";
		$MM_donotCheckaccess = "true";

		$MM_restrictGoTo = "index.php?p=users/login";
		if (!((isset($user_id)) && ($this->isAuthorized("",$MM_authorizedUsers, $user_id, $user_group)))) {   
		  $MM_qsChar = "?";
		  $MM_referrer = $_SERVER['PHP_SELF'];
		  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
		  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
		  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
		  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
		  header("Location: ".$MM_restrictGoTo);
		  exit;
		}
		
		return false;
	}
	
	public function restrictAdminAccess($user_id, $user_group) {
		$MM_authorizedUsers = "Admin";
		$MM_donotCheckaccess = "false";

		$MM_restrictGoTo = "index.php?p=users/login";
		if (!((isset($user_id)) && ($this->isAuthorized("",$MM_authorizedUsers, $user_id, $user_group)))) {   
		  $MM_qsChar = "?";
		  $MM_referrer = $_SERVER['PHP_SELF'];
		  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
		  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
		  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
		  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
		  header("Location: ".$MM_restrictGoTo);
		  exit;
		}
		
		return false;
	}
	// *** Restrict Access To Page: Grant or deny access to this page
	public function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
	  // For security, start by assuming the visitor is NOT authorized. 
	  $isValid = False; 
	
	  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
	  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
	  if (!empty($UserName)) { 
		// Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
		// Parse the strings into arrays. 
		$arrUsers = explode(",", $strUsers); 
		$arrGroups = explode(",", $strGroups); 
		if (in_array($UserName, $arrUsers)) { 
		  $isValid = true; 
		} 
		// Or, you may restrict access to only certain users based on their username. 
		if (in_array($UserGroup, $arrGroups)) { 
		  $isValid = true; 
		} 
		if (($strUsers == "") && true) { 
		  $isValid = true; 
		} 
	  } 
	  return $isValid; 
	}
}
?>