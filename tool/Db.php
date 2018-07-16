<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/21
 * Time: 18:46
 */

class Db {
    /**
     * 获取pdo
     * @param $config_name
     * @return bool|PDO
     */
    public static function get_pdo($config_name) {
        if (!array_key_exists($config_name, DB_CONFIG_TEST)) {
            Log::error(__METHOD__ . ' invalid config_name, config_name = ' . $config_name);
            return false;
        }

        $config = DB_CONFIG_TEST[$config_name];

        try {
            $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

            if (isset($config['init_statements'])) {
                foreach ($config['init_statements'] as $sql) {
                    $pdo->exec($sql);
                }
            }

            return $pdo;
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' db error, exception = ' . $e->getMessage());
            return false;
        }
    }
}