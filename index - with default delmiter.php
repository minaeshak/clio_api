
<h1>Welcome to CLIO APP</h1>

<form method="post">
<input type="submit" name="Auth" value="Authorize"> </br></br>
Enter Display Number for Matter
</br></br><textarea name="display_id" rows="8" cols="80"></textarea>  </br>
<input type="submit" name="Complete" value="Mark As Completed" /> </br>

Please enter start date :<input type="text" name="start_date" value="2019-03-18" /></br>

<input type="submit" name="Generate" value="Generate" />

</form>

<?php
require_once('functions.php');
$REQ = 'https://eu.app.clio.com/oauth/authorize?client_id=b8StZo2glWArzI0t1jALiKvSjHGXhmIzvJjtP6pE&response_type=code&redirect_uri=http://localhost/CLIO/Token.php';


if (isset($_POST['Auth']))
{//file_get_contents($REQ);
//ssfile_get_contents($REQ);
header('Location:' .$REQ);


}
/////////////////////////////////////////



//$URL = "https://eu.app.clio.com/api/v4/matters.json?fields=id,display_number,client{id,name},status{pending}";
//$URL = "https://eu.app.clio.com/api/v4/matters.json?fields=id,display_number,client{id,name},task_template_list_instances";
if(isset($_POST['Complete']))
{

  $ids = explode("\n",str_replace("\r","",$_POST['display_id']));
  //print_r ($ids);


  foreach ($ids As $id){
    $id = "$id";

  $URL = "https://eu.app.clio.com/api/v4/matters.json?fields=id,display_number&query=".$id;
  $result_matter = json_decode(send_request($URL,'GET'),true);
  //echo $result_matter['data']['0']['id'];

  $matter_id=$result_matter['data']['0']['id'];

$URL = "https://eu.app.clio.com/api/v4/tasks.json?fields=id,matter{id,display_number},name&matter_id=".$matter_id."&query=Prepare%20Documentation%20Abm";
$result = json_decode(send_request($URL,'GET'),true);
$task_id = $result['data']['0']['id'];

  //echo $task_id; //question ? is it possible to have 1 matter with multi prepare document tasks



$URL = "https://eu.app.clio.com/api/v4/tasks/".$task_id.".json";
$result = json_decode(send_patch_request($URL),true);

$URL2 = "https://eu.app.clio.com/api/v4/tasks/".$task_id.".json?fields=status";
$result = json_decode(send_request($URL2,'GET'),true);


$status=$result['data']['status'];



//$URL = "https://eu.app.clio.com/api/v4/tasks.json?fields=matter{display_number}&ids[]=430973";

//echo $result['data'];
//echo jsonToTable($result['data']);
echo "</br><b>Prepare Documentation Abm</b> Task for matter <b>".$id. " </b>is now <b>".$status."</b>";
}
}



//{echo "Please Enter Display Number"."\n";}


///////////////////////////////////////////// part 2 /////


