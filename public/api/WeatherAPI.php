<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 07/12/2015
 * Time: 17:31
 */

class WeatherAPI {
    private static $key = '6d617ec82d1dc9ab4c939389aa0a35cd';
    private static $url;

    function __construct()
    {
        self::$url='https://api.forecast.io/forecast/'.self::$key;
    }


    public function getWeatherByPlace($latitude,$longitude,$time ='')
    {
        $url =  self::$url. '/'. $latitude .',' .$longitude;

        $url .= !empty($time)?','.$time:'';
        $url .= '?units=si';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") );
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result= curl_exec ($ch);
        curl_close ($ch);
        return $result;


    }


}