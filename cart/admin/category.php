<?php
try {	
	include_once('Classes/Ccategory.php');
	$Ccategory = new Ccategory($dbFrameWork, $Common);	
	$PAGEHEADING = "Category Management";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);
	
	if($MIDDetails['setting_category_type']=='None'||$MIDDetails['setting_category_type']=='') {
		throw new Exception("Category management is not allowed in this module.");
	}
	
	$catId = $_GET['catId'];
	if(!$catId) $catId = 0;			
	$smarty->assign('catId', $catId);
	
	if($_POST['MM_Insert']==1) {
		if(!trim($_POST['category'])) {
			throw new Exception("Could not add category. Please fill the category field.");
		}
		$Common->phpinsert('ccategory', 'category_id', $_POST);
		$errorMessage = 'Category Added Successfully';
		$smarty->assign('errorMessage', $errorMessage);
	}
	
	$sql = "select * from ccategory WHERE parent_id = '".$catId."' and site_id = '".$ID."' and module_id = '".$MID."'";
	$records = $Common->selectRecord($sql);
	$smarty->assign('records', $records);	
	
	$sql = "select * from ccategory WHERE category_id = '".$catId."' and site_id = '".$ID."' and module_id = '".$MID."'";
	$current = $Common->selectRecord($sql);
	$smarty->assign('current', $current[0]);
			
	// creating breadcrumb
	if($MIDDetails['setting_category_type']=='Multiple'){
		$breadCrumb = $Ccategory->categoryParentLink($catId);
		$smarty->assign('breadCrumb', $Ccategory->catLinkDisplay);		
	}
	
	$body = $smarty->fetch('cart/admin/category.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('error.html');
}
?>