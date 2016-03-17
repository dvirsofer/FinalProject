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
    public function showWorker()
    {
        $user = unserialize($_SESSION['user']);
        $this->userName = $user[0]->user_name;

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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#flight_ticket">כרטיס טיסה</button>
            <button type="button" class="btn btn-primary">נטישה</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mobility">ניוד</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mna">מנה</button>
            <button type="button" class="btn btn-primary">הוסף עובד</button>
        </div>
    </div>
</form>
';
        $html .= '
    <!-- Search Worker -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseOne">חיפוש עובד
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
            </div>
        </div>

    </div>';

        $html .= '
        <div class="panel-group" id="accordion">
    <!-- Worker information -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseTwo">פרטי עובד
                </a>
            </h4>
        </div>

        <div class="row">
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <form class="form-horizontal">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="passport_number" class="col-sm-3 control-label">מספר דרכון</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="passport_number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="col-sm-3 control-label">שם משפחה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="last_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nation" class="col-sm-3 control-label">לאום</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nation">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="date" class="col-sm-3 control-label">תאריך לידה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="date">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone_number" class="col-sm-3 control-label">טלפון</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="phone_number">
                                </div>
                            </div>

                            <div class = "form-group">
                                <label for="comments" class="col-sm-3 control-label">הערות</label>
                                <div class="col-md-9">
                                    <textarea class = "form-control" rows = "5"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="col-sm-3 control-label">סטטוס</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="status">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="first_name" class="col-sm-3 control-label">שם פרטי</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="first_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="gender" class="col-sm-3 control-label">מין</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="gender">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="arrive" class="col-sm-3 control-label">צורת הגעה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="arrive">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="arrive" class="col-sm-3 control-label">צורת הגעה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="arrive">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="arrival_date" class="col-sm-3 control-label">הגעה לארץ</label>
                                <div class="col-md-9">
                                    <input type="text" class="col-md-6 form-control" id="arrival_date">
                                    <input type="text" class="col-md-6 form-control" id="arrival_date">
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
                                    <input type="text" class="form-control" id="valid_passport">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dereliction_date" class="col-sm-3 control-label">תאריך נטישה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="dereliction_date">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="validity_insurance" class="col-sm-3 control-label">תוקף ביטוח</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="validity_insurance">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="valid_driving_license" class="col-sm-3 control-label">תוקף רישיון נהיגה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="valid_driving_license">
                                </div>
                            </div>


                        </div>

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
            <div class="panel-body">
                <div>';

        //$html .= $this->createWorkersTable();

        $html .= '</div>

            </div>
        </div>
    </div>

    <!-- Events a customer -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseFour">אירועים ללקוח
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">

                 <div>
                    <table class="table">
                        <thead>
                            <th>מ"ס</th>
                            <th>סטטוס אירוע לעובד</th>
                            <th>תאריך האירוע</th>
                            <th>סוג האירוע</th>
                            <th>מתאריך</th>
                            <th>הערה</th>
                            <th>קישור למסמך עובד</th>
                        </thead>

                        <tbody>

                        </tbody>

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
        <div class="modal fade" id="mna" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">';

        $html .= $this->requireToVar('./public/popups/Mna.php');

        $html .= '
         </div>
    </div>
</div>
<script src='.SERVER_NAME .'/public/js/configure.js></script>
<script src='.SERVER_NAME .'/public/js/flight.js></script>
<script src='.SERVER_NAME .'/public/js/search.js></script>
</body>
</html>';


        echo $html;
    }

    /**
     * @return string - table of all workers.
     */
   /* private function createWorkersTable()
    {
        $workers = $this->workerModel->allWorkersInfo();
        $str = "";
        $str .= "<table class='table table-striped table-bordered'>
                        <thead>
                            <th>מ'ס</th>
                            <th>שם מעסיק</th>
                        </thead>

                        <tbody>";

        foreach($workers as $row){   //Creates a loop to loop through results
            $str .= "<tr><td>" .
                $row->user_name . "</td><td>" . $row->user_password .
                "</td></tr>";
        }

        $str .= "</tbody>

              </table>";


        return $str;
    }*/

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

    /**
     * @param $file
     * @return string
     */
    private function requireToVar($file){
        ob_start();
        include($file);
        return ob_get_clean();
    }

}