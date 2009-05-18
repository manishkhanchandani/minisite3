<?php
try {
	$PAGEHEADING = "SEO Management";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	$Common->restrictAccess($_COOKIE['user_id'], $_COOKIE['user_group']);
	if($MM_restrictGoTo) {
		throw new Exception("You are not authorized to view this page");
	}
	if($_POST['MM_Insert']==1) {
		$sqlCnt = "select count(*) as cnt from seo_sites where site_id = '".$ID."' and module_id = '".$MID."' and user_id = '".$_COOKIE['user_id']."'";
		$result = $Common->selectRecord($sqlCnt);
		$tot = $result[0]['cnt'];
		if($tot>=$MIDDetails['settings_seo_site_limit']) {
			throw new Exception("Maximum Limit reached for your seo site creation.");
		}
		$Common->phpinsert('seo_sites','sid',$_POST);
		$errorMessage = "Seo Site Submitted Successfully";
		$smarty->assign('errorMessage', $errorMessage);
	}
	$sql = "select * from seo_sites where site_id = '".$ID."' and module_id = '".$MID."' and user_id = '".$_COOKIE['user_id']."'";
	$sqlCnt = "select count(*) as cnt from seo_sites where site_id = '".$ID."' and module_id = '".$MID."' and user_id = '".$_COOKIE['user_id']."'";
	$max = 10;
	$page = $_GET['page'];
	if(!$page) $page = 1;
	$pageNum = $page-1;
	$start = $pageNum * $max;
	
	$records = $Common->selectCacheLimitRecordFull($sql, $sqlCnt, $max, $start);
	$smarty->assign('records', $records);
	
	if($records['totalRows']>$max) {
		include_once('Classes/PaginateIt.php');
		// pagination
		$PaginateIt = new PaginateIt();
		$PaginateIt->SetItemCount($records['totalRows']);
		$PaginateIt->SetItemsPerPage($max);
		$pagination = $PaginateIt->GetPageLinks_Old();
		$smarty->assign('pagination', $pagination);
	}
	$body = $smarty->fetch('seo/index.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>