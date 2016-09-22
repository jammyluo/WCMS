<?php

/**
 * 此模型不包含任何数据库操作 这里为后端
 * 赋值和视图处理
 * 对于扩展字段来说 这里只有1 新闻扩展字段
 * @author Wolf
 *
 */
class FactoryController extends NodeController
{

    static $newsService;

    static $cateService;

    private $_num = 40; // 后台新闻条数
    /**
     * 清除所有缓存 增加编译缓存 高性能
     */
    public function cleanCache ()
    {
        $cache=new CacheService();
        $cache->cleanCache();
        // 清楚统计数据缓存
        self::getNewsService()->truncate();
        self::getLogService()->delMoreLog();
        // 清除smarty 缓存
        $t = $this->view()->clearAllCache();
        $c = $this->view()->clearCompiledTemplate();
        $notice = '清除了' . $t . ' 静态缓存 ' . $c . ' 编译缓存';
        $this->sendNotice($notice);
    }

    /**
     * 排序
     */
    public function s ()
    {
        if (isset($_POST['sort']) && $_POST['sort'] >= 0) {
            $sort = trim($_POST['sort']);
            self::getNewsService()->setNewsSort($sort, $_POST['id']);
            echo 'SUCCESS!';
            // 清除缓存
            exit();
        } else {
            echo 'Failed!';
            exit();
        }
    }

    public function c ()
    {
        // 执行代码
        $cid = $_GET['cid'];
        $p = isset($_GET['p']) ? $_GET['p'] : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        $num = isset($_GET['num']) ? $_GET['num'] : $this->_num;

		
		$memberCenter=new MemberCenterModule();
        $user=$memberCenter->getUserByCookie($_COOKIE[self::COOKIENAME]);

		if ($user ['manager'] >= 2) {
			$username = $user ['username'];
		}
			
        $params = array(
                'cid' => $cid,
                'sort' => $sort,
                'p' => $p,
                'num' => $num,
                "username" => $username
        );
        
        // 没有指定MID
        $rs = self::getNewsService()->newsModule->listing($cid, $p, $params);
        $cate = self::getCateService()->getCategory($cid, 
                array(
                        'module' => $_GET['mid']
                )); // 调用父id         
        $this->view()->assign('category', $cate);
        $this->view()->assign('currentcid', $cid); // 当前cid
        $this->view()->assign('news', $rs['newslist']);
        $this->view()->assign('totalnum', $rs['totalnum']);
        $this->view()->assign('num', $rs['page']);
        $this->view()->assign('module', $rs['module']);
        $this->view()->display('file:news/list.tpl');
    }

    public function iframe ()
    {
        $sys = new SysService();
        $nodes = $sys->getNodesByFid(0);
        $this->view()->assign('nodes', $nodes);
        $this->view()->display('file:news/iframe.tpl');
    }

    /**
     * 搜索页面
     */
    public function search ()
    {
        $cid = $_GET['cid'];
        /* 增加扩展字段 也就是分类搜索 */
        if (! isset($_REQUEST['key']) || ! isset($_REQUEST['value'])) {
            return;
        }
        $newslist = self::getNewsService()->search($_REQUEST['key'], 
                $_REQUEST['value']);
        $cate = self::getCateService()->getCategory($cid, NULL);
        if ($_REQUEST['datatype'] == 'json') {
            $rs = empty($newslist) ? self::ERROR : self::SUCEESS;
            $this->sendNotice($rs, $newslist, true);
        }
        $this->view()->assign('category', $cate);
        $this->view()->assign('news', $newslist);
        $this->view()->assign('currentcid', 1);
        $this->view()->assign('totalnum', count($newslist));
        $this->view()->assign('num', 
                array(
                        'current' => 1,
                        'page' => 1
                ));
        $this->view()->assign('module', 1);
        $this->view()->display('file:news/list.tpl');
    }

