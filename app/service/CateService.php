<?php

class CateService
{

    const SUCCESS = 'success';

    const ERROR = 'error';

    /**
     * ztree专用接口
     * 
     * @param unknown_type $type            
     * @param unknown_type $ids            
     * @param unknown_type $rootid            
     * @return JSON
     */
    public function cleanSonId ()
    {
        CategoryModel::instance()->setSonIdNull();
    }

    public function ztree ($id = null)
    {
        $fid = $id == null ? 0 : $id;
        
        if ($fid == 0) {
            $rs = CategoryModel::instance()->getCateByWhere(null);
        } else {
            $rs = CategoryModel::instance()->getCategoryByFid($fid);
        }
        foreach ($rs as $k => $v) {
            
            $fcate = CategoryModel::instance()->getCategoryByFid($v['id']);
            if (! empty($fcate)) {
                $rs[$k]['isParent'] = true;
            } else {
                $rs[$k]['isParent'] = false;
            }
            $rs[$k]['drag'] = true;
            $rs[$k]['open'] = $v['id'] == 1 ? true : false;
            $rs[$k]['name'] = $v['name'] . $v['id'];
        }
        return json_encode($rs);
    }

    public function move ($id, $fid)
    {
        TreeModel::instance()->moveCatagory($id, $fid);
        return self::SUCCESS;
    }

    public function rename ($id, $name)
    {
        CategoryModel::instance()->renameCategory(array(
                'name' => $name
        ), array(
                'id' => $id
        ));
        return self::SUCCESS;
    }

    public function remove ($id)
    {
        $rs = CategoryModel::instance()->getCategoryByFid($id);
        if (! empty($rs)) {
            return "还有子类无法删除";
        }
        
        TreeModel::instance()->deleteSort($id);
        return self::SUCCESS;
    }

    public function add ($fid, $name, $mid)
    {
        $param = array(
                'fid' => $fid,
                'name' => $name,
                'module' => $mid
        );
        $lastid = TreeModel::instance()->addsort($fid, $name, $mid);
        return $lastid < 1 ? self::ERROR : $lastid;
    }
    // 返回值有问题
    public function authorize ($id, $groupid, $type)
    {
        if ($type == "jicheng") {
            $category = CategoryModel::instance()->getCateogryById($id);
            $sonCate = $this->getSonCate($id);
            
            foreach ($sonCate as $v) {
                CategoryModel::instance()->save(array(
                        'groupid' => $groupid
                ), array(
                        'id' => $v['id']
                ));
            }
        }
        
        CategoryModel::instance()->save(array(
                'groupid' => $groupid
        ), array(
                'id' => $id
        ));
        
        return self::SUCCESS;
    }

    /**
     * 递归扫描上级分类
     * 用来生成静态页面 参见factory/vhtml
     * 
     * @param int $categoryId            
     * @param String $type            
     * @return
     *
     *
     */
    protected function getTemp ($categoryId, $type)
    {
        $rs = CategoryModel::instance()->getCateogryById($categoryId);
        if (empty($rs)) {
            return self::ERROR;
        }
        
        if ($rs[$type] == "NULL" || empty($rs[$type]) == true ||
                 $rs[$type] == "null") {
            $rs = $this->getTemp($rs['fid'], $type);
        } else {
            return $rs;
        }
        return $rs;
    }

    /**
     * 分类id
     * 已经作废
     *
     * @return array
     */
    public function loadTemp ($categoryId, $type = "temp_list")
    {
        // 先检查是否自身绑定
        return $this->getTemp($categoryId, $type);
    }

