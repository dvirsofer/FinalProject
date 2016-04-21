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
            error_log(print_r("1", TRUE));
            $workerId = $passportInfo[0]->worker_id;
            $worker = $this->workerModel->getWorkerInfo($workerId);
            array_push($allWorkers, $worker);
            echo(json_encode($allWorkers));
        }
        else {
            // LCS algorithm

            //search in database
            $allPassports = $this->workerModel->getAllPassports();
            error_log(print_r("2", TRUE));
            foreach($allPassports as $pass) {
                $passportNumber = $pass->passport_number;
                $lcs = $this->LCS($passport, $passportNumber);
                if($lcs[strlen($passport)][strlen($passportNumber)] >= 6) {
                    //error_log(print_r($pass, TRUE));
                    $workerId = $pass->worker_id;
                    $worker = $this->workerModel->getWorkerInfo($workerId);
                    //error_log(print_r($worker, TRUE));
                    array_push($allWorkers, $worker);
                    //echo(json_encode($worker));
                }
            }

            //error_log(print_r($allWorkers, TRUE));
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
                $lcs = $this->LCS($name, $workerName);
                if($lcs[strlen($name)][strlen($workerName)] >= 5) {
                    array_push($workers, $workerInfo);
                }
            }
            error_log(print_r($workers, TRUE));
            echo(json_encode($workers));
        }*/
    }

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
                $lcs = $this->LCS($name, $workerName);
                if($lcs[strlen($name)][strlen($workerName)] >= 5) {
                    array_push($workers, $workerInfo);
                }
            }
            error_log(print_r($workers, TRUE));
            echo(json_encode($workers));
        }
    }

    function LCS($string1, $string2) {
        $lcs = array_fill(0, strlen($string1 + 1), array_fill(0, strlen($string2 + 1), 0));

        for($i = 0; $i <= strlen($string1); $i++) {
            $lcs[$i][0] = 0;
        }
        for($j = 0; $j <= strlen($string2); $j++) {
            $lcs[0][$j] = 0;
        }

        for($i = 1; $i <= strlen($string1); $i++) {
            for($j = 1; $j <= strlen($string2); $j++) {
                if($string1[$i - 1] === $string2[$j - 1]) {
                    $lcs[$i][$j] = $lcs[$i - 1][$j - 1] + 1;
                }
                else {
                    $lcs[$i][$j] = max($lcs[$i - 1][$j], $lcs[$i][$j - 1]);
                }
            }
        }
        return $lcs;
    }


}