<?php

class WeixinService
{

    static $APPID;

    static $APPSECRET;

    static $TOKEN;

    const TIMEOUT = 7200;

    private $_sex = array(
            1 => "先生",
            2 => "女士",
            0 => "总"
    );

    private $_num = 40;

    private $_config;

    public function __construct ()
    {
        $this->_config = $this->getAllConfig();
        self::$APPID = trim($this->_config['appid']);
        self::$APPSECRET = trim($this->_config['appsecret']);
        self::$TOKEN = trim($this->_config['token']);
    }
    
    // 启动
    public function run ()
    {
        if ($this->_config['valid'] != 1) {
            $this->valid();
        } else {
            $this->responseMsg();
        }
    }

    public function valid ()
    {
        $echoStr = $_GET["echostr"];
        // valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            WeixinModel::instance()->saveConfigByName(1, 'valid');
            exit();
        }
    }

    public function responseMsg ()
    {
        // get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        // extract post data
        if (! empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', 
                    LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName; // openid
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $msgType = $postObj->MsgType;
            $event = $postObj->Event;
            $eventKey = $postObj->EventKey;
            $time = time();
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            if ($msgType == 'event' && $event == 'subscribe') {
                $msgType = "text";
                $user = $this->getUserByOpenid($fromUsername);
                $contentStr = $this->parseUBB($this->_config['welcome']);
                $contentStr = $this->parseSendHtml($contentStr);
                $this->addComment($user, "关注顶上集成吊顶");
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, 
                        $time, $msgType, $contentStr);
                echo $resultStr;
                exit();
            }
            
            if ($msgType == 'event' && $event == 'CLICK' &&
                     $eventKey == 'message') {
                $msgType = "text";
                $user = $this->getUserByOpenid($fromUsername);
                $contentStr = $this->parseUBB($this->_config['server']);
                $contentStr = $this->parseSendHtml($contentStr);
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, 
                        $time, $msgType, $contentStr);
                echo $resultStr;
                exit();
            }
            if (! empty($keyword) && $keyword == "2015") {
               
                $user = $this->getUserByOpenid($fromUsername);
                $contentStr = "请点击 参与活动<a href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxdd55b4acacd385a6&redirect_uri=http%3A%2F%2Fwww.d-shang.com%2Findex.php%3Fyao%2Fus%2F%3F&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect'>摇一摇</a>";
          
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, 
                        $time, $msgType, $contentStr);
                $liwu = "参加摇一摇活动";
                $this->addComment($user, $liwu);
                echo $resultStr;
                exit();
            }
            if (! empty($keyword)) {
                $msgType = "text";
                $user = $this->getUserByOpenid($fromUsername);
                $contentStr = "Hi," . $user['nickname'] . "留言成功,我们会尽快联系你";
                $this->addComment($user, $keyword);
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, 
                        $time, $msgType, $contentStr);
                echo $resultStr;
            } else {
                echo "Input something...";
            }
        } else {
            echo "error1";
            exit();
        }
    }

    public function parseUBB ($comment)
    {
        $ubb = array(
                ":smile",
                ":up",
                ":sweat",
                ":fear",
                ":cry",
                ":money",
                ":tongue",
                ":rose",
                ":drink"
        );
        $html = array(
                "<span class=\"emoji emoji1f604\"></span>",
                "<span class=\"emoji emoji1f44d\"></span>",
                "<span class=\"emoji emoji1f630\"></span>",
                "<span class=\"emoji emoji1f631\"></span>",
                "<span class=\"emoji emoji1f62d\"></span>",
                "<span class=\"emoji emoji1f4b0\"></span>",
                "<span class=\"emoji emoji1f61c\"></span>",
                "<span class=\"emoji emoji1f339\"></span>",
                "<span class=\"emoji emoji1f37a\"></span>"
        );
        return str_replace($ubb, $html, $comment);
    }
    // 回复
    public function reply ($toUser, $msg, $id)
    {
        // 查看是否已经评论过了
        $rs = $this->getCommentById($id);
        if (! empty($rs['reply'])) {
            return array(
                    'status' => false,
                    'message' => '请勿重复发送!'
            );
        }
        $msg = $this->parseUBB($msg);
        // 先解析ubb代码
        $msg = $this->parseSendHtml($msg);
        $param = json_encode(
                array(
                        'touser' => $toUser,
                        'msgtype' => "text",
                        'text' => array(
                                'content' => urlencode($msg)
                        )
                ));
        $param = '{
    "touser":"' . $toUser . '",
    "msgtype":"text",
    "text":
    {
         "content":"' . $msg . '"
    }
}';
        $token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" .
                 $token;
        // 解决unicode编码问题
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $rs = curl_exec($ch);
        curl_close($ch);
        WeixinModel::instance()->saveReply($msg, $id);
        $rs = json_decode($rs, true);
        if ($rs['errmsg'] == "ok") {
            return array(
                    'status' => true,
                    'message' => "成功发送"
            );
        } else {
            return array(
                    'status' => false,
                    'message' => $rs['errmsg']
            );
        }
    }

    private function checkSignature ()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = self::$TOKEN;
        $tmpArr = array(
                $token,
                $timestamp,
                $nonce
        );
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function getOpenIdByCode ($code)
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' .
                 self::$APPID . '&secret=' . self::$APPSECRET . '&code=' . $code .
                 '&grant_type=authorization_code';
        $con = file_get_contents($url);
        $rs = $this->parseJSON($con);
        if (isset($rs['errcode'])) {
            return array(
                    'status' => false,
                    'message' => $rs['errmsg']
            );
        }
        return array(
                'status' => true,
                'data' => $rs['openid']
        );
    }
    
    // 获取用户信息
    public function getUserByOpenid ($openid)
    {
        $token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" .
                 $token . "&openid=" . $openid . "&lang=zh_CN";
        $con = file_get_contents($url);
        $user = $this->parseJSON($con);
        $this->saveLog($user['openid']);
        if (isset($user['errcode'])) {
            $this->saveLog($user['errmsg']);
        }
        return $user;
    }
    // 获取access_token
    private function getAccessToken ()
    {
        $rs = WeixinModel::instance()->getConfigByName('access_token');
        if (time() - $rs['add_time'] < self::TIMEOUT) {
            return $rs['value'];
        }
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                 self::$APPID . "&secret=" . self::$APPSECRET;
        $con = file_get_contents($url);
        $token = $this->parseJSON($con);
        if (isset($token['errcode'])) {
            $this->saveLog($token['errmsg']);
        }
        $rs = WeixinModel::instance()->saveConfigByName($token['access_token'], 
                'access_token');
        if ($rs < 1) {
            $this->saveLog("access_token update is failed");
        }
        return $token['access_token'];
    }

    private function parseJSON ($string)
    {
        return json_decode($string, true);
    }

    private function saveLog ($string)
    {
        $handle = fopen(ROOT . "/log/weixin.log", "a+");
        $string = date("Ymd H:i:s", time()) . "#" . $string . "\r\n";
        fwrite($handle, $string);
        fclose($handle);
    }
    // 添加评论
    private function addComment ($user, $content)
    {
        $params = array(
                'nickname' => $user['nickname'],
                'province' => $user['province'],
                'sex' => $user['sex'],
                'city' => $user['city'],
                'face' => $user['headimgurl'],
                'add_time' => time(),
                'content' => $content,
                'openid' => $user['openid']
        );
        $rs = WeixinModel::instance()->addComment($params);
        if ($rs < 1) {
            $this->saveLog("comment error");
        }
    }

    public function getComment ()
    {
        return WeixinModel::instance()->getComment(10);
    }

    public function getCommentPage ($p)
    {
        $total = $this->getCommentNum();
        $page = $this->page($total, $p, $this->_num);
        $rs = WeixinModel::instance()->getCommentPage($page['start'], 
                $this->_num);
        $user = $this->matchUser($rs);
        return array(
                'page' => $page,
                'user' => $user
        );
    }

    private function matchUser ($rs)
    {
        if (empty($rs)) {
            return;
        }
        foreach ($rs as $k => $v) {
            $rs[$k]['sex'] = $this->_sex[$v['sex']];
            $rs[$k]['content'] = $this->parseHtmlemoji($v['content']);
            $rs[$k]['reply'] = $this->parseHtmlemoji($v['reply']);
        }
        return $rs;
    }
    // 转换得到含emoji表情的代码 注意引入css文件
    protected function parseHtmlemoji ($text)
    {
        require_once 'emoji/emoji.php';
        $tmpStr = json_encode($text);
        $tmpStr = preg_replace("#(\\\ue[0-9a-f]{3})#ie", "addslashes('\\1')", 
                $tmpStr);
        $text = json_decode($tmpStr);
        preg_match_all("#u([0-9a-f]{4})+#iUs", $text, $rs);
        if (empty($rs[1])) {
            return $text;
        }
        foreach ($rs[1] as $v) {
            $test_iphone = '0x' . trim(strtoupper($v));
            $test_iphone = $test_iphone + 0;
            $t = emoji_unified_to_html(
                    emoji_softbank_to_unified($this->utf8_bytes($test_iphone)));
            $text = str_replace("\u$v", $t, $text);
        }
        return $text;
    }

    protected function parseSendHtml ($msg)
    {
        require_once 'emoji/emoji.php';
        return emoji_unified_to_softbank(emoji_html_to_unified($msg));
    }

    protected function utf8_bytes ($cp)
    {
        if ($cp > 0x10000) {
            // 4 bytes
            return chr(0xF0 | (($cp & 0x1C0000) >> 18)) .
                     chr(0x80 | (($cp & 0x3F000) >> 12)) .
                     chr(0x80 | (($cp & 0xFC0) >> 6)) . chr(0x80 | ($cp & 0x3F));
        } else 
            if ($cp > 0x800) {
                // 3 bytes
                return chr(0xE0 | (($cp & 0xF000) >> 12)) .
                         chr(0x80 | (($cp & 0xFC0) >> 6)) .
                         chr(0x80 | ($cp & 0x3F));
            } else 
                if ($cp > 0x80) {
                    // 2 bytes
                    return chr(0xC0 | (($cp & 0x7C0) >> 6)) .
                             chr(0x80 | ($cp & 0x3F));
                } else {
                    // 1 byte
                    return chr($cp);
                }
    }
    // 获取最新的
    public function getCommentMaxId ($id)
    {
        $rs = WeixinModel::instance()->getCommentMaxId($id);
        if (empty($rs)) {
            return array(
                    'status' => false,
                    'data' => ""
            );
        } else {
            return array(
                    'status' => true,
                    'data' => $rs
            );
        }
    }

    private function getCommentNum ()
    {
        return WeixinModel::instance()->getCommentNum();
    }
    // 微信更新方法
    public function saveConfig ($v)
    {
        foreach ($v as $k => $v) {
            $v = urldecode($v);
            if ($k == "button") {
                $button = $v;
            }
            $rs = WeixinModel::instance()->saveConfigByName($v, $k);
        }
        return $this->saveButton($button);
    }
    // 微信更新方法
    public function saveButton ($v)
    {
        if (empty($v)) {
            return array(
                    'status' => false,
                    'message' => "按钮内容不能为空"
            );
        }
        $rs = WeixinModel::instance()->saveConfigByName($v, 'button');
        $token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" .
                 $token;
        $msg = $this->postConfig($url, $v);
        $msg = json_decode($msg, true);
        if ($rs > 0) {
            return array(
                    'status' => true,
                    'message' => $msg['errmsg']
            );
        } else {
            return array(
                    'status' => false,
                    'message' => $msg['errmsg']
            );
        }
    }

    private function postConfig ($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

    /**
     * 获取配置
     */
    public function getAllConfig ()
    {
        $rs = WeixinModel::instance()->getAllConfig();
        $res = array();
        foreach ($rs as $v) {
            $res[$v['name']] = $v['value'];
        }
        return $res;
    }

    /**
     * 分页
     *
     * @return void
     */
    private function page ($total, $pageid, $num)
    {
        $pageid = isset($pageid) ? $pageid : 1;
        $start = ($pageid - 1) * $num;
        $pagenum = ceil($total / $num);
        /* 修正分类不包含内容 显示404错误 */
        $pagenum = $pagenum == 0 ? 1 : $pagenum;
        /* 如果超过了分类页数 404错误 */
        if ($pageid > $pagenum) {
            return false;
        }
        return array(
                'start' => $start,
                'num' => $num,
                'current' => $pageid,
                'page' => $pagenum
        );
    }
    // 获取具体内容
    private function getCommentById ($id)
    {
        return WeixinModel::instance()->getCommentById($id);
    }
}

