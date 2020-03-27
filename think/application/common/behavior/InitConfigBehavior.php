<?php
namespace app\conmmon\behavior;

class InitConfigBehavior
{
    public function run(&$content)
    {
        $system_config = cache('DB_CONFIG_DATA');
        if (!$system_config) {
            $system_config = \think\Loader::model('admin/SystemConfig')->getDataList();
            cache('DB_CONFIG_DATA', null);
            cache('DB_CONFIG_DATA', $system_config, 36000); //缓存配置
        }
        config($system_config); //添加配置
    }
}