<?php
namespace app\admin\controller;

use think\Controller;
use app\common\controller\Common;
use think\Request;
use app\admin\logic\L_Base;
use app\admin\model\Manager;

class Base extends Common
{   
    //登录
    public function login() {
        $param = $this->param;

        $result = $this->validate($param, 'Base.login');
        if ($result !== true) {
            $this->api_result->show_api_error(-1, $result);

        }
        $username = $param['username'];
        $password = $param['password'];
        
        $manager = new Manager;
        $data = $manager->login($username, $password);

        $this->api_result->show_api_result();
    }

    // miss 路由 处理没有匹配到到路由
    public function miss()
    {
        if (Request::instance()->isOptions()) {
            return;
        } else {
            return ['name' => 'thinkphp', 'status' => 1];
        }
    }

    public function index()
    {
        return 23;
    }
}

