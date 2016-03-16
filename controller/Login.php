<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 01/12/2015
 * Time: 18:16
 */

require_once('./model/User.php');
require_once('./model/UserModel.php');
require_once('./model/LoginModel.php');
require_once("./view/LoginView.php");
require_once("./view/LobbyView.php");

/**
 * Class Login
 */
class Login
{
    private $model;
    private $loginView;
    private $lobbyView;
    private $userModel;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->model = new LoginModel();
        $this->loginView = new LoginView();
        $this->lobbyView = new LobbyView();
        $this->userModel = new UserModel();
    }

    /**
     * show lobby - if userName and password in database.
     */
    public function index()
    {
        //if user exist -- session exist
        if (!empty($_SESSION['user'])) {
            $this->lobbyView->showLobby($_SESSION['user']);
        }

        // user not exist
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $userName = $_POST['inputId'];
            $password = $_POST['inputPassword'];
            $response = $this->model->checkLogin($userName, $password);

            if ($response->isSuccess()) {
                //$user = $this->model->getUser($userName, $password);
                $user = $this->userModel->getUser($userName, $password);
                $_SESSION['user'] = serialize($user);
                //var_dump($user); exit;
                //$this->lobbyView->showLobby($user->getUserName());
                $this->lobbyView->showLobby($user[0]->user_name);
            }
            else {
                $this->loginView->showLogin(false, $response->getErrorMessage());
            }
        }
        else{
            $this->loginView->showLogin(true);
        }
    }

    /**
     * logout of the user.
     */
    public function logout()
    {
        $this->model->logout();
    }

}






