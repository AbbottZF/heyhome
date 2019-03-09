<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;
use think\Model;
/**
 * Description of Room
 *
 * @author zfeng
 */
class Room extends Model{
    //put your code here
    /**
     * 插入数据
     * @param type $info
     * @return type
     */
    public function insetInfo($info) {
        $info['status'] = 1;
        $info['create_time'] = time();
        return $this->isUpdate(FALSE)->save($info);
    }
    /**
     * 更新数据
     * @param type $info
     * @param type $where
     * @return type
     */
    public function updateInfo($info=[],$where=[]){
        return $this->isUpdate(true)->save($info,$where);
    }
    /**
     * 获得单条数据
     * @param type $where
     * @return type
     */
    public function getInfo($where = []) {
        return $this->field(true)->where($where)->find()->toArray();
    }
}
