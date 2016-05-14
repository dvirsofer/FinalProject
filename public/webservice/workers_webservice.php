<?php

date_default_timezone_set('Asia/Tel_Aviv');
session_start();
require_once('../../Configure.php');
require_once('../lib/Response.php');
require_once('../lib/DB.php');
require_once('../lib/class.security.php');

Security::checkGetPostSqlInjection();

$customer_name_in_hebrew = $_POST['settlement_id'];
$workers_amount = $_POST['workers_amount'];


$db = DB::getInstance();
$db->checkConnection();

if(isset($_POST['new_area_field']) && strlen($_POST['new_area_field']) >2)
{
    update_customer_area_fields($_POST['new_area_field'],$customer_name_in_hebrew,$db);
}


$sql ="SELECT
settlement.latitude,
settlement.longitude,
settlement.settlement_name
FROM mbtm_workers.customer
 RIGHT join settlement on   customer.settlement_id  = settlement.id
 where responsible_id = ". $_SESSION['user_id'] . " and customer.customer_name  = ('".$customer_name_in_hebrew."') LIMIT 0, 1;";

$list1 = $db->sql_query($sql);


$sql ="SELECT
settlement.latitude,
settlement.longitude,
settlement.settlement_name,
customer.customer_name,
forgen_workes.ammount_of_workers
FROM mbtm_workers.customer
 left join settlement on   customer.settlement_id  = settlement.id
 INNER JOIN (SELECT current_customer_id,count(current_customer_id) as ammount_of_workers FROM mbtm_workers.forgen_workes
 where responsible_id = ". $_SESSION['user_id'] . " group by current_customer_id) as forgen_workes on customer.id = current_customer_id

 where responsible_id = ". $_SESSION['user_id'] . " and customer.customer_name  <> ('".$customer_name_in_hebrew."') GROUP BY customer.customer_name ORDER BY customer.customer_name ASC;";


$list = $db->sql_query($sql);


$dis_array=array();
for($i=0  ;$i<count($list);$i++) {

    $distance=getDistance($list1[0]->latitude,$list1[0]->longitude,$list[$i]->latitude,$list[$i]->longitude);
   // var_dump($list[$i]);
    $dis_array[$i]=array(
    customer_name =>   $list[$i]->customer_name,
    settlement_name => $list[$i]->settlement_name,
    distance => $distance,
    ammount_of_workers=> $list[$i]->ammount_of_workers
);

}
usort($dis_array, "sort_by_dist");

$dis_array = array_slice($dis_array,0,10);



echo include('../parts/free_workers.html');die();

function sort_by_dist($distance1,$distance2)
{
    return $distance1['distance']>$distance2['distance'];
}

 function getDistance($lat1, $lon1, $lat2, $lon2) {
    //echo " lat1: ".$lat1." lon1: ". $lon1." lat2: ". $lat2." lon2: ". $lon2;
     if($lat1==$lat2 && $lon1 == $lon2)
         return 0;
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return ($miles * 1.609344);

}

function update_customer_area_fields($fields,$customer_name_in_hebrew,$db)
{
    $customerId = $db->getTableData("customer", ['customer_name' =>$customer_name_in_hebrew]);
    $list=$db->sql_query("select id from activity_fields WHERE activity_name = '".$fields."' limit 0,1");

    //field not exist - insert it
    if(empty($list)){

        $lastId=$db->insert('activity_fields',['activity_name'=>$fields]);
        $db->insert('customer_fields',['field_id'=>$lastId,'customer_id'=>$customerId[0]->id]);

    }
    else{

        $customerFields=$db->getTableData('customer_fields',['customer_id'=>$customerId[0]->id,'field_id'=>$list[0]->id]);
        if(empty($customerFields))
            $db->insert('customer_fields',['field_id'=>$list[0]->id,'customer_id'=>$customerId[0]->id]);
    }


}


?>