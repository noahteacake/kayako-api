<?php
 //inserts mult. organizations
 //initialization
 $api_url="https://support.domainname.com/api/index.php?e=/Base/UserOrganization";
 $api_key = "insert_your_api_key_here";
 $sKey = "insert_secret_key";
 $salt = mt_rand();
 $signature = base64_encode(hash_hmac('sha256',$salt,$sKey,true)); //don't urlencode post's

 //user org.txt
 $file = "cust.txt";    //file with cust information
 $fh = fopen($file, 'r');
 $data = fread($fh, filesize($file));

 $lines = explode("\n", $data);
 echo count($lines);

 $orgtype = "shared";
 $slaplanex = "0";                   //0 =  never expires
 $country = "United States";

 for($k = 0; $k < (count($lines)-1); $k++){
   $carrot = explode('^', $lines[$k]);
        if($carrot[10] == "55"){
          $slaplanid = "2";
        }
        if($carrot[10] == "56"){
          $slaplanid = "3";
        }
        if($carrot[10] == "57"){
          $slaplanid = "4";
        }

        $post_data = array('name' => $carrot[1],
          'organizationtype' => $orgtype,
          'address' => $carrot[2].$carrot[3],
          'city' => $carrot[4],
          'state' => $carrot[5],
          'postalcode' => $carrot[6],
          'country' => $country,
          'phone' => $carrot[7],
          'fax' => $carrot[9],
          'slaplanid' => $slaplanid,
          'slaplanexpiry' => $slaplanex,
          'apikey' => $api_key,
          'salt' => $salt,
          'signature' => $signature);


         $post_data = http_build_query($post_data, '', '&');
         $curl = curl_init($api_url);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($curl, CURLOPT_POST, true);
         curl_setopt($curl, CURLOPT_URL, $api_url);
         curl_setopt($curl, CURLOPT_HEADER, false);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

         $response = curl_exec($curl);
         curl_close($curl);
         print $response;
 }//end of FOR LOOP
 fclose($fh);
?>
