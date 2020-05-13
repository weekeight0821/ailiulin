<?php
namespace app\admin\controller;

use app\common\controller\Common;
use think\Request;

class ApiCommon extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        $header = Request::instance()->header();
    }
}