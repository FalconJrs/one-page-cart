<?php

if(isset($_REQUEST["pro"])) {
	$i=1;
	foreach ($_REQUEST["pro"] as $id_class[$i]) {
		echo"...ห้องที่ $i = $id_class[$i]<br>";
	$i++;
	}
}

?>
