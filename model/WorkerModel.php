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
     * @param $passportNumber
     * @return array - passport.
     */
    public function getWorkerPassport($passportNumber)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getWorkerPassportInfo($passportNumber);
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

    /**
     * @param $workerId
     * @return array - worker of this id.
     */
    public function getWorkerInfo($workerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getWorkerInfo($workerId);
        return $result;
    }

    /**
     * @param $workerName
     * @return array - worker.
     */
    public function getWorkerInfoByName($workerName)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getWorkerInfoByName($workerName);
        return $result;
    }

    /**
     * @return array - all workers.
     */
    public function getAllWorkers()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllWorkers();
        return $result;
    }

    /**
     * @return array - All workers details.
     */
    public function getAllWorkersDetails()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllWorkersDetails();
        return $result;
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $date
     * @param $phone
     * @param $nation
     * @param $passportNumber
     * @param $validPassport
     * @param $gender
     * @param $arrive
     * @param $arrivalDate
     * @param $comments
     * @param $userId
     * @param $customerId
     * @return string - message.
     */
    public function newWorker($firstName, $lastName, $date, $phone, $nation, $passportNumber, $validPassport, $gender,
                              $arrive, $arrivalDate, $comments, $userId, $customerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $worker = $this->db->newWorker($firstName, $lastName, $date, $phone, $nation, $passportNumber, $validPassport, $gender,
            $arrive, $arrivalDate, $comments, $userId, $customerId);
        //$result = $this->db->addPassport($worker, $passportNumber, $validPassport);
        return $worker;
    }

    public function addPassport($worker, $passportNumber, $validPassport)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $msg = $this->db->addPassport($worker, $passportNumber, $validPassport);
        return $msg;
    }

    /**
     * @return string - all workers.
     */
    public function createWorkersFile()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $csv = $this->db->createWorkersFile();
        return $csv;
    }

    /**
     * @param $workerId - the worker for delete.
     * @return bool
     * true - if update success
     * false - else.
     */
    public function updateWorker($workerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $msg = $this->db->updateWorker($workerId);
        return $msg;
    }

    /**
     * @param $workerId
     * @param $customerId
     * @return bool
     * true - if update success.
     * false - else.
     */
    public function updateCustomerOfWorker($workerId, $customerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $msg = $this->db->updateCustomerOfWorker($workerId, $customerId);
        return $msg;
    }

    public function editWorker($workerId, $firstName, $lastName, $date, $phone, $nation,
                               $passportNumber, $validPassport, $gender, $arrive, $arrivalDate, $comments)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $worker = $this->db->editWorker($workerId, $firstName, $lastName, $date, $phone, $nation,
            $passportNumber, $validPassport, $gender, $arrive, $arrivalDate, $comments);
        $msg = $this->db->editWorkerPassport($workerId, $passportNumber, $validPassport);
        return $worker;

    }

    public function getWorkerHistory($workerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $worker = $this->db->getWorkerHistory($workerId);
        return $worker;
    }

}