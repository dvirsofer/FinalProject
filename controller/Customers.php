<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./model/CustomersModel.php');
require_once("./view/CustomersView.php");
require_once('./model/WorkerModel.php');

/**
 * Class Customers
 */
class Customers
{
    private $model;
    private $customersView;
    private $workerModel;

    function __construct()
    {
        $this->model = new CustomersModel();
        $this->customersView = new CustomersView();
        $this->workerModel = new WorkerModel();
    }

    function index()
    {
        $id = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['customers_dropdown'];
        }
        $this->customersView->showCustomers($id);

    }

    function getCustomerInfoById()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['customers_dropdown'];
            $workerTable = $this->customersView->createWorkersTable($id);
            echo($workerTable);
        }
    }



}