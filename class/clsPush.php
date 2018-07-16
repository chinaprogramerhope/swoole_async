<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 15:19
 */

class clsPush {
    /**
     * 推送小程序模板消息
     * @param $touser - 接收者（用户）的 openid - 必填
     * @param $template_id - 所需下发的模板消息的id - 必填
     * @param $from_id - 表单提交场景下，为 submit 事件带上的 formId；支付场景下，为本次支付的 prepay_id - 必填
     * @param $data - 模板内容，不填则下发空模板 - 必填
     * @param null $page - 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
     * @param null $emphasis_keyword - 模板需要放大的关键词，不填则默认无放大
     * @return mixed
     */
    public static function mp_tmp($touser, $template_id, $from_id, $data,
                                            $page = null, $emphasis_keyword = null) {
        $access_token = WeChat::get_access_token();

        $param = [
            'touser' => $touser,
            'template_id' => $template_id,
            'from_id' => $from_id,
            'data' => $data,
        ];

        if ($page) {
            $param['page'] = $page;
        }
        if ($emphasis_keyword) {
            $param['emphasis_keyword'] = $emphasis_keyword;
        }

        $url = MP_TMP_PUSH_URL . $access_token;
        $param = json_encode($param);

        $ret_json = Http::curl_post($url, $param); //请求地址，数据，非加密算法，json格式发送
        return $ret_json;
    }
}