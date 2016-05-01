<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30/04/2016
 * Time: 11:34
 */

require_once('./model/ActivityModel.php');
require_once("./view/ActivityView.php");

/**
 * Class ActivityController
 */
class ActivityController
{
    private $activityModel;
    private $activityView;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->activityModel = new ActivityModel();
        $this->activityView = new ActivityView();
    }

    /**
     * show activity page.
     */
    public function index()
    {
        $this->activityView->showActivity();
    }

    /**
     * show all activities page.
     */
    public function allActivities()
    {
        $this->activityView->showAllActivities();
    }

    public function editActivity()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $activityId = $_POST['activity_id'];
            $this->activityModel->editActivity($activityId);
        }

    }

    public function cancelActivity()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $activityId = $_POST['activity_id'];
            $this->activityModel->updateCancelActivity($activityId);
        }
    }



}