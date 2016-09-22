<?php

class MemberGroupModule implements IMember
{
    /*
     * (non-PHPdoc) @see IMember::add()
     */
    public function add ($params)
    {
        $rs = MemberModel::instance()->addMemberGroup($params);
        if ($rs > 0) {
            return array(
                'status' => true,
                'message' => "删除成功"
            );
        } else {
            return array(
                'status' => false,
                'message' => "删除失败"
            );
        }
    }
    /*
     * (non-PHPdoc) @see IMember::remove()
     */
    public function remove ($id)
    {
        $rs = MemberModel::instance()->delMemberGroup(array(
            'id' => $id
        ));
        if ($rs > 0) {
            return array(
                'status' => true,
                'message' => "删除成功"
            );
        } else {
            return array(
                'status' => false,
                'message' => "删除失败"
            );
        }
    }
    /*
     * (non-PHPdoc) @see IMember::getCon()
     */
    public function getCon ($uid)
    {
        // TODO Auto-generated method stub
    }
    /*
     * (non-PHPdoc) @see IMember::saveCon()
     */
    public function saveCon ($v, $id)
    {
        return MemberModel::instance()->updateMemberGroup(array(
            'name' => $v
        ), array(
            'id' => $id
        ));
    }
}