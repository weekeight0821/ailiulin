<?php
namespace app\common\common;

class Api_result {

    private $_result_code;
    private $_msg;
    private $_alert;
    private $_content;
    private $_alert_type;
    private $_error_scheme;
    private $_success_toast_msg;
    private $_user_alert;
    static private $instance;

    private function __construct() {
        $this->init();
    }

    private function __clone() {}

    static public function getInstance() {

        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init() {
        $this->_result_code = -999;
        $this->_msg = '';
        $this->_alert = '';
        $this->_content = null;
        $this->_alert_type = 1; // 1:code!=0时toast 2:code!=0时alert,3:code=0时toast
        $this->_error_scheme = ''; // code!=0时，跳转地址
        $this->_user_alert = array();
    }

    //操作成功显示toast提示
    public function set_success_toast($toast_msg) {
        $this->_success_toast_msg = $toast_msg;
    }

    public function set_api_result($result_code, $msg = '', $content = null, $alert = '', $alert_type = 1, $scheme = '', $user_alert = array()) {
        $this->init();
        if (isset($result_code)) {
            $this->_result_code = $result_code;
        }
        if (!empty($msg)) {
            $this->_msg = $msg;
        }
        if (!empty($content)) {
            $this->_content = $content;
        }
        if (!empty($alert)) {
            $this->_alert = $alert;
        }
        if (!empty($user_alert)) {
            $this->_user_alert = $user_alert;
        }
        $this->_alert_type = $alert_type;
        $this->_error_scheme = $scheme;
    }

    public function get_api_result($is_final_show = false) {
        $result_array[strrev(time())] = 1;

        $result_array['code'] = $this->_result_code;
        $result_array['msg'] = $this->_msg;
        if (!empty($this->_content)) {
            $result_array['content'] = $this->_content;
        }

        $result_array['alert_type'] = $this->_alert_type;
        $result_array['error_scheme'] = $this->_error_scheme;
        if (!empty($this->_alert)) {
            $result_array['alert'] = $this->_alert;
        }
        //当返回code为0时，并且_success_toast_msg不为空
        if ($this->_result_code == 0 && strlen($this->_success_toast_msg) > 0) {
            $result_array['alert_type'] = 3;
            $result_array['alert'] = $this->_success_toast_msg;
        }
        if (!empty($this->_user_alert)) {
            $result_array['user_alert'] = $this->_user_alert;
        }

        return $result_array;
    }

    public function show_api_result($show_pop_up = true) {
        $result_array = $this->get_api_result($show_pop_up);
        $result = json_encode($result_array, JSON_UNESCAPED_UNICODE);
        echo $result;

    }

    public function set_success_result($content = array(), $alert = "操作成功") {
        $this->set_api_result(0, 'ok', $content, $alert);
        return $this->get_api_result();
    }

    public function set_api_error($result_code, $msg = '', $alert = '', $alert_type = 1, $scheme = '') {
        $this->set_api_result($result_code, $msg, null, $alert, $alert_type, $scheme);
        return $this->get_api_result();
    }

    public function show_api_error($msg, $alert = '', $code = 1000, $content = null) {
        $this->set_api_result($code, $msg, $content, $alert);
        $this->show_api_result();
        exit();
    }

    public function show_param_error($msg) {
        $this->show_api_error($msg, "请求参数异常", 10101);
    }

    public function show_param_missing($arg_name) {
        $this->show_api_error('missing params:' . $arg_name, '请求参数不完整:' . $arg_name, 10102);
    }
}
