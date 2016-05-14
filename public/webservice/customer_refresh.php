<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 16/04/2016
 * Time: 16:29
 */
date_default_timezone_set('Asia/Tel_Aviv');
session_start();
require_once('../../Configure.php');
require_once('../lib/Response.php');
require_once('../lib/DB.php');
require_once('../lib/class.security.php');

Security::checkGetPostSqlInjection([$_POST['keyword']]);

$db = DB::getInstance();
$db->checkConnection();
$keyword = '%'.$_POST['keyword'].'%';


$columnLookIn = (mb_detect_encoding($_POST['keyword'])== 'UTF-8')?'customer_name':'name_in_english';



$sql = "select customer.customer_name,customer.name_in_english,customer.settlement_id,settlement.latitude,settlement.longitude from customer
left join (select * from settlement) as settlement
on customer.settlement_id = settlement.id
 where responsible_id =  ". $_SESSION['user_id'] . " and (customer.".$columnLookIn." like ('".$keyword."')) ORDER BY customer.".$columnLookIn." ASC LIMIT 0, 10;";

$list = $db->sql_query($sql);



foreach ($list as $result) {
   // $result->settlement_name = trim($result->settlement_name);

    $customer_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $result->{$columnLookIn});
    $hebrewCustomerName =str_replace("'", "\'", $result->customer_name);
    $hebrewCustomerName =str_replace('"', '&quot', $hebrewCustomerName);
    // add new option
   echo '<li onclick="set_item(\''.$hebrewCustomerName.'\',{lat: '.$result->latitude.', lng: '.$result->longitude.'})">'.$customer_name.'</li>';
}

?>