if(isset($_POST['Generate']))
{


$URL = "https://eu.app.clio.com/api/v4/tasks.json?fields=matter{id,display_number}&query=Prepare%20Documentation%20Abm&status=pending";
$matters_1 = json_decode(send_request($URL,'GET'),true);  //all matters have this task

//if (empty($matters_1) == false )
//print_r($result);
//echo "\n";

//{

$now = date("Y-m-d");
$now_date = $now;
$start_date = $_POST['start_date'];
$matter_numbers = sizeof($matters_1['data']);


$URL = "https://eu.app.clio.com/api/v4/custom_fields.json?fields=id,name&query=URL";
$result_cf= json_decode(send_request($URL,'GET'),true);
$URLL=$result_cf['data']['0']['id'];

$URL = "https://eu.app.clio.com/api/v4/custom_fields.json?fields=id,name&query=Image";
$result_cf= json_decode(send_request($URL,'GET'),true);
$Image=$result_cf['data']['0']['id'];

$URL = "https://eu.app.clio.com/api/v4/custom_fields.json?fields=id,name&query=Imprint";
$result_cf= json_decode(send_request($URL,'GET'),true);
$Imprint=$result_cf['data']['0']['id'];

$URL = "https://eu.app.clio.com/api/v4/custom_fields.json?fields=id,name&query=Website";
$result_cf= json_decode(send_request($URL,'GET'),true);
$Website=$result_cf['data']['0']['id'];

$URL = "https://eu.app.clio.com/api/v4/custom_fields.json?fields=id,name&query=Additional%20Usage";
$result_cf= json_decode(send_request($URL,'GET'),true);
$Additional_Usage=$result_cf['data']['0']['id'];

$URL = "https://eu.app.clio.com/api/v4/custom_fields.json?fields=id,name&query=CM%20info";
$result_cf= json_decode(send_request($URL,'GET'),true);
$CM_info=$result_cf['data']['0']['id'];

//echo $Image;


for ($i=0; $i < $matter_numbers ; $i++) {

  //$matter_ids_disp[$i] = array("id" => $result['data'][$i]['matter']['id'] , "display" => $result['data'][$i]['matter']['display_number']);
  // $URL = "https://eu.app.clio.com/api/v4/matters.json?fields=display_number,pending_date&query=".$matters_1["data"][$i]["matter"]["display_number"]."&status=pending&pending_date=\"<2019-03-18\"&pending_date=<=\"2019-03-19\"";

  $URL = "https://eu.app.clio.com/api/v4/matters.json?fields=display_number,pending_date,custom_field_values{field_name,value}&query=".$matters_1["data"][$i]["matter"]["display_number"]."&status=pending&pending_date=>".$start_date."&custom_field_ids[]=".$URLL."&custom_field_ids[]=".$Image."&custom_field_ids[]=".$Imprint."&custom_field_ids[]=".$Website."&custom_field_ids[]=".$Additional_Usage."&custom_field_ids[]=".$CM_info	;

  $json_data = send_request($URL,'GET');
  $result_matter_1 = json_decode($json_data,true);
  if (empty($result_matter_1['data']) == false && $result_matter_1['data']['0']['pending_date'] != $now_date) {
  $result[$i] = array("disp" => $result_matter_1['data']);

    // //
    // //
    //  $final_result[$i]=$result[$i]['disp']['0']['display_number'].",".$result[$i]['disp']['0']['pending_date'].",".$result[$i]['disp']['0']['custom_field_values']['4']['value'].",".$result[$i]['disp']['0']['custom_field_values']['2']['value'].",".$result[$i]['disp']['0']['custom_field_values']['3']['value'].",".$result[$i]['disp']['0']['custom_field_values']['4']['value'].",".$result[$i]['disp']['0']['custom_field_values']['0']['value'].",".$result[$i]['disp']['0']['custom_field_values']['1']['value'];


    $final_result[]=array("Matter-ID" => $result[$i]['disp']['0']['display_number'] , "Pending Date" => $result[$i]['disp']['0']['pending_date'],
    "Custom Field: URL" => $result[$i]['disp']['0']['custom_field_values']['4']['value'],
    "Custom Field: Image" => $result[$i]['disp']['0']['custom_field_values']['2']['value'],
    "Custom Field: Imprint" => $result[$i]['disp']['0']['custom_field_values']['3']['value'],
    "Custom Field: Website" => $result[$i]['disp']['0']['custom_field_values']['5']['value'],
    "Custom Field: Additional Usage" => $result[$i]['disp']['0']['custom_field_values']['0']['value'],
    "Custom field: CM info" => $result[$i]['disp']['0']['custom_field_values']['1']['value']
    );



}


  // code...
}




//

if (empty($result) == false) {
print_r ($final_result);
//$fp = fopen('file.txt', 'w');
$fp = fopen('file2.csv', 'w');


// $titles=array('Matter-ID','Pending Date','Custom Field: URL','Custom Field: Image','Custom Field: Imprint','Custom Field: Website','Custom Field: Additional Usage','Custom field: CM info');

fwrite($fp,"Matter-ID,Pending Date,Custom Field: URL,Custom Field: Image,Custom Field: Imprint,Custom Field: Website,Custom Field: Additional Usage,Custom field: CM info\r\n");

//fputcsv($fp,$titles,';');
    for ($i=0; $i < sizeof($final_result); $i++) {

    fputcsv($fp,$final_result[$i]);
}

//fputcsv($fp,$final_result);


fclose($fp);

// $fp = fopen('file2.csv', 'w');
// for ($i=0;$l<sizeof($final_resulti);$i++){fputcsv($fp,$final_result[$i]);fclose($fp);}


// }
//
// else {echo "No Records";}
}

else {echo "No Records";}
}

?>
