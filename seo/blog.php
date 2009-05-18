<?php
try {
	$PAGEHEADING = "SEO Management";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	$Common->restrictAccess($_COOKIE['user_id'], $_COOKIE['user_group']);
	if($MM_restrictGoTo) {
		throw new Exception("You are not authorized to view this page");
	}	
	if($_POST['MM_Insert']==1) {
		if($_POST['rs']) {
			$post = $_POST;
			foreach($_POST['rs'] as $k=>$v) {
				$post['bid'] = $v;
				$post['sid'] = $_GET['sid'];
				$Common->phpinsert('seo_blog_submission', 'sub_id', $post);
			}
		}
	}
	$sql = "select count(bid) as cnt, bid from seo_blog_submission where sid = '".$_GET['sid']."' and site_id = '".$ID."' and module_id = '".$MID."' and user_id = '".$_COOKIE['user_id']."' GROUP BY bid";
	$rs = $dbFrameWork->CacheExecute(60, $sql);
	if($dbFrameWork->ErrorMsg()) {
		throw new Exception($dbFrameWork->ErrorMsg());
	}
	while ($arr = $rs->FetchRow()) { 
		$posted[$arr['bid']] = $arr['cnt'];
	}
	$smarty->assign('posted', $posted);
	
	$sql = "select * from seo_sites where sid = '".$_GET['sid']."' and site_id = '".$ID."' and module_id = '".$MID."' and user_id = '".$_COOKIE['user_id']."'";
	$current = $Common->selectCacheRecord($sql);
	$smarty->assign('current', $current[0]);
	$sql = "select * from seo_blog_sites order by blog_site_name";
	$sqlCnt = "select count(*) as cnt from seo_blog_sites";
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
	$body = $smarty->fetch('seo/blog.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>