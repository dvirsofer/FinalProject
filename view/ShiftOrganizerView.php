<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:44
 */


require_once('./model/ShiftOrganizerModel.php');
require_once('./Configure.php');

class ShiftOrganizerView
{
    private $shiftOrganizerModel;


    /**
     * constructor
     */
    public function __construct()
    {
        $this->shiftOrganizerModel = new ShiftOrganizerModel();


    }

    public function showMainPage()
    {
        $_SESSION['user_id'] = unserialize($_SESSION['user'])[0]->id;
        $user_type =  unserialize($_SESSION['user'])[0]->type_id;
        $workersCount=  $this->shiftOrganizerModel->getWorkerAmount($_SESSION['user_id']);
        $employeeCount=  $this->shiftOrganizerModel->getEmployeeAmount($_SESSION['user_id']);
        $citiesCount=  $this->shiftOrganizerModel->getCitiesAmount($_SESSION['user_id']);
        $workersInProcessHtml =  $this->shiftOrganizerModel->getWorkersInProcessAmount($_SESSION['user_id']);
        include('./public/parts/workerOrganizer.html');
    }


}