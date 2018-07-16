<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 15:16
 *
 * 消息推送
 */

class svcPush {
    public function __construct() {
    }

    /**
     * 推送小程序模板消息
     */
    public function mp_tmp($param) {
        $need_param = [
            'touser',
            'template_id',
            'from_id',
            'data',
        ];

        if (!Tool::check_param_exists($need_param, $param)) {
            Log::error(__METHOD__ . ' invalid param, param = ' . json_encode($param) . ', need_param = ' . json_encode($need_param));
            return ERROR_INVALID_PARAM;
        }

        $touser = $param['touser'];
        $template_id = $param['template_id'];
        $from_id = $param['from_id'];
        $data = $param['data'];

        $page = isset($param['page']) ? $param['page'] : null;
        $emphasis_keyword = isset($param['emphasis_keyword']) ? $param['emphasis_keyword'] : null;

        clsPush::mp_tmp();
    }
}