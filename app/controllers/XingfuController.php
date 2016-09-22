<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 15/12/22
 * Time: 下午2:03
 */
class XingfuController extends  Action{


    /**
     * 对单个用户进行编辑
     */
    public function add ()
    {
        $this->view()->display('file:xingfu/add.tpl');
    }
}