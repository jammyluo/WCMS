<?php

/**
 * 缓存
 * @author ldm
 *
 */
class CacheService
{

    private $_dir = 'cache';

    public function __construct ()
    {
        $this->_dir = ROOT . "cache" . DIRECTORY_SEPARATOR . $this->_dir .
                 DIRECTORY_SEPARATOR;
    }

    public function setCache ($con, $mark)
    {
        $mark = md5($mark);
        $file = $this->_dir . $mark;
        $handle = fopen($file, "w+") or die("创建缓存失败");
        fwrite($handle, $con);
        fclose($handle);
    }

    /**
     * 清理缓存
     *
     * @return boolean
     */
    public function cleanCache ()
    {
        $files = scandir($this->_dir);
        foreach ($files as $v) {
            if ($v == '.' || $v == '..') {
                continue;
            } else {
                @unlink($this->_dir . $v);
            }
        }
        return true;
    }

    public function isCache ($mark)
    {
        $mark = md5($mark);
        $filename = $this->_dir . $mark;
        return file_exists($filename);
    }

    public function getCache ($mark)
    {
        $mark = md5($mark);
        $filename = $this->_dir . $mark;
        return file_get_contents($filename);
    }
}
?>