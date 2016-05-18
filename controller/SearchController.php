<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./model/WorkerModel.php');
require_once('./public/lib/LCS.php');

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
        /*$employee = $_POST['employer_name_form'];
        $allWorkers = $this->workerModel->getAllWorkerOfCustomerInfo($employee);
        //error_log(var_export($allWorkers,true));
        //error_log(print_r($allWorkers, TRUE));
        echo(json_encode($allWorkers));*/

        $passport = $_POST['passport_number_form'];
        $passportInfo = $this->workerModel->getWorkerPassport($passport);
        $allWorkers = array();
        if(count($passportInfo) == 1) {
            // get all information of worker
            $workerId = $passportInfo[0]->worker_id;
            $worker = $this->workerModel->getWorkerInfo($workerId);
            array_push($allWorkers, $worker);
            echo(json_encode($allWorkers));
        }
        else {
            // LCS algorithm

            //search in database
            $allPassports = $this->workerModel->getAllPassports();
            foreach($allPassports as $pass) {
                $passportNumber = $pass->passport_number;
                $length = strlen($passport) * 0.75;
                $lcs = LCS::LCSAlgorithm($passport, $passportNumber);
                if($lcs[strlen($passport)][strlen($passportNumber)] >= $length) {
                    $workerId = $pass->worker_id;
                    $worker = $this->workerModel->getWorkerInfo($workerId);
                    array_push($allWorkers, $worker);
                }
            }
            echo(json_encode($allWorkers));
        }

        /*$name = $_POST['last_name_form'];
        $worker = $this->workerModel->getWorkerInfoByName($name);
        if(count($worker) == 1) {
            echo(json_encode($worker));
        }
        else {
            // LCS algorithm

            $allWorkers = $this->workerModel->getAllWorkers();
            $workers = array();
            foreach($allWorkers as $workerInfo) {
                $workerName = $workerInfo->last_name;
                $length = strlen($name) * 0.75;
                //$lcs = $this->LCS($name, $workerName);
                $lcs = LCS::LCSAlgorithm($name, $workerName);
                if($lcs[strlen($name)][strlen($workerName)] >= $length) {
                    array_push($workers, $workerInfo);
                }
            }
            error_log(print_r($workers, TRUE));
            echo(json_encode($workers));
        }*/
    }

    /**
     * search name.
     */
    public function searchByName()
    {
        $name = $_POST['last_name_form'];
        $worker = $this->workerModel->getWorkerInfoByName($name);
        if(count($worker) == 1) {
            echo(json_encode($worker));
        }
        else {
            // LCS algorithm
            $allWorkers = $this->workerModel->getAllWorkers();
            $workers = array();
            foreach($allWorkers as $workerInfo) {
                $workerName = $workerInfo->last_name;
                $length = strlen($name) * 0.75;
                $lcs = LCS::LCSAlgorithm($name, $workerName);
                if($lcs[strlen($name)][strlen($workerName)] >= $length) {
                    array_push($workers, $workerInfo);
                }
            }
            echo(json_encode($workers));
        }
    }

}