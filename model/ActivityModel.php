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

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function getAllActivities()
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $allActivities = $this->db->getAllActivities();
        return $allActivities;
    }

    public function getActivityType($id)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $activityType = $this->db->getActivityType($id);
        return $activityType;
    }

}