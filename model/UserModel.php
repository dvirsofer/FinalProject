<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 09/02/2016
 * Time: 16:07
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

class UserModel
{
    private $db;

    function __construct()
    {
        $this->db = DB::getInstance();
    }

    function getUser($userName, $password)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $userInfo = $db->getUserInfo($userName, $password);
        return $userInfo;
    }

    function addUser($userFirstName, $userLastName, $userName, $userEmail, $userPhone, $userPosition, $userPassword)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        error_log(var_export($userName,true));
        error_log(var_export($userEmail,true));
        error_log(var_export($userPhone,true));
        error_log(var_export($userPosition,true));
        error_log(var_export($userPassword,true));
        $msg = $db->addNewUser($userFirstName, $userLastName, $userName, $userEmail, $userPhone,
            $userPosition, $userPassword);
        return $msg;
    }

    function updateUserInfo($id, $userName, $userEmail, $userPhone,
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

    function checkPassword($password, $passwordC)
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