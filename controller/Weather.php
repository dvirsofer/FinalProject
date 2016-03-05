<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 07/12/2015
 * Time: 17:54
 */



require_once('./model/WeatherModel.php');
require_once('./model/LocationModel.php');

class Weather {

    private static $model;
    private static $locationModel;


    function __construct()
    {


        if (!isset(self::$model)) {
            self::$model = new WeatherModel();
        }

        if (!isset(self::$locationModel))
        self::$locationModel = new LocationModel();



    }

    public  function index()
    {
        echo 'ttt';
    }

    public function getWeather($data = '')
    {

        if(isset($data) && !empty($data))
        {
            if(is_array($data) && count($data) ==2)
            {
                $place = $data[0];
                $time = $data[1];
            }
            else
            {
                $place = $data;
                $time = time();
            }

        }
        else
            die('no data');

        if(isset($place) && !empty($place)) {
            $bounds = self::$locationModel->getGeoLocation($place);

            if($bounds != false) {

                self::$model->getForecast($bounds,$time);
            }
        }
    }


    public function testDB()
    {
        require_once('./public/lib/DB.php');
        $db = DB::getInstance();
        $db->checkConnection();
        $res =$db->getTableData('name');

        var_dump($res);
    }

}