<?php

class MemberLoginModule
{
    // 绑定
    public function bind ($data)
    {
        $member = new MemberService();
        $rs = $member->isLogin($data['username'], $data['password']);
        if (! $rs['status']) {
            return $rs;
        }
        $user = $rs['data'];
        // 检查是否已经绑定过了
        $isbind = $this->getLoginByUid($user['uid']);
        if (! empty($isbind) && ! empty($isbind[$data['type']])) {
            return array(
                    'status' => false,
                    'message' => "已经绑定了"
            );
        }
        if (! empty($isbind)) {
            $rs = $this->updateLoginByUid(
                    array(
                            $data['type'] => $data[$data['type']]
                    ), $user['uid']);
        } else {
            $rs = $this->addLogin(
                    array(
                            'uid' => $user['uid'],
                            $data['type'] => $data[$data['type']]
                    ));
        }
        if ($rs > 0) {
            $this->setLoginCookie($user['username']);
            return array(
                    'status' => true,
                    'data' => $user,
                    'message' => "绑定成功"
            );
        } else {
            return array(
                    'status' => false,
                    'message' => "绑定失败"
            );
        }
    }

    public function isBind ($openid, $type)
    {
        $uid = $this->getLoginByValue($openid,$type);
        if (! empty($uid)) {
            $member = new MemberService();
            $user = $member->getMemberByUid($uid['uid']);
            $this->setLoginCookie($user['username']);
            return array(
                    'status' => true
            );
        } else {
            return array(
                    'status' => false
            );
        }
    }

    private function setLoginCookie ($username)
    {
        setcookie("user", $username, time() + 3600 * 10, "/");
    }

    public function addLogin ($params)
    {
        return MemberLoginModel::instance()->addLogin($params);
    }

    public function updateLoginByUid ($v, $uid)
    {
        return MemberLoginModel::instance()->updateLoginByUid($v, $uid);
    }

    public function removeLoginByUid ($uid, $type)
    {
        $where = array(
                $type => null
        );
        $rs = MemberLoginModel::instance()->updateLoginByUid($where, $uid);
        if ($rs > 0) {
            return array(
                    'status' => true,
                    'message' => "解绑成功"
            );
        } else {
            return array(
                    'status' => false,
                    'message' => "解绑失败"
            );
        }
    }

    public function getLoginByValue ($openid, $type)
    {
        return MemberLoginModel::instance()->getLoginByWhere(
                array(
                        $type => $openid
                ));
    }

    public function getLoginByUid ($uid)
    {
        return MemberLoginModel::instance()->getLoginByWhere(
                array(
                        'uid' => $uid
                ));
    }
}

class MemberLoginModel extends Db
{

    private $_login = 'w_member_login';

    public function addLogin ($params)
    {
        return $this->add($this->_login, $params);
    }

    public function updateLoginByUid ($v, $uid)
    {
        return $this->update($this->_login, $v, 
                array(
                        'uid' => $uid
                ));
    }

    public function getLoginByWhere ($where)
    {
        return $this->getOne($this->_login, $where);
    }

    /**
     *
     * @return MemberLoginModel
     */
    public static function instance ()
    {
        return parent::_instance(__CLASS__);
    }
}