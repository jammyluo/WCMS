<?php

/**
 * 简单的用户系统
 * 头像验证、用户组、实名认证
 * @author wolf
 * @since 2014-07-12
 *
 */
class MemberService extends MemberBaseService
{

    const SUCCESS = 'success';

    const ERROR = 'error';

    const USERNAME = 'username';
    // 系统默认管理员 权限从上到下 默认是5
    public $_group = array(
            1 => "站长",
            2 => "管理员",
            3 => "实名用户",
            4 => "注册会员",
            5 => "游客",
            6 => "黑名单",
            0 => "继承分类权限"
    );
    // 分页数
    private $_num = 40;
    // 用来区分等级
    // 用户等级制度
    private $_sex = array(
            0 => "先生",
            1 => "女士"
    );

    public $_verify = array(
            "-1" => "不通过",
            "0" => "尚未认证",
            "1" => "实名认证"
    );

    public $_status = array(
            "0" => "活跃",
            "1" => "禁用",
            2 => "离职"
    );

    private $_legal = array(
            'province',
            'town',
            'city',
            'area',
            'qq',
            'email',
            'birthday',
            'sex'
    );

    const OVERTIME = 30; // 登陆超时时间 天数
    /**
     * 保存用户
     */
    public function save ($user)
    {
        $this->saveMemberByUid($user, $user['uid']);
        return self::SUCCESS;
    }

    public function getCompletePercent ($user)
    {
        $percent = ceil(100 / count($this->_legal)) / 100;
        $now = 0;
        foreach ($this->_legal as $v) {
            
            if (! empty($user[$v])) {
                $now += $percent;
                continue;
            }
        }
        
        if ($user['sex'] == 0) {
            $now += $percent;
        }
        return $now > 1 ? 1 : $now;
    }
    
    // 修改用户真实信息
    public function saveMemberData ($uid, $data)
    {
        if (empty($uid)) {
            return "请先登录";
        }
        
        foreach ($data as $k => $v) {
            if (! in_array($k, $this->_legal)) {
                unset($data[$k]);
            }
        }
        
        $data['birthday'] = strtotime($data['birthday']);
        $rs = $this->saveMemberByUid($data, $uid);
        if ($rs > 0) {
            return array(
                    'status' => true,
                    'message' => "更新成功"
            );
        } else {
            return array(
                    'status' => true,
                    'message' => "更新失败"
            );
        }
    }

    /**
     * 增加用户
     */
    public function register ($userInfo)
    {
        if (! $this->checkValidate($userInfo['codeimg'])) {
            return array(
                    'status' => false,
                    'message' => "验证码错误"
            );
        }
        if (strlen($userInfo['mobile_phone']) != 11) {
            return array(
                    'status' => false,
                    'message' => "手机号码为11位数"
            );
        }
        if (strlen($userInfo['password']) < 5) {
            return array(
                    'status' => false,
                    'message' => "密码至少为5位数"
            );
        }
        if ($this->filter($userInfo['password'])) {
            return array(
                    'status' => false,
                    'message' => "密码中包含了标点符号"
            );
        }
        if ($this->filter($userInfo['username'])) {
            return array(
                    'status' => false,
                    'message' => "用户名中包含了标点符号"
            );
        }
        $moblie = $this->getMemberByMobile($userInfo['mobile_phone']);
        if (! empty($moblie)) {
            return array(
                    'status' => false,
                    'message' => "手机号码重复了!"
            );
        }
        $username = $this->getMemberByUsername($userInfo['username']);
        if (! empty($username)) {
            return array(
                    'status' => false,
                    'message' => "用户名重复了!"
            );
        }
        return $this->addMember($userInfo);
    }



    /**
     * 增加用户
     */
    public function onMobileRegisterUser ($userInfo)
    {

        if (strlen($userInfo['mobile_phone']) != 11) {
            return array(
                'status' => false,
                'message' => "手机号码为11位数"
            );
        }
        if (strlen($userInfo['password']) < 5) {
            return array(
                'status' => false,
                'message' => "密码至少为5位数"
            );
        }
        if ($this->filter($userInfo['password'])) {
            return array(
                'status' => false,
                'message' => "密码中包含了标点符号"
            );
        }

        $moblie = $this->getMemberByMobile($userInfo['mobile_phone']);
        if (! empty($moblie)) {
            return array(
                'status' => false,
                'message' => "手机号码重复了!"
            );
        }

        //验证短信是否正确
        $rs = IosModel::instance()->getCheckMsgByPhone($userInfo['mobile_phone']);
        if($userInfo['msg'] != $rs[0]['num']){
            return array('status'=>false, 'message'=>"验证码错误", 'data'=>'');
        }

        return $this->addMember($userInfo);
    }


