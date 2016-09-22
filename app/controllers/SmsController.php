<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 16/1/12
 * Time: 下午2:43
 */
class SmsController extends NodeController{


    public function sms(){

        $this->view()->display("file:sms/sms.tpl");
    }
    

    public function send(){

        $smsSer=new SMSService();
        $rs=$smsSer->add($_POST,2);
        if($rs['status']){
            $this->sendNotice("发送成功",null,true);
        }else{
            $this->sendNotice("发送失败",null,false);
        }
    }
}