<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 07/12/2015
 * Time: 21:12
 */

class GoogleApi {
    private static $key = 'AIzaSyBRNiFCZPqNrK_-sQNjuFcIzZ9_4yZYitk';

    private static $url;

    function __construct()
    {
        self::$url='https://maps.googleapis.com/maps/api/geocode/json';

    }


public  function getLatAndLng($name)
    {
        $name = mb_strtolower($name);
        $name = str_replace("'","%27",$name);
        $name = str_replace(" ","%20",$name);
        $url =self::$url . '?address=' .$name .'&key='.self::$key.'&components=country:il';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,["User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"] );
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result= curl_exec ($ch);
        curl_close ($ch);
        $resultsObj = json_decode($result);
        $shortName = mb_strtolower($resultsObj->results[0]->address_components[0]->short_name);
        $longName = mb_strtolower($resultsObj->results[0]->address_components[0]->long_name);


        if (strpos(rawurlencode($shortName), $name) !== false || strpos(rawurlencode($longName), $name) !== false)
        {
            $borders['lat'] = ($resultsObj->results[0]->geometry->bounds->northeast->lat + $resultsObj->results[0]->geometry->bounds->southwest->lat)/2.0;
            $borders['lng'] =  ($resultsObj->results[0]->geometry->bounds->northeast->lng + $resultsObj->results[0]->geometry->bounds->southwest->lng)/2.0;
            return $borders;
        }

        else {

            return false;
        }

    }

}