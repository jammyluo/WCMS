<?php

class MemberAuthorizeModule implements IMember
{

    private $_password = '123456';
    /*
     * (non-PHPdoc) @see IMember::add()
     */
    public function add ($params)
    {
        // TODO Auto-generated method stub
    }
    /*
     * (non-PHPdoc) @see IMember::getCon()
     */
    public function getCon ($uid)
    {
        // TODO Auto-generated method stub
    }
    /*
     * (non-PHPdoc) @see IMember::remove()
     */
    public function remove ($uid)
    {
        // TODO Auto-generated method stub
    }
    /*
     * (non-PHPdoc) @see IMember::saveCon()
     */
    public function saveCon ($v, $uid)
    {
        // TODO Auto-generated method stub
    }
    /*
     * 二次密码
     */
    public function vaild ($user, $password)
    {
        if (empty($user)) {
            return array(
                'status' => false,
                "message" => "请先登录!"
            );
        }
        if (empty($password)) {
            return array(
                'status' => false,
                'message' => "密码不能为空"
            );
        }
        $sq = $this->getUser($user['uid']);
        if (empty($sq)) {
            return array(
                'status' => false,
                "message" => "你没有进入权限,请联系管理员!"
            );
        }
        if ($sq['num'] > 4) {
            return array(
                'status' => false,
                'message' => "连续5次密码输错，账号已被禁用"
            );
        }
        if ($sq['password'] !== md5(trim($password))) {
            $this->addFaildNum($user['uid']);
            $last = 5 - $sq['num'] - 1;
            $message = '密码错误,你还剩' . $last . '次机会';
            return array(
                'status' => false,
                'message' => $message
            );
        }
        if ($sq['status'] < 1) {
            return array(
                'status' => false,
                'message' => "尚未激活，请先激活密码"
            );
        }
        setcookie("jiami", $sq['uid'], 0);
        $this->clearFaildNum($sq['uid']);
        return array(
            'status' => true,
            "message" => "授权成功"
        );
    }

    public function save ($user, $old, $new)
    {
        if (empty($user)) {
            return array(
                'status' => false,
                "message" => "请先登录!"
            );
        }
        if (empty($new) || empty($old)) {
            return array(
                'status' => false,
                'message' => "密码不能为空"
            );
        }
        if ($user['verify'] != 1) {
            return array(
                'status' => false,
                'message' => "你尚未实名认证"
            );
        }
        if ($new == "123456") {
            return array(
                'status' => false,
                'message' => "新密码太简单了"
            );
        }
        if ($new == $old) {
            return array(
                'status' => false,
                'message' => "新密码与旧密码相同了"
            );
        }
        if ($this->filter($new)) {
            return array(
                'status' => false,
                'message' => "密码中请勿包含了符号"
            );
        }
        $sq = $this->getUser($user['uid']);
        if ($sq['num'] > 4) {
            return array(
                'status' => false,
                'message' => "输错5次，帐号已被禁用"
            );
        }
        if ($sq['password'] !== md5($old)) {
            $this->addFaildNum($user['uid']);
            $last = 5 - $sq[num] - 1;
            $message = '原密码错误,你还剩' . $last . '次机会';
            return array(
                'status' => false,
                'message' => $message
            );
        }
        BuyPasswordModel::instance()->savePasswordByUid(md5(trim($new)), $user['uid']);
        $this->clearFaildNum($sq['uid']);
        return array(
            'status' => true,
            'message' => "授权密码修改成功,请返回订购中心登录"
        );
    }

    private function clearFaildNum ($uid)
    {
        BuyPasswordModel::instance()->setNumByUid(0, $uid);
    }

    /**
     * 检测是否包含非法字符
     * 
     * @return boolean true or false
     */
    private function filter ($str)
    {
        $pattern = "#[\*\.\/\?\-\%\!]+#i";
        return preg_match($pattern, $str);
    }

    public function addFaildNum ($uid)
    {
        BuyPasswordModel::instance()->addFaildNum($uid);
    }
    // 增加授权
    public function addUser ($uid)
    {
        // 检查是否已经含有权限
        $user = BuyPasswordModel::instance()->getUserByUid($uid);
        if (! empty($user)) {
            return $this->init($uid);
        }
        // 如果还没有权限就增加授权
        $params = array(
            'uid' => $uid,
            'password' => md5($this->_password)
        );
        $flag = BuyPasswordModel::instance()->addUser($params);
        if ($flag < 1) {
            return array(
                'status' => false,
                'message' => "无法授权"
            );
        } else {
            return $this->init($uid);
        }
    }

    public function addUserWallet ($uid)
    {
        $wallet = new MemberWalletModule();
        return $wallet->addWallet($uid);
    }
    // 初始化
    private function init ($uid)
    {
        $user = BuyPasswordModel::instance()->getUserByUid($uid);
        if ($user['password'] == md5($this->_password)) {
            return array(
                'status' => false,
                'message' => "已经初始化，请勿重复"
            );
        }
        $rs = BuyPasswordModel::instance()->savedUser(array(
            'password' => md5($this->_password),
            'num' => 0,
            'status' => 0
        ), $uid);
        if ($rs > 0) {
            return array(
                'status' => true,
                'message' => "初始密码成功"
            );
        } else {
            return array(
                'status' => false,
                'message' => "初始密码失败"
            );
        }
    }

    public function getUser ($uid)
    {
        if (empty($uid)) {
            return false;
        }
        return BuyPasswordModel::instance()->getUserByUid($uid);
    }
}
