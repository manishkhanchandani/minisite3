<?php 
include_once('Connections/conn.php');
include_once('settings.php');
include_once('functions.php');
?>
<?php
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$option_name1 = $_POST['option_name1'];
$option_name2 = $_POST['option_name2'];
$option_selection1 = $_POST['option_selection1'];
$option_selection2 = $_POST['option_selection2'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
}
}
fclose ($fp);
}

if($_POST['payment_status']=="Completed") {
	$sql = "update sites set status = 'Paid', charges = '1', next_payment_date = '".strtotime("+1 month")."' where site_id = '".$_POST['item_number']."'";	
	if(mysql_query($sql)) {
	
	} else {
		$s = mysql_error();
		file_put_contents('tmp/log_'.time().'_'.$_POST['custom'].'.txt', $s);
	}
}
?>