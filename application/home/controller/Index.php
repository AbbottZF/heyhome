<?php
namespace app\home\controller;
use app\common\controller\Home;
use app\common\model\WebConfig;

/**
 * Description of Index
 *
 * @author LIANG
 */
class Index extends Home{
    
    protected $config_model;
    
    protected function _initialize() {
        parent::_initialize();
        $this->config_model = new WebConfig();
    }
    
    public function index(){
        $info = $this->config_model->getInfo();
        return $this->fetch('test',['info'=>$info]);
    }
}
