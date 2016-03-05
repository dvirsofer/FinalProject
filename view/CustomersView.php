<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:44
 */

require_once('./model/WorkerModel.php');
require_once('./model/CustomersModel.php');
require_once('./model/UserModel.php');

class CustomersView
{
    private $workerModel;
    private $customerModel;
    private $userName;

    function __construct()
    {
        $this->workerModel = new WorkerModel();
        $this->customerModel = new CustomersModel();
    }

    function showCustomers($id='')
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
        <div class="panel-body col-sm-offset-5 col-sm-5">
            <button type="button" class="btn btn-primary">הזמן עובדים</button>
            <button type="button" class="btn btn-primary">עדכן אשרות</button>
        </div>
    </div>
    <div class="form-group">
        <label for="employer_name">שם המעסיק </label>
        <input type="text" class="form-control" id="employer_name_form">
    </div>
    <div class="form-group">
        <label for="city">ישוב </label>
        <input type="text" class="form-control" id="city_form">
    </div>
    <button type="submit" class="btn btn-success">הוסף לקוח</button>
    <button type="button" class="btn btn-success">עדכן לקוח</button>
</form>
';


        $html .= '
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
                        <form class="form-horizontal">
                            <select class="form-control col-sm-2" id="customers_dropdown" name="customers_dropdown">';
                            $html .= $this->getCustomers();

                            $html .= '</select>
                            <div id="customer" style="display: none"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="panel-group" id="accordion">
    <!-- Cunstomer information -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseTwo">פרטי הלקוח
                </a>
            </h4>
        </div>

        <div class="row">
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <form class="form-horizontal">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="employer_name" class="col-sm-3 control-label">שם המעסיק </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="employer_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="employer_name_en" class="col-sm-3 control-label">שם באנגלית</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="employer_name_en">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city" class="col-sm-3 control-label">ישוב</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="city">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dealer" class="col-sm-3 control-label">רכז</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="dealer">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="open_date" class="col-sm-3 control-label">תאריך פתיחה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="open_date">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">כתובת</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="רחוב מספר בית">
                                    <input type="text" class="form-control" placeholder="ת.ד">
                                    <input type="text" class="form-control" placeholder="ד.נ">
                                    <input type="text" class="form-control" placeholder="מיקוד">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="main_employer" class="col-sm-3 control-label">מעסיק ראשי</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="main_employer">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-3 control-label">סטטוס</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="status">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="mna" class="col-sm-3 control-label">מנ"א</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="mna">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="type_employer" class="col-sm-3 control-label">סוג מעסיק</label>
                                <div class="col-md-9">
                                    <input type="text" class="col-md-6 form-control" id="type_employer" placeholder="סוג">
                                    <input type="text" class="col-md-6 form-control" id="number_employer" placeholder="מספר">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sm" class="col-sm-3 control-label">ס.מ</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="sm">
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Contacts -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseThree">אנשי קשר
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                <div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>מ"ס</th>
                            <th>שם</th>
                            <th>תפקיד</th>
                            <th>טלפון</th>
                            <th>פקס</th>
                            <th>מייל</th>
                            <th>דיוור</th>
                            <th>ראשי</th>
                            <th>הערה</th>
                        </thead>

                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees of Customer -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseFour">עובדים של הלקוח
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="workers">';

        if(!empty($id))
        {
            $html .= $this->createWorkersTable($id);
        }
        $html .= '</table>
                </div>

            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseFive">הזמנות
                </a>
            </h4>
        </div>
        <div id="collapseFive" class="panel-collapse collapse">
            <div class="panel-body">

                 <table class="table table-striped table-bordered">
                    <thead>
                        <th>מ"ס</th>
                        <th>מספר הזמנה</th>
                        <th>תאריך פתיחת הזמנה</th>
                        <th>מספר עובדים</th>
                        <th>הערות</th>
                        <th>מתאריך</th>
                        <th>סטטוס הזמנה</th>
                        <th>תאריך שינוי סטטוס</th>
                        <th>כמות חוזים חסרים</th>
                    </thead>

                    <tbody>

                    </tbody>

                </table>

            </div>
        </div>
    </div>

    <!-- Events a customer -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion"
                   href="#collapseSix">אירועים ללקוח
                </a>
            </h4>
        </div>
        <div id="collapseSix" class="panel-collapse collapse">
            <div class="panel-body">
                 <table class="table table-striped table-bordered">
                    <thead>
                        <th>מ"ס</th>
                        <th>סטטוס אירועים ללקוח</th>
                        <th>תאריך</th>
                        <th>תאריך יעד</th>
                        <th>סוג</th>
                        <th>הערה</th>
                        <th>שם המסמך וקישור</th>
                    </thead>

                    <tbody>

                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>
<script src="/public/js/search.js"></script>
</body>
</html>';

        echo $html;

    }

    function createWorkersTable($id)
    {
        $workers = $this->workerModel->getAllWorkerOfCustomerInfo($id);
        $str = "";
        $str .= "
                        <thead>
                        <tr>
                        <th>מ'ס</th>
                        <th>מספר עובד</th>
                        <th>שם פרטי</th>
                        <th>שם משפחה</th>
                        <th>תחילת עבודה</th>
                        <th>סיום עבודה</th>
                        <th>תאריך כניסה לארץ</th>
                        <th>דרכון</th>
                        <th>תוקף דרכון</th>
                        <th>ביטוח</th>
                        </tr>
                    </thead>
                       <tbody>";

        foreach($workers as $row){   //Creates a loop to loop through results
            $passportInfo = $this->workerModel->getPassportInfo($row->worker_id);
            $passportNumber = $passportInfo[0]->passport_number;
            $passportValid = $passportInfo[0]->validation_date;

            $str .= "<tr><td>" .
                $row->id . "</td><td>" .
                $row->worker_id . "</td><td>" .
                $row->first_name . "</td><td>" .
                $row->last_name . "</td><td>" .
                $row->start_date_of_work . "</td><td>" .
                $row->phone_number . "</td><td>" .
                $row->entrance_date . "</td><td>" .
                $passportNumber . "</td><td>" .
                $passportValid .
                "</td></tr>";
        }

        $str .= "</tbody>";

        error_log(var_export($str,true));
        return $str;
    }

    function getCustomers()
    {
        $str = "";
        $customers = $this->customerModel->getCustomers();

        $str .= '<option value="">בחר לקוח</option>';
        foreach($customers as $row)
        {
            $str .= "<option value=" .$row->id .">" .$row->customer_name . "</option>";
        }
        return $str;
    }

}