<?php

/**
 * 继承了最基本的News服务 然后进行扩展
 * 服务类 不能涉及参数和视图操作
 * @author Administrator
 *
 */
class NewsService
{

    const SUCCESS = 'success';

    /**
     *
     * @return News
     */
    public $newsModule;

    public function __construct ($cid, $mid)
    {
        $this->newsModule = new News($cid, $mid);
    }

    /**
     * 一键获取模板
     *
     * @param String $type            
     */
    public function Temp ($type)
    {
        return $this->newsModule->temp($type);
    }

    /**
     * 返回所有标签 并且是否选中
     */
    public function getFlag ($nid = 0, $flag = 0)
    {
        $flagSer = new FlagService();
        $flags = $flagSer->getFlag(null);
        $isChecked = $flagSer->getFlagByNid($nid);
        $group = $flagSer->getFlagGroup();
        if (empty($flags)) {
            return;
        }
        foreach ($flags as $k => $v) {
            $flags[$k]['ischecked'] = false;
            if ($v['id'] == $flag) {
                $flags[$k]['ischecked'] = true;
            }
            foreach ($isChecked as $isk => $isv) {
                if ($isv['id'] == $v['id']) {
                    $flags[$k]['ischecked'] = true;
                }
            }
        }
        // 重组
        foreach ($group as $k => $v) {
            foreach ($flags as $fv) {
                if ($v['id'] == $fv['groupid']) {
                    $group[$k]['data'][] = $fv;
                }
            }
        }
        return $group;
    }

    public function getExtendByCid ($cid)
    {
        return ExtendModule::instance()->getExtendByCid($cid);
    }

    /**
     * 获取指定内容模型
     *
     * @param int $nid            
     * @return Array content=news extend=extend
     */
    public function getCon ($nid)
    {
        return $this->newsModule->getCon($nid);
    }

    /**
     * * 根据新闻分类ids获取数量
     */
    public function getNewsByCid ($cid)
    {
        return NewsModel::instance()->getNewsNum(
                array(
                        'cid' => $cid
                ));
    }

    /**
     * 生成静态页面
     *
     * @param            
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     */
    public function html ($news, $html)
    {
        $path = ROOT . "a" . DIRECTORY_SEPARATOR;
        if ($news['date'] == null) {
            $date = "197001";
        }else{
            $date=$news['date'];
        }
        $ym = date("Ym", $date);
        $save_path .= $path . $ym . DIRECTORY_SEPARATOR;
        if (! file_exists($save_path)) {
            if (mkdir($save_path, 0755, true) == FALSE) {
                echo "无法创建文件夹";
                exit();
            }
        }
        if (empty($news['template'])) {
            $url = '/a/' . $ym . '/' . $news['id'] . ".html";
            $file = $save_path . $news['id'] . ".html";
        } else {
            $filename = str_replace("tpl", "html", $news['template']);
            $filename = strtolower($filename);
            $url = '/a/' . $filename;
            $file = $path . $filename;
        }

          
        $handle = fopen($file, "w");
        if (!$handle) {
            echo "无法创建静态文件,请检查权限!".$url;
            exit();
        }
        
        // 图片集和专题模式下 不处理图片title
        if (! fwrite($handle, $html)) {
            echo "无法写入静态文件" . $url;
            exit();
        }
        fclose($handle);
        // 更新地址
        
        NewsModel::instance()->saveNews(
                array(
                        'html' => $url
                ), 
                array(
                        'id' => $news['id']
                ));
        
        return $url;
    }

    /**
     * 新增点击量
     * Enter description here .
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * ..
     */
    public function addViews ($id)
    {
        $rs = NewsModel::instance()->getNewsWhere(
                array(
                        'id' => $id
                ));
        $num = $rs['views'] + 1;
        NewsModel::instance()->saveNews(
                array(
                        'views' => $num
                ), 
                array(
                        'id' => $id
                ));
        return $num;
    }

