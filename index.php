<?php



//phpinfo();exit;
if(!isset($_SESSION))
    session_start();



require_once("Router.php");
Router::route($_SERVER['REQUEST_URI']);

Router::dispatch();
