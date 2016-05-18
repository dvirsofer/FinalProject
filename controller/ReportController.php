<?php

require_once('./model/ReportModel.php');
require_once('./view/ReportView.php');

/**
 * Class ReportController
 */
class ReportController
{
    private $reportModel;
    private $reportView;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->reportView = new ReportView();
    }

    /**
     * show report.
     */
    public function index()
    {
        $sameWorkers = array();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sameWorkers = $this->getAllSameWorkers();
        }
        $this->reportView->showReport($sameWorkers);
    }

    /**
     * @return array - all the duplicate workers.
     */
    private function getAllSameWorkers()
    {
        $workers = $this->reportModel->getAllWorkers();
        $sameWorkers = array();

        for($i = 0; $i < 1000; $i++) {
            $allWorkers = array();
            $workerName = $workers[$i]->last_name;
            $workerPassport = $workers[$i]->passport_number;
            array_push($allWorkers, $workers[$i]);
            for($j = $i + 1; $j < 1000; $j++) {
                $currWorker = $workers[$j];
                $lengthName = strlen($workerName) * 0.75;
                $lengthPassport = strlen($workerPassport) * 0.75;
                $lcsMatrix1 = LCS::LCSAlgorithm($workerName, $currWorker->last_name);
                $lcsMatrix2 = LCS::LCSAlgorithm($workerPassport, $currWorker->passport_number);
                if(($lcsMatrix1[strlen($workerName)][strlen($currWorker->last_name)] >= $lengthName) &&
                    ($lcsMatrix2[strlen($workerPassport)][strlen($currWorker->passport_number)] >= $lengthPassport)) {
                    array_push($allWorkers, $workers[$j]);
                    unset($workers[$j]);
                    $workers = array_values($workers);
                    //error_log(print_r($workers[$j], TRUE));
                    //error_log(print_r(count($workers), TRUE));
                }
            }
            if(count($allWorkers) > 1) {
                array_push($sameWorkers, $allWorkers);
            }
            //error_log(print_r($sameWorkers, TRUE));
        }
        return $sameWorkers;
    }

}