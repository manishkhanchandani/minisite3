<?php
$array = array(1=>"index", 2=>"addtocart", 3=>"checkout", 4=>"failure", 5=>"mycart", 6=>"myorders", 7=>"products", 8=>"payment", 9=>"success", 10=>"admin/orders", 11=>"admin/products", 12=>"admin/category");
$s = json_encode($array);
echo $s;
echo "<br>";

$array = array(1=>"index",2=>"blog");
$s = json_encode($array);
echo $s;
echo "<br>";
?>