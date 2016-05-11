<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
set_time_limit(300);
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */

require_once('./model/CustomersModel.php');
require_once('./model/UserModel.php');
require_once('./public/lib/class.phpmailer.php');
require_once('./public/lib/class.smtp.php');




/**
 * Class MailController
 */
class MailController
{

    private $customerModel;
    private $userModel;
    private $mail;

    public function __construct()
    {
        $this->customerModel = new CustomersModel();
        $this->userModel = new UserModel();
        $this->mail = new PHPMailer();
        date_default_timezone_set("Asia/Jerusalem");
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
        $body = "הפרטים של הכרטיס טיסה"  . "\n";
        $body .= "שם העובד ". $first_name . " " . $last_name . "\n";
        $body .= "מספר דרכון" . $passport . "\n";
        $body .= "מספר פלאפון" . $phone . "\n";
        $body .= "סוג כרטיס" . $type . "\n";
        $body .= "ליעד ". $target . "\n";
        $body .= "מתאריך " .$dereliction_date . " " . "עד תאריך " . $arrival_date;
        $body = wordwrap($body, 70, "\r\n");

        $headers = 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        ini_set("sendmail_from", $from);

        $this->sendMail($to,$from,$subject,$body);

        //$mailResult = mail($to, $subject, $body, $headers);
        //error_log(print_r($mailResult, TRUE));

        // if mail is true
        $descriptionId = 1;
        $description = "כרטיס טיסה לעובד ". $first_name . " " . $last_name;
        $status = "open";
        $msg = $this->userModel->addActivity($descriptionId, $status, $userId, $workerId, $description);


        echo($msg);
    }

    /**
     * send activity.
     */
    public function sendMobility()
    {
        $user = unserialize($_SESSION['user']);
        $userId = $user[0]->id;
        $workerId = $_POST['worker_id'];
        $customerId = $_POST['customer_id'];
        $oldEmployer = $_POST['old_employer_name'];
        $newEmployer = $_POST['new_employer_name'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $workerName = $_POST['worker_name'];
        $customer = $this->customerModel->getCustomerInfo($newEmployer);

        $descriptionId = 2;
        $description =  $workerName . " מלקוח " . $oldEmployer . " ללקוח " . $customer[0]->customer_name;
        $status = "open";
        $msg = $this->userModel->addMobilityActivity($descriptionId, $status, $userId, $workerId, $description, $customerId, $newEmployer);

        echo($msg);
    }

    private function sendMail($to,$from,$subject,$body)
    {
        $this->mail->IsSMTP();                                      // set mailer to use SMTP
        // $this->mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $this->mail->SMTPAuth = true; // authentication enabled
        $this->mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $this->mail->Host = "smtp-pulse.com";
        $this->mail->Port = 465; // or 587
        $this->mail->Username = "mbtmProject@gmail.com";  // SMTP username
        //$this->mail->Password = "mbtm1234"; // SMTP password
        $this->mail->Password = "F5sGK4AK9mPoY"; // SMTP password

        //$this->mail->From = $from;
        //$this->mail->FromName =$from;
        $this->mail->SetFrom('mbtmProject@gmail.com', $from);
        $this->mail->AddAddress($to);

        // $this->mail->AddReplyTo("info@example.com", "Information");

        // $this->mail->WordWrap = 50;                                 // set word wrap to 50 characters

        //$this->mail->IsHTML(true);                                  // set email format to HTML

        $this->mail->Subject = $subject;
        $this->mail->Body    = $body;
        //$this->mail->AltBody = "This is the body in plain text for non-HTML mail clients";

        if(!$this->mail->Send())
        {
            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $this->mail->ErrorInfo;
            exit;
        }

        echo "Message has been sent";
    }

}