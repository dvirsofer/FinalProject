<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 20/03/2016
 * Time: 21:43
 */

require_once('./model/ShiftOrganizerModel.php');
require_once("./view/ShiftOrganizerView.php");

class ShiftOrganizer {

    private static $model;

    function __construct()
    {

        try
        {
            self::$model = new ShiftOrganizerModel();

        }
        catch(exaption $e)
        {
            echo $e->getMessage();
        }

    }

}