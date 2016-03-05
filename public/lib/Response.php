<?php

class Response
{
    const ERROR_LOGIN = 'התחברות נכשלה';
    const ADD_USER_SUCCESS = 'המשתמש נשמר במערכת';
    const ADD_USER_ERROR = 'המשתמש לא נשמר במערכת';
    const UPDATE_SUCCESS = 'המידע התעדכן';
    const UPDATE_ERROR = 'המידע לא התעדכן';

    private $success;
    private $error;

    public function __construct()
    {
        $this->success = true;
    }

    public function setError($errorMessage)
    {
        $this->error = $errorMessage;
    }

    public function getErrorMessage()
    {
        return $this->error;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function setSuccess($bool)
    {
        $this->success = $bool;
    }
}