<?php

$message =" FalconJrs Shop: " ;

for($i=0;$i<count($_POST["item_name"]);$i++)
{
	$message .= $_POST["message"][$i]. "<br> " ;

}
echo $message;


?>
