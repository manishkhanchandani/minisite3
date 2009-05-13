<?php
$xtraFields = array(
					1=>array("xtra_field"=>"address", "xtra_field_label"=>"Address", "xtra_field_value"=>"", "type"=>"textarea"),
					2=>array("xtra_field"=>"city", "xtra_field_label"=>"City", "xtra_field_value"=>"", "type"=>"text"),
					3=>array("xtra_field"=>"state", "xtra_field_label"=>"State", "xtra_field_value"=>"", "type"=>"text"),
					4=>array("xtra_field"=>"country", "xtra_field_label"=>"Country", "xtra_field_value"=>"", "type"=>"text"),
					5=>array("xtra_field"=>"zipcode", "xtra_field_label"=>"Zipcode", "xtra_field_value"=>"", "type"=>"text"),
					6=>array("xtra_field"=>"phone", "xtra_field_label"=>"Phone", "xtra_field_value"=>"", "type"=>"text")
				);
$s = json_encode($xtraFields);
echo $s;

?>