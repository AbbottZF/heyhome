<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\controller;
use app\common\controller\Admin;
use app\common\model\Room as R;
/**
 * Description of Home
 *
 * @author zfeng
 */
class Room extends Admin{
    //put your code here
    protected $room_model;
    
    protected function _initialize() {
        parent::_initialize();
        $this->room_model = new R();
    }
    
    /**
     * 房间新增
     */
    public function add(){
        if($this->request->isPost()){//判断请求方式
            $data = $this->request->param();//获得前台提交的数据
            $res = $this->room_model->insetInfo($data);//插入提交的数据
            if($res === FALSE){
                return ajax_error('设置失败！');
            }
            return ajax_success('设置成功！');
        }else{
            return $this->fetch('');//输出HTML页面
        }
    }
}
