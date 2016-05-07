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
        $csv = $this->workerModel->createExcelFile();
        echo $csv;
//        $now = gmdate("D, d M Y H:i:s");
//        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
//        header("Last-Modified: {$now} GMT");
//
//        // force download
//        header("Content-Type: text/csv; charset=utf-8");
//        header("Content-Disposition: attachment; filename=Workers_{$now}.csv");
//
//        $fh = @fopen('php://output', 'w');
//
//        fwrite($fh, $csv);
//
//        fclose($fh);
    }

}