<?php

class WeixinController extends Action
{

    static $service;
    
    // 账号绑定
    public function bind ()
    {
        $rs = self::getService()->getOpenIdByCode($_GET['code']);
        // 检查opendid是否已经绑定
        if (! $rs['status']) {
            echo $rs['message'];
            exit();
        }
        $login = new MemberLoginModule();
        $isbind = $login->isBind($rs['data'], 'weixin');
        if ($isbind['status']) {
            echo "<script>location.href='./index.php?anonymous/login';</script>";
            exit();
        }
        $this->view()->assign('openid', $rs['data']);
        $this->view()->display('file:app/bind.tpl');
    }

    public function v ()
    {
        $wechatObj = new WeixinService();
        $rs = $wechatObj->getComment();
        $this->view()->assign('maxid', $rs[0]['id']);
        $this->view()->assign('rs', $rs);
        $this->view()->display('file:app/weixin.tpl');
    }

    public function config ()
    {
        $rs = self::getService()->getAllConfig();
        $this->view()->assign('rs', $rs);
        $this->view()->display('file:app/config.tpl');
    }

    public function saveConfig ()
    {
        $rs = self::getService()->saveConfig($_GET);
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public function saveButton ()
    {
        $rs = self::getService()->saveButton($_POST['value']);
        $this->sendNotice($rs['message'], null, $rs['status']);
    }
    // 拉取新的聊天记录
    public function pull ()
    {
        $wechatObj = new WeixinService();
        $rs = $wechatObj->getCommentMaxId($_POST['maxid']);
        $this->sendNotice(null, $rs['data'], $rs['status']);
    }

    public function reply ()
    {
        $wechatObj = new WeixinService();
        $rs = $wechatObj->reply($_POST['touser'], $_POST['msg'], $_POST['id']);
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public function listing ()
    {
        $wechatObj = new WeixinService();
        $rs = $wechatObj->getCommentPage($_GET['p']);
        $this->view()->assign('rs', $rs['user']);
        $this->view()->assign('num', $rs['page']);
        $this->view()->display('file:app/list.tpl');
    }

    public static function getService ()
    {
        if (self::$service == null) {
            self::$service = new WeixinService();
        }
        return self::$service;
    }
}