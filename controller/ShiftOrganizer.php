<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 20/03/2016
 * Time: 21:43
 */

require_once('./model/ShiftOrganizerModel.php');
require_once('./model/WorkerModel.php');
require_once("./view/ShiftOrganizerView.php");

class ShiftOrganizer {

    private $model;
    private $workerModel;
    private $view;
    private $test;


    function __construct()
    {
        try
        {
            $this->model = new ShiftOrganizerModel();
            $this->workerModel = new WorkerModel();
            $this->view = new ShiftOrganizerView();

        }
        catch(exaption $e)
        {
            echo $e->getMessage();
        }

    }

    function showWorkers()
    {

        if (!empty($_SESSION['user'])) {

           // $workers=$this->workerModel->getAllWorkerOfCustomerInfo($_SESSION['user']);
            $this->view->showMainPage();
        }
    }

}