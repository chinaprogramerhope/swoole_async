<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/21
 * Time: 16:29
 */

class Log {
    // 调式日志
    public static function debug($content) {
        self::write_file('swoole_debug', $content);
    }

    // 运行日志, 打印感兴趣或重要信息, 勿滥用
    public static function info($content) {
        self::write_file('swoole_info', $content);
    }

    // 潜在错误, 不是错误信息, 但有必要提示
    public static function warn($content) {
        self::write_file('swoole_warn', $content);
    }

    // 错误日志, 出现这种错误时, 不影响系统运行
    public static function error($content) {
        self::write_file('swoole_error', $content);
    }

    // 重大错误, 出现这种错误时吗, 须停止程序
    public static function fatal($content) {
        self::write_file('swoole_fatal', $content);
    }

    public static function write_file($level, $content) {
        $log_dir = '/home/hxl/swoole_log/'; // notice: 运行php的用户必须对要写入的目录有写权限
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0777, true);
        }

        $today = date('Y-m-d');
        $time_now = date('Y-m-d H:i:s');

        $file = $log_dir . $today . '_' . $level . '.log';
        $res = fopen($file, 'ab');
        $content = $time_now . ' : ' . $content . "\n";
        fwrite($res, $content);
        fclose($res);
    }
}