<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 14/05/2016
 * Time: 12:45
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


$sql = "SELECT activity_name FROM mbtm_workers.activity_fields where activity_name LIKE ('".$keyword."')";
$list = $db->sql_query($sql);

$htmlResult ="";

foreach ($list as $result) {

    $activity_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $result->activity_name);
    // add new option
    $htmlResult .=  '<li onclick="set_activity_item(\'';
    $tmp =str_replace("'", "\'", $result->activity_name);
    $tmp =str_replace('"', '\"', $tmp);
    $htmlResult .= $tmp;
    $htmlResult .= '\')">'. $activity_name.'</li>';
}
echo $htmlResult;
?>