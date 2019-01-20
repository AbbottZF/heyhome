<?php
namespace app\admin\controller;
use app\common\controller\Admin;
/**
 * Description of Example
 *
 * @author zfeng
 */
class Example extends Admin{
    
    public function index(){
        $data = $this->request->param();
        return $this->fetch($data['name']);
    }
}
