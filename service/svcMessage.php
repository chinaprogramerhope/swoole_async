<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/21
 * Time: 10:49
 *
 * 短信
 */

class svcMessage {
    public function __construct() {
    }

    /**
     * 发送手机验证码
     * @param $param
     * @return bool
     */
    public function send_message($param) {
        if (empty($param['u_kkid']) || empty($param['phone_number'])) { // 参数检测
            Log::error(__METHOD__ . ' invalid param, param = ' . json_encode($param));
            return false;
        }

        $u_kkid = $param['u_kkid'];
        $phone_number = $param['phone_number'];

        $instance = new clsMessage();
        return $instance->send_authentication_code($u_kkid, $phone_number);
    }
}