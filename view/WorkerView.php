<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 16:40
 */

require_once('./model/WorkerModel.php');
require_once('./model/CustomersModel.php');
require_once('./model/UserModel.php');
require_once('./Configure.php');

/**
 * Class WorkerView
 */
class WorkerView
{
    private $workerModel;
    private $customerModel;
    private $userName;
    private $workerId;
    private $userFullName;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->workerModel = new WorkerModel();
        $this->customerModel = new CustomersModel();
    }

    /**
     * Show worker.
     */
    public function showWorker($id='')
    {
        $user = unserialize($_SESSION['user']);
        $this->userFullName = $user[0]->full_name;
        $this->workerId = $id;

        if (empty($user)) {
            header('Location: index.php');
        }

        $html = '<!DOCTYPE html>
                <html lang="en">';

        include("./public/parts/top.php");

        $html .= '<body>
             <!--NavBar-->';

        include("./public/parts/nav.php");

        $html .= '
        <form class="form-inline panel flip">
    <div class="panel panel-default row">
        <div class="panel-body col-md-offset-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#flight_ticket"><span class="fa fa-plane"></span> כרטיס טיסה</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mobility"><span class="glyphicon glyphicon-transfer"></span> ניוד</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_worker"><span class="fa fa-edit"></span> עדכן עובד</button>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_worker"><span class="fa fa-plus"></span> הוסף עובד</button>
        </div>
    </div>
</form>
';
        $html .= '
<div class="panel-group" id="accordion">
    <!-- Search Worker -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseOne">חיפוש עובד
                   <span class="fa fa-search"></span>
                </a>
            </h4>
        </div>

        <div class="row">
            <div id="collapseOne" class="panel-collapse collapse in">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <select class="form-control col-sm-2" id="search_dropdown">
                            <option value="">בחר חיפוש</option>
                            <option value="form_by_employee">לפי מעסיק</option>
                            <option value="form_by_name">לפי שם משפחה</option>
                            <option value="form_by_passport">לפי מספר דרכון</option>
                        </select>
                    </div>
                </div>

                <div class="panel-body" id="forms_panel">

                    <form class="form-inline panel" id="form_by_employee" style="display: none;">
                        <div class="form-group">
                            <label for="employer_name">שם מעסיק</label>
                            <select class="form-control " id="employer_name_form" name="employer_name_form">';
                                $html .= $this->createAllCustomers();
                                $html .= '</select>
                        </div>
                        <button type="submit" class="btn btn-success">חיפוש</button>
                    </form>

                     <form class="form-inline panel" id="form_by_name" style="display: none;">
                        <div class="form-group">
                            <label for="employer_name">שם משפחה</label>
                            <input type="text" class="form-control" id="last_name_form" name="last_name_form">
                        </div>
                        <button type="submit" class="btn btn-success">חיפוש</button>
                    </form>

                    <form class="form-inline panel" id="form_by_passport" style="display: none;">
                        <div class="form-group">
                            <label for="passport_number">מספר דרכון</label>
                            <input type="text" class="form-control" id="passport_number_form" name="passport_number_form">
                        </div>
                        <button type="submit" class="btn btn-success">חיפוש</button>
                    </form>

                </div>

                <div class="panel panel-default col-md-12">
                    <form class="form-inline panel" id="select_worker_form" method="post">
                        <div class="form-group">
                            <label for="employer_name">כל העובדים</label>
                            <select class="form-control" id="select_worker" name="select_worker">
                                <option value="0">חיפוש</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">הצג פרטים</button>
                    </form>
                </div>

            </div>
        </div>
    </div>';

        $html .= '

    <!-- Worker information -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseTwo">פרטי עובד
                   <span class="fa fa-info-circle"></span>
                </a>
            </h4>
        </div>

        <div class="row">
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <form class="form-horizontal">';

        if(!empty($id)) {
            $workerInfo = $this->workerModel->getWorkerInfo($id);
            $passport = $this->workerModel->getPassportInfo($id);
            $customerId = $workerInfo[0]->current_customer_id;
            error_log(print_r($workerInfo[0]->worker_status, TRUE));
            if($workerInfo[0]->worker_status == 0) {
                error_log(print_r("a", TRUE));
                $workerStatus = "פעיל";
            }
            else {
                error_log(print_r("b", TRUE));
                $workerStatus = "לא פעיל";
            }
            if(!empty($customerId)) {
                $customer = $this->customerModel->getCustomerInfo($customerId);
                $customerName = $customer[0]->customer_name;
            }
            else {
                $customerName = "";
            }

            $html .= '
            <div class="col-md-4">
                <div class="form-group">
                    <label for="passport_number" class="col-sm-3 control-label">מספר דרכון</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="passport_number" value="'. $passport[0]->passport_number .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label">שם משפחה</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="last_name" value="'. $workerInfo[0]->last_name .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nation" class="col-sm-3 control-label">לאום</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="nation" value="'. $workerInfo[0]->citizen .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="col-sm-3 control-label">תאריך לידה</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="date" value="'. $workerInfo[0]->birthday_date .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number" class="col-sm-3 control-label">טלפון</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="phone_number" value="'. $workerInfo[0]->phone_number .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="customer" class="col-sm-3 control-label">מעסיק</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="customer" value="'. $customerName .'">
                    </div>
                </div>

                <div class = "form-group">
                    <label for="comments" class="col-sm-3 control-label">הערות</label>
                    <div class="col-md-9">
                        <textarea class = "form-control" rows = "5" value="'. $workerInfo[0]->note .'"></textarea>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="status" class="col-sm-3 control-label">סטטוס</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="status" value="'. $workerStatus .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-3 control-label">שם פרטי</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="first_name" value="'. $workerInfo[0]->first_name .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">מין</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="gender" value="'. $workerInfo[0]->gender .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="arrive" class="col-sm-3 control-label">צורת הגעה</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="arrive" value="'. $workerInfo[0]->form_of_eravel .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="arrival_date" class="col-sm-3 control-label">הגעה לארץ</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="arrival_date" value="'. $workerInfo[0]->entrance_date .'">
                    </div>
                </div>

                <div class="form-group">
                    <label for="exit_date" class="col-sm-3 control-label">יציאה מהארץ</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="exit_date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="valid_passport" class="col-sm-3 control-label">תוקף דרכון</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="valid_passport" value="'. $passport[0]->validation_date .'">
                    </div>
                </div>
            </div>';
        }
        $html .= '
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- history -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseThree">היסטוריית מעסיקים וסטטוסים
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="col-md-12">
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="contacts">
                        <thead>
                            <tr>
                            <th> מעסיק</th>
                            <th> מתאריך</th>
                            <th> עד תאריך</th>
                            </tr>
                        </thead>

                        <tbody>';

        $html .= $this->createWorkerHistory();

        $html .= '</tbody>
                  </table>
                </div>
            </div>
            </div>
        </div>
    </div>';

        $html .= '
       <!-- Modals -->
<div class="modal fade" id="flight_ticket" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">';
        $html .= $this->requireToVar('./public/popups/FlightTicket.php');
        $html .= '
        </div>
    </div>
</div>';

        $html .= '
        <div class="modal fade" id="mobility" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">';

        $html .= $this->requireToVar('./public/popups/Mobility.php');

        $html .= '
         </div>
    </div>
</div>';

        $html .= '
<div class="modal fade" id="update_worker" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">';
        $html .= $this->requireToVar('./public/popups/UpdateWorker.php');
        $html .= '
        </div>
    </div>
</div>
        ';

        $html .= '
        <div class="modal fade" id="new_worker" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">';
        $html .= $this->requireToVar('./public/popups/NewWorker.php');
        $html .= '
        </div>
    </div>
</div>';

        $html .= '
<script src='.SERVER_NAME .'/public/js/configure.js></script>
<script src='.SERVER_NAME .'/public/js/flight.js></script>
<script src='.SERVER_NAME .'/public/js/search.js></script>
<script src='.SERVER_NAME .'/public/js/worker.js></script>
</body>
</html>';
        echo $html;
    }

    /**
     * show workers table.
     */
    public function showWorkersTable()
    {
        $user = unserialize($_SESSION['user']);
        $this->userFullName = $user[0]->full_name;

        if (empty($user)) {
            header('Location: index.php');
        }

        $html = '<!DOCTYPE html>
                <html lang="en">';

        include("./public/parts/top.php");

        $html .= '<body>
             <!--NavBar-->';

        include("./public/parts/nav.php");

        $html .= '
        <div class="container">
        <h1>טבלת עובדים</h1>
  	    <hr>
            <div class="row">
            <!-- activity table -->
                <div class="col-md-12 personal-info">
                <form class="form-horizontal" id="worker_table" role="form" method="post">
                    <div class="col-md-12">
                    <div class="panel-body">
                    <button class="btn btn-primary" type="submit" id="excel_button"><span class="fa fa-file-excel-o"></span> excel</button>
                        <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="workers">
                            <thead>
                                <tr>
                                    <th> מספר</th>
                                    <th> מספר עובד</th>
                                    <th> שם פרטי</th>
                                    <th> שם משפחה</th>
                                    <th> תחילת עבודה</th>
                                    <th> מספר פלאפון</th>
                                    <th> תאריך כניסה לארץ</th>
                                    <th> דרכון</th>
                                    <th> תוקף דרכון</th>
                                </tr>
                            </thead>

                            <tbody>';
        $html .= $this->createWorkersTable();

                            $html .= '</tbody>

                        </table>
                        </div>
                    </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
<script src='.SERVER_NAME .'/public/js/configure.js></script>
<script src='.SERVER_NAME .'/public/js/excel_file.js></script>
<script src='.SERVER_NAME .'/public/js/customer.js></script>
</body>
</html>';

        echo $html;
    }

    /**
     * @return string - All customers.
     */
    private function createAllCustomers()
    {
        $customers = $this->customerModel->getCustomers();
        $str = "";

        foreach($customers as $row)
        {
            $str .= "<option value=" .$row->id .">" .$row->customer_name . "</option>";
        }
        return $str;
    }

    private function createWorkerHistory()
    {
        $worker = $this->workerModel->getWorkerHistory($this->workerId);
        $str = "";

        foreach($worker as $row){   //Creates a loop to loop through results
            $customer = $this->customerModel->getCustomerInfo($row->employer_id);
            $customerName = $customer[0]->customer_name;
            $str .= "<tr><td>" .
                $customerName . "</td><td>" .
                $row->from_date . "</td><td>" .
                $row->to_date .
                "</td></tr>";
        }
        return $str;
    }

    /**
     * @return string - workers table.
     */
    private function createWorkersTable()
    {
        $workers = $this->workerModel->getAllWorkersDetails();
        $str = "";

        foreach($workers as $row){   //Creates a loop to loop through results
            $str .= "<tr><td>" .
                $row->id . "</td><td>" .
                $row->worker_id . "</td><td>" .
                $row->first_name . "</td><td>" .
                $row->last_name . "</td><td>" .
                $row->start_date_of_work . "</td><td>" .
                $row->phone_number . "</td><td>" .
                $row->entrance_date . "</td><td>" .
                $row->passport_number . "</td><td>" .
                $row->validation_date .
                "</td></tr>";
        }

        return $str;
    }

    /**
     * @param $file
     * @return string
     */
    private function requireToVar($file){
        ob_start();
        $id = $this->workerId;
        include($file);
        return ob_get_clean();
    }

}