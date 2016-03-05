<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./model/WorkerModel.php');

/**
 * Class SearchController
 */
class SearchController
{

    private $workerModel;

    function __construct()
    {
        $this->workerModel = new WorkerModel();
//        $this->customersView = new CustomersView();
    }

    function searchByPassport()
    {
        $passportId = $_POST['passport_number_form'];

        //search in database
        $passport = $this->workerModel->getPassportInfo($passportId);
        error_log(var_export($passport,true));
        echo(json_encode($passport));
    }

}