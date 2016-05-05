<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 09/02/2016
 * Time: 16:07
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

/**
 * Class UserModel
 */
class UserModel
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
     * @param $userName
     * @param $password
     * @return array - User.
     */
    public function getUser($userName, $password)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $userInfo = $db->getUserInfo($userName, $password);
        return $userInfo;
    }

    /**
     * @param $userId
     * @return array - User.
     */
    public function getUserById($userId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $user = $db->getUserById($userId);
        return $user;
    }

    /**
     * @param $typeId
     * @return array - user type.
     */
    public function getUserType($typeId)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $userType = $db->getUserType($typeId);
        return $userType;
    }

    /**
     * @param $userFirstName
     * @param $userLastName
     * @param $userName
     * @param $userEmail
     * @param $userPhone
     * @param $userPosition
     * @param $userPassword
     * @return string - message if success.
     */
    public function addUser($userFirstName, $userLastName, $userName, $userEmail, $userPhone, $userPosition, $userPassword)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $msg = $db->addNewUser($userFirstName, $userLastName, $userName, $userEmail, $userPhone,
            $userPosition, $userPassword);
        return $msg;
    }

    /**
     * @param $id
     * @param $userName
     * @param $userEmail
     * @param $userPhone
     * @param $userPassword
     * @param $userPasswordC
     * @param $userFirstName
     * @param $userLastName
     * @return Response - message if success.
     */
    public function updateUserInfo($id, $userName, $userEmail, $userPhone,
                            $userPassword, $userPasswordC, $userFirstName, $userLastName)
    {
        $response = new Response();
        $updatePassword = false;

        $db = DB::getInstance();
        $db->checkConnection();

        if(empty($userPassword) && empty($userPasswordC)) {
            $updatePassword = true;
        }
        if($this->checkPassword($userPassword, $userPasswordC) && !$updatePassword) {
            // need update user password
            $updatePassword = $db->updateUserPassword($id, $userPassword);
        }
        $result = $db->updateUserInfo($id, $userName, $userEmail, $userPhone, $userFirstName, $userLastName);
        if($result === true && $updatePassword === true){
            // update success
            $response->setSuccess(true);
            $response->setError(Response::UPDATE_SUCCESS);
        }
        else {
            $response->setSuccess(false);
            $response->setError(Response::UPDATE_ERROR);
        }
        return $response;
    }

    /**
     * @param $descriptionId
     * @param $status
     * @param $userId
     * @param $workerId
     * @param $description
     * @return string - message.
     */
    public function addActivity($descriptionId, $status, $userId, $workerId, $description)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $msg = $this->db->addActivity($descriptionId, $status, $userId, $workerId, $description);
        return $msg;
    }

    /**
     * @param $password
     * @param $passwordC
     * @return bool - validation password.
     */
    private function checkPassword($password, $passwordC)
    {
        if(!empty($password) || !empty($passwordC)) {
            if($password === $passwordC) {
                return true;
            }
            else {
                return false;
            }
        }
        return true;
    }

}