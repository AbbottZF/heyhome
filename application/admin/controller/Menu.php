<?php

namespace app\admin\controller;
use app\common\controller\Admin;
use app\common\model\AuthRule;
/**
 * Description of Menu
 *
 * @author zfeng
 */
class Menu extends Admin{
    
    protected $auth_rule_model;
    
    protected function _initialize(){
        parent::_initialize();
        $this->auth_rule_model = new AuthRule();
    }
    
    public function index($page = 1){
        $where = [];
        return $this->auth_rule_model->getPage($where, $page);
    }
}
