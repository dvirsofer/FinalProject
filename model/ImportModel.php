<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 12/12/2015
 * Time: 20:14
 */

require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

class ImportModel {

    private $db;

    function __construct()
    {
        $this->db = DB::getInstance();
    }



    public function updateSettlements()
    {



    }

    public function getSettlementsXML()
    {
        $db = DB::getInstance();
        $res= simplexml_load_file("http://www.piba.gov.il/AuthorityUnits/Documents/yeshuvim_31012016.xml");

       // print_r($res);exit;
        $array=$res->ROW;
        foreach($array as $val)
        {


           // $this->db->checkConnection();
            $values =  [
           "symbol" => intval($val->סמל_ישוב),
           "settlement_name_in_english" => $val->שם_ישוב_לועזי,
                "settlement_name" => $val->שם_ישוב,
            "napa_name"=> $val->שם_נפה,
                "council_name" => $val->שם_מועצה
        ];

            $db = DB::getInstance();
            $db->checkConnection();
           $db->update("settlement",$values,["symbol" => intval($val->סמל_ישוב)]);
            echo $values['symbol'];
            echo '    ';
            echo $values['settlement_name_in_english'];
            echo '    ';
            echo $values['settlement_name'];
            echo '    ';
            echo $values['napa_name'];
            echo '    ';
            echo $values['council_name'];
            echo "</br>";
        }


    }






}