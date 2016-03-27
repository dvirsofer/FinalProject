<?php
include_once('../Configure.php');
require_once('../public/lib/Response.php');
require_once('../public/lib/DB.php');

$doc = domxml_new_doc("1.0");
$node = $doc->create_element("markers");
$parNode = $doc->append_child($node);


$connection = DB::getInstance();
$result=$connection->query('
SELECT
customer.settlement_id,
settlement.latitude,
settlement.longitude,
settlement.settlement_name,
settlement_name_in_english
FROM mbtm_workers.customer
 left join settlement on   customer.settlement_id  = settlement.id
 where responsible_id = $_SESSION["user"] group by settlement_id;');

if (!$result) {
    die('Invalid query: ' . mysql_error());
}
header("Content-type: text/xml");
foreach ($result as $row){
    $node = $doc->create_element("marker");
    $newNode = $parNode->append_child($node);
    $newNode->set_attribute("name", $row['settlement_name']);
    $newNode->set_attribute("address", $row['address']);
    $newNode->set_attribute("lat", $row['latitude']);
    $newNode->set_attribute("lng", $row['longitude']);
    $newNode->set_attribute("type", "city");
}
$xmlFile = $doc->dump_mem();
echo $xmlFile;
?>