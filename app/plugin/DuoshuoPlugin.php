<?php
class DuoshuoPlugin extends BasePlugin{
    
    
    
    public function run(){
        $sys=new SysService();
        $config=$sys->getConfig();
        $this->view()->assign('config',$config);
    }
}