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

}