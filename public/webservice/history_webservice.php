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
    if(isset($_POST['new_area_field_form']))
    {
        $activity_name = $_POST['new_area_field_form'];
    }

    elseif($_POST['old_area_field_form'] !='אחר')
    {
        $activity_name = $_POST['old_area_field_form'];
    }

    $list = $db->getTableData('activity_fields', [activity_name => $activity_name], null, 1);
    $activityId = $list[0]->id;

    $db->update('history', [to_date => $_POST['start_date'], status => 'pad_old'], [forgen_workers_id => $_POST['worker_id'], to_date => 'is null']);

    $htmlResult = "";
    $historyInsert = '';
    $historyInsert['forgen_workers_id'] = $_POST['worker_id'];
    $historyInsert['employer_id'] = $_POST['new_employer_name'];
    $historyInsert['from_date'] = $_POST['start_date'];
    $historyInsert['to_date'] = $_POST['end_date'];
    $historyInsert['status'] = 'pad_new';

    $res = $db->insert('history', $historyInsert);
    if ($res != false)
        echo 'הועברה בקשה למעבר עובד!';
}
else if($_POST['history_update'] == 'approve')
{
    $db->update('history', [status => 'prv_emp'], [forgen_workers_id => $_POST['worker_id'], status => 'pad_old']);
    $db->update('history', [status => 'cur_emp'], [forgen_workers_id => $_POST['worker_id'], status => 'pad_new']);
}
else if($_POST['history_update'] == 'cancel')
{
    $db->update('history', [to_date => '', status => 'cur_emp'], [forgen_workers_id => $_POST['worker_id'], status => 'pad_old']);
}

?>