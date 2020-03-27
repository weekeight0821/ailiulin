<?php
namespace app\admin\controller;

use think\Controller;
use app\common\controller\Common;
use think\Request;

class Base extends Common
{   
    //登录
    public function login()
    {
        $userModel = model('User');
        $param = $this->param;
        $username = $param['username'];
        $password = $param['password'];
        // $verifyCode = !empty($param['verifyCode'])? $param['verifyCode']: '';
        $data = $userModel->login($username, $password);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        }
        return resultArray(['data' => $data]);
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
