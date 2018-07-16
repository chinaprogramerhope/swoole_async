<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/7/2
 * Time: 14:03
 *
 * 定时器
 */

class clsTimer {
    public static function timer_after($timer_name, $after_time_ms) {
        $max_after_time_ms = 86400000;
        $current_after_time_ms = 0;
        $left_after_time_ms = 0;

        if ($after_time_ms > $max_after_time_ms) {
            $current_after_time_ms = $max_after_time_ms;
            $left_after_time_ms = $after_time_ms - $max_after_time_ms;
        } else {
            $current_after_time_ms = $after_time_ms;
        }

        swoole_timer_after($current_after_time_ms, function () use ($left_after_time_ms, $timer_name) {
            if ($left_after_time_ms > 0) { // 剩余时间还未耗完
                self::timer_after($timer_name, $left_after_time_ms);
            } else { // 满足条件, 跳出递归, 执行相关逻辑
                self::$timer_name();
            }
        });
    }

    public static function test() {
        echo 111 . "\n";
    }
}