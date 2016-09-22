<?php

class FaceService
{

    const SUCCESS = 'success';

    const ERROR = 'error';
    // 0审核中 1不通过
    private $_isvalid = false; // 开启审核
                               // 存储头像的路径
    private $_savefacePath = "/static/attached/face/";

    private $_status = array(
        0 => "等待审核",
        1 => "通过",
        - 1 => "不通过"
    );

    public function __construct ()
    {
        $sys = new SysService();
        $config = $sys->getConfig();
        $this->_isvalid = $config['face'];
    }

    /**
     * 新增加头像队列
     * 
     * @param int $uid            
     * @param String $face            
     * @param String $username            
     */
    public function add ($uid, $face, $username)
    {
        if ($this->checkUser($uid)) {
            $rs = $this->addUser($face, $uid, $username);
        } else {
            $rs = $this->saveUser($face, $uid, $username);
        }
        
        return $rs;
    }

    private function saveUser ($face, $uid, $username)
    {
        return FaceModel::instance()->saveFaceByUid(array(
            'face' => $face,
            'username' => $username,
            'status' => 0
        ), $uid);
    }

    private function addUser ($face, $uid, $username)
    {
        return FaceModel::instance()->addFaceList(array(
            'face' => $face,
            'uid' => $uid,
            'username' => $username,
            'status' => 0
        ));
    }

    /**
     * 检查申请队列是否已经存在
     * 
     * @param int $uid            
     * @return true 不存在 false 存在
     */
    private function checkUser ($uid)
    {
        $user = FaceModel::instance()->getFaceByUid($uid);
        // 删除了原有的图片
        unlink(ROOT . $user['face']);
        return empty($user) ? true : false;
    }

    /**
     * 验证头像
     * 
     * @param int $id            
     * @param String $type            
     */
    public function validFace ($id, $type)
    {
        $face = FaceModel::instance()->getFaceById($id);
        
        if ($type == 'pass') {
            // 删除申请
            FaceModel::instance()->saveFaceByid(array(
                'status' => 1
            ), $id);
            // 删除申请记录 确保下次不被覆盖掉
            $this->delFaceById($id);
        } else {
            FaceModel::instance()->saveFaceByid(array(
                'status' => - 1
            ), $id);
        }
        return $face;
    }

    public function delFaceById ($id)
    {
        return FaceModel::instance()->delFaceById($id);
    }

    /**
     * 获取所有提交的头像审核
     */
    public function getVaildFaceList ()
    {
        return FaceModel::instance()->getFaceList();
    }

    /**
     * 上传头像
     */
    public function upload ($user)
    {
        $uid = $user['uid'];
        $image = new Image();
        $face = $image->upload($_FILES['upload_file'], "face", false);
        // 自动缩小
        $face = $face['message'];
        $sface = $image->reduceImage($face, 360, 360, "face");
        
        // 删除原图
        @unlink(getcwd() . $face);
        
        // 增加队列
        $rs = $this->add($uid, $sface, $user['real_name']);
        if ($rs < 1) {
            return "上传失败";
        }
        // 是否开启审核功能
        if ($this->_isvalid) {
            return "上传成功，人工审核后生效";
        }
        
        // print_r ( $valid );
        // 直接通过审核
        $rs = $this->setMemberFace($uid);
        if ($rs < 1) {
            return '上传失败';
        }
        return '上传成功';
    }

    public function setMemberFace ($uid)
    {
        $member = new MemberService();
        $valid = $this->getFaceByUid($uid);
        return $member->saveMemberByUid(array(
            'face' => $valid['face']
        ), $uid);
    }

    private function getFaceByUid ($uid)
    {
        return FaceModel::instance()->getFaceByUid($uid);
    }

    private function meitu ()
    {
        $post_input = 'php://input';
        $save_path = dirname(__FILE__);
        $postdata = file_get_contents($post_input);
        
        if (isset($postdata) && strlen($postdata) > 0) {
            $filename = $save_path . '/' . uniqid() . '.jpg';
            $handle = fopen($filename, 'w+');
            fwrite($handle, $postdata);
            fclose($handle);
            if (is_file($filename)) {
                echo 'Image data save successed,file:' . $filename;
                exit();
            } else {
                die('Image upload error!');
            }
        } else {
            die('Image data not detected!');
        }
    }
}