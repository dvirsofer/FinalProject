<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 26/11/2015
 * Time: 16:17
 */
require_once('Configure.php');

class Router {
    private static $uriArray;
    private static $controller;
    private static $action;
    private static $data;
    private static $controllerObject;


    public static function route($url)
    {

        $config = parse_ini_file('config.ini');

       //if(SERVER_NAME == 'http://localhost:8000/finalProject')

        self::$uriArray =explode('/',$url);
        array_shift(self::$uriArray);
        self::checkController($config);

        self::checkAction($config);

        self::setData();
    }

    private static function checkController($config)
    {

        if(isset(self::$uriArray[0]) &&  file_exists('controller/' . self::$uriArray[0] . '.php'))
        {
            self::$controller = self::$uriArray[0];
            array_shift(self::$uriArray);
        }
        else
            self::$controller =$config['default_controller'];
    }

    private static function checkAction($config)
    {
        require_once('controller/'.self::$controller . '.php');
        self::$controllerObject = new  self::$controller();

        if(isset(self::$uriArray[0]) &&  method_exists( self::$controllerObject,self::$uriArray[0]))
        {
            self::$action = self::$uriArray[0];
            array_shift(self::$uriArray);
        }
        else
             self::$action = $config['default_action'];
    }

    private static function setData()
    {
        if(isset(self::$uriArray))
            self::$data =self::$uriArray;
    }

    public static function dispatch()
    {

        //$object = new  self::$controller();
        $action = self::$action;
        if(isset(self::$data) && count(self::$data) > 0)
        {
            if(count(self::$data) == 1)
                self::$data = self::$data[0];

            self::$controllerObject->$action(self::$data);
        }
        else {
            self::$controllerObject->$action();
        }
    }
}