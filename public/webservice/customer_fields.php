<?php

date_default_timezone_set('Asia/Tel_Aviv');
session_start();
require_once('../../Configure.php');
require_once('../lib/Response.php');
require_once('../lib/DB.php');
require_once('../lib/class.security.php');

Security::checkGetPostSqlInjection([$_POST['customer_name'],$_POST['isTouch']]);

$customer_name_in_hebrew = $_POST['customer_name'];
$db = DB::getInstance();
$db->checkConnection();






$sql ="select activity_name from activity_fields right join

(select customer_fields.field_id from customer_fields WHERE customer_id =
	(
		SELECT id from
		customer where customer_name  = ('".$customer_name_in_hebrew."') and responsible_id = ". $_SESSION['user_id'] . "  LIMIT 0, 1
    )
 ) as customer_fields on customer_fields.field_id = activity_fields.id";

$workerList = $db->sql_query($sql);




$selectMulti=($_POST['isTouch']==false)?'multiple':'';

$dis_array = array_slice($dis_array,0,10);

 include('../parts/customer_area_fields.html');die();





?>