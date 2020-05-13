<?php

use think\Route;

Route::group('admin', function() {
    //基础 登陆
    Route::group('base', function() {
        Route::post('login', 'admin/Base/login');
    });
});
