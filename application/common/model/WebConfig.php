<?php

namespace app\common\model;

use think\Model;

/**
 * Description of Config
 *
 * @author LIANG
 */
class WebConfig extends Model {

    public function insetInfo($info) {
        return $this->isUpdate(FALSE)->save($info);
    }
    
    public function updateInfo($info=[],$where=[]){
        return $this->isUpdate(true)->save($info,$where);
    }
    public function getInfo($where = []) {
        return $this->field(true)->where($where)->find()->toArray();
    }

}
