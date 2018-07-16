<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/7/3
 * Time: 11:11
 */
// 邮件
const MAIL_SMTP_SERVER = 'smtp.exmail.qq.com';
const MAIL_SMTP_USER = 'noreply@kangkanghui.com';
const MAIL_SMTP_PASS = 'SCkjF#xj1237jKs%';

// 短信
const SMS_PROVIDER_URL = 'https://sms.yunpian.com/v2/sms/tpl_single_send.json'; // 短信服务商地址
const SMS_PROVIDER_ID = '1916474'; // 短信模板ID
const SMS_PROVIDER_MARKET_APIKEY = '4968d32fc54da13181879fadd234479d'; // 短信服务商私钥
const SMS_PROVIDER_CAPTCHA_APIKEY = '4d27e0f6b9cd89de1e69c27ba7ced9bd'; // 专用注册登录验证码通道

const SMS_SEND_IC_INTERVAL = 120; // 手机短信验证码发送间隔 - 秒
const SMS_RESEND_IC_TIME = 60; // 手机短信验证码重发间隔 - 秒
const SMS_IC_EXPIRED = 3600; // 手段短信验证码过期时间 - 秒

// mysql
const DB_DEFAULT_FETCH_MODE = PDO::FETCH_ASSOC;
const DB_CONFIG = [
    'usercenter' => [
        'dsn'=>'mysql:host=10.28.150.218;dbname=usercenter_db',
        'username' => 'kkhfast01',
        'password' => 'ufxjp3x#z&',
        'init_attributes' => [],
        'init_statements' => [
            'SET CHARACTER SET utf8mb4',
            'SET NAMES utf8mb4'
        ],
//            'default_fetch_mode' => Config::DB_DEFAULT_FETCH_MODE,
    ],

    'shop' => [
        'dsn'=>'mysql:host=10.28.150.218;dbname=shop_db_for_test',
        'username' => 'kkhfast01',
        'password' => 'ufxjp3x#z&',
        'init_attributes' => [],
        'init_statements' => [
            'SET CHARACTER SET utf8mb4',
            'SET NAMES utf8mb4'
        ],
    ],
];

const DB_CONFIG_TEST = [
    'usercenter' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=usercenter_db',// 'dsn'=>'mysql:host=10.28.150.218;dbname=usercenter_db'
        'username' => 'root', // 'kkhfast01',
        'password' => 'password', // 'ufxjp3x#z&',
        'init_attributes' => [],
        'init_statements' => [
            'SET CHARACTER SET utf8mb4',
            'SET NAMES utf8mb4'
        ],
//            'default_fetch_mode' => Config::DB_DEFAULT_FETCH_MODE,
    ],

    'shop' => [
        'dsn'=>'mysql:host=127.0.0.1;dbname=shop_db_for_test',//'dsn'=>'mysql:host=10.28.150.218;dbname=shop_db_for_test',
        'username' => 'root',//'kkhfast01',
        'password' => 'password',//'ufxjp3x#z&',
        'init_attributes' => [],
        'init_statements' => [
            'SET CHARACTER SET utf8mb4',
            'SET NAMES utf8mb4'
        ],
    ],
];

// 微信小程序
const MP_TMP_PUSH_URL = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=';
const MP_APP_ID = 'wx35326675599f54e9'; // 第三方用户唯一凭证
const MP_APP_SECRET = '5cfba736681fd03ba4bc68e09339a0b8'; // 第三方用户唯一凭证密钥，即appsecret
const MP_GET_ACCESS_TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='
    . MP_APP_ID . '&secret='. MP_APP_SECRET; // 获取access_token的url