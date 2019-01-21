<?php
namespace app\admin\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Session;
use app\common\model\ActionLog;
use app\common\model\AdminUser;
use app\utils\service\ConfigService;

/**
 * Description of Login
 *
 * @author ZFeng
 */
class Login extends Controller{
    
    protected $admin_user_model;

    protected function _initialize() {
        parent::_initialize();
        //加载系统配置
        ConfigService::config();
        $this->admin_user_model = new AdminUser();
    }
    /**
     * 后台登录
     * @return mixed
     */
    public function index(){
//        if(session('admin_user')){
//            $this->redirect(url('admin/index/index'));
//        }
        return $this->fetch();
    }
    /**
     * 登录验证
     * @return string
     */
    public function login(){
        if ($this->request->isPost()) {
            $data = $this->request->only(['username', 'password', 'verify']);
            $vali = \think\Loader::validate('Login');
            if(!$vali->scene('login')->check($data)){
                return ajax_error($vali->getError());
            }
            $where = [
                'username'=>$data['username'],'password'=>md5($data['password'] . Config::get('salt'))
            ];
            $admin_user = $this->admin_user_model->field('id,username,status,headimg,name,mobile,sex,is_admin,merchant_id')->where($where)->find();
            if(empty($admin_user)){
                return ajax_error('账号或密码错误!');
            }
            if ($admin_user['status'] != 1) {
                return ajax_error('账号已被禁用!');
            }
            Session::set('admin_id', $admin_user['id']);
            Session::set('is_admin_'.$admin_user['id'], $admin_user['is_admin']);
            Session::set('admin_name', $admin_user['username']);
            Session::set('admin_user', $admin_user);
            Db::name('admin_user')->update(
                [
                    'last_login_time' => time(),
                    'last_login_ip'   => $this->request->ip(),
                    'id'              => $admin_user['id']
                ]
            );
            //添加日志
            (new ActionLog())->addLog(1,'登录');
            return ajax_success('登录成功!',url('admin/index/index'));
        }
    }
    /**
     * 退出登录
     */
    public function logout(){
        Session::delete('admin_id');
        Session::delete('admin_name');
        Session::delete('admin_user');
        $this->success('退出成功', 'admin/login/index');
    }
}
