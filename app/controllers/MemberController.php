<?php

/**
 * 会员系统    暂时不支持 系统组授权
 * groupid系统组,verify为验证级别 ,coupons为自定义会员组
 * 功能:会员的添加、删除、查看信息、授权
 *@author wolf  [Email: 116311316@qq.com]
 *@since 2011-07-20  2014-08-04
 *@version 3.0 第3次简化
 */
class MemberController extends NodeController
{

    static $service;
    // 配置用户列表 导入
    public function listing ()
    {
        $member = self::getMemberService()->listing($_GET['p']);
        $this->view()->assign('num', $member['page']);
        $this->view()->assign('totalnum', $member['totalnum']);
        $this->view()->assign('news', $member['memberlist']);
        // 在线导出功能
        $this->view()->display('file:member/mlist.tpl');
    }
    
    public function getUsernameByMobile(){
        $memberSer=new MemberService();
        $user=$memberSer->getMemberByMobile($_GET['mobile']);
        if (empty($user)){
            $rs=  array('status'=>false,'message'=>"新建用户");
        }else{
            $rs= array('status'=>true,'message'=>$user['real_name'],'data'=>array('uid'=>$user['uid']));
        }
        $this->sendNotice($rs['message'],$rs['data'],$rs['status']);
    }

    /**
     * 删除会员
     */
    public function remove ()
    {
        $rs = self::getMemberService()->remove($_POST['uid'], $this->_user_global['uid']);
        if ($rs == self::SUCEESS) {
            $message = "删除会员$_POST[uid]";
        } else {
            $message = "删除会员失败$_POST[uid]";
        }
        self::getLogService()->add($this->_user_global['username'], $message);
        $this->sendNotice($rs, null, true);
    }

    /**
     * 查询用户系统
     */
    public function cSearch ()
    {
        $rs = self::getMemberService()->search($_GET['type'], $_GET['value']);
        $this->view()->assign('search', urldecode($_GET['value']));
        $this->view()->assign('num', array(
            'current' => 1,
            'page' => 1
        ));
        $this->view()->assign('totalnum', count($rs));
        $this->view()->assign('news', $rs);
        $this->view()->assign('cate', self::getMemberService()->_verify);
        $this->view()->display('file:member/mlist.tpl');
    }
    // 添加 操作日志
    public function addLog ()
    {
        $event = $_POST['event'] . 'by ' . $this->_user_global['real_name'];
        self::getLogService()->add($_POST['real_name'], $event, 1);
    }

    /**
     * 对单个用户进行编辑
     */
    public function add ()
    {
        $group = self::getMemberService()->getMemberGroup();
        $this->view()->assign('verify', self::getMemberService()->_verify);
        $this->view()->assign('group', $group);
        $this->view()->display('file:member/add.tpl');
    }

