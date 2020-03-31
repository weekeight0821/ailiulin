<?php
namespace app\admin\Controller;

use think\Controller;
use app\admin\model\Permission;
use app\common\controller\Common;

class Menus extends Common
{
    public function getMenusList()
    {
        $permissionModel = new Permission;
        $data = $permissionModel->getList();
        if (!$data) {
            return resultArray(['data' => $permissionModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }
}