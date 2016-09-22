<?php
//会员归属地
class MemberAreaModule implements IMember
{
    private $_keys = array('junqu', 'response', 'man', 'uid', 'land');
    public function getMemberByGroupid ($groupid)
    {
        return MemberAreaModel::instance()->getMemberByGroupid($groupid);
    }
    /* (non-PHPdoc)
	 * @see IMember::add()
	 */
    public function add ($params)
    {
        $arr = $this->parseData($params);
        return MemberAreaModel::instance()->addUser($arr);
    }
    /* (non-PHPdoc)
	 * @see IMember::getCon()
	 */
    public function getCon ($uid)
    {
        return MemberAreaModel::instance()->getAreaByUid($uid);
    }
    //处理积分
    private function parseData ($data)
    {
        $arr = array();
        foreach ($this->_keys as $v) {
            if (isset($data[$v])) {
                $arr[$v] = $data[$v];
            }
        }
        return $arr;
    }
    public function saveConByUid ($v, $uid)
    {
        return MemberAreaModel::instance()->saveAreaByUid($v, $uid);
    }
    /* 
	 * @see IMember::remove()
	 */
    public function remove ($uid)
    {
        return MemberAreaModel::instance()->removeByUid($uid);
    }
    /* (non-PHPdoc)
	 * @see IMember::saveCon()
	 */
    public function saveCon ($v, $uid)
    {
        $arr = $this->parseData($v);
        $flag = $this->getCon($uid);
        //如果不存在 就新增
        if (! $flag) {
            $rs = $this->add($v);
        } else {
            unset($arr['uid']);
            $rs = MemberAreaModel::instance()->saveAreaByUid($arr, $uid);
        }
        return $rs;
    }
}