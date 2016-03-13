<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 12/12/2015
 * Time: 20:14
 */

require_once('./public/api/GoogleApi.php');

class LocationModel {




    public function getGeoLocation($place ='')
    {

        if(isset($place)    &&  !empty($place))
            $l_place = $place;

        else
            die('place not set');


        $googleAPI = new GoogleApi();

        return  $googleAPI->getLatAndLng($l_place);

    }


    public function getDistance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);

    }



}