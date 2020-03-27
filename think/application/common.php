<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 行为绑定
 */
// use think\Hook;

// Hook::add('app_init','app\\common\\behavior\\InitConfigBehavior');

function resultArray($array)
{   
    $meta = [];
    if (isset($array['data'])) {
        $meta['code'] = 200;
        $meta['msg'] = '请求成功';
    } elseif (isset($array['error'])) {
        $meta['code'] = 400;
        $meta['msg'] = '请求失败';
        $array['data'] = '';
        $meta['error'] = $array['error'];
    }

    return [
        'data' => $array['data'],
        'meta' => $meta
    ];
}

function user_md5($str, $auth_key = '')
{
    return '' === $str ? '' : md5(sha1($str) . $auth_key);
}