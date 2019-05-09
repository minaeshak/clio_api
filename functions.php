<?php

function send_request($REQ,$METHOD){
$curl = curl_init();

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt_array($curl, array(
  CURLOPT_URL => $REQ ,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,


  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => $METHOD ,
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer mwOk6IyKkIW7CjtS2xSJVzX5HndPyFcDyPmecNQ6",
    "Postman-Token: d43a8ea2-eb20-481e-8db8-a44bf86ec331",
    "cache-control: no-cache",


  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  if ($response == NULL) echo 'No Response';
  echo $response."end response\r";
}
return $response;
}
///////////////////////



function send_patch_request($REQ){
$curl = curl_init();

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$data=array("data" => array("status" => "complete"));
$data2=array("fields"=>"status");
curl_setopt_array($curl, array(
  CURLOPT_URL => $REQ  ,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,


  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PATCH" ,
  CURLOPT_POSTFIELDS =>   json_encode($data),
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer mwOk6IyKkIW7CjtS2xSJVzX5HndPyFcDyPmecNQ6",

    "Postman-Token: d43a8ea2-eb20-481e-8db8-a44bf86ec331",
    "cache-control: no-cache",
    "Content-Type: application/json",
  //   "{'data':{'status':'pending'}}"




  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  if ($response == NULL) echo 'mafesh';
//  echo $response;
}
return $response;
}

///////////////////////


/**
 * JSON data to html table
 *
 * @param object $data
 *
 */
function jsonToTable ($data)
{
    $table = '
    <table class="json-table" border=1>
    ';
    foreach ($data as $key => $value) {
        $table .= '
        <tr valign="top">
        ';
        if ( ! is_numeric($key)) {
            $table .= '
            <td>
                <strong>'. $key .'</strong>
            </td>
            <td>
            ';
        } else {
            $table .= '
            <td colspan="2">
            ';
        }
        if (is_object($value) || is_array($value)) {
            $table .= jsonToTable($value);
        } else {
            $table .= $value;
        }
        $table .= '
            </td>
        </tr>
        ';
    }
    $table .= '
    </table>
    ';
    return $table;
}

////////////////////////

function send_patch_request_cf($REQ,$instance_id,$cf_id,$cf_value){
$curl = curl_init();

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$data=array("data" => array( "custom_field_values" => array("id" => $instance_id, "value" => $cf_value )));
$json=json_encode($data);
echo $json;


curl_setopt_array($curl, array(
  CURLOPT_URL => $REQ  ,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,


  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PATCH" ,
  CURLOPT_POSTFIELDS =>  $json ,
  CURLOPT_HTTPHEADER => array(

    "Authorization: Bearer mwOk6IyKkIW7CjtS2xSJVzX5HndPyFcDyPmecNQ6",
    "Postman-Token: d43a8ea2-eb20-481e-8db8-a44bf86ec331",
    "cache-control: no-cache",
    "Content-Type: application/json",




  ),
));


$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  if ($response == NULL) echo 'mafesh';
//  echo $response;
}
return $response;
}

?>
