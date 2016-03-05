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



}