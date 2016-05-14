<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 14/05/2016
 * Time: 11:43
 */
class Security
{
    public static function checkGetPostSqlInjection()
    {
        $checkExpressionsArr = [";", "1=1", '""=""', "''=''"];

        foreach ($_POST as $value) {
            foreach ($checkExpressionsArr as $expValue)
                if (strpos($value, $expValue)!= false) {
                    die('Error');
                }
        }

        foreach ($_GET as $value) {
            foreach ($checkExpressionsArr as $expValue)
                if (strpos($value, $expValue) != false) {
                    die('Error');
                }
        }

    }
}

