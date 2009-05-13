<?php
$array = array(1=>"hello", 2=>"world", 3=>array(1=>"hello", 2=>"world"));
$js = json_encode($array);
echo $js;
$ns = json_decode($js);
print_r($ns);
foreach($ns as $k=>$v) {
	echo $k." = ";
	print_r($v);
	if(gettype($v)=="object") {
		foreach($v as $k1=>$v1) {
			echo $k1." = ";
			print_r($v1);
			echo "<br>";
		}
	}	
}
?>