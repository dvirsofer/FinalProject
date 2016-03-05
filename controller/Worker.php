<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 16:39
 */

require_once('./model/WorkerModel.php');
require_once("./view/WorkerView.php");

class Worker
{
    private $workerModel;
    private $workerView;

    function __construct()
    {
        $this->workerModel = new WorkerModel();
        $this->workerView = new WorkerView();
    }

    function index()
    {
        $this->workerView->showWorker();
    }

}