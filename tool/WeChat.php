<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 16:00
 */

class WeChat {
    /**
     * 获取 access_token(接口调用凭证)
     * @return bool|string
     */
    public static function get_access_token(){
        $key_access_token = 'xapp_access_token';
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $access_token = $redis->get($key_access_token);
        if ($access_token){
            return $access_token;
        }

        $data = Http::curl_post(MP_GET_ACCESS_TOKEN_URL, []);

        $redis->set($key_access_token, $data['access_token'], 3600); // 原逻辑中是3600
        return $data['access_token'];
    }
}