    /**
     * 新增用户
     */
    public function addUser ()
    {
        $rs = self::getMemberService()->register($_POST);
        if ($rs['status']) {
            $event = $this->_user_global['real_name'] = "新增";
            self::getLogService()->addAdminEvent($rs['data'], $event);
        }
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    /**
     * 编辑用户
     */
    public function edit ()
    {
        $rs = self::getMemberService()->getMemberByUid($_GET['id']);
        $group = self::getMemberService()->getMemberGroup();
        // 载入日志记录
        $adminlog = self::getLogService()->getLogByUsername($rs['real_name'], 1);
        $ownlog = self::getLogService()->getLogByUsername($rs['real_name'], 0);
        // 载入地址
        $province = new ProvinceService();
        $provinces = $province->getAllProvince();
        $areas = $province->getAreasByCityId($rs['city']);
        $citys = $province->getCityByProvinceId($rs['province']);
        $this->view()->assign('provinces', $provinces);
        $this->view()->assign('areas', $areas);
        $this->view()->assign('citys', $citys);
        $this->view()->assign('adminlog', $adminlog);
        $this->view()->assign('ownlog', $ownlog);
        $this->view()->assign('systemgroup', self::getMemberService()->_group);
        $this->view()->assign('group', $group);
        $this->view()->assign("verify", self::getMemberService()->_verify);
        $this->view()->assign("rs", $rs);
        $this->view()->display('file:member/edit.tpl');
    }

    /**
     * 保存用户
     */
    public function save ()
    {
        $rs = self::getMemberService()->save($_POST);
        self::getLogService()->add($this->_user_global['username'], "编辑用户$_POST[uid]");
        $this->redirect($rs, "./index.php?member/edit/?id=$_POST[uid]");
    }

    public function saveArea ()
    {
        $rs = self::getMemberService()->saveMemberData($this->_user_global['uid'], $_POST);
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public function savebirthday ()
    {
        self::getLogService()->add($this->_user_global['real_name'], "更新生日");
        $member = new MemberBaseService();
        $rs = $member->saveMemberByUid(array(
            'birthday' => strtotime($_POST['birthday']),
            'sex' => $_POST['sex']
        ), $this->_user_global['uid']);
        if ($rs) {
            $message = "提交成功";
        } else {
            $message = "提交失败";
        }
        $this->sendNotice($message);
    }
    // 个人概况
    public function intro ()
    {
        self::getPluginService('login')->run();
        // 获取店铺数量
        $storesService = new MemberStoresModule();
        $percent = self::getMemberService()->getCompletePercent($this->_user_global);
        $stores = $storesService->getStoresByUid($this->_user_global['uid']);
        $this->view()->assign('stores_num', count($stores));
        $this->view()->assign('percent', $percent);
        $this->view()->display('file:member/intro.tpl');
    }

    /**
     * 用户账户信息
     */
    public function info ()
    {
        $province = new ProvinceService();
        $provinces = $province->getAllProvince();
        $areas = $province->getAreasByCityId($this->_user_global['city']);
        $citys = $province->getCityByProvinceId($this->_user_global['province']);
        $this->view()->assign('provinces', $provinces);
        $this->view()->assign('areas', $areas);
        $this->view()->assign('citys', $citys);
        $this->view()->display("file:member/info.tpl");
    }

    /**
     * 审核
     * 实名认证
     */
    public function setStatus ()
    {
        if (! $this->_user_global['manager'] > 1) {
            $rs = array(
                'status' => false,
                'message' => "需要超级管理员权限!"
            );
        } else {
            $rs = self::getMemberService()->saveStatus($_POST['status'], $_POST['uid']);
        }
        if ($rs['status']) {
            $msg = $this->_user_global['real_name'] . "设置为" . $rs['data'];
            $flag = self::getLogService()->add(urldecode($_POST['username']), $msg, 1);
            if ($flag < 1) {
                $rs = array(
                    'status' => false,
                    'message' => "操作记录失败"
                );
            }
        }
        $this->sendNotice($rs['message'], NULL, $rs['status']);
    }

    public function area ()
    {
        $area = new MemberAreaModule();
        $rs = $area->getMemberByGroupid(11);
        $this->view()->assign('member', $rs);
        $this->view()->display('file:member/area.tpl');
    }


    /**
     * 修改密码
     */
    public function rePassword ()
    {
        $this->view()->display('file:member/password.tpl');
    }

    public function setPassword ()
    {
        $rs = $this->isLogin();
        if ($rs != self::SUCEESS) {
            $this->sendNotice($rs);
        }
        $uid = $this->_user_global['uid'];
        $message = self::getMemberService()->rePassword($uid, $_POST['password'], $_POST['newPassword']);
        self::getLogService()->add($this->_user_global['username'], "修改密码");
        $this->sendNotice($message);
    }

    public static function getMemberService ()
    {
        if (self::$service == null) {
            self::$service = new MemberService();
        }
        return self::$service;
    }
}