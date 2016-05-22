<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

/**
 * Class CustomersModel
 */
class CustomersModel
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
     * @return array - All customers
     */
    public function getCustomers()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllCustomersOrder();
        return $result;
    }

    /**
     * @return array - All customers details.
     */
    public function getAllCustomersDetails()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllCustomersDetails();
        return $result;
    }

    /**
     * @param $id - customer id.
     * @return array - All contacts of this customer.
     */
    public function getAllContactsOfCustomerInfo($id)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllContactsOfCustomerInfo($id);
        return $result;

    }

    /**
     * @param $customerId - customer id.
     * @return array - All information of this customer.
     */
    public function getCustomerInfo($customerId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getCustomerInfo($customerId);
        json_encode($result);
        return $result;
    }

    /**
     * @param $sid - Settlement id.
     * @return array - All information of this settlement.
     */
    public function getSettlement($sid)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getSettlement($sid);
        return $result;
    }

    /**
     * @return array - all settlements.
     */
    public function getAllSettlements()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllSettlements();
        return $result;
    }

    /**
     * @param $customerName
     * @param $customerNameEn
     * @param $settlement
     * @param $mainCustomer
     * @param $companyNumber
     * @param $agent
     * @return string - message.
     */
    public function newCustomer($customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->addNewCustomer($customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent);
        return $result;
    }

    /**
     * @return array - all agents.
     */
    public function getAllAgent()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $allAgents = $this->db->getAllAgent();
        return $allAgents;
    }

    /**
     * @param $customerId
     * @param $customerName
     * @param $customerNameEn
     * @param $settlement
     * @param $mainCustomer
     * @param $companyNumber
     * @param $agent
     * @return bool
     * true - if update success.
     * false - else.
     */
    public function updateCustomer($customerId, $customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $msg = $this->db->updateCustomer($customerId, $customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent);
        return $msg;
    }

    /**
     * @return string - all customers.
     */
    public function createCustomersFile()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $csv = $this->db->createCustomersFile();
        return $csv;
    }

    public function getAllCustomersOfUser($userId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $customers = $this->db->getAllCustomersOfUser($userId);
        return $customers;
    }

}