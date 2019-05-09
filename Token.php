<?php

$curl = curl_init();

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://eu.app.clio.com/oauth/token?client_id=mh2jtzuokfZRffW0lDwLlvT6G1NsEm9lRIlgwyyV&client_secret=RXqZ8P4BNt8s9ueyu6GcvHA5Bf1sE6XcnuVRowzC&grant_type=authorization_code&code=".$_GET['code']."&redirect_uri=http://localhost/CLIO/Token.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "Postman-Token: 0e1a104d-0d24-44f4-b8a4-d2ae73f4461c",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
  $response=json_decode($response);
  $res = $response -> {'access_token'};
  header('Location:'.'index.php?token='.$res);
;

}

?>
