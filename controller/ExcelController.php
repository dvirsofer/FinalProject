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
        //header('Content-Type: text/csv; charset=utf-8');
        //header('Content-Disposition: attachment; filename=members.csv');

        $csv = $this->workerModel->createExcelFile();
        echo $csv;

    }

}