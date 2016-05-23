<?php

set_time_limit(1000);
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

    /**
     * @return array - all workers.
     */
    public function getAllWorkers()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $allWorkers = $this->db->getAllWorkersDetails();
        return $allWorkers;
    }

}