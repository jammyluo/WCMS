<?php

class QqController extends NodeController
{
    
    // qq登录api绑定
    public function bind ()
    {
        $this->view()->display('file:qq/qq.tpl');
    }

    public function cancleBind ()
    {
        $login = new MemberLoginModule();
        $rs = $login->getLoginByUid($this->_user_global['uid']);
        
        $this->view()->assign('rs', $rs);
        $this->view()->display('file:qq/removebind.tpl');
    }

    public function removeBind ()
    {
        $login = new MemberLoginModule();
        $rs = $login->removeLoginByUid($this->_user_global['uid'], 
                $_POST['type']);
        $this->sendNotice($rs['message'], NULL, $rs['status']);
    }

    public function qq ()
    {
        $login = new MemberLoginModule();
        $rs = $login->isBind($_POST['qq'], 'qq');
        $this->sendNotice($rs['message'], NULL, $rs['status']);
    }

    public function saveBind ()
    {
        $login = new MemberLoginModule();
        
        $rs = $login->bind($_POST);
        if ($rs['status']) {
            self::getLogService()->add($rs['data']['username'], "登录");
        }
        $this->sendNotice($rs['message'], NULL, $rs['status']);
    }
}