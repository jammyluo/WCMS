<?php 
class MemberCenterModule{
    
    
    private $_syncUrl="http://localhost";
    
    private $_sync=0;//是否打开
    
    
    
   public function getUserByCookie($cookie){
       if ($this->_sync!=1){
           $member=new MemberService();
           return $member->getMemberByUsername($cookie);
       }else{   
          return   $this->getUserInfo($_COOKIE['token']);

       }
       
   }
   
   public function saveCoupons ($coupons, $order)
   {
       $rs=$this->checkToken();
       if (!$rs['status']){
           return $rs;
       }
       $data=array('token'=>$_COOKIE['token'],'coupons'=>$coupons,'order'=>array('name'=>$order['name'],'sno'=>$order['sno']));
       return  $this->reduceCoupons($data);
    
   }
   
   private function checkToken(){
       if (empty($_COOKIE['token'])){
        return array('status'=>false,'message'=>"token is not exsit!");   
       }else{
           return array('status'=>true);
       }
   }

   
   private function reduceCoupons($data){
     
       $url = $this->_syncUrl . "ios/coupons";
       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($data));
       $return = curl_exec($ch);
       curl_close($ch);
       return json_decode($return,true);
   }
 

    
    public function getUserInfo($token){
       
        if (!empty($_SESSION['userdata'])){
          return  unserialize($_SESSION['userdata']);
        }
        
        $url=$this->_syncUrl."index.php?ios/user/?token=".$token;
        $userInfo=file_get_contents($url);
        //转换头像
        $user= json_decode($userInfo,true);
        
        if (!$user['status'])  {
            echo $user['message'];
            exit();
        }
        $userInfo=$user['data'];
        $userInfo['face']=$this->_syncUrl.$userInfo['face'];
      
        $_SESSION['userdata']=serialize($userInfo);
        
        return $userInfo;
    }
    
}

?>