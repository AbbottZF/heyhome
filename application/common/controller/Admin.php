<?php
namespace app\common\controller;

use org\Auth;
use think\Controller;
use think\Db;
use think\Session;
use app\common\model\ActionLog;
use app\utils\service\ConfigService;
/**
 * Description of Admin
 *
 * @author zfeng
 */
class Admin extends Controller{
    
    
    protected function _initialize() {
        parent::_initialize();
        //加载系统配置
        ConfigService::config();
        $this->getMenu();
        $this->checkAuth();
        //输出trace
        if (config('app_trace')) {
            trace('服务器端口:' . $_SERVER['SERVER_PORT'], 'user');
            trace('服务器环境:' . $_SERVER['SERVER_SOFTWARE'], 'user');
            trace('PHP版本:' . PHP_VERSION, 'user');
            $version = Db::query('SELECT VERSION() AS ver');
            trace('MySQL版本:' . $version[0]['ver'], 'user');
            trace('最大上传限度:' . ini_get('upload_max_filesize'), 'user');
        }
    }
    
    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth() {

        if (!Session::has('admin_id')) {
            $this->redirect('admin/login/index');
        }
        $admin_id = Session::get('admin_id');
        if (Session::get('is_admin_'.$admin_id)==1)
            return true;
        $module = $this->request->module();
        $controller = $this->request->controller();
        $action = $this->request->action();
        //优先过滤魔法方法
        if (strpos($action, "_") === 0) {
            return true;
        }
        // 排除权限
        $not_check = json_decode(strtolower(json_encode(config('allow_list'))), true);
        if (!in_array(strtolower($module . '/' . $controller . '/' . $action), $not_check)) {
            $auth = new Auth();
            if (!$auth->check($module . '/' . $controller . '/' . $action, $admin_id) && Session::get('is_admin_'.$admin_id)!=1) {
                $this->error('没有权限');
            }
        }
    }
    
    /**
     * 获取侧边栏菜单
     */
    protected function getMenu() {
        $menu = [];
        $admin_id = Session::get('admin_id');
        $auth = new Auth();
        $auth_rule_list = Db::name('auth_rule')->where('status', 1)->where('type',1)->order(['sort' => 'DESC', 'id' => 'ASC'])->select();
        foreach ($auth_rule_list as $value) {
            if ($auth->check($value['name'], $admin_id) || Session::get('is_admin_'.$admin_id)==1) {
                $menu[] = $value;
            }
        }
        $menu = !empty($menu) ? array2tree($menu) : [];
        tree_sort($menu);
        $this->assign('menu', $menu);
    }
}
