<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/7/2
 * Time: 14:03
 *
 * 定时器
 */

class svcTimer {
    public function __construct() {
    }

    public function timer_after($param) {
        if (!isset($param['timer_name']) || !isset($param['after_time_ms'])) {
            Log::error(__METHOD__ . __LINE__ . ' invalid param, param = ' . json_encode($param));
            return ERROR_INVALID_PARAM;
        }

        $timer_name = $param['timer_name'];
        $after_time_ms = intval($param['after_time_ms']);
        $timer_param = isset($param['timer_param']) ? $param['timer_param'] : [];

        if ($after_time_ms <= 0) {
            Log::error(__METHOD__ . __LINE__ . ' invalid param, param = ' . json_encode($param));
            return ERROR_INVALID_PARAM;
        }

        clsTimer::timer_after($timer_name, $after_time_ms, $timer_param);

        return ERROR_OK;
    }
}