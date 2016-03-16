<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/12/2015
 * Time: 13:43
 */


/**
 * Class MailController
 */
class MailController
{

    public function __construct()
    {
//        $this->customersView = new CustomersView();
    }

    /**
     * send mail.
     */
    public function send()
    {
        $first_name = $_POST['first_name_FT'];
        $last_name = $_POST['last_name_FT'];

        $from = 'dvir.sofer90@gmil.com';
        $to = $_POST['mail-address'];
        $subject = 'Message from Contact Demo ';
        $body = "From: dvir sofer";

        $headers = 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $mailResult = mail($to, $subject, $body, $headers);

        echo($mailResult);
    }

}