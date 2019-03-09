<?php
namespace app\common\model;
use think\Model;

/**
 * Description of AuthRule
 *
 * @author zfeng
 */
class AuthRule extends Model{
    
    public function getPage($where=[],$page=1){
        return $this->where($where)->order('sort desc,create_time desc')->paginate(10, false, ['page' => $page]);
    }
    
}
