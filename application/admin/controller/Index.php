<?php
namespace app\admin\controller;
use app\common\controller\Admin;
/**
 * Description of Index
 *
 * @author zfeng
 */
class Index extends Admin{
    
    protected function _initialize() {
        parent::_initialize();
    }


    public function index(){
        return $this->fetch('base/main');
    }
    
    public function info(){
        return $this->fetch();
    }
}
