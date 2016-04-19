<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 16:39
 */

require_once('./model/WorkerModel.php');
require_once("./view/WorkerView.php");

/**
 * Class Worker
 */
class Worker
{
    private $workerModel;
    private $workerView;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->workerModel = new WorkerModel();
        $this->workerView = new WorkerView();
    }

    /**
     * Show worker page.
     */
    public function index()
    {
        $id = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['select_worker'];
        }
        $this->workerView->showWorker($id);
    }

    public function newWorker()
    {
        error_log(print_r("worker", TRUE));
    }

}