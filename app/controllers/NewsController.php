<?php

/**
 * 新闻系统  只考虑分类绑定模版 频道页 列表页 内容页 不支持在线修改  这里为前端
 *@author wolf  [Email: 116311316]
 *@since 2010-11-28
 *@version 1.0
 */
class NewsController extends NodeController
{

    static $newService;

    static $cateService;

    private $_htmlnum = 30;

    public function c ()
    {
        // 这里穿进去的是$_GET 参数
        // 执行代码
        $cid = $_GET['cid'];
        $p = isset($_GET['p']) ? $_GET['p'] : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
        // 停止xhprof
        $nInfo = self::getCateService()->getCateTemp($cid, $p, 'temp_list'); // 调用内容
        $num = isset($_GET['num']) ? $_GET['num'] : 0;
        $params = array(
                'cid' => $cid,
                'sort' => $sort,
                'p' => $p,
                'num' => $num,
                'flag' => $_GET['flag'],
                "username" => "jammy"
        );
        
        $mark = implode($params, "&");
        $cache = new CacheService();
        
        if ($cache->isCache($mark)) {
            echo $cache->getCache($mark);
            exit();
        }
        
        $newslist = self::getNewsService()->listing($params);
        $flags = self::getNewsService()->getFlag(0, $_GET['flag']);
        $this->view()->assign('flags', $flags);
        $this->view()->assign('flag', $_GET['flag']);
        // 导入插件
        self::getPluginService('list')->run();
        // 导入广告
        $advService = new AdvService();
        $advType=$cid==1?5:0;
        $adv = $advService->getAdvByType($advType);
        $this->view()->assign('adv', $adv);
        
        
        $rs = array_merge($nInfo, $newslist);
        $this->view()->assign('news', $rs['newslist']);
        $this->view()->assign('totalnum', $rs['totalnum']);
        $this->view()->assign('num', $rs['page']);
        $this->view()->assign('module', $rs['module']);
        $this->view()->assign('category', $rs['cate']);
        $con = $this->view()->fetch($rs['tempname']);
        $cache->setCache($con, $mark);
        echo $con;
    }

    /**
     * 专题页
     * 用来替换 cid=1&type=temp_index
     */
    public function i ()
    {
        $cid = $_GET['cid'];
        $nInfo = self::getCateService()->getCateTemp($cid, null, 'temp_index'); // 调用内容
        $cate = $this->view()->assign('category', $nInfo['cate']);
        $this->view()->display($nInfo['tempname']);
    }

    /**
     * 根据内容的分类 绑定所需模板
     */
    public function v ($vid = NULL)
    {
        $id = $vid != NULL ? $vid : trim($_GET['id']);
        if (empty($id)) {
            header("HTTP/1.1 404 Not Found");
            /* 内容不存在 */
        }
        // 如果链接自带模板 覆盖上方
        $temp = isset($_GET['mb']) ? $_GET['mb'] : null;
        $con = self::getNewsService()->getCon($id);
        
        $news = self::getCateService()->setConTemp($con['content'], $temp);
        // 设置绑定模板
        if (! $news) {
            header("HTTP/1.1 404 Not Found");
        }
        
        $advService = new AdvService();
        $adv = $advService->getAdvByType(2);
        $this->view()->assign('adv', $adv);
        
        
        $this->view()->assign('content', $news['content']);
        // 导入ajax评论
        if (isset($_GET['mid']) && $_GET['mid'] > 0) {
            $mid = $_GET['mid'];
            $this->view()->assign('commentid', $mid);
        }
        // 导入插件
        $_GET['id'] = $id;
        $_GET['cid'] = $news['content']['cid'];
        self::getPluginService('content')->run();
        $content = $this->view()->fetch($news['tempname']);
        $content = self::getNewsService()->parseImagePath($content);
        // 解析content
        
        if ($news['content']['mid'] < 2) {
            $content = self::getNewsService()->parseImageAlt($content, 
                    $news['content']['title']);
        }
        
        if ($vid != null) {
            return array(
                    'news' => $news['content'],
                    'html' => $content
            );
        } else {
            echo $content;
        }
    }

    /**
     * 搜索页面
     */
    public function search ()
    {
        /* 增加扩展字段 也就是分类搜索 */
        if (! isset($_REQUEST['key']) || ! isset($_REQUEST['value'])) {
            return;
        }
        $newslist = self::getNewsService()->search($_REQUEST['key'], 
                $_REQUEST['value']);
        if ($_REQUEST['datatype'] == 'json') {
            $this->sendNotice("success", $newslist, true);
        }
        $this->view()->assign('news', $newslist);
        $this->view()->display("mysql:$_REQUEST[template]");
    }

    /**
     * 前端更新评论数接口
     */
    public function views ()
    {
        if (! isset($_GET['id']))
            return;
        $rs = self::getNewsService()->addViews(trim($_GET['id']));
        $this->sendNotice(self::SUCEESS, $rs, true);
    }
    /* 批量处理html */
    public function batch ()
    {
        set_time_limit(0);
        $ids = $_POST['id'];
        // 获取所有分类
        // 批量生成内容
        $start = ($_POST['p'] - 1) * $this->_htmlnum;
        $rs = NewsModel::instance()->getNewsIdByIds($ids, $start, 
                $this->_htmlnum);
        foreach ($rs as $k => $v) {
            $content = $this->v($v['id']);
            self::getNewsService()->html($content['news'], $content['html']);
            $content = null;
        }
        $rs = array(
                'status' => true
        );
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }
    // 获取文章ids
    public function cids ()
    {
        $cid = $_REQUEST['cid'];
        $cate = self::getCateService()->getCateById($cid);
        $ids = BaseModule::instance()->getSonCate($cid, $cate['module']);
        $total = NewsModel::instance()->getNewsNum(
                array(
                        'cid' => $ids
                ));
        $pagenum = ceil($total / $this->_htmlnum);
        $pagenum = $pagenum == 0 ? 1 : $pagenum;
        if (! empty($ids)) {
            $rs = array(
                    'status' => true,
                    'data' => array(
                            'cids' => $ids,
                            'pagenum' => $pagenum
                    ),
                    'message' => "ok"
            );
        } else {
            $rs = array(
                    'status' => false,
                    'message' => "没有内容!"
            );
        }
        $this->sendNotice($rs['message'], $rs['data'], $rs['status']);
    }

    /**
     * 静态生成首页
     */
    public function htmlindex ()
    {
        ob_start();
        $_GET['cid'] = 1;
        $this->c();
        $content = ob_get_contents();
        ob_end_clean();
        $file = 'index.html';
        file_put_contents(ROOT . $file, $content);
        echo "已经生成!";
        exit();
    }

    public static function getCateService ()
    {
        if (self::$cateService == null) {
            self::$cateService = new CateService();
        }
        return self::$cateService;
    }

    /**
     * 获取news服务类
     */
    public static function getNewsService ()
    {
        if (self::$newService == null) {
            self::$newService = new NewsService($_REQUEST['cid'], 
                    $_REQUEST['mid']);
        }
        return self::$newService;
    }
}