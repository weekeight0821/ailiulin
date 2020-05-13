<?php
namespace app\admin\validate;

use think\Validate;

class Base extends validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
    ];

    protected $message = [
        'username.require' => '用户名必填',
        'password.require'     => '密码必填',
    ];
    
    protected $scene = [
        'login'   =>  ['username', 'password']
    ];
}