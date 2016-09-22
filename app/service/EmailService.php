<?php

class EmailService
{

    private $_config;

    static $smtp;

    public function __construct ()
    {
        $sys = new SysService();

        $config = $sys->getConfig();
        $this->_config = $config;

        self::$smtp = new Email();
        self::$smtp->setServer($config['smtp'], $config['email_account'], $config['email_password'],$config['smtp_socket']); // 设置smtp服务器
        self::$smtp->setFrom($config['email_account']);
        self::$smtp->setMail("test", "<b>test</b>"); 
        self::$smtp->sendMail();
    }

    public function send ($smtpemailto, $mailtitle, $mailcontent)
    {
        self::$smtp->setReceiver($smtpemailto);
        self::$smtp->setMail($mailtitle, $mailcontent);
       $state= self::$smtp->sendMail();
       if(!$state){
           return array('status'=>false,'message'=>"发送失败");
       }else{
           return array('status'=>true,'message'=>"发送成功");

       }
    }

    public function test ($test)
    {
        if (empty($this->_config['smtp'])) {
            return array(
                'status' => false,
                'message' => "请先配置服务器信息"
            );
        }

        return $this->send(trim($test), "邮件测试发送", "这是一封测试邮件");
    }
}
