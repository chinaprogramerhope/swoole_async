<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/21
 * Time: 10:54
 */

class clsMessage {
    public function __construct() {
    }

    /**
     * 发送手机验证码
     * todo 验证$u_kkid是否必要
     * @param $u_kkid
     * @param $phone_number
     * @return bool
     */
    public function send_authentication_code($u_kkid, $phone_number) {
        $time_now = time();

        // 验证手机号
        if (strlen($phone_number) !== 11 || !preg_match("/1(3|4|5|7|8)[0-9]\d{8}/", $phone_number, $matches)) {
            Log::error(__METHOD__ . ' invalid phone_number, phone_number = ' . $phone_number);
            return false;
        }

        // 验证发送验证码间隔时间
        $last_send_ic_ts = $this->get_sms_captcha_log_ts($phone_number, $time_now); // 获取最后一次给该手机号发送验证码的时间
        if ($last_send_ic_ts) {
            $over_time = $time_now - $last_send_ic_ts;
            if ($over_time < SMS_SEND_IC_INTERVAL) {
                Log::error(__METHOD__ . ' over_time limit, left_ts = ' . (SMS_SEND_IC_INTERVAL - $over_time));
                return false;
            }
        }

        // 保存发送验证码的记录
        $captcha = $this->save_sms_captcha_log($phone_number, $time_now);
        if (!$captcha) {
            Log::error(__METHOD__ . ' save_sms_captcha_log fail, phone_number = ' . $phone_number);
            return false;
        }

        // 保存 注册/登录 的手机验证码
        $ret_save_sms_captcha = $this->save_sms_captcha($u_kkid, $phone_number, $captcha, $time_now);
        if (!$ret_save_sms_captcha) { // 之前的逻辑中这里错了不会中断, 所以这里也只是打印日志
            Log::error(__METHOD__ . ' save_sms_captcha fail, phone_number = ' . $phone_number);
        }

//        // test
//        $captcha = 1111;

        // 发送模板短信
        $ret_json = $this->send_sms($phone_number, $captcha);

        if ($ret_json === false) {
            Log::error(__METHOD__ . ' sms_tpl_send fail, phone_number = ' . $phone_number . ', captcha = ' . $captcha);
            return false;
        }
        $ret = json_decode($ret_json, true);
//        if (intval($ret['http_status_code']) === 400) {
        if (intval($ret['code']) === 400) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 发送模板短信
     * @param $phone_number
     * @param $content
     * @return mixed
     */
    private function send_sms($phone_number, $content) {
        $param = [
            'tpl_id' => SMS_PROVIDER_ID,
            'tpl_value' => ('#code#') . '=' . urlencode($content), // 需要对value进行编码
            'apikey' => SMS_PROVIDER_CAPTCHA_APIKEY,
            'mobile' => $phone_number,
        ];

        $json_data = Http::curl_post(SMS_PROVIDER_URL, $param);

        return $json_data;
    }

    // ==== db function

    /**
     * 获取最后一次给该手机号发送验证码的时间
     * @param $phone_number
     * @param $time_now
     * @return bool|int
     */
    public function get_sms_captcha_log_ts($phone_number, $time_now) {
        $pdo_usercenter = Db::get_pdo('usercenter');

        try {
            $sql = 'select create_ts from t_phone_captcha_code';
            $sql .= ' where phone_num = :phone_number and expired > ' . $time_now;
            $sql .= ' order by create_time desc limit 1';

            $stmt = $pdo_usercenter->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute([
                ':phone_number' => $phone_number
            ]);
            $row = $stmt->fetch();
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' db error, exception = ' . $e->getMessage());
            return false;
        }

        if (empty($row)) {
            Log::info(__METHOD__ . ' select result is empty, phone_number = ' . $phone_number);
            return false;
        }

        return intval($row['create_ts']);
    }

    /**
     * 保存发送验证码的记录
     * @param $phone_number
     * @param $time_now
     * @return bool|int
     */
    public function save_sms_captcha_log($phone_number, $time_now) {
        $pdo_usercenter = Db::get_pdo('usercenter');

        $code = intval(substr(str_pad(base_convert(sha1(uniqid(rand().$phone_number)),36,10), 6 , 0, STR_PAD_LEFT), 0, 6));
        $expire = SMS_IC_EXPIRED;

        $param = [
            ':id' => 0,
            ':phone_num' => $phone_number,
            ':code' => $code,
            ':expired' => $time_now + $expire,
            ':create_time' => $time_now,
            ':status' => 1,
        ];

        try {
            $sql = 'insert into t_phone_captcha_code (id, phone_num, code, expired, create_time, status)';
            $sql .= ' values(:id, :phone_num, :code, :expired, :create_time, :status)';

            $stmt = $pdo_usercenter->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute($param);
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' db error, exception = ' . $e->getMessage());
            return false;
        }

        return $code;
    }

    /**
     * 保存 注册/登录 的手机验证码
     * @param $u_kkid
     * @param $phone_number
     * @param $captcha
     * @param $time_now
     * @return bool
     */
    public function save_sms_captcha($u_kkid, $phone_number, $captcha, $time_now) {
        $pdo_usercenter = Db::get_pdo('usercenter');

        $param = [
            ':id' => 0,
            ':mobile' => $phone_number,
            ':v_code' => $captcha,
            ':datei' => date('Y-m-d H:i:s', $time_now),
            ':u_kkid' => $u_kkid,
            ':status' => 1,
            ':created' => $time_now,
        ];

        try {
            $sql = 'insert into t_verifysms (id, mobile, v_code, datei, u_kkid, status, created)';
            $sql .= ' values(:id, :mobile, :v_code, :datei, :u_kkid, :status, :created)';

            $stmt = $pdo_usercenter->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute($param);
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' db error, exception = ' . $e->getMessage());
            return false;
        }

        return true;
    }
}