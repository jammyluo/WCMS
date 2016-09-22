<?php

//IOS服务接口
class IOSService
{


    public function login($data)
    {

        $member = new MemberService();
        $userInfo = $member->getMemberByMobile($data['mobile']);
        if (empty($userInfo)) {
            return array('status' => false, 'message' => "用户不存在!");
        }
        // 判断密码是否正确
        if ($userInfo['password'] != md5(md5($data['password']) . $userInfo['salt'])) {
            return array(
                'status' => false,
                'message' => "密码不正确"
            );
        }

        if ($userInfo['status'] > 0) {

            return array('status' => false, 'message' => "你的账号异常!");
        }




        $code = $this->getTokenByUid($userInfo['uid']);
        $data = array('user' => $userInfo['real_name'], 'token' => $code);
        return array('status' => true, 'message' => "登录成功", "data" => $data);


    }



    public function register(){

        $memberSer=new MemberService();
        $memberSer->register();

    }

    public function getTokenByUid($uid){
        return  $this->encode($uid);
    }




    private function saveLog($string)
    {
        $handle = fopen(ROOT . "/log/ios.log", "a+");
        $string = date("Ymd H:i:s", time()) . "#" . $string . "\r\n";
        fwrite($handle, $string);
        fclose($handle);
    }




    public function getUserByToken($token)
    {

        $encrypt = new Encrypt();
        $rs = $encrypt->decode($token);
        if (!strpos($rs, "&")) {
            $msg="不合法的token".$rs;
            return array('status' => false, 'message' => $msg);

        }
        $user = explode("&", $rs);

        $memberSer = new MemberService();
        $userInfo = $memberSer->getMemberByUid($user[0]);//$user[0] equals uid
        if (empty($userInfo)) {
            return array('status' => false, 'message' => "Users do not exist");
        }

        unset($userInfo['uid'],$userInfo['password'],$userInfo['salt']);//销毁关键信息
        return array('status' => true, 'message' => "成功", 'data' => $userInfo);
    }

    //更改用户信息
    public function alterUserInfo($uid,$data){
        $flag = IosModel::instance()->alterUserInfo($data, array('uid'=>$uid));
        if($flag){
            return array('status'=>true, 'message'=>"成功", 'data'=>'');
        }
        else{
            return array('status'=>false, 'message'=>"失败", 'data'=>'');
        }
    }

    //只从token中获取uid
    public function getUidByToken($token){


        if(empty($token)){
            return array('status'=>false,'message'=>"token不存在!");
        }

    	$encrypt = new Encrypt();
        $rs = $encrypt->decode($token);
        if (!strpos($rs, "&")) {
            $msg="不合法的token".$rs;
            return array('status' => false, 'message' => $msg);

        }
        $user = explode("&", $rs);
        return array(
        	'status' => true,
        	'message' => "成功",
        	'data' => $user[0]
        );
    }


    // 进行授权cookie加密
    public function encode($uid)
    {
        $encrypt = new Encrypt();
        $str = $uid . '&xingfu&10086';
        return $encrypt->encode($str);
    }

    public function getRandStr($num)
    {
        $code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";
        $max = strlen($code) - 1;
        for ($i = 0; $i < $num; $i++) {
            $rand = rand(0, $max);
            $str .= $code{$rand};
        }
        return $str;

    }

    /**
     * 头像上传
     */
    public function headUpload($data, $uid){
        $imageSer=new Image();
        $source= $imageSer->uploadBinaryFile($data['file'],"blog");
        $flag = IosModel::instance()->headUpload(array('face'=>$source['message']),array('uid'=>$uid));
        if($flag){
            return array('status'=>true, 'message'=>"成功", 'list'=>'');
        }
        else{
            return array('status'=>false, 'message'=>"失败", 'list'=>'');
        }
    }

    /**
     * 根据产品名搜索
     */
    public function searchByTitle($data, $name){
        $buySer=new BuyService();
        $rs = $buySer->search($data['title']);
        $title = urldecode($data['title']);
        $logSer=new LogService();
        $logSer->add($name, "搜索$title");
        $page = array('num' => 50, 'current' => 1, 'page' => 1);
        return array('status'=>true, 'message'=>$rs['message'], 'list'=>$rs['data']);
    }

    /**
     * 发送推荐产品
     */
    public function getRecommend(){
        $recommend = IosModel::instance()->getRecommend();
        $adSer = new AdvService();
        $pic = $adSer->getAdvByType(6);
        $class = IosModel::instance()->getClass();
        $rs = array(
            'recommend'=>$recommend,
            'images'=>$pic,
            'class'=>$class
        );
        return array('status' => true, 'message' => "成功", 'list' => $rs);
    }

    /**
     * 修改密码
     */
    public function changePwd($data,$uid){

        $user = self::getUserByToken($data['token']);
        $member = new MemberService();
        $userInfo = $member->getMemberByMobile($user['data']['mobile_phone']);
        if (empty($userInfo)) {
            return array('status' => false, 'message' => "用户不存在!");
        }
        // 判断密码是否正确
        if ($userInfo['password'] != md5(md5($data['pwdold']) . $userInfo['salt'])) {
            return array(
                'status' => false,
                'message' => "原密码不正确"
            );
        }
        else if (strlen($data['pwdnew']) < 5) {
            return array(
                'status' => false,
                'message' => "密码至少为5位数"
            );
        }
         else if (self::filter($data['pwdnew'])) {
            return array(
                'status' => false,
                'message' => "密码中包含了标点符号"
            );
        }
        else{
            $pwd = md5(md5($data['pwdnew']) . $userInfo['salt']);
            $flag = IosModel::instance()->changePwd(array('password'=>$pwd),array('uid'=>$uid));
            if($flag){
                return array('status'=>true, 'message'=>"成功", 'list'=>'');
            }
            else{
                return array('status'=>false, 'message'=>"失败", 'list'=>'');
            }
        }

    }

