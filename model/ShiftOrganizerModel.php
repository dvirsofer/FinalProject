<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 20/03/2016
 * Time: 22:02
 */
require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

class ShiftOrganizerModel {
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function getWorkerAmount($responsible_id)
    {

        $this->db->checkConnection();
        $res= $this->db->getTableData('forgen_workes',['responsible_id'=>$responsible_id],'count(*)');

        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';


    }

    public function getEmployeeAmount($responsible_id)
    {
        $this->db->checkConnection();
        $res= $this->db->getTableData('customer',['responsible_id'=>$responsible_id],'count(*)');
        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';
    }


    public function getCitiesAmount($responsible_id)
    {
        $this->db->checkConnection();
        $res= $this->db->getTableData('customer',['responsible_id'=>$responsible_id],'count(distinct settlement_id)');
        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';
    }

    public  function  getWorkersInProcessAmount($responsible_id)
    {
        $   $this->db->checkConnection();
        $res= $this->db->getTableData('activity',['user_id'=>$responsible_id,'status_description'=>'open'],'count(*)');
        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';
    }



}