    /**
     * 根据内容的分类 绑定所需模板
     */
    public function setConTemp ($news, $temp)
    {
        
        // 设置绑定模板
        if (! empty($news['template'])) {
            $tempName = "mysql:" . $news['template'];
            return array(
                    'content' => $news,
                    'tempname' => $tempName
            );
            ;
        }
        
        // 如果循环模板不存在 则提示错误
        $cateInfo = $this->loadTemp($news['cid'], 'temp_content');
        if (is_string($cateInfo)) {
            return $cateInfo;
        }
        
        // 如果链接自带模板 覆盖上方
        if ($temp != NULL) {
            $cateInfo['temp_content'] = $temp;
        }
        // 如果是专题模板 就调用绑定内容的模板页
        
        $tempName = "mysql:" . $cateInfo['temp_content'];
        
        return array(
                'content' => $news,
                'tempname' => $tempName
        );
    }

    /**
     * 获取分类
     * 
     * @param int $cid            
     */
    public function getCateById ($id)
    {
        return CategoryModel::instance()->getCateogryById($id);
    }

    /**
     * 获取模型模板和缓存id
     */
    public function getCateTemp ($cid, $p, $tempType)
    {
        /* 对首页进行缓存 */
        $cateInfo = $this->getTemp($cid, $tempType);
        $tempName = "mysql:" . $cateInfo[$tempType];
        // 如果p不存在则默认为1;
        $cate = CategoryModel::instance()->getCateogryById($cid); // 调用父id
        $cacheid = $p > 1 ? $cid . 'p' . $p : $cid;
        return array(
                'cate' => $cate,
                'tempname' => $tempName,
                'cacheid' => $cacheid
        );
    }

    /**
     * 绑定分类模板
     * 
     * @param unknown_type $type            
     * @param unknown_type $name            
     * @param unknown_type $cid            
     */
    public function bindCateTemp ($type, $name, $cid)
    {
        CategoryModel::instance()->save(array(
                $type => trim($name)
        ), array(
                'id' => $cid
        ));
        return self::SUCCESS;
    }
    // 处理分类扩展字段
    public function getCateField ($cid)
    {
        $extend = ExtendModel::instance()->getExtend(
                array(
                        'module' => 'news'
                ));
        $cateInfo = CategoryModel::instance()->getCateExtendByCid($cid);
        
        $selected = array();
        foreach ($cateInfo as $v) {
            array_push($selected, $v['eid']);
        }
        foreach ($extend as $k => $v) {
            if (in_array($v['eid'], $selected)) {
                $extend[$k]['checked'] = 'checked';
            }
        }
        return $extend;
    }

    public function category ($categoryid)
    {
        return CategoryModel::instance()->getcatagory($categoryid);
    }

    /**
     * 绑定字段
     * 
     * @param int $cid            
     * @param Array $eidArr            
     */
    public function bindField ($cid, $eidArr)
    {
        if ($cid < 1) {
            return '你提交的分类不正确';
        }
        // 删除原有的
        CategoryModel::instance()->delCateExtend($cid);
        
        // 如果没有的情况下
        if (empty($eidArr)) {
            return "没有绑定任何东西";
        }
        
        foreach ($eidArr as $v) {
            CategoryModel::instance()->addCateExtend(
                    array(
                            'cid' => $cid,
                            'eid' => $v
                    ));
        }
        
        return self::SUCCESS;
    }

    /**
     * 没有实现递归
     * 
     * @param int $id            
     * @return String
     */
    public function getSonCate ($id)
    {
        $son = CategoryModel::instance()->getCategoryByFid($id);
        if (empty($son)) {
            return $id;
        }
        
        foreach ($son as $v) {
            $sids .= $v['id'] . ",";
        }
        return $sids . $id;
    }

    /**
     * 获取模块分类
     * 
     * @param unknown_type $selectId
     *            当前选中的
     * @param unknown_type $where            
     */
    public function getCategory ($selectId, $where)
    {
        $result = CategoryModel::instance()->getCateByWhere($where);
        
        foreach ($result as $r) {
            
            if ($r['id'] == $selectId) {
                $options = $options . "<option value=\"" . $r[id] .
                         "\" selected>" . $r[name] . "</option>";
            } else {
                $options = $options . "<option value=\"" . $r[id] . "\">" .
                         $r[name] . "</option>";
            }
        }
        return "<select name=cid id=cate >" . $options . "</select>";
    }
}