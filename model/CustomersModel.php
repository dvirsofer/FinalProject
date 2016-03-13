<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

class CustomersModel
{

    private $db;

    function __construct()
    {
        $this->db = DB::getInstance();
    }

    function getCustomers()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllCustomersOrder();
        return $result;
    }

    function getAllContactsOfCustomerInfo($id)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->getAllContactsOfCustomerInfo($id);
        return $result;

    }

}