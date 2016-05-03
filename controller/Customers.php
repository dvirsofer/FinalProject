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

    /**
     * constructor
     */
    public function __construct()
    {
        $this->model = new CustomersModel();
        $this->customersView = new CustomersView();
        $this->workerModel = new WorkerModel();
    }

    /**
     * show customers.
     */
    public function index()
    {
        $id = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['customers_dropdown'])) {
                $id = $_POST['customers_dropdown'];
            }
            else {
                $id = "";
            }
        }
        $this->customersView->showCustomers($id);

    }

    public function newCustomer()
    {
        $customerName = $_POST['customer_name'];
        $customerNameEn = $_POST['customer_name_en'];
        $settlement = $_POST['settlement'];
        $mainCustomer = $_POST['main_customer'];
        $companyNumber = $_POST['company_number'];
        $agent = $_POST['dealer'];
        $msg = $this->model->newCustomer($customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent);
        return $msg;
    }

    public function updateCustomer()
    {
        $customerId = $_POST['customer_id'];
        $customerName = $_POST['customer_name'];
        $customerNameEn = $_POST['customer_name_en'];
        $settlement = $_POST['settlement'];
        $mainCustomer = $_POST['main_customer'];
        $companyNumber = $_POST['company_number'];
        $agent = $_POST['dealer'];
        $msg = $this->model->updateCustomer($customerId, $customerName, $customerNameEn, $settlement, $mainCustomer, $companyNumber, $agent);
        return $msg;

    }

}