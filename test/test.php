<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 17:38
 */

require_once '../spl_autoload_register.php';

//// 发邮件
//$url = 'http://127.0.0.1:9401';
//$param = [
//    'to' => '18301805881@163.com',
//    'subject' => 'test_mail',
//    'body' => 'gagaga',
//];
//$params = [
//    'class_name' => 'svcMail',
//    'func_name' => 'send_mail',
//    'func_param' => $param,
//];
//Http::curl_post($url, $params);

// 发短信
$url = 'http://127.0.0.1:9401';
$params = [
    'class_name' => 'svcMessage',
    'func_name' => 'send_message',
    'func_param' => [
        'u_kkid' => 'xx',
        'phone_number' => '18301805881'
    ],
];
Http::curl_post($url, $params);

//// 发小程序推送消息 todo
//$url = 'http://127.0.0.1:9401';
//$params = [
//    'class_name' => 'svcPush',
//    'func_name' => 'mp_tmp',
//    'func_param' => [
//        'touser' => , // 接收者（用户）的 openid - 必填
//        'template_id' => , // 所需下发的模板消息的id - 必填
//        'from_id' => , // 表单提交场景下，为 submit 事件带上的 formId；支付场景下，为本次支付的 prepay_id - 必填
//        'data' => , // 模板内容，不填则下发空模板 - 必填
//    ],
//];
//Http::curl_post($url, $params);

//// 测试post  json todo
//$url = 'http://127.0.0.1:9401';
//$params = [
//    'class_name' => 'svcTest',
//    'func_name' => 'post',
//    'func_param' => []
//];
//$ret = Http::curl_post($url, $params, true);
//echo 'type = ' . gettype($ret);


//// 测试无限制定时器
//$url = 'http://127.0.0.1:9401';
//$params = [
//    'class_name' => 'svcTimer',
//    'func_name' => 'timer_after',
//    'func_param' => [
//        'timer_name' => 'test',
//        'after_time_ms' => 2000,
//    ]
//];
//$ret = Http::curl_post($url, $params);
//echo 'type = ' . gettype($ret) . ', ret = ' . json_encode($ret) . "\n";

//// 测试日志
//$url = 'http://127.0.0.1:9401';
//$params = [
//    'class_name' => 'svcTest',
//    'func_name' => 'log',
//    'func_param' => [
//    ]
//];
//$ret = Http::curl_post($url, $params);
//echo 'type = ' . gettype($ret) . ', ret = ' . json_encode($ret) . "\n";
//
//
//$data = [
//    'os' => 'wechat',
//    'user_token' => 'xx',
//    'kkid' => 'xxx',
//    'comment_list' => [
//        'id_order_detail' => 1,
//        'id_product' => 1,
//        'quality_score' => 1,
//        'service_score' => 1,
//        'logistics_score' => 1,
//        'content' => 'xx',
//        'picture' => ["https://img10.kkhcdn.com/qpg_commodity_home_pic/add8e896558911e7962300163e0060d2.jpg", "xx", "xx"],
//    ],
//];