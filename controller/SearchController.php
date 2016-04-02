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
        echo(json_encode($allWorkers));
    }

    /**
     * search passport.
     */
    public function searchByPassport()
    {
        $employee = $_POST['employer_name_form'];
        $allWorkers = $this->workerModel->getAllWorkerOfCustomerInfo($employee);
        //error_log(var_export($allWorkers,true));
        //error_log(print_r($allWorkers, TRUE));
        echo(json_encode($allWorkers));

        /*$passport = $_POST['passport_number_form'];

        //search in database
        $passports = $this->workerModel->getAllPassports();

        //error_log(var_export($passport,true));
        echo(json_encode($passport));*/
    }

    public function searchByName()
    {
        $name = $_POST['last_name_form'];
        var_dump($name);

        echo(json_encode($name));
    }

}