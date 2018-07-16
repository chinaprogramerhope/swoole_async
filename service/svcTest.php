<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/22
 * Time: 18:35
 */

class svcTest {
    public function __construct() {
    }

    public function post() {
        $a = [
            'k1' => 1,
            'k2' => 2,
        ];

        return $a;
    }

    public function log() {
        Log::info(__METHOD__ . ', 你好  aaa  ***  似的发射点发生');
        return ERROR_OK;
    }
}