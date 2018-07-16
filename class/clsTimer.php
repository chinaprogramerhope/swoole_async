<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/7/2
 * Time: 14:03
 *
 * 定时器
 */

class clsTimer {
    public static function timer_after($timer_name, $after_time_ms, $timer_param = []) {
        $max_after_time_ms = 86400000;
        $current_after_time_ms = 0;
        $left_after_time_ms = 0;

        if ($after_time_ms > $max_after_time_ms) {
            $current_after_time_ms = $max_after_time_ms;
            $left_after_time_ms = $after_time_ms - $max_after_time_ms;
        } else {
            $current_after_time_ms = $after_time_ms;
        }

        swoole_timer_after($current_after_time_ms, function () use ($left_after_time_ms, $timer_name, $timer_param) {
            if ($left_after_time_ms > 0) { // 剩余时间还未耗完
                self::timer_after($timer_name, $left_after_time_ms, $timer_param);
            } else { // 满足条件, 跳出递归, 执行相关逻辑
                Log::info('clsTimer::timer_after, ' . __LINE__ . ', ' . $timer_name . ' begin! timer_param = '
                    . json_encode($timer_param));

                self::$timer_name($timer_param);

                Log::info('clsTimer::timer_after, ' . __LINE__ . ', ' . $timer_name . ' begin! timer_param = '
                    . json_encode($timer_param));
            }
        });
    }

    /**
     * 3天后把该订单的订单状态改为已完成(如果到时该订单状态仍为已发货)
     * @param $timer_param
     * @return bool
     */
    public function update_order_status($timer_param) {
        $id_order = $timer_param['id_order'];
        $order_status = $timer_param['order_status'];

        $pdo_shop = Db::get_pdo('shop');
        try {
            $sql = 'select current_state from s_orders where id_order = :id_order';
            $stmt = $pdo_shop->prepare($sql);
            $stmt->execute([
                ':id_order' => $id_order
            ]);
            $current_state = $stmt->fetchColumn();
            if (empty($current_state)) {
                Log::error(__METHOD__ . ', ' . __LINE__ . ', db select return empty, sql = ' . $sql
                    . ', timer_param = ' . json_encode($timer_param));
                return false;
            }
            if ($current_state != 4) {
                Log::warn(__METHOD__ . ', ' . __LINE__ . ', will not update order status to ' . $order_status .
                    ', because current_state != 4, id_order = ' . $id_order . ', current_state = ' . $current_state);
                return false;
            }

            $sql = 'update s_orders set current_state = :order_status where id_order = :id_order';
            $stmt = $pdo_shop->prepare($sql);
            $stmt->execute([
                ':id_order' => $id_order,
                ':order_status' => $order_status
            ]);
        } catch (Exception $e) {
            Log::error(__METHOD__ . ', ' . __LINE__ . ', db exception = ' . $e->getMessage());
            return false;
        }
    }

    public static function test() {
        echo 111 . "\n";
    }
}