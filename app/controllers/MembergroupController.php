<?php

class MembergroupController extends NodeController
{

    static $service;

    public function add ()
    {
        $group = new MemberGroupModule();
        $rs = $group->add($_POST);
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public function remove ()
    {
        $group = new MemberGroupModule();
        $rs = $group->remove($_POST['id']);
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public function save ()
    {}

    public function group ()
    {
        $rs = self::getService()->getMemberGroup();
        $this->view()->assign('group', $rs);
        $this->view()->display('file:member/group.tpl');
    }

    public static function getService ()
    {
        if (self::$service == null) {
            self::$service = new MemberService();
        }
        return self::$service;
    }
}