    public function goods ()
    {
        $value = urldecode(trim($_GET['value']));
        if (! is_numeric($value)) {
            $rs = GoodsModule::instance()->search($value, "name");
        } else {
            $rs = GoodsModule::instance()->search($value, "sku");
        }
        $this->view()->assign('value', $value);
        $cate = self::getCateService()->getCategory(null, 
                array(
                        'module' => 5
                ));
        $this->view()->assign('category', $cate);
        $this->view()->assign('news', $rs);
        $this->view()->assign('currentcid', 1);
        $this->view()->assign('totalnum', count($rs));
        $this->view()->assign('num', 
                array(
                        'current' => 1,
                        'page' => 1
                ));
        $this->view()->assign('module', 5);
        $this->view()->display('file:news/list.tpl');
    }
    /* 添加内容 */
    public function data ()
    {
        $categoryid = isset($_GET['cid']) ? $_GET['cid'] : 1;
        $mid = $_GET['mid'];
        // 导入扩展字段
        /**
         * 增加flag标记
         */
        $flag = self::getNewsService()->getFlag(0); // 返回所有标签
        $this->view()->assign('flag', $flag); // 导入标签
        $extend = self::getNewsService()->getExtendByCid($categoryid);
        if (! empty($_SESSION['width'])) {
            $this->view()->assign('height', $_SESSION['height']);
            $this->view()->assign('width', $_SESSION['width']);
        }
        $category = self::getCateService()->getCategory($categoryid, 
                array(
                        'module' => $mid
                ));
        // 防止重复刷新
        $_SESSION['repeat'] = time();
        $this->view()->assign('repeat', $_SESSION['repeat']);
        $this->view()->assign('category', $category);
        $this->view()->assign('group', $this->_group);
        $this->view()->assign('module', $mid);
        $this->view()->assign('extend', $extend);
        $temp = self::getNewsService()->newsModule->_m->temp("add");
        $this->view()->display($temp);
    }
    // 添加内容时调用扩展字段ajax 支持递归父类
    public function extend ()
    {
        $rs = ExtendModule::instance()->getExtendByCid($_POST['cid']);
        $this->sendNotice(self::SUCEESS, $rs);
    }

    /**
     * 删除整篇新闻
     */
    public function remove ()
    {
        $rs = self::getNewsService()->remove($_POST['id']);
        $this->sendNotice($rs, null, true);
    }
    // 模型添加信息
    public function add ()
    {
        if ($_SESSION['repeat'] == $_POST['repeat']) {
            unset($_POST['repeat']);
            $lastInsertId = self::getNewsService()->add($_POST);
        } else {
            $lastInsertId = "重复提交了";
        }
        // 日志记录
        self::getLogService()->add($this->_user_global['username'], 
                "新增文章$lastInsertId");
        // 生成静态文件 暂时没有考虑权限问题
        if (is_numeric($lastInsertId)) {
            $message = $this->vHtml($lastInsertId);
        } else {
            $message = $lastInsertId;
        }
        $news = self::getNewsService()->getCon($lastInsertId);
        $this->wait($news['content'], $message);
    }

    /**
     * 删除内容 不是删除整篇
     * Enter description here .
     *
     *
     *
     * ..
     */
    public function delCon ()
    {
        $rs = self::getNewsService()->newsModule->_m->remove(
                array(
                        'id' => $_REQUEST['id']
                ));
        self::getLogService()->add($this->_user_global['username'], 
                "删除图集图片$_REQUEST[id]");
        if ($rs > 0) {
            $this->sendNotice(self::SUCEESS);
        } else {
            $this->sendNotice(self::ERROR);
        }
    }

