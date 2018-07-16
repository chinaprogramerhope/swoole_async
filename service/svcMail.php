<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/15
 * Time: 15:11
 *
 * 邮件
 */

class svcMail {
    public function __construct() {
    }

    /**
     * 发送加密邮件
     * @param $param
     * @return bool
     */
    public function send_mail($param) {
        return clsMail::send_mail($param);
    }
}