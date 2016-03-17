<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21/12/2015
 * Time: 14:18
 */

require_once('./model/UserModel.php');
require_once("./view/UserProfileView.php");

/**
 * Class UserProfileController
 */
class UserProfileController
{
    private $userModel;
    private $userView;
    private $user;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->user = unserialize($_SESSION['user']);
        $this->userModel = new UserModel();
        $this->userView = new UserProfileView();
    }

    public function fFf()
    {
        echo 'jjjj';
    }

    /**
     * Show user profile page.
     */
    public function index()
    {
        $this->userView->showUserProfile();
    }

    /**
     * Show user settings page.
     */
    public function settings()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userName = $_POST['userName'];
            $userEmail = $_POST['userEmail'];
            $userPhone = $_POST['userPhone'];
            $id = $this->user[0]->user_id;
            $userPassword = $_POST['userPassword'];
            $userPasswordC = $_POST['userPasswordC'];
            $userFirstName = $_POST['userFirstName'];
            $userLastName = $_POST['userLastName'];
            $response = $this->userModel->updateUserInfo($id, $userName,
                $userEmail, $userPhone, $userPassword, $userPasswordC, $userFirstName, $userLastName);
            if($response->isSuccess()) {
                $this->userView->showSettings(true, $response->getErrorMessage());
            }
            else {
                $this->userView->showSettings(false, $response->getErrorMessage());
            }
        }
        else {
            $this->userView->showSettings();
        }
    }

    /**
     * Show add user page.
     */
    public function addUser()
    {
        $this->userView->showAddUser();
    }

    /**
     * @return string - message if success.
     */
    public function newUser()
    {
        $userFirstName = $_POST['userFirstName'];
        $userLastName = $_POST['userLastName'];
        $userName = $_POST['userName'];
        $userEmail = $_POST['userEmail'];
        $userPhone = $_POST['userPhone'];
        $userPosition = $_POST['position'];
        $userPassword = $_POST['userPassword'];
        $user = $this->userModel->addUser($userFirstName, $userLastName, $userName, $userEmail, $userPhone,
            $userPosition, $userPassword);
        return $user;

    }

}