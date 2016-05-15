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
        $this->reportView->showReport();
    }

    public function getAllSameWorkers()
    {
        $workers = $this->reportModel->getAllWorkers();
        $sameWorkers = array();

        for($i = 0; $i < count($workers); $i++) {
            $workerName = $workers[$i]->last_name;
            $workerPassport = $workers[$i]->passport_number;
            for($j = $i + 1; $j < count($workers); $j++) {
                $lcsMatrix1 = LCS::LCSAlgorithm($workerName, $workers[$j]->last_name);
                $lcsMatrix2 = LCS::LCSAlgorithm($workerPassport, $workers[$j]->passport_number);
                if(($lcsMatrix1[strlen($workerName)][strlen($workers[$j]->last_name)] >= 6) &&
                    ($lcsMatrix2[strlen($workerPassport)][strlen($workers[$j]->passport_number)] >= 6)) {
                    array_push($sameWorkers, $workers[$j]);
                    unset($workers[$j]);
                    $workers = array_values($workers);
                    error_log(print_r($workers[$j], TRUE));
                    error_log(print_r(count($workers), TRUE));
                }
            }
            error_log(var_export($i, TRUE));
        }
        return $sameWorkers;
    }

}