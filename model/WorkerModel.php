<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 16:39
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

class WorkerModel
{

    private $db;

    function __construct()
    {
        $this->db = DB::getInstance();
    }

    function allWorkersInfo()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getTableData('forgen_workes');

        return $result;

    }

    function getAllWorkerOfCustomerInfo($customerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllWorkersOfCustomer($customerId);
        return $result;
    }

    function getPassportInfo($workerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getWorkerPassportInfo($workerId);
        return $result;
    }



}