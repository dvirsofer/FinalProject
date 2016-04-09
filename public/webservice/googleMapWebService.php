<?php
//ini_set('display_errors', 1);
date_default_timezone_set('Asia/Tel_Aviv');
session_start();
require_once('../../Configure.php');
require_once('../lib/Response.php');
require_once('../lib/DB.php');
require_once('../api/GoogleApi.php');






$db = DB::getInstance();
$googleLatAndLog = new GoogleApi();



$db->checkConnection();
$sql ="SELECT
customer.settlement_id,
settlement.latitude,
settlement.longitude,
settlement.settlement_name,
settlement_name_in_english
FROM mbtm_workers.customer
 left join settlement on   customer.settlement_id  = settlement.id
 where responsible_id = ". $_SESSION['user_id'] . " and settlement_id is not null group by settlement_id;";

$result=$db->sql_query($sql);

if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$doc  = new SimpleXMLElement('<markers></markers>');
foreach ($result as $row){

    if($row->settlement_id != null );
    {

        if( $row->latitude == null || $row->longitude == null || $row->latitude < 30 || $row->longitude < 30)
        {

            $row->settlement_name_in_english =trim($row->settlement_name_in_english);

            $latLogArray=$googleLatAndLog->getLatAndLng($row->settlement_name_in_english);
            if($latLogArray == false){var_dump( $row->settlement_name_in_english);continue;}
            $res=$db->update('settlement',['latitude'=>$latLogArray['lat'],'longitude'=>$latLogArray['lng']],['settlement_name_in_english'=> $row->settlement_name_in_english]);
            $row->latitude =  $latLogArray['lat'];
            $row->longitude =  $latLogArray['lng'];

        }
        $newNode = $doc->addChild("marker");

        $newNode->addAttribute("name", $row->settlement_name);
        $newNode->addAttribute("address", $row->settlement_name);
        $newNode->addAttribute("lat", $row->latitude);
        $newNode->addAttribute("lng", $row->longitude);
        $newNode->addAttribute("type", "city");

    }

}

Header('Content-type: text/xml');

echo $doc->asXML();
