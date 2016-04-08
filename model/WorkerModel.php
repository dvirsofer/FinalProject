<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 16:39
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

/**
 * Class WorkerModel
 */
class WorkerModel
{

    private $db;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    /**
     * @return bool|PDOStatement
     */
    public function allWorkersInfo()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllWorkers();
        return $result;
    }

    /**
     * @param $customerId
     * @return array - All workers of the customer.
     */
    public function getAllWorkerOfCustomerInfo($customerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllWorkersOfCustomer($customerId);
        return $result;
    }

    /**
     * @param $passport
     * @return array - Passport of the worker.
     */
    public function getPassportInfo($passport)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getPassportInfo($passport);
        return $result;
    }

    /**
     * @return array - All passports.
     */
    public function getAllPassports()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllPassports();
        return $result;
    }

    public function getWorkerInfo($workerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getWorkerInfo($workerId);
        return $result;
    }

    public function getWorkerInfoByName($workerName)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getWorkerInfoByName($workerName);
        return $result;
    }

    public function getAllWorkers()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllWorkers();
        return $result;
    }

}