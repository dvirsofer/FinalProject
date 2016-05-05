<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30/04/2016
 * Time: 11:35
 */

require_once('./public/lib/DB.php');

/**
 * Class ActivityModel
 */
class ActivityModel
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
     * @return array - all activities.
     */
    public function getAllActivities()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $allActivities = $this->db->getAllActivities();
        return $allActivities;
    }

    /**
     * @return array - all open activities.
     */
    public function getAllOpenActivities()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $activities = $this->db->getAllOpenActivities();
        return $activities;
    }

    /**
     * @param $id
     * @return array - activity type.
     */
    public function getActivityType($id)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $activityType = $this->db->getActivityType($id);
        return $activityType;
    }

    /**
     * @param $activityId
     * @return bool
     */
    public function editActivity($activityId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $result = $this->db->editActivity($activityId);
        return $result;
    }

    /**
     * @param $activityId
     * @return bool
     */
    public function updateCancelActivity($activityId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $msg = $this->db->updateCancelActivity($activityId);
        return $msg;
    }

}