    /**
     * 新闻排序
     *
     * @param int $sort            
     * @param int $id            
     */
    public function setNewsSort ($sort, $id)
    {
        return NewsModel::instance()->setNewsSort($sort, $id);
    }
    // 可见
    public function setVisable ($visable, $id)
    {
        return NewsModel::instance()->setNewsVisable($visable, $id);
    }
    // 添加新闻
    public function add ($data)
    {
        return $this->newsModule->add($data);
    }

    /**
     * 删除新闻
     *
     * @param int $ids
     *            单条新闻
     * @param int $cid            
     * @param String $type            
     */
    public function remove ($id)
    {
        $this->newsModule->remove($id);
        return self::SUCCESS;
    }

    /**
     * 获取指定列表页内容
     *
     * @param s $params
     *            参数
     */
    public function listing ($params)
    {
        return $this->newsModule->listing($params['cid'], $params['p'], $params);
    }
    // 删除分类下的所有新闻 支持文章 图集 专题 并且删除图片
    public function removeByCid ($cid)
    {
        $rs = NewsModel::instance()->getNewsIdsByCid($cid);
        if (empty($rs)) {
            return;
        }
        foreach ($rs as $v) {
            $this->remove($v['id']);
        }
    }

    /**
     * 搜索方法 2种类型 精确搜索 模糊搜索
     *
     * @param unknown_type $key            
     * @param unknown_type $value            
     */
    public function search ($key, $value)
    {
        $value = urldecode($value);
        if (preg_match("/\D+/iUs", $value)) {
            $rs = $this->getNewsByFuzzy('title', $value);
        } else {
            $rs = $this->getNewsByBase('id', $value);
        }
        if (empty($rs)) {
            return false;
        }
        // 获取id集合 增加扩展字段 搜索图集时会有问题
        foreach ($rs as $k => $v) {
            $nrs = $this->getCon($v['id']);
            $rs[$k] = $nrs['content'];
        }
        return $rs;
    }

    /**
     * 对接ckeditor
     * 注意上传文件大小限制
     *
     * @return string $filePath 图片路径
     */
    public function water ()
    {
        $path = ROOT . 'config/water.png';
        move_uploaded_file($_FILES['waterfile']['tmp_name'], $path);
        return array(
                'status' => true,
                'message' => "上传成功!"
        );
    }
    
    /**
     * 对接ckeditor
     * 注意上传文件大小限制
     *
     * @return string $filePath 图片路径
     */
    public function upload ($type)
    {
        $file = $this->newsModule->_base->thumb($_FILES['upload'], 'image');
        if ($type) {
            echo json_encode($file);
            return;
        }
        $callback = $_REQUEST["CKEditorFuncNum"];
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'" .
        $file['message'] . "','');</script>";
    }

    /**
     * 清除新闻统计结果
     */
    public function truncate ()
    {
        // 增加一个数据库整理 以提高性能
        CacheModel::instance()->clearNumCache();
        return self::SUCCESS;
    }

    /**
     * 修正图片地址
     * 和增加alt title标签 利于优化
     */
    public function parseImagePath ($content)
    {
        return str_replace("./", "../../", $content);
    }
    // 处理imagealt属性
    public function parseImageAlt ($content, $title)
    {
        $alt = "alt='" . $title . "' title='" . $title . "' ";
        return str_replace("alt", $alt, $content);
    }

    /**
     * 精确搜索
     */
    private function getNewsByBase ($key, $value)
    {
        $where = array(
                $key => $value
        );
        return ModuleModel::instance()->getModuleBase($where, 20);
    }

    /**
     * 模糊搜索
     *
     * @param unknown_type $key            
     * @param unknown_type $name            
     */
    private function getNewsByFuzzy ($key, $value)
    {
        return NewsModel::instance()->getOneNewsLikeTitle($key, $value);
    }
}