class WeixinModel extends Db
{

    private $_weixin = 'd_weixin';

    private $_weixin_comment = 'd_weixin_comment';

    public function saveConfigByName ($value, $name)
    {
        return $this->update($this->_weixin, 
                array(
                        'value' => $value,
                        'add_time' => time()
                ), 
                array(
                        'name' => $name
                ));
    }
    // 获取秘钥
    public function getConfigByName ($name)
    {
        return $this->getOne($this->_weixin, 
                array(
                        'name' => $name
                ));
    }

    public function getAllConfig ()
    {
        return $this->getAll($this->_weixin);
    }
    // 添加评论
    public function addComment ($params)
    {
        return $this->add($this->_weixin_comment, $params);
    }

    public function saveReply ($reply, $id)
    {
        return $this->update($this->_weixin_comment, 
                array(
                        'reply' => $reply
                ), 
                array(
                        'id' => $id
                ));
    }

    public function getCommentById ($id)
    {
        return $this->getOne($this->_weixin_comment, 
                array(
                        'id' => $id
                ));
    }

    public function getComment ($limit)
    {
        return $this->getAll($this->_weixin_comment, null, null, 'id DESC', 
                $limit);
    }

    public function getCommentPage ($start, $num)
    {
        return $this->getPage($start, $num, $this->_weixin_comment, null, null, 
                'id DESC');
    }
    // 获取总条数
    public function getCommentNum ()
    {
        $sql = "SELECT id FROM $this->_weixin_comment";
        return $this->rowCount($sql);
    }
    // 获取最新的
    public function getCommentMaxId ($id)
    {
        $sql = "SELECT * FROM $this->_weixin_comment WHERE id>$id ORDER By id ASC LIMIT 1";
        return $this->fetch($sql);
    }

    /**
     *
     * @return WeixinModel
     */
    public static function instance ()
    {
        return parent::_instance(__CLASS__);
    }
}