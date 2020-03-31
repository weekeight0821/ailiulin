<?php
namespace app\admin\model;

use think\Model;
use think\Db;
class Permission extends Model
{   
    protected $name = 'permission';

    public function getList()
    {
        $data = Db::table('sp_permission_api')->alias('api')->join('sp_permission p','api.ps_id  = p.ps_id ','LEFT')->where('p.ps_id is not null')->select();
        if (empty($data)) {
            $this->error = '没有菜单项';
			return false;
        }

        $resultData = [];
        //获取一级菜单栏
        foreach($data as $val) {
            if ($val['ps_level'] == 0) {
                $resultData[$val['ps_id']] = [
                    'id' => $val['ps_id'],
                    'authName' => $val['ps_name'],
                    'path' => $val['ps_api_path'],
                    'children' => []
                ];
            }
        }
        //获取二级菜单栏
        foreach($data as $val) {
            if ($val['ps_level'] == 1) {
                $children = [
                    'id' => $val['ps_id'],
                    'authName' => $val['ps_name'],
                    'path' => $val['ps_api_path'],
                    'children' => []
                ];
                $resultData[$val['ps_pid']]['children'][] = $children;
            }
        }

        return $resultData;

    }
}