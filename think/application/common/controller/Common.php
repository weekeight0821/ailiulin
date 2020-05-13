<?php
namespace app\common\controller;

use think\Controller;
use think\Request;
use app\common\common\Api_result;

class Common extends Controller
{   
    public $param;
    public $api_result;
    
    public function _initialize()
    {   
        parent::_initialize();
        /*防止跨域*/      
        header('Access-Control-Allow-Origin: *'); 
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, sessionId");
        $this->param = Request::instance()->param();
        $this->api_result = Api_result::getInstance();
    }

    public function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key=>$value) {  
                $array[$key] = $this->object_array($value);  
            } 
        }
        return $array;
    }
}