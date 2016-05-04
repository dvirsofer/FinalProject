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
require_once('./Configure.php');

class CustomersView
{
    private $workerModel;
    private $customerModel;
    private $userModel;
    private $userName;
    private $customerId;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->workerModel = new WorkerModel();
        $this->customerModel = new CustomersModel();
        $this->userModel = new UserModel();

    }

    /**
     * @param string $id - customer id.
     */
    public function showCustomers($id='')
    {
        $user = unserialize($_SESSION['user']);
        $this->userName = $user[0]->user_name;
        $this->customerId = $id;

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
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_customer"><span class="fa fa-plus"></span>הוסף לקוח</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_customer"><span class="fa fa-edit"></span>עדכן לקוח</button>
        </div>
    </div>

</form>
';


        $html .= '
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
                        <form class="form-horizontal" method="post">
                            <select class="form-control col-sm-2" id="customers_dropdown" name="customers_dropdown">';
                            $html .= $this->getCustomers($id);

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
                   <span class="fa fa-info-circle"></span>
                </a>
            </h4>
        </div>

        <div class="row">
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <form class="form-horizontal">';

                    if(!empty($id)) {
                        // get all customer info
                        $customer = $this->customerModel->getCustomerInfo($id);
                        $settlement = $this->customerModel->getSettlement($customer[0]->settlement_id);
                        $settlementName = $settlement[0]->settlement_name;
                        $responsibleInfo = $this->userModel->getUserById($customer[0]->responsible_id);
                        $responsibleName = $responsibleInfo[0]->user_name;
                        
                        $html .= '<div class="col-md-4">
                            <div class="form-group">
                                <label for="employer_name" class="col-sm-3 control-label">שם המעסיק </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="employer_name" value="'. $customer[0]->customer_name .'  ">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="employer_name_en" class="col-sm-3 control-label">שם באנגלית</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="employer_name_en" value="' . $customer[0]->name_in_english .' ">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city" class="col-sm-3 control-label">ישוב</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="city" value="'. $settlementName .'">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dealer" class="col-sm-3 control-label">רכז</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="dealer" value="'. $responsibleName .' ">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="open_date" class="col-sm-3 control-label">תאריך פתיחה</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="open_date" value="'. $customer[0]->opening_date .' ">
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
                                    <input type="text" class="form-control" id="main_employer" value="'. $customer[0]->main_customer .' ">
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
                                <label for="sm" class="col-sm-3 control-label">מספר</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="num" value="'. $customer[0]->company_number .' ">
                                </div>
                            </div>

                        </div>';
                            }

                    $html .= '</form>
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
                   <span class="fa fa-phone"></span>
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="contacts">
                        <thead>
                            <tr>
                            <th> שם</th>
                            <th> תפקיד</th>
                            <th> טלפון</th>
                            <th> פקס</th>
                            <th> מייל</th>
                            <th> הערה</th>
                            </tr>
                        </thead>

                        <tbody>';

        if(!empty($id))
        {
            $html .= $this->createContactsTable($id);
        }

        $html .= ' </tbody>

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
                   <span class="fa fa-users"></span>
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="workers">
                <thead>
                        <tr>
                        <th> מספר</th>
                        <th> מספר עובד</th>
                        <th> שם פרטי</th>
                        <th> שם משפחה</th>
                        <th> תחילת עבודה</th>
                        <th> סיום עבודה</th>
                        <th> תאריך כניסה לארץ</th>
                        <th> דרכון</th>
                        <th> תוקף דרכון</th>
                        </tr>
                    </thead><tbody>';

        if(!empty($id))
        {
            $html .= $this->createWorkersTable($id);
        }
        $html .= '</tbody></table>
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
    </div>';

        $html .= '
<div class="modal fade" id="add_customer" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">';
        $html .= $this->requireToVar('./public/popups/AddCustomer.php');
        $html .= '
        </div>
    </div>
</div>
        ';

        $html .= '
<div class="modal fade" id="update_customer" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">';
        $html .= $this->requireToVar('./public/popups/UpdateCustomer.php');
        $html .= '
        </div>
    </div>
</div>
        ';

$html .= '</div>

<script src='.SERVER_NAME .'/public/js/configure.js></script>
<script src='.SERVER_NAME .'/public/js/customer.js></script>
</body>
</html>';

        echo $html;

    }

    public function showCustomersTable()
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
        <div class="container">
            <div class="row">
            <!-- activity table -->
                <div class="col-md-9 personal-info">
                <form class="form-horizontal" id="customer_table" role="form" method="post">
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="activity">
                            <thead>
                                <tr>
                                    <th> מ"ס</th>
                                    <th> פעולה</th>
                                    <th> מצב הפעולה</th>
                                    <th> תיאור הפעולה</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>

                        </table>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
      ';

        echo $html;
    }

    /**
     * @param $id - customer id.
     * @return string - table of all workers.
     */
    private function createWorkersTable($id)
    {
        $workers = $this->workerModel->getAllWorkerOfCustomerInfo($id);
        $str = "";

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

        return $str;
    }

    /**
     * @param $id - customer id.
     * @return string - table of all Contacts.
     */
    function createContactsTable($id)
    {
        $contacts = $this->customerModel->getAllContactsOfCustomerInfo($id);
        $str = "";

        foreach($contacts as $contact){   //Creates a loop to loop through results

            $str .= "<tr><td>" .
                $contact->contact_name . "</td><td>" .
                $contact->positon . "</td><td>" .
                $contact->phone_number . "</td><td>" .
                $contact->fax . "</td><td>" .
                $contact->email . "</td><td>" .
                $contact->comment .
                "</td></tr>";
        }

        return $str;
    }

    /**
     * @param string $id
     * @return string - all customers.
     */
    private function getCustomers($id = '')
    {
        $str = "";
        $customers = $this->customerModel->getCustomers();

        $str .= '<option value="">בחר לקוח</option>';
        foreach($customers as $row)
        {
            if ($id == $row->id) {
                $str .= "<option value=" .$row->id ." selected=\"selected\">" .$row->customer_name . "</option>";
            } else {
                $str .= "<option value=" .$row->id .">" .$row->customer_name . "</option>";
            }

        }
        return $str;
    }

    private function requireToVar($file){
        ob_start();
        $id = $this->customerId;
        include($file);
        return ob_get_clean();
    }

}