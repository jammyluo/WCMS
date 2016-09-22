<?php
// 解决手机端的问题
class ChangyanController extends NodeController
{

    static $service;
    
    // 服务评价
    public function rating ()
    {
        $sys = new SysService();
        $config = $sys->getConfig();
        
        $token = array(
                "short_name" => $config['short_name'],
                "user_key" => $this->_user_global['uid'],
                "name" => $this->_user_global['real_name']
        );
        $duoshuoToken = JWT::encode($token, $config['duoshuo_secret']);
        setcookie('duoshuo_token', $duoshuoToken, time() + 3600 * 10, "/");
        $this->view()->assign('config', $config);
        $this->view()->display("file:rating/market.tpl");
    }
    
    // 接口
    public function duoshuo ()
    {
        $duoshuo = new DuoshuoService();
        $rs = $duoshuo->sync_log();
        $this->view()->assign('news', $rs);
        // 在线导出功能
        // 增加指定模板
        $this->view()->display("file:comment/list.tpl");
    }
}