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
    
    protected function _initialize() {
        parent::_initialize();
        //加载系统配置
        ConfigService::config();
    }
    /**
     * 后台登录
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }
    /**
     * 登录验证
     * @return string
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $data = $this->request->only(['username', 'password', 'verify']);
            $validate_result = $this->validate($data, 'Login');

            if ($validate_result !== true) {
                return ajaxMsg($validate_result);
            } else {
                $where['username'] = $data['username'];
                $where['password'] = md5($data['password'] . Config::get('salt'));
                $admin_user = (new AdminUser())->field('id,username,status,headimg,name,mobile,sex,is_admin,merchant_id')->where($where)->find();
                if (!empty($admin_user)) {
                    if ($admin_user['status'] != 1) {
                        return ajaxMsg('当前用户已禁用!');
                    } else {
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
                        return ajaxMsg('登录成功!',1,url('admin/index/index'));
                    }
                } else {
                    return ajaxMsg('用户名或密码错误!');
                }
            }
        }
    }
}
