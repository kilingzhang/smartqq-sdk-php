<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-5
 * Time: 下午11:24
 */

namespace kilingzhang\SmartQQ\Utils;


class Utils
{
    /**
     * 获取当前时间的毫秒数
     * @return float
     */
    public static function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    /**
     * 用于发送消息时生成msg id
     * @return int
     */
    public static function makeMsgId()
    {
        static $sequence = 0;
        static $t = 0;
        if (!$t) {
            $t = static::getMillisecond();
            $t = ($t - $t % 1000) / 1000;
            $t = $t % 10000 * 10000;
        }
        //获取msgId
        $sequence++;
        return $t + $sequence;
    }

}