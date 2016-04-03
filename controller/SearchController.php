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
        $passportInfo = $this->workerModel->getPassportInfo($passport);
        if(count($passportInfo) == 1) {
            // get all information of worker
            $workerId = $passportInfo[0]->worker_id;
            $worker = $this->workerModel->getWorkerInfo($workerId);
            echo(json_encode($worker));
        }
        else {
            // LCS algorithm

            //search in database
            $allPassports = $this->workerModel->getAllPassports();
            $allWorkers = array();
            foreach($allPassports as $pass) {
                if($this->LCS($passport, $pass) >= 4) {
                    $workerId = $passportInfo[0]->worker_id;
                    $worker = $this->workerModel->getWorkerInfo($workerId);
                    array_push($allWorkers, $worker);
                }
            }
            //error_log(print_r($allPassports, TRUE));
            //error_log(var_export($passport,true));
            //error_log(print_r($allWorkers, TRUE));
            echo(json_encode($allWorkers));
        }
    }

    public function searchByName()
    {
        $name = $_POST['last_name_form'];
        var_dump($name);

        echo(json_encode($name));
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