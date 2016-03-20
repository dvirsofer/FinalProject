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


}