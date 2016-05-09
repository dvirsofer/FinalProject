<?php

ini_set("display_errors", 1);
set_time_limit(300);
require_once('./public/lib/DB.php');
require_once('./public/lib/LCS.php');

/**
 * Class ReportModel
 */
class ReportModel
{
    private $db;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function getAllSameWorkers($workers)
    {
        $sameWorkers = array();

        /*for($i = 0; $i < count($workers); $i++) {
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
        }*/
        return $sameWorkers;
    }



}