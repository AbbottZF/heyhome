<?php

namespace app\admin\controller;
use app\common\controller\Admin;
use app\common\model\WebConfig as WC;
/**
 * Description of WebConfig
 *
 * @author LIANG
 */
class WebConfig extends Admin{
    
    protected $config_model;

    protected function _initialize() {
        parent::_initialize();
        $this->config_model = new WC();
    }
    
    public function index(){
        return $this->fetch('');
    }
    
    public function config(){
        if($this->request->post()){
            $data = $this->request->param();
            $info = $this->config_model->getInfo();
            if(empty($info)){
                $res = $this->config_model->insetInfo($data);
            } else {
                $res = $this->config_model->updateInfo($data,['id'=>$info['id']]);
            }
            if($res === FALSE){
                return ajax_error('设置失败！');
            }
            return ajax_success('设置成功！');
        }
    }
}
