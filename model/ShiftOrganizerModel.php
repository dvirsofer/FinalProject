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

    public function getWorkerAmount($responsible_id)
    {

        $this->db->checkConnection();
        $res= $this->db->getTableData('forgen_workes',['responsible_id'=>$responsible_id],'count(*)');

        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';


    }

    public function getEmployeeAmount($responsible_id)
    {
        $this->db->checkConnection();
        $res= $this->db->getTableData('customer',['responsible_id'=>$responsible_id],'count(*)');
        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';
    }


    public function getCitiesAmount($responsible_id)
    {
        $this->db->checkConnection();
        $res= $this->db->getTableData('customer',['responsible_id'=>$responsible_id],'count(distinct settlement_id)');
        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';
    }

    public  function  getWorkersInProcessAmount($responsible_id)
    {
        $this->db->checkConnection();
        $res= $this->db->getTableData('activity',['user_id'=>$responsible_id,'status_description'=>'open'],'count(*)');
        if($res != false)
            return $res[0]->funcColumn;
        return 'sql error';
    }

    public  function  getWorkersInProcess($responsible_id)
    {
        $this->db->checkConnection();
        $res= $this->db->sql_query(
            "select first_name,last_name,from_customer,new_customer from
            (
                (
                    select user_id,worker_id,customer_id,new_customer_id
                    from activity
                    where user_id =".$responsible_id." and status_description = 'open'
                ) as activity
	        inner join
                (
                    select last_name,first_name,id
                    from forgen_workes
                ) as forgen_workes
	        on forgen_workes.id = activity.worker_id
            left join
              (
                select id,customer_name as from_customer from customer where responsible_id =".$responsible_id."
              ) as fc
	        on activity.customer_id = fc.id
	        left join
            (
              select id,customer_name as new_customer from customer where responsible_id =".$responsible_id."
            ) as nc
	on activity.new_customer_id = nc.id;");




        $commentHtml='';
        if($res != false) {
            foreach ($res as $value) {
                $commentHtml .= "<li>

                            <div>
                                <strong>$value->first_name $value->last_name</strong>
                                    <span class='pull-right text-muted'>
                                        <em>ממתין לאישור העברה</em>
                                    </span>
                            </div>
                            <div>
                            ממעסיק
                            $value->from_customer
                            למעסיק
                            $value->new_customer
                            </div>

                    </li>
                    <li class='divider'></li>";


            }
            return $commentHtml;
        }
        return 'sql error';
    }



}