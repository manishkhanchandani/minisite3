<?php
try {
	include_once('Classes/Ccategory.php');
	$Ccategory = new Ccategory($dbFrameWork, $Common);	
	
	$PAGEHEADING = "Product Management";
	$smarty->assign('PAGEHEADING', $PAGEHEADING);	
	//if($MIDDetails['setting_category_type']=='None'||$MIDDetails['setting_category_type']=='')
	if(!($MIDDetails['setting_category_type']=='None'||$MIDDetails['setting_category_type']=='')) {
		// get Categories
		$Ccategory->treeSelectBox(0);
		$categorySelBox = $Ccategory->treeSelectBox;
		$smarty->assign('categorySelBox', $categorySelBox);	
	}
	$DATE = date('Y-m-d');
	$smarty->assign('DATE', $DATE);
	$DATE1 = date('Y-m-d', strtotime("+1 month"));
	$smarty->assign('DATE1', $DATE1);
	$body = $smarty->fetch('cart/admin/products.html');
} catch (exception $e) { 
	$errorMessage = $e->getMessage();
	$smarty->assign('errorMessage', $errorMessage);
	$body = $smarty->fetch('home.html');
}
?>