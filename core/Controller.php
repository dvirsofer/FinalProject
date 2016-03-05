<?php
/**
 * Created by PhpStorm.
 * User: IgorB
 * Date: 28/11/2015
 * Time: 15:40
 */

class Controller {

   protected $db;

    function __construct()
    {
        require_once('../public/DB');
       $this->db = DB::getInstance();



        
    }

    function  test()
    {

    }


}