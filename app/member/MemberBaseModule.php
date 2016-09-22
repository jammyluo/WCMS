<?php
// 用户基本信息
class MemberBaseModule implements IMember
{
    // 可更改的信息
    private $_keys = array(
            'username',
            'password',
            'groupid',
            'salt',
            'real_name',
            'area',
            'country',
            'face',
            'mobile_phone',
            'email',
            'verify',
            'manager',
            'status',
            'lastlogin',
            'birthday',
            'sex',
            'province',
            'city',
            'town',
            'qq'
    );
    /*
     * (non-PHPdoc) @see IMember::add()
     */
    public function add ($data)
    {
        // TODO Auto-generated method stub
        $arr = $this->parseData($data);
        // 增加辅助信息
        $salt = $this->randstr();
        $arr['password'] = md5(md5($arr['password']) . $salt);
        //$ip = $this->getIp();
        //$arr['area'] = $ip['region'] . $ip['city'];
        $arr['salt'] = $salt;
        $arr['add_time'] = time();
        // 注册用户权限
        $arr['manager'] = 2;
        $arr['verify'] = 0;
        return MemberModel::instance()->addMember($arr);
    }
    // 处理积分
    private function parseData ($data)
    {
        $arr = array();
        foreach ($this->_keys as $v) {
            if (isset($data[$v])) {
                $arr[$v] = $data[$v];
            }
        }
        return $arr;
    }
    /*
     * (non-PHPdoc) @see IMember::getCon()
     */
    public function getCon ($uid)
    {
        // TODO Auto-generated method stub
        return MemberModel::instance()->getOneMember(array(
                'uid' => $uid
        ));
    }
    /*
     * (non-PHPdoc) @see IMember::remove()
     */
    public function remove ($uid)
    {
        // TODO Auto-generated method stub
        return MemberModel::instance()->delMemberByWhere(array(
                'uid' => $uid
        ));
    }
    /*
     * (non-PHPdoc) @see IMember::saveCon()
     */
    public function saveCon ($v, $uid)
    {
        $v = $this->parseData($v);
        if (! empty($v['password'])) {
            $salt = $this->randstr();
            $v['password'] = md5(md5($v['password']) . $salt);
            $v['salt'] = $salt;
        } else {
            unset($v['password']);
        }
        if (! empty($_FILES['face']['tmp_name'])) {
            $v['face'] = $this->upload();
        }
        if (isset($v['manager'])) {
            $v['verify'] = $v['manager'] <= 3 ? 1 : 0;
        }
        return MemberModel::instance()->setMemberByWhere($v, 
                array(
                        'uid' => $uid
                ));
    }

    public function setLogintimeByUid ($time, $uid)
    {
        return MemberModel::instance()->setMemberByWhere(
                array(
                        'lastlogin' => $time
                ), array(
                        'uid' => $uid
                ));
    }
    // 修改积分
    public function setCouponsByUid ($coupons, $uid)
    {
        return MemberModel::instance()->setMemberByWhere(
                array(
                        'coupons' => $coupons
                ), array(
                        'uid' => $uid
                ));
    }
    // 修改帐号状态
    public function setStatusByUid ($status, $uid)
    {
        return MemberModel::instance()->setMemberByWhere(
                array(
                        'status' => $status
                ), array(
                        'uid' => $uid
                ));
    }
    // 修改密码
    public function setPasswordByUid ($password, $uid)
    {
        $salt = $this->getCon($uid);
        return $this->saveCon(array(
                'password' => $password
        ), $uid);
    }

    public function getMemberByUsername ($username)
    {
        return MemberModel::instance()->getOneMember(
                array(
                        'username' => $username
                ));
    }

    public function getMemberByRealname ($realname)
    {
        return MemberModel::instance()->getOneMember(
                array(
                        'real_name' => $realname,
                        'verify' => 1
                ));
    }

    public function getMemberByMobile ($mobile)
    {
        return MemberModel::instance()->getOneMember(
                array(
                        'mobile_phone' => $mobile
                ));
    }
    // 模糊查询真实姓名
    public function getMemberLikeRealName ($realName)
    {
        return MemberModel::instance()->getMemberLikeRealName($realName);
    }
    // 根据条件查询用户
    public function getMemberByWhere ($where)
    {
        return MemberModel::instance()->getOneMember($where);
    }

    /**
     * 后台头像上传处理
     * 注意上传文件大小限制
     *
     * @return string $filePath 图片路径
     */
    public function upload ()
    {
        if (is_uploaded_file($_FILES['face']['tmp_name'])) {
            $upfile = $_FILES['face'];
            $name = $upfile['name'];
            $type = $upfile['type'];
            $size = $upfile['size'];
            $tmp_name = $upfile['tmp_name'];
            $error = $upfile[error];
            switch ($type) {
                case 'image/jpeg':
                    $ok = 1;
                    break;
                case 'image/pjpeg':
                    $ok = 1;
                    break;
                case 'image/gif':
                    $ok = 1;
                    break;
                case 'image/png':
                    $ok = 1;
                    break;
                case 'image/x-png':
                    $ok = 1;
                    break;
            }
            // 修正缩略图文件夹
            // 创建文件夹
            $save_path = getcwd() . "/static/attached/face/";
            $save_url = "./static/attached/face/";
            $ym = date("Ym");
            $save_path .= $ym . "/";
            $save_url .= $ym . "/";
            if (! file_exists($save_path)) {
                mkdir($save_path);
            }
            if ($ok == '1' && $error == '0') {
                $fileType = substr($name, strpos($name, ".") + 1);
                $newName = time() . "." . $fileType;
                $filepath = $save_path . $newName;
                move_uploaded_file($tmp_name, $filepath);
                $callback = $_REQUEST["CKEditorFuncNum"];
                return $save_url . $newName;
            } else {
                return self::ERROR;
            }
        }
    }
    // 加密方法
    private function randstr ($len = 6)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        mt_srand((double) microtime() * 1000000 * getmypid());
        $password = '';
        while (strlen($password) < $len) {
            $password .= substr($chars, (mt_rand() % strlen($chars)), 1);
        }
        return $password;
    }

    /**
     * 获取ip
     */
    private function getIp ()
    {
        $ip = new IpLocation();
        $clientIp = $ip->getIP();
        return $ip->getlocation($clientIp);
    }
}