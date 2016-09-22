<?php

class EmailController extends Action
{

    static $service;

    public function test ()
    {
        $rs = self::getService()->test($_POST['email_test']);
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public static function getService ()
    {
        if (self::$service == null) {
            self::$service = new EmailService();
        }
        return self::$service;
    }
}