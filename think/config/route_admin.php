<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    //定义资源路由
    // '___rest_' => [
    //     'admin/rules'    => 'admin/rules'
    // ],

    // 基础 登录
    'login' => ['admin/base/login', ['method' => 'POST']],
    'menus' => ['admin/menus/getMenusList', ['method' => 'GET']],
    'users' => ['admin/managers/getManagerList', ['method' => 'GET']],
    // // 基础 登录
    // '/index' => ['admin/base/index', ['method' => 'POST']],
    //miss路由
    '__miss__'         => 'admin/base/miss'

];
