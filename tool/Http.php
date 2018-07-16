<?php
class Http {
    // todo 保证返回值类型是[]
    public static function curl_post($url, $param) {
        $ch = curl_init(); // 初始化

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8')); // 设置验证方式
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时时间
        curl_setopt($ch, CURLOPT_POST, 1); // 设置通信方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param)); // 设置post数据
        $ret = curl_exec($ch); // 执行命令
        curl_close($ch); // 关闭请求

        return $ret;
    }
}