<?php

require_once('./model/WorkerModel.php');
require_once('./model/CustomersModel.php');
require_once('./Configure.php');

/**
 * Class ExcelController
 */
class ExcelController
{
    private $workerModel;
    private $customerModel;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->workerModel = new WorkerModel();
        $this->customerModel = new CustomersModel();
    }

    /**
     * create workers file.
     */
    public function createWorkersFile()
    {
        $csv = $this->workerModel->createWorkersFile();
        echo $csv;
    }

    /**
     * create customers file.
     */
    public function createCustomersFile()
    {
        $csv = $this->customerModel->createCustomersFile();
        echo $csv;
    }

}