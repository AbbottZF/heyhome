<?php
namespace app\admin\validate;
use think\Validate;
/**
 * Description of Login
 *
 * @author ZFeng
 */
class Login extends Validate{
    
    protected $rule = [
        'username'=>'require',
        'password'=>'require'
    ];
    
    protected $message = [
        'username.require'=>'请填写账号!',
        'password.require'=>'请填写密码!',
    ];
    
    protected $scene = [
        'login'=>['username','password']
    ];
}
