<?php

$curl = curl_init();

/* CURLOPT_URL => "http://2factor.in/API/V1/293832-67745-11e5-88de-5600000c6b13/SMS/9760894418/4499", */

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://2factor.in/API/V1/4917de67-4756-11ea-9fa5-0200cd936042/SMS/8755269458/54498",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}