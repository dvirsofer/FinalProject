<?php

require_once('./model/WorkerModel.php');
require_once('./Configure.php');

/**
 * Class ExcelController
 */
class ExcelController
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
     * create excel file.
     */
    public function createExcelFile()
    {
        $this->workerModel->createExcelFile();
        /*error_log(print_r("a", TRUE));
        $workers = $this->workerModel->getAllWorkersDetails();
        //error_log(print_r($workers, TRUE));
        $num_fields = count($workers);
        $headers = array();
        for ($i = 0; $i < $num_fields; $i++) {
            $headers[] = $workers[$i];
        }
        $fp = fopen('php://output', 'w');
        if ($fp && $workers) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="export.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
            fputcsv($fp, $headers);
        }*/

    }

}