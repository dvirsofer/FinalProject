
<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 12/12/2015
 * Time: 20:26
 */
require_once('./model/ImportModel.php');
class Import {

    private static $model;

    function __construct()
    {

        try
        {
            self::$model = new ImportModel();

        }
        catch(exaption $e)
        {
            echo $e->getMessage();
        }

    }


    public function importSettlements()
    {
     //   echo 'start importing..';
        self::$model->getSettlementsXML();


    }


    public function index()
    {
        var_dump('test');exit;
    }
}