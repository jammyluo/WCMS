<?php
class SMSCenter{

    private $apikey;//云片接口密钥
    private $text;//默认模板信息
    private $ch;//curl句柄
    private $tpl_id;

    function __construct(){
        header("Content-Type:text/html;charset=utf-8");
        $smsConf=require_once 'smsConfig.php';
        $this->apikey = $smsConf['APIKEY'];
        $this->tpl_id = "1313825";//【顶上集成吊顶】亲，#goods# 已插上幸福的翅膀奔向您~请保持手机畅通，确认包裹完好后再签收
        //配置curl
        $this->ch = curl_init();
        /* 设置验证方式 */
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));

        /* 设置返回结果为流 */
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        /* 设置超时时间*/
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);

        /* 设置通信方式 */
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
    }
    /**
     *
     * @license 单条短信，带参数模板
     * @param String $mobile 电话
     * @param String $info 模板对应的信息
     * @param String $model 模板
     */
    public function sendMessage($mobile, $info, $model){
        $data=array(
            'tpl_id'=>$this->tpl_id,
            'tpl_value'=>urlencode($model).'='.urlencode($info),
            'apikey'=>$this->apikey,
            'mobile'=>$mobile);
        curl_setopt ($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $data= curl_exec($this->ch);
        $this->saveLog($data);
        return json_decode($data,true);
    }

    private function saveLog($log){

        $file=ROOT."log".DIRECTORY_SEPARATOR."sms.log";
        $handle=fopen($file,"a");
        $log=date("Y-m-d H:i")."####".$log."\r\n";
        fwrite($handle,$log);
        fclose($handle);
    }
    /**
     *
     * @license 群发短信，带参数模板。此处的信息和模板都是索引数组,一定要一一对应
     * @example $model=array('#code#','#company#');$info=array('1234','顶上');
     * @param string $mobile 电话/格式：A,B,C
     * @param array $info 模板对应的信息
     * @param array $model 模板
     */
    public function sendMessages($mobile, $info, $model){
        $tpl_value="";
        for($i=0;$i<count($model);$i++){
            $tpl_value=urlencode($model[$i]).'='.urlencode($info[$i]);
            if($i!=count($model)){
                $tpl_value.='&';
            }
        }
        $data = array(
            'tpl_id'=>$this->tpl_id,
            'tpl_value'=>$tpl_value,
            'apikey'=>$this->apikey,
            'mobile'=>$mobile
        );
        curl_setopt ($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/tpl_batch_send.json');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return json_decode(curl_exec($this->ch),true);
    }

    /**
     *
     * @license 更换模板
     * @param String $id
     */
    public function setTpl_id($id){
        $this->tpl_id=$id;
    }

    /**
     * @license 测试用
     * @return array
     */
    public function get_user(){
        curl_setopt ($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $this->apikey)));
        return json_decode(curl_exec($this->ch),true);
    }

    /**
     *
     * @license 单条短信，固定模板
     * @param string $mobile
     */
    public function send($mobile){
        $data=array('text'=>$this->text,'apikey'=>$this->apikey,'mobile'=>$mobile);
        curl_setopt ($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $json_data = curl_exec($this->ch);
        $array = json_decode($json_data,true);
        return $array;
    }

    /**
     *
     * @license 批量短信，固定模板
     * @param string $mobile
     */
    public function sendMulti($mobile){
        $data=array('text'=>$this->text,'apikey'=>$this->apikey,'mobile'=>$mobile);
        curl_setopt($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/batch_send.json');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $json_data = curl_exec($this->ch);
        $array = json_decode($json_data,true);
        return $array;
    }

    function __destruct(){
        curl_close($this->ch);
    }

}