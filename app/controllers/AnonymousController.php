<?php

/**
 * WCMS 登陆器 只跟用户有关注册、登陆有关 其他无关 判断有无登陆 可以设置cookie
 * 描述 调用了MemberService指定接口  login  register getOneMemberByUsername
 * @author wolf
 * @since 2014-08-02 
 * @version 第4次简化
 *
 */
class AnonymousController extends Action
{
    // 修改了这个 别忘记修改权限管理器的cookie
    const COOKIENAME = 'user';

    /**
     * 管理员登录口
     */
    public function admin ()
    {
        $this->login();
    }

    /**
     * 用户注册 接口 调用用户服务
     * 只检测提交的字段是否合法
     * 
     * @todo 默认用户组未添加
     */
    public function register ()
    {
        $group = self::getMemberService()->getMemberGroup();
        $this->view()->assign("group", $group);
        $this->view()->display('file:anonymous/register.tpl');
    }

    /**
     * 用户提交注册
     */
    public function setRegister ()
    {
        $rs = self::getMemberService()->register($_POST);
        if ($rs['status']) {
            $event = "自己注册";
            self::getLogService()->addAdminEvent($rs['data'], $event);
        }
        $this->sendNotice($rs['message'], null, $rs['status']);
    }

    public function password ()
    {
        $this->view()->display('file:anonymous/password.tpl');
    }

    public function mailPassword ()
    {
        $member = new MemberService();
        $member->mailPassword($_POST['mobile_phone']);
    }

    /**
     * 普通会员登录
     */
    public function login ()
    {
      
        // 导入广告
        $advService = new AdvService();
        $adv = $advService->getAdvByType(3);
        $this->view()->assign('adv', $adv);
        if (isset($_COOKIE[self::COOKIENAME])) {
            $memberCenter=new MemberCenterModule();
            $user=$memberCenter->getUserByCookie($_COOKIE[self::COOKIENAME]);
            $this->view()->assign('user', $user);

			if ($user ['manager'] >= 2) {
		        $nodes = 75;
		        $this->view()->assign('user', $user);
		        $this->view()->assign('nodes', $nodes);
		        $this->view()->display('file:news/main.tpl');
			}
			else
			{
			    $sys = new SysService();
		        $nodes = $sys->getNodesByFid(0);
		        $this->view()->assign('user', $user);
		        $this->view()->assign('nodes', $nodes);
		        $this->view()->display('file:news/main.tpl');
			} 
            exit();
        }
        $this->view()->display('file:anonymous/login.tpl');
        
    }

    /**
     * 生成验证码
     */
    public function captcha ()
    {
        require 'Captcha.php';
        // 确保每次都能取到新值
        // 实例化一个对象
        $_vc = new Captcha();
        $_vc->ttf_file = './config/captcha.ttf'; // 字体
        $_vc->code_length = 4; // 长度
        $_vc->charset = '234567890'; // 字体
        $_vc->num_lines = 0;
        $_vc->font_ratio = 0.6;
        $_vc->image_width = 120;
        $_vc->image_height = 40;
        $_vc->noise_level = 0.5; // 噪点
        $_vc->show();
    }

    /**
     * 登录验证
     */
    public function setLogin ()
    {
        $user = self::getMemberService()->login($_POST);
        // 登陆成功 默认记录10个小时
        if (is_array($user)) {
            setcookie(self::COOKIENAME, $user['username'], time() + 3600 * 10, "/");
            self::getLogService()->add($user['username'], "登录");
            $user = self::SUCEESS;
        }
        $this->sendNotice($user, null, false);
    }

    /**
     * 退出登录 同步登录
     */
    public function signout ()
    {
        self::getLogService()->add($_COOKIE[self::COOKIENAME], "退出");
        setcookie(self::COOKIENAME, "", - 86400, "/");
        setcookie("jiami", "", - 86400, "/");
        unset($_SESSION['userdata']);
        $this->redirect("退出成功!", './index.php?anonymous/login');
    }

    /**
     * 获取用户服务类
     */
    public static function getMemberService ()
    {
        return new MemberService();
    }
}