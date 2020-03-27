<?php
namespace app\admin\model;

use think\Model;
use think\facade\Session;

class User extends Model
{   
    protected $name = 'admin_user';
    protected $createTime = 'create_time';
    protected $updateTime = false;
	protected $autoWriteTimestamp = true;
	protected $insert = [
		'status' => 1,
    ];
    
    public function login($username, $password)
    {
        if (empty($username)) {
            $this->error = '用户不能为空';
            return false;
        }
        
        if (empty($password)) {
            $this->error = '密码不能为空';
            return false;
        }

        $data['username'] = $username;
        $userInfo = $this->where($data)->find();
        if (!$userInfo) {
            $this->error = '帐号不存在';
            return false;
        }

        if (user_md5($userInfo['password']) !== $password) {
            $this->error = '密码不正确';
            return false;
        }

        if ($userInfo['status'] === 0) {
            $this->error = '帐号已被禁用';
			return false;
        }

        // 保存缓存
        session_start();
        $info['userInfo'] = $userInfo;
        $info['sessionId'] = session_id();
        $authKey = user_md5($userInfo['username'].$userInfo['password'].$info['sessionId']);
        $info['authKey'] = $authKey;
        cache('Auth_'.$authKey, null);
        cache('Auth_'.$authKey, $info, config('LOGIN_SESSION_VALID'));
        // 返回信息
        $data['authKey']		= $authKey;
        $data['sessionId']		= $info['sessionId'];
        $data['userInfo']		= $userInfo;
        return $data;
    }
}