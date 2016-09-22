<?php
/**
 * 设置最底层接口
 * Enter description here ...
 * @author Administrator
 *
 */
abstract class Module implements IModule
{
    static $instance;
    private function __construct ()
    {}
    private function __clone ()
    {}
    /**
     * 上传缩略图
     * 注意上传文件大小限制
     *
     * @return string $filePath 图片路径
     */
    public function thumb ($files, $dir = "thumb")
    {
        $imagetrans = new Image();
        $sys = new SysService();
        $config = $sys->getConfig();
        $imagetrans->watermark_fontsize = $config['water_fontsize'];
        $imagetrans->watermark_text = $config['water_text'];
        $imagetrans->thumb_maxheight = $config['image_maxheight'];
        $imagetrans->thumb_maxwidth = $config['image_maxwidth'];
        $imagetrans->_waterPosition = $config['water_position'];
        $imagetrans->water_type = $config['water_type'];
        return $imagetrans->upload($files, $dir, $config['water']);
    }
    /**
     * 生成缩略图
     * 
     * @param unknown_type $id        	
     */
    protected function water ($imagefile, $thumbWidth, $thumbHeight)
    {
        $imagetrans = new Image();
        return $imagetrans->reduceImage($imagefile, $thumbWidth, $thumbHeight);
    }
    /**
     * 获取指定分类
     * Enter description here ...
     * @param int $id
     */
    public function getCategoryById ($id)
    {
        return CategoryModel::instance()->getCateogryById($id);
    }
	/**
	 * 递归获取子类 和本身
	 * 重写了方法
	 * @param int $id        	
	 * @return mixed Ambigous mixed>
	 */
	public function getSonCate($id = 0, $filterModule = 1) {
		$rs = TreeModel::instance ()->getCatagory ( $id );
		
		if (! $rs) {
			return $id;
		}
		foreach ( $rs as $v ) {
			
			if ($v ['module'] != $filterModule) {
				continue;
			}
			
			$newids .= $v ['id'] . ',';
		}
		//缓存
		$sonid = $newids . $id;
		CategoryModel::instance ()->save ( array ('sonid' => $sonid ), array ('id' => $id ) );
		return $sonid;
	
	}
    //获取分类缓存
    private function getSonCateCache ($id)
    {
        $rs = CategoryModel::instance()->getCateogryById($id);
        return $rs['sonid'];
    }
    //此代码可以优化性能
    private function getSon ($id)
    {
        $rs = CategoryModel::instance()->getCategoryByFid($id);
        foreach ($rs as $v) {
            $r = CategoryModel::instance()->getCategoryByFid($v['id']);
            if (empty($r)) {
                continue;
            } else {
                $rs = array_merge($rs, $this->getSon($v['id']));
            }
        }
        return $rs;
    }
    /**
     * 递归获取父类  这里没有采用左右值
     *
     * @param int $id        	
     * @return mixed Ambigous mixed>
     */
    public function getParentCate ($id)
    {
        $ids = CategoryModel::instance()->getCateogryById($id);
        $newids = '';
        $newids .= $ids['id'] . ',';
        if ($ids['fid'] < 1) {
            return $id;
        }
        $rs = $this->getParentCate($ids['fid']);
        if (strlen($rs) > 0) {
            $newids .= $rs;
        }
        return $newids . $id;
    }
    /**
     * 全角转半角
     * @param String $str        	
     */
    protected function semiangle ($str)
    {
        $arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', 
        '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9', 'Ａ' => 'A', 
        'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E', 'Ｆ' => 'F', 'Ｇ' => 'G', 
        'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J', 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 
        'Ｎ' => 'N', 'Ｏ' => 'O', 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 
        'Ｔ' => 'T', 'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y', 
        'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd', 'ｅ' => 'e', 
        'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i', 'ｊ' => 'j', 'ｋ' => 'k', 
        'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n', 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 
        'ｒ' => 'r', 'ｓ' => 's', 'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 
        'ｘ' => 'x', 'ｙ' => 'y', 'ｚ' => 'z', '（' => '(', '）' => ')', '〔' => '[', 
        '〕' => ']', '【' => '[', '】' => ']', '〖' => '[', '〗' => ']', '“' => '[', 
        '”' => ']', '‘' => '[', '’' => ']', '｛' => '{', '｝' => '}', '《' => '<', 
        '》' => '>', '％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-', 
        '：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.', '；' => ',', 
        '？' => '?', '！' => '!', '…' => '-', '‖' => '|', '”' => '"', '’' => '`', 
        '‘' => '`', '｜' => '|', '〃' => '"', '　' => ' ');
        return strtr($str, $arr);
    }
    public static function getInstance ($class)
    {
        if (self::$instance[$class] == null) {
            self::$instance[$class] = new $class();
        }
        return self::$instance[$class];
    }
}