<?php

class CustomerController extends NodeController
{

    static $service;
    // 获取二维码
    public function article ()
    {
        $id = $_REQUEST['id'];
        if (empty($id)) {
            echo "生成失败";
            exit();
        }
        // 静态页面
        $img = self::getService()->qrcode($id);
        if ($_REQUEST['type'] == 'url') {
            echo $img;
            exit();
        }
        $this->view()->assign('img', $img);
        $this->view()->display('file:customer/article.tpl');
    }

    public function news ()
    {
        // 对字符进行加密
        $rs = self::getService()->getArticle($_GET['code']);
        $this->view()->assign('rs', $rs);
        $this->view()->display('file:customer/news.tpl');
    }

    public static function getService ()
    {
        if (self::$service == null) {
            self::$service = new CustomerService();
        }
        return self::$service;
    }
}