    /**
     * 收货地址列表
     */
    public function addressList($uid){
        $rs = IosModel::instance()->addressList($uid);
        return array('status'=>true, 'message'=>"成功", 'list'=>$rs);
    }

    //查找收货地址
    public function getAddressById($id){
        return IosModel::instance()->getAddressById($id);
    }

    /**
     * 添加收货地址
     */
    public function addAddress($uid,$user,$address){
        $params = array(
            'uid'=>$uid,
            'address'=>$address,
            'contact'=>$user['data']['real_name'],
            'tel'=>$user['data']['mobile_phone']
        );
        $lastId =  IosModel::instance()->addAddress($params);
        if($lastId>0){
            return array('status'=>true, 'message'=>"成功", 'list'=>'');
        }
        else{
            return array('status'=>false, 'message'=>"失败", 'list'=>'');
        }
    }

    /**
     * 修改收货地址
     */
    public function alterAddress($id, $address){
        $flag = IosModel::instance()->alterAddress(array('address'=>$address), array('id'=>$id));
        if($flag){
            return array('status'=>true, 'message'=>"成功", 'list'=>'');
        }
        else{
            return array('status'=>false, 'message'=>"失败", 'list'=>'');
        }
    }

    //修改性别
    public function setSex($sex,$uid){
        if($sex=='1' || $sex=='0'){
            $flag = IosModel::instance()->setSex(array('sex'=>$sex),array('uid'=>$uid));
        }
        else{
            return array('status'=>false, 'message'=>"'sex'值有误", 'list'=>'');
        }
        if($flag){
            return array('status'=>true, 'message'=>"成功", 'list'=>'');
        }
        else{
            return array('status'=>false, 'message'=>"失败", 'list'=>'');
        }
    }

    //确认收货
    public function confirmReceive($orderno){
        $orderSer = new OrderService();
        $order = $orderSer->getOrderByOrderno($orderno);
        if(!empty($order)){
            $flag = IosModel::instance()->confirmReceive(array('status'=>11), array('orderno'=>$orderno));
            if($flag){
                return array('status'=>true, 'message'=>"成功", 'list'=>'');
            }
            else{
                return array('status'=>false, 'message'=>"失败", 'list'=>'');
            }
        }else{
            return array('status'=>false, 'message'=>'未找到订单');
        }
    }

    //注册时手机获得验证短信
    public function setCheckMsg($phone){
        //发送短信到用户
        $num = self::getRandCode();
        $info = array(
            'mobile_phone'=>$phone,
            'message'=>$num
        );
        $sms = new SmsService();
        $rs = $sms->add($info,"#code#","1479183");
        if($rs['code']==22){
            return array('status'=>false, 'message'=>$rs['msg'], 'data'=>'');
        }
        //信息存入数据库
        $params = array(
            'phone'=>$phone,
            'add_time'=>time(),
            'num'=>$num
        );
        $lastId =  IosModel::instance()->addCheckMsg($params);
        if($lastId>0 && $rs['code'] == 0){
            return array('status'=>true, 'message'=>"成功", 'data'=>'');
        }
        else{
            return array('status'=>false, 'message'=>$rs['msg'], 'data'=>'');
        }
    }

    /**
     * 验证短信是否正确
     */
    public function isCheckMsg($data){
        $rs = IosModel::instance()->getCheckMsgByPhone($data['phone']);
        if($data['msg'] == $rs[0]['num']){
            return array('status'=>true, 'message'=>"正确", 'data'=>'');
        }else{
            return array('status'=>false, 'message'=>"错误", 'data'=>'');
        }
    }

    /**
     * @param $data
     * 充值
     */
    public function recharge($data){

        require_once 'wxpay/lib/WxPay.Api.php';
//初始化日志
//        require_once 'wxpay/example/log.php';
//        $logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
//        $log = Log::Init($logHandler, 15);

        $transaction_id = $data['orderno'];

        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $rs = WxPayApi::orderQuery($input);
//        echo json_encode($rs);
        if($rs['return_code'] == "SUCCESS" && $rs['result_code'] == "SUCCESS"){
            if($rs['trade_state']=="SUCCESS"){
                $uid = $data['uid'];
                $coupons = $rs['total_fee'];
                $remark = "APP充值";

                $memberSer = new MemberService();
                $couponSer = new CouponsService();
                $id=$memberSer->saveCoupons($uid, $coupons, 0);
                if ($id>0){
                    $sno=$couponSer->getSNO("CZ");
                    $order=array('sno'=>$sno,'coupons'=>$coupons,'remark'=>$remark,'status'=>8,'chargetypes'=>2);
                    $couponSer->addCoupons($uid, $order);
                    return array('status'=>true,'message'=>"充值成功!");
                }else{
                    return array('status'=>false,'message'=>"充值失败！");
                }
            }else{
                return array(
                    'status'=>false,
                    'message'=>"订单状态为".$rs['trade_state']
                );
            }
        }else{
            return array(
                'status'=>false,
                'message'=>$rs['err_code_des']
            );
        }
    }

    //获得6位验证码
    private function getRandCode(){
        $str='23567890';
        $code="";
        for($i=0;$i<6;$i++){
            $rand=rand(0,strlen($str)-1);
            $code.=$str{$rand};
        }
        return $code;
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

}