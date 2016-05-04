<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./model/CustomersModel.php');
require_once('./model/UserModel.php');

/**
 * Class MailController
 */
class MailController
{

    private $customerModel;
    private $userModel;

    public function __construct()
    {
        $this->customerModel = new CustomersModel();
        $this->userModel = new UserModel();
    }

    /**
     * send mail.
     */
    public function send()
    {
        $user = unserialize($_SESSION['user']);
        $from = $user[0]->email;
        $userId = $user[0]->id;
        $workerId = $_POST['worker_id'];
        $first_name = $_POST['first_name_FT'];
        $last_name = $_POST['last_name_FT'];
        $passport = $_POST['passport_number_FT'];
        $customer = $_POST['employer_name_FT'];
        $phone = $_POST['phone_contact_FT'];
        $type = $_POST['type_FT'];
        $target = $_POST['target_FT'];
        $dereliction_date = $_POST['dereliction_date_FT'];
        $arrival_date = $_POST['arrival_date_FT'];

        //$from = 'dvir.sofer90@gmil.com';
        $to = $_POST['mail-address'];
        $subject = 'הזמנת כרטיס טיסה לעובד.';
        $body = "הפרטים של הכרטיס טיסה:" ;
        $body .= "שם העובד:"  . $first_name . " " . $last_name . "\n";
        $body .= "מספר דרכון " . $passport . "\n";
        $body .= "מספר טלפון " . $phone . "\n";
        $body .= "סוג כרטיס " . $type . "\n";
        $body .= "ליעד " . $target . "\n";
        $body .= "מהתאריך " . $dereliction_date . " " . "עד לתאריך " . $arrival_date;
        $body = wordwrap($body, 70, "\r\n");

        $headers = 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        ini_set("sendmail_from", $from);
        $mailResult = mail($to, $subject, $body, $headers);
        error_log(var_export($mailResult, TRUE));

        // if mail is true
        $descriptionId = 1;
        $description = "כרטיס טיסה לעובד" . $first_name . " " . $last_name;
        $status = "open";
        $msg = $this->userModel->addActivity($descriptionId, $status, $userId, $workerId, $description);


        echo($msg);
    }

    public function sendMobility()
    {
        $user = unserialize($_SESSION['user']);
        $userId = $user[0]->id;
        $workerId = $_POST['worker_id'];
        $oldEmployer = $_POST['old_employer_name'];
        $newEmployer = $_POST['new_employer_name'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $workerName = $_POST['worker_name'];
        $customer = $this->customerModel->getCustomerInfo($newEmployer);

        $descriptionId = 2;
        $description =  $workerName . " מלקוח " . $oldEmployer . " ללקוח " . $customer[0]->customer_name;
        $status = "open";
        $msg = $this->userModel->addActivity($descriptionId, $status, $userId, $workerId, $description);

        echo($msg);
    }

}