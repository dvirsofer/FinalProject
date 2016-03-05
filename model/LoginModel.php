<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 01/12/2015
 * Time: 18:55
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');
class LoginModel {

    private $db;

    function __construct()
    {
        $this->db = DB::getInstance();
    }

    function checkLogin($userName,$password)
    {
        $response = new Response();

        $db = DB::getInstance();
        $db->checkConnection();
        $user = $db->isLogin($userName, $password);

        if ($user == false) {
            $response->setSuccess(false);
            $response->setError(Response::ERROR_LOGIN);
        }
        return $response;
    }

    function getUser($userName, $password)
    {
        $db = DB::getInstance();
        $db->checkConnection();
        $userInfo = $db->getUserInfo($userName, $password);
        $user = new User($userInfo{0}->id, $userInfo{0}->type_id, $userInfo{0}->user_name, $userInfo{0}->user_password,
            $userInfo{0}->user_id, $userInfo{0}->phone_number, $userInfo{0}->email, $userInfo{0}->create_date);

        return $user;
    }

     function lobby()
     {
         $user = $_SESSION['user'];
         if (empty($user)) {
             header('Location: index.php');
         } else {
             $lobby = new LobbyView();
             $lobby->showLobby($user);
         }
     }

    function logout()
    {
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
        header('Location: index.php');
    }

}