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
        $user = unserialize($_SESSION['user']);
        $from = $user[0]->email;
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
        $subject = '����� ����� ���� �����.';
        $body = "������ �� ������ ����:";
        $body .= "�� �����:"  . $first_name . " " . $last_name . "\n";
        $body .= "���� ����� " . $passport . "\n";
        $body .= "���� ����� " . $phone . "\n";
        $body .= "��� ����� " . $type . "\n";
        $body .= "���� " . $target . "\n";
        $body .= "������� " . $dereliction_date . " " . "�� ������ " . $arrival_date;


        $headers = 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $mailResult = mail($to, $subject, $body, $headers);

        echo($mailResult);
    }

}