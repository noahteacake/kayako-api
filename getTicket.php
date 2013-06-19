<php
//gets an individual ticket from kayako site for support

//init
 $api_url = "https://support.domain_name/api/index.php?e=/Tickets/Ticket/1";
 $api_key = "insert_your_api_key_here";
 $sKey = "insert_your_secretKey";
 $salt = mt_rand();
 $signature = urlencode(base64_encode(hash_hmac('sha256', $salt, $sKey, true)));

//main get request
 $get =  $api_url."$apikey=".$api_key."&salt=".$salt."&signature=".$signature;
//make sure it's right
 echo $get,"\n";

 $curl = curl_init();
 curl_setopt($curl, CURLOPT_URL, $get);
 $writeto = fopen('RESULT.txt', 'w');
 curl_setopt($curl, CURLOPT_FILE, $writeto);
 curl_exec($curl);
 curl_close($curl);

 fclose($writeto);
?>
 
