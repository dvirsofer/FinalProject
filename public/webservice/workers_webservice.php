<?php

date_default_timezone_set('Asia/Tel_Aviv');
session_start();
require_once('../../Configure.php');
require_once('../lib/Response.php');
require_once('../lib/DB.php');
require_once('../lib/class.security.php');

Security::checkGetPostSqlInjection($_POST);

$customer_name_in_hebrew = $_POST['settlement_id'];
$workers_amount = $_POST['workers_amount'];


$db = DB::getInstance();
$db->checkConnection();

if(isset($_POST['new_area_field']) && strlen($_POST['new_area_field']) >2)
{
    update_customer_area_fields($_POST['new_area_field'],$customer_name_in_hebrew,$db);
    $search_area = $_POST['new_area_field'];
}

elseif($_POST['workers_fields'] !='אחר')
{
    $search_area = $_POST['workers_fields'];
}

if($_POST['userOptionsRadios']=='work_experience')
{
    search_worker_by_experience($db,$search_area);
}

else {
    $sql = "SELECT
settlement.latitude,
settlement.longitude,
settlement.settlement_name,
settlement.setelment_type
FROM mbtm_workers.customer
 RIGHT join settlement on   customer.settlement_id  = settlement.id
 where responsible_id = " . $_SESSION['user_id'] . " and customer.customer_name  = ('" . $customer_name_in_hebrew . "') LIMIT 0, 1;";

    $list1 = $db->sql_query($sql);

    if (is_null($list1[0]->setelment_type))
        $settlement_type_sql = "settlement.setelment_type is null or settlement.setelment_type = 'moshav'";
    else
        $settlement_type_sql = "settlement.setelment_type = '" . $list1[0]->setelment_type . "'";


    $sql = "SELECT
settlement.latitude,
settlement.longitude,
settlement.settlement_name,
customer.customer_name,
settlement.setelment_type,
forgen_workes.ammount_of_workers
FROM mbtm_workers.customer
 left join settlement on   customer.settlement_id  = settlement.id
 INNER JOIN (SELECT current_customer_id,count(current_customer_id) as ammount_of_workers FROM mbtm_workers.forgen_workes
 where responsible_id = " . $_SESSION['user_id'] . " group by current_customer_id) as forgen_workes on customer.id = current_customer_id

 where responsible_id = " . $_SESSION['user_id'] . "  and customer.customer_name  <> ('" . $customer_name_in_hebrew . "')  and  " . $settlement_type_sql . " GROUP BY customer.customer_name ORDER BY customer.customer_name ASC;";


    $list = $db->sql_query($sql);


    $dis_array = array();
    for ($i = 0; $i < count($list); $i++) {

        $distance = getDistance($list1[0]->latitude, $list1[0]->longitude, $list[$i]->latitude, $list[$i]->longitude);
        // var_dump($list[$i]);
        $dis_array[$i] = array(
            customer_name => $list[$i]->customer_name,
            settlement_name => $list[$i]->settlement_name,
            distance => $distance,
            ammount_of_workers => $list[$i]->ammount_of_workers
        );

    }
    usort($dis_array, "sort_by_dist");

    $dis_array = array_slice($dis_array, 0, 10);


    echo include('../parts/free_workers_by_distance.html');
    die();
}
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

function search_worker_by_experience($db,$area)
{

   // $field = $db->getTableData("activity_fields",[activity_name=>$area],null,true);
    $subFieldsArr=explode (" ",$area);
    $likeSql="";
    foreach($subFieldsArr as $value)
    {
        $likeSql = " like %". $value . "% or";
    }
    $likeSql= rtrim($likeSql,"or");



    $fieldArr =$db->sql_query("select group_concat(id) as fields_id from activity_fields WHERE activity_name " . $likeSql);

    $sql = "select
            history.forgen_worker_id,
            history.activity_name,
            forgen_workes.first_name,
            forgen_workes.last_name,
            forgen_workes.current_custemer_id,
            forgen_workes.customer_name

            from (
                select
                history.forgen_worker_id,
                activity_fields.activity_name
                from
                history INNER JOIN (SELECT activity_name from activity_fields WHERE id in (" .$fieldArr[0]->fields_id .")
                as activity_fields
                on  activity_fields.id = history.working_field
                )
                where
                working_field in (" .$fieldArr[0]->fields_id .")
                ) as history
                left join
                (SELECT
                 forgen_workes.first_name,
            forgen_workes.last_name,
            forgen_workes.current_custemer_id,
            customer.customer_name
                 FROM mbtm_workers.forgen_workes
                inner join
                customer on
                ) as forgen_workes
                 on forgen_workes.current_customer_id = customer.id
                 history.forgen_worker_id = forgen_workes.id" ;

    echo include('../parts/free_workers_by_experience.html');
    die();


}

?>