<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 17/12/2015
 * Time: 11:50
 */
class User
{
    private $id;
    private $typeId;
    private $userName;
    private $userPassword;
    private $userId;
    private $phoneNumber;
    private $email;
    private $createDate;

    /**
     * @param $id
     * @param $typeId
     * @param $userName
     * @param $userPassword
     * @param $userId
     * @param $phoneNumber
     * @param $email
     * @param $createDate
     */
    function __construct($id, $typeId, $userName, $userPassword, $userId, $phoneNumber, $email, $createDate)
    {
        $this->id = $id;
        $this->typeId = $typeId;
        $this->userName = $userName;
        $this->userPassword = $userPassword;
        $this->userId = $userId;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->createDate = $createDate;
    }

    function getTypeId()
    {
        return $this->typeId;
    }

    function getUserName()
    {
        return $this->userName;
    }

    function getUserPassword()
    {
        return $this->userPassword;
    }

    function getUserId()
    {
        return $this->userId;
    }

    function getUserPhone()
    {
        return $this->phoneNumber;
    }

    function getUserEmail()
    {
        return $this->email;
    }

    function getUserCreateDate()
    {
        return $this->createDate;
    }

}