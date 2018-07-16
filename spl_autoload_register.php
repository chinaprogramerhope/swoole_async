<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/11
 * Time: 10:35
 */

spl_autoload_register(function ($class) {
    $dir_name = [
        '',
        'service',
        'class',
        'tool',
        'config',
    ];

    foreach ($dir_name as $v) {
        if (empty($v)) {
            $file_name = __DIR__ . '/' . $class . '.php';
        } else {
            $file_name = __DIR__ . '/' . $v . '/' . $class . '.php';
        }

        if (file_exists($file_name)) {
            require_once $file_name;
            break;
        }
    }
});