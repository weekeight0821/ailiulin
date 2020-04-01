<?php
namespace app\admin\controller;

use app\admin\model\Manager;
use app\common\controller\Common;

class Managers extends Common
{
    public function getManagerList()
    {   
        $param = $this->param;
        // echo '<pre>';
        // print_r($param);exit;
        $query = $param['query'];
        if (empty($query)) {
            $query = '';
        }

        $pagenum = $param['pagenum'];
        if ($pagenum <= 0) {
            return resultArray(['data' => 'pagenum 参数错误']);
        }

        $pagesize = $param['pagesize'];
        if ($pagesize <= 0) {
            return resultArray(['data' => 'pagesize 参数错误']);
        }
        $managerModel = new Manager;
        $data = $managerModel->getList($query, $pagenum, $pagesize);
        if (!$data) {
            return resultArray(['data' => $managerModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }
}