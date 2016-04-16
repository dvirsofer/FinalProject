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

$db = DB::getInstance();
$db->checkConnection();
$keyword = '%'.$_POST['keyword'].'%';

$sql ="SELECT
settlement.latitude,
settlement.longitude,
settlement.settlement_name
FROM mbtm_workers.customer
 left join settlement on   customer.settlement_id  = settlement.id
 where responsible_id = ". $_SESSION['user_id'] . " and settlement_name  LIKE ('".$keyword."') ORDER BY settlement_name ASC LIMIT 0, 10;";


$list = $db->sql_query($sql);



foreach ($list as $result) {
    $result->settlement_name = trim($result->settlement_name);
    $settlement_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $result->settlement_name);
    // add new option
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $result->settlement_name).'\')">'.$settlement_name.'</li>';
}
?>