    /**
     * 根据内容的分类 绑定所需模板
     */
    public function vHtml ($id)
    {
        $news = self::getNewsService()->getCon($id);
        // 如果链接自带模板 覆盖上方
        $rs = self::getCateService()->setConTemp($news['content'], null);
        
        if ($rs == "error") {
            return "提交成功,但无法生成静态页面，请检查分类是否绑定模板 !";
        }
        $this->view()->assign('content', $rs['content']);

        // 导入插件 设置超全局变量
        $_GET['id'] = $id;
        $_GET['cid'] = $news['content']['cid'];
        self::getPluginService('content')->run();


        // 检查模板编译 报错为捕获
        $content = $this->view()->fetch($rs['tempname']);
        $content = self::getNewsService()->parseImagePath($content);
        // 解析content
        if ($news['content']['mid'] < 2) {
            $content = self::getNewsService()->parseImageAlt($content, 
                    $news['content']['title']);
        }


        self::getNewsService()->html($news['content'], $content);
        return "提交成功";
    }

    /**
     * 编辑页面
     */
    public function v ()
    {
        $nid = $_GET['id'];
        $mid = $_GET['mid'];
        if (! empty($_SESSION['width'])) {
            $this->view()->assign('height', $_SESSION['height']);
            $this->view()->assign('width', $_SESSION['width']);
        }
        $news = self::getNewsService()->getCon($nid); // 一键获取内容
        
        if (! empty($news['content']['summary'])) {
            $news['content']['summary'] = str_replace("<br>", "", 
                    $news['content']['summary']);
        }
        
        // 结合自身的
        $flag = self::getNewsService()->getFlag($nid);
        $temp = self::getNewsService()->temp("edit");
        $this->view()->assign('flag', $flag);
        $category = self::getCateService()->getCategory($news['content']['cid'], 
                array(
                        'module' => $news['content']['mid']
                ));
        $this->view()->assign('category', $category);
        $this->view()->assign('group', $this->_group);
        // 为了兼容之间新闻 可能没有进行过滤 2013-08-20
        $this->view()->assign('extend', $news['extend']);
        $this->view()->assign('news', $news['content']);
        $this->view()->assign('module', $mid);
        $this->view()->display($temp);
    }
    // 模型保存数据
    public function save ()
    {
        $_POST['nid'] = $_POST['id']; // 转换
                                      // 处理标签
        $preid = isset($_POST['preid']) ? $_POST['preid'] : 1;
        $p = isset($_POST['p']) ? $_POST['p'] : 1;
        $id = $_POST['id'];
        // 一键保存
        $mid = self::getNewsService()->newsModule->save($_POST, $id);
        // 操作记录
        self::getLogService()->add($this->_user_global['username'], 
                "修改新闻$_POST[nid]");
        // 生成静态文件
        if (is_numeric($mid)) {
            $message = $this->vHtml($id);
        } else {
            $message = $mid;
            $mid = $_POST['mid'];
        }
        $news = self::getNewsService()->getCon($id);
    
        $this->wait($news['content'], $message);
        // 结果 返回结果
    }

    /**
     *
     *
     *
     *
     *
     * 提交之后用户等待的页面
     *
     * @param int $id            
     * @param int $cid            
     * @param int $mid            
     */
    public function wait ($news, $message)
    {
        // 防止重复提交
        $_SESSION['repeat'] = time();
        $this->view()->assign("message", $message);
        $this->view()->assign("news", $news);
        $this->view()->display("file:module/wait.tpl");
    }

    /**
     * 上传水印
     */
    public function upload ()
    {
        $rs = self::getNewsService()->water();
        $this->sendNotice($rs['message']);
    }

    /**
     * 上传图片 ckeditor
     */
    public function ckeditor ()
    {
        self::getNewsService()->upload($_POST['type']);
    }
    
    
    /**
     * 获取newsService
     */
    public static function getNewsService ()
    {
        if (self::$newsService == null) {
            self::$newsService = new NewsService($_REQUEST['cid'], 
                    $_REQUEST['mid']);
        }
        return self::$newsService;
    }

    public static function getCateService ()
    {
        if (self::$cateService == null) {
            self::$cateService = new CateService();
        }
        return self::$cateService;
    }
}