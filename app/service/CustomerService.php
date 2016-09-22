<?php
class CustomerService
{
    private $_key = 'ds';
    private $_cid = 35803;
    private $_num = 20;
    //获取二维码连接
    public function getArticle ($code)
    {
        $id = $this->jiemi($code);
        $news = new NewsService(12, 1);
        $rs = $news->getCon($id);
        return $rs['content'];
    }
    public function jiami ($id)
    {
        return $this->encrypt($id, "E", $this->_key);
    }
    public function qrcode ($id)
    {
        $code = $this->jiami($id);
        $sys = new SysService();
        $config = $sys->getConfig();
        $qr = new MyQrcode();
        $qr->logo = ROOT . 'config/logo.png';
        $web = './static/attached/qrcode/';
        $qr->dir = ROOT . $web;
        $qr->islogo = $config['islogo'];
        $qr->size = $config['ewm_size'];
        $url = "http://".$config['website'] . "/WCMS/index.php?customer/news/?code=" . $code;
        $qr->create($url, $id);
        return $web . $id . ".png";
    }
    public function jiemi ($code)
    {
        return $this->encrypt($code, "D", $this->_key);
    }
    private function encrypt ($string, $operation, $key = '')
    {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(
        md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i ++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i ++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i ++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(
            ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) ==
             substr(md5(substr($result, 8) . $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return '';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }
    }
}

