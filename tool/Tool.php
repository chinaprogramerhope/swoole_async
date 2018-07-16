<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 18:05
 */

class Tool {
    /**
     * 参数检查 - 是否包含必须参数
     * @param $need_param - 服务端所须参数
     * @param $param - 客户端所传参数
     * @return bool - true成功,  false失败
     */
    public static function check_param_exists($need_param, $param) {
        foreach ($need_param as $v) {
            if (!isset($param[$v])) {
                return false;
            }
        }

        return true;
    }
}