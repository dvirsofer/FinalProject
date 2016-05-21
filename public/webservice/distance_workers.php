<?php

date_default_timezone_set('Asia/Tel_Aviv');
session_start();
require_once('../../Configure.php');
require_once('../lib/Response.php');
require_once('../lib/DB.php');
require_once('../lib/class.security.php');


Security::checkGetPostSqlInjection($_POST);

$customer_id = $_POST['customer_id'];



$db = DB::getInstance();
$db->checkConnection();

$sql="
SELECT
                    forgen_workes.id,
                    forgen_workes.worker_id,
						forgen_workes.first_name,
						forgen_workes.last_name,
						forgen_workes.current_customer_id,
						customer.customer_name
					FROM
                    (select id,worker_id,first_name,last_name,current_customer_id from
						mbtm_workers.forgen_workes
						where current_customer_id = ".$customer_id." and responsible_id =  " . $_SESSION['user_id']."
                        ) as forgen_workes
                inner join
(
    select
                        id,customer_name
                        from
                        customer
                        where
                        id = ".$customer_id." and
                        responsible_id = " . $_SESSION['user_id']."
                        ) as customer
                on forgen_workes.current_customer_id = customer.id


";


    if(SQL_DEBUG)echo($sql);
    $list1 = $db->sql_query($sql);



    include('../parts/free_workers_by_employee.html');
    die();




?>