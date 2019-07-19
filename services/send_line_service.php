

  <?php

$message =" FalconJrs Shop: " ;

for($i=0;$i<count($_POST["item_name"]);$i++)
{
	$message .= $_POST["message"][$i]. "\r\n "."\r\n "."\r\n " ;

}
$message .= "ยังไม่มีรหัสลูกค้า กับ ที่อยู่นะจ๊ะพี่จ๋า";
  $lineapi ="xh9TvLQghnX3jnvV7QPLyqDjllVusbOISme7jO5c3iO"; // ใส่ token key ที่ได้มา

 	date_default_timezone_set("Asia/Bangkok");
 	$chOne = curl_init();
 	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
 	// SSL USE
 	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
 	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
 	//POST
 	curl_setopt( $chOne, CURLOPT_POST, 1);
 	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
 	curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
 	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', );
         curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
 	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
 	$result = curl_exec( $chOne );
 	//Check error
 	if(curl_error($chOne))
 	{
            echo 'error:' . curl_error($chOne);
 	}
 	else {
 	$result_ = json_decode($result, true);
 	   echo "status : ".$result_['status']; echo "message : ". $result_['message'];
         }
 	curl_close( $chOne );





?>
