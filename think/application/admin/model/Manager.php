<?php
namespace app\admin\model;

use app\common\model\BaseModel;
use think\facade\Session;

class Manager extends BaseModel
{   
    protected $name = 'manager';
    protected $mg_time = 'mg_time';
    protected $updateTime = false;
	protected $autoWriteTimestamp = true;
	protected $insert = [
		'mg_state' => 1,
    ];
    
    public function login($username, $password)
    {

        $data['mg_name'] = $username;
        $userInfo = $this->query_one($data);

        if (!$userInfo) {
            $this->error = '帐号不存在';
            return false;
        }

        if (user_md5($password) !== $userInfo['mg_pwd']) {
            $this->error = '密码不正确';
            return false;
        }

        if ($userInfo['mg_state'] === 0) {
            $this->error = '帐号已被禁用';
			return false;
        }

        // 保存缓存
        session_start();
        $info['userInfo'] = $userInfo;
        $info['sessionId'] = session_id();
        $authKey = user_md5($userInfo['mg_name'].$userInfo['mg_pwd'].$info['sessionId']);
        $info['authKey'] = $authKey;
        cache('Auth_'.$authKey, null);
        cache('Auth_'.$authKey, $info, config('LOGIN_SESSION_VALID'));
        // 返回信息
        $data['authKey']		= $authKey;
        $data['sessionId']		= $info['sessionId'];
        $data['userInfo']		= $userInfo;
        return $data;
    }

    public function getList($query, $pagenum, $pagesize)
    {
        $where = [];
        if ($query) {
            $where['sp_manager.mg_name'] = array('like', '%'.$query.'%');
        }
        $result = Db::table('sp_manager')->alias('m')->where($where)
                   ->join('sp_role r','r.role_id  = m.role_id ','LEFT')
                   ->page($pagenum)->limit($pagesize)->field('m.mg_id, m.mg_name, m.mg_mobile, m.mg_time, m.mg_email, r.role_name, m.mg_state')->select();
        $count = $this->getCount($query);

        if (!empty($result)) {
            foreach($result as $val) {
                if (empty($val['role_name'])) {
                    $val['role_name'] = '超级管理员';
                }
                $users[] = $val;
            }
        } else {
            $users = [];
        }

        $data['total'] = $count;
        $data['pagenum'] = $pagenum;
        $data['users'] = $users;
        
        return $data;
    }

    public function getCount($query)
    {
        $where = [];
        if ($query) {
            $where['mg_name'] = array('like', '%'.$query.'%');
        }

       $count =  $this->where($where)->count();
       return $count;
    }
}