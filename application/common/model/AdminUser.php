<?php
namespace app\common\model;

use think\Model;
use think\Config;
/**
 * 管理员模型
 * Class AdminUser
 * @package app\common\model
 */
class AdminUser extends Model
{
    protected $insert = ['create_time'];
    
    
    public function getSexTextAttr($value,$data){
        $sex = [1=>'男',2=>'女',3=>'保密'];
        return $sex[$data['sex']];
    }
    
    public function setLockPasswordAttr($value){
        return md5($value . Config::get('salt'));
    }
    
    public function setPasswordAttr($value){
        return md5($value . Config::get('salt'));
    }
}