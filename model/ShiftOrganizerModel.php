<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 20/03/2016
 * Time: 22:02
 */
require_once('./public/lib/Response.php');
require_once('./public/lib/DB.php');

class ShiftOrganizerModel {
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

}