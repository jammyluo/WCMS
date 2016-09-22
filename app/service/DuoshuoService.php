<?php

class DuoshuoService
{

    static $secret ;
    static $short_name;
    static $last_log_id ;
    private $_num=40;

    public function __construct ()
    {
        $sys = new SysService();
        $config = $sys->getConfig();
        self::$secret = $config['duoshuo_secret'];
        self::$short_name = $config['short_name'];
    }

    /**
     * 获取评论数据
     */
    public function sync_log ()
    {
        $limit = 20;
        $params = array(
                'limit' => $limit,
                'order' => 'asc'
        );
        
        $posts = array();
        
        if (! self::$last_log_id) {
            $last_log_id = 0;
        }
        $params['since_id'] = $last_log_id;
        // 自己找一个php的 http 库
        $url = 'http://api.duoshuo.com/log/list.json?short_name=' .
                 self::$short_name . '&secret=' . self::$secret .
                 '&limit='.$this->_num.'&order=desc&since_id=0';
        $response = file_get_contents($url);
        
        $response = json_decode($response, true);
        if ($response['code'] != 0) {
            echo $response['errorMessage '];
            exit();
        }
        $rs=array();
        
        foreach ($response['response'] as $k=>$v) {
          $rs[$k]['comment']=$v['meta']['message'];
          $rs[$k]['real_name']=$v['meta']['author_name'];
          $rs[$k]['date']=strtotime($v['meta']['created_at']);
        }
        return $rs;
    }

    /**
     * 检查签名
     */
    private function check_signature ($input)
    {
        $signature = $input['signature'];
        unset($input['signature']);
        
        ksort($input);
        $baseString = http_build_query($input, null, '&');
        $expectSignature = base64_encode(
                $this->hmacsha1($baseString, self::$secret));
        if ($signature !== $expectSignature) {
            return false;
        }
        return true;
    }
    
    // from: http://www.php.net/manual/en/function.sha1.php#39492
    // Calculate HMAC-SHA1 according to RFC2104
    // http://www.ietf.org/rfc/rfc2104.txt
    private function hmacsha1 ($data, $key)
    {
        if (function_exists('hash_hmac'))
            return hash_hmac('sha1', $data, $key, true);
        
        $blocksize = 64;
        if (strlen($key) > $blocksize)
            $key = pack('H*', sha1($key));
        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack('H*', 
                sha1(
                        ($key ^ $opad) . pack('H*', 
                                sha1(($key ^ $ipad) . $data))));
        return $hmac;
    }
}
?>