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

Security::checkGetPostSqlInjection($_POST);

$db = DB::getInstance();
$db->checkConnection();
if($_POST['history_update'] == 'insert') {


    if($_POST['old_area_field_form'] !='אחר')
    {
        $activity_name = $_POST['old_area_field_form'];
    }
    elseif(isset($_POST['new_area_field_form']))
    {
        $activity_name = $_POST['new_area_field_form'];
    }

    if(empty($activity_name))
        die('Error: Enter activity name');

    $list = $db->getTableData('activity_fields', [activity_name => $activity_name], null, 1);
    $activityId = $list[0]->id;

    $db->update('history', [to_date => $_POST['start_date'], status => 'pad_old'], [forgen_workers_id => $_POST['new_worker_id'], employer_id=>$_POST['customer_id']]);

    $htmlResult = "";
    $historyInsert = '';
    $historyInsert['forgen_workers_id'] = $_POST['new_worker_id'];
    $historyInsert['employer_id'] = $_POST['new_employer_name'];
    $historyInsert['from_date'] = $_POST['start_date'];
    $historyInsert['to_date'] = $_POST['end_date'];
    $historyInsert['status'] = 'pad_new';
    $historyInsert['working_field']= $activityId;

    $res = $db->insert('history', $historyInsert);
    if ($res != false)
        echo 'הועברה בקשה למעבר עובד!';
    die();
}


?>