<?php
//ini_set('display_errors', 1);
date_default_timezone_set('Asia/Tel_Aviv');
session_start();
require_once('../../Configure.php');
require_once('../lib/Response.php');
require_once('../lib/DB.php');






$db = DB::getInstance();



$db->checkConnection();
$sql ="SELECT
customer.settlement_id,
settlement.latitude,
settlement.longitude,
settlement.settlement_name,
settlement_name_in_english
FROM mbtm_workers.customer
 left join settlement on   customer.settlement_id  = settlement.id
 where responsible_id = ". $_SESSION['user_id'] . " group by settlement_id;";

$result=$db->sql_query($sql);

if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$doc  = new SimpleXMLElement('<root></root>');
foreach ($result as $row){

    if($row->settlement_id!=null);
    {
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