    public function login ($user)
    {
        if (! $this->checkValidate($user['codeimg'])) {
            return "验证码错误";
        }
        if ($this->filter($user['password'])) {
            return '密码中含有标点符号';
        }
        $userInfo = $this->isLogin($user['mobile_phone'], $user['password']);
        // 这里的$userInfo 返回一个对象 现在是数组
        if (! $userInfo['status']) {
            return $userInfo['message'];
        }
        // 增加登录历史记录
        $this->_baseObj->setLogintimeByUid(time(), $userInfo['data']['uid']);
        return $userInfo['data'];
    }

    /**
     * 用户账户状态
     *
     * @param string $ids            
     * @param string $type            
     */
    public function saveStatus ($status, $uid)
    {
        $rs = $this->_baseObj->setStatusByUid($status, $uid);
        if ($rs > 0) {
            return array(
                    'status' => true,
                    'data' => $this->_status[$status],
                    'message' => "更新成功"
            );
        } else {
            return array(
                    'status' => false,
                    'data' => $this->_status[$status],
                    'message' => "更新失败"
            );
        }
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     * 管理用户钱袋子
     *
     * @param int $uid            
     * @param decimal $coupons            
     * @param int $type
     *            0增加 1减少
     */
    public function saveCoupons ($uid, $coupons, $type)
    {
        $user = $this->getMemberByUid($uid);
        
        if ($user['coupons']<$coupons&&$type>=1){
            return array('status'=>false,'message'=>"余额不足");
        }
        
        if ($type < 1) {
            $coupons = $user['coupons'] + $coupons;
        } else {
            $coupons = $user['coupons'] - $coupons;
        }
        return $this->_baseObj->setCouponsByUid($coupons, $uid);
    }

    /**
     * 搜索
     */
    public function search ($field, $value)
    {
        if ($field == "uid") {
            $member = $this->getMemberByUid($value);
            $rs[0] = $member;
        } else {
            $value = urldecode($value);
            $rs = MemberModel::instance()->getMemberByLike($field, $value);
        }
        return $this->parseMember($rs);
    }
    // 处理member状态
    private function parseMember ($members)
    {
        foreach ($members as $k => $v) {
            $members[$k]['age'] = date("Y") - date("Y", $v['birthday']);
            $members[$k]['status'] = $this->_status[$v['status']];
        }
        return $members;
    }

    /**
     * 删除会员
     *
     * @param int $uid            
     */
    public function remove ($uid, $actionUserId)
    {
        if ($uid < 1) {
            return "id必须大于1";
        }
        if ($uid == $actionUserId) {
            return "无法删除自己";
        }
        $user = $this->getMemberByUid($uid);
        if (empty($user)) {
            return "用户不存在";
        }
        // 如果存在交易信息 就无法删除
        if (round($user['coupons']) > 0 || round($user['coupons']) < 0) {
            return "用户积分还有剩余,无法删除";
        }
        $rs = $this->removeByUid($uid);
        return $rs > 0 ? self::SUCCESS : self::ERROR;
    }
    // 用户列表页
    public function listing ($currentPage)
    {
        $group = $this->getMemberGroup();
        // 系统组别
        foreach ($group as $v) {
            $groupname[$v['id']] = $v['name'];
        }
        $totalNum = MemberModel::instance()->getMemberNums();
        $page = $this->page($currentPage, $totalNum);
        $memberlist = MemberModel::instance()->getMemberPages($page['start'], 
                $page['num']);
        // 重组验证和等级
        foreach ($memberlist as $k => $v) {
            $memberlist[$k]['age'] = date("Y") - date("Y", $v['birthday']);
            $memberlist[$k]['sex'] = $this->_sex[$v['sex']];
            $memberlist[$k]['status'] = $this->_status[$v['status']];
            $memberlist[$k]['statusid'] = $v['status'];
        }
        return array(
                'totalnum' => $totalNum,
                'memberlist' => $memberlist,
                'groupname' => $groupname,
                'verify' => $this->_verify,
                'page' => $page
        );
    }

    /**
     * 用户修改密码
     *
     * @param int $uid            
     * @param String $password            
     * @param String $newPassword            
     */
    public function rePassword ($uid, $password, $newPassword)
    {
        $base = new MemberBaseModule();
        $user = $base->getCon($uid);
        $oldPassword = md5(md5($password) . $user['salt']);
        if ($this->filter($newPassword)) {
            return "密码中请勿包含标点符号等";
        }
        if ($newPassword == "123456") {
            return "密码过于简单";
        }
        if ($newPassword == $password) {
            return "新的密码和旧密码不能相同";
        }
        if (strlen($newPassword) < 5) {
            return "密码至少为6位";
        }
        if ($user['password'] != $oldPassword) {
            return "原密码错误";
        } else {
            $this->_baseObj->setPasswordByUid(trim($newPassword), $uid);
            return "修改成功,下次登录时生效";
        }
    }
    
    // 邮件修改密码
    public function mailPassword ($mobile)
    {
        $user = $this->getMemberByMobile($mobile);
        if (empty($user)) {
            return array(
                    'status' => false,
                    'message' => "账号不存在"
            );
        }
        
        if (empty($user['email'])) {
            return array(
                    'status' => false,
                    'message' => "没有绑定邮箱,请联系管理员!"
            );
        }
        $newPassword = $this->getRandNum(6);
        $this->_baseObj->setPasswordByUid(trim($newPassword), $user['uid']);
        $email = new EmailService();
        $sys = new SysService();
        $config = $sys->getConfig();
        $mailcontent = "恭喜你，获取了新的密码:" . $newPassword . "点击重新登录<a href=\"http://" .
                 $config['website'] . "\">" . $config['website'] . "</a>";
        $email->send($user['email'], "密码找回", $mailcontent);
    }

    private function getRandNum ($num)
    {
        $str = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
        $pd = "";
        for ($i = 0; $i < $num; $i ++) {
            $sj = rand(0, strlen($str) - 1);
            $pd .= $str{$sj};
        }
        return $pd;
    }

    /**
     * 新增用户
     *
     * @param Array $userInfo            
     */
    private function addMember ($user)
    {
        // 直接验证成功
        $rs = $this->add($user);
        if ($rs > 0) {
            return array(
                    'status' => true,
                    'message' => "注册成功",
                    'data' => $rs
            );
        } else {
            return array(
                    'status' => false,
                    'message' => "注册失败",
                    'data' => $rs
            );
        }
    }

    /**
     * 判断是否登录
     *
     * @param String $username            
     * @param String $passsword            
     * @return Array 用户信息
     */
    public function isLogin ($username, $passsword)
    {
        // 下面调用服务
        // 查询用户是否存在
        $userInfo = $this->getMemberByMobile($username);
        // 简单验证
        if (empty($userInfo)) {
            return array(
                    'status' => false,
                    'message' => "手机号码不存在"
            );
        }
        if (strlen($username) < 4 || strlen($passsword) < 4) {
            return array(
                    'status' => false,
                    'message' => "用户名或密码不能小与6位!"
            );
        }
        // 判断密码是否正确
        if ($userInfo['password'] != md5(md5($passsword) . $userInfo['salt'])) {
            return array(
                    'status' => false,
                    'message' => "密码不正确"
            );
        }
        // 检查账号是否被禁用
        if ($userInfo['status'] > 0) {
            return array(
                    'status' => false,
                    'message' => "账号已被禁用!"
            );
        }
        return array(
                'status' => true,
                'data' => $userInfo
        );
    }

    /**
     * 检测验证码是否正确
     */
    private function checkValidate ($codeimg)
    {
        $captcha = new Captcha();
        return $captcha->check($codeimg);
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

    /**
     * 分页
     *
     * @return void
     */
    private function page ($p, $total)
    {
        $pageid = isset($p) ? $p : 1;
        $start = ($pageid - 1) * $this->_num;
        $pagenum = ceil($total / $this->_num);
        return array(
                'start' => $start,
                'num' => $this->_num,
                'current' => $pageid,
                'page' => $pagenum
        );
    }
}