<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 12/12/2015
 * Time: 20:12
 */

require_once('./public/api/WeatherAPI.php');



class WeatherModel {


    public function getForecast($bounds,$time='')
    {


        if(!isset($time) || $time == '')
            $time =  false;
        



        $weatherAPI = new WeatherAPI();
       $ee= $weatherAPI->getWeatherByPlace($bounds['lat'],$bounds['lng'],$this->iso8601($time));


        var_dump(json_decode($ee)->currently);
    }



    private function iso8601($time=false) {
        if ($time === false)
            $time = time();


     //   $datetime1 = date_create('2009-10-11');
      //  $datetime2 = date_create('2009-10-13');
       // $interval = date_diff($datetime1, $datetime2);
        //echo $interval->format('%R%a days');

       // exit;
      //  var_dump($datetime1->);exit;

        $date = date('Y-m-d\TH:i:sO', $time);
        return (substr($date, 0, strlen($date)-2).':'.substr($date, -2));
    }

}