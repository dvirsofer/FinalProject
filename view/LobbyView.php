<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 01/12/2015
 * Time: 18:41
 */

require_once('./model/UserModel.php');

class LobbyView {

    private $userNmae;

    /**
     * @param $userName
     */
    public function showLobby($userName)
    {
        $user = unserialize($_SESSION['user']);
        $this->userName = $user[0]->user_name;
        include('./public/parts/top.php');

        echo "<body>
        <!-- Navbar --> ";
        include('./public/parts/nav.php');
        echo " </body>";

    }

}