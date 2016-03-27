<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./model/WorkerModel.php');

/**
 * Class SearchController
 */
class SearchController
{

    private $workerModel;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->workerModel = new WorkerModel();
    }

    /**
     * Search the all workers of customer.
     */
    public function searchByEmployee()
    {
        $employee = $_POST['employer_name_form'];
        $allWorkers = $this->workerModel->getAllWorkerOfCustomerInfo($employee);
        //error_log(var_export($allWorkers,true));
        echo(json_encode($allWorkers));
    }

    /**
     * search passport.
     */
    public function searchByPassport()
    {
        $passportId = $_POST['passport_number_form'];

        //search in database
        $passport = $this->workerModel->getPassportInfo($passportId);
        //error_log(var_export($passport,true));
        echo(json_encode($passport));
    }

}