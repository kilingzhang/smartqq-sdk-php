<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-5
 * Time: 下午8:28
 */

namespace kilingzhang\SmartQQ\Utils;


class EncryptUtils
{
    public static function time33($t)
    {
        for ($e = 0, $i = 0, $n = strlen($t); $i < $n; $i++)
            $e = (33 * $e + static::charCodeAt($t, $i)) % 4294967296;
        return $e;
    }

    public static function hash33($t)
    {
        $e = 0;
        $n = strlen($t);
        for ($i = 0; $n > $i; ++$i) {
            //64位php进行32位转换
            if (PHP_INT_MAX > 2147483647) {
                $e = static::toUint32val($e);
            }
            $e += ($e << 5) + static::charCodeAt($t, $i);
        }
        return 2147483647 & $e;
    }

    /**
     * 转换为32位无符号整数，若溢出，则只保留低32位
     */
    public static function toUint32val($var)
    {
        if (is_string($var)) {
            if (PHP_INT_MAX > 2147483647) {
                $var = intval($var);
            } else {
                $var = floatval($var);
            }
        }
        if (!is_int($var)) {
            $var = intval($var);
        }
        if ((0 > $var) || ($var > 4294967295)) {
            $var &= 4294967295;
            if (0 > $var) {
                $var = sprintf('%u', $var);
            }
        }
        return $var;
    }


    public static function charCodeAt($str, $index)
    {
        $char = mb_substr($str, $index, 1, 'UTF-8');
        if (mb_check_encoding($char, 'UTF-8')) {
            $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
            return hexdec(bin2hex($ret));
        } else {
            return null;
        }
    }

    public static function hashUin($uin, $ptwebqq)
    {
        $n = array(0, 0, 0, 0);
        for ($i = 0; $i < strlen($ptwebqq); $i++) {
            $n[$i % 4] ^= self::charCodeAt($ptwebqq, $i);
        }
        $u = ['EC', 'OK'];
        $v = [];
        $v[0] = (((floatval($uin) >> 24) & 255) ^ self::charCodeAt($u[0], 0));
        $v[1] = (((floatval($uin) >> 16) & 255) ^ self::charCodeAt($u[0], 1));
        $v[2] = (((floatval($uin) >> 8) & 255) ^ self::charCodeAt($u[1], 0));
        $v[3] = ((floatval($uin) & 255) ^ self::charCodeAt($u[1], 1));
        $result = array();
        for ($i = 0; $i < 8; $i++) {
            if ($i % 2 == 0)
                $result[$i] = $n[$i >> 1];
            else
                $result[$i] = $v[$i >> 1];
        }
        return self::byte2hex($result);
    }

    public static function byte2hex($bytes)
    {//bytes array
        $hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
        $buf = "";
        for ($i = 0; $i < count($bytes); $i++) {
            $buf .= $hex[($bytes[$i] >> 4) & 15];
            $buf .= ($hex[$bytes[$i] & 15]);
        }
        return $buf;
    }

    /**
     * 根据skey计算出bkn的值
     * @param string $skey
     * @return int
     */
    public static function getBkn($skey)
    {
        $hash = 5381;
        for ($i = 0; $i < strlen($skey); ++$i) {
            $hash += ($hash << 5) + self::utf8_unicode($skey[$i]);
        }
        return $hash & 0x7fffffff;
    }

    /**
     * 用于bkn的计算
     * @param number|string $c
     * @return number|boolean
     */
    public static function utf8_unicode($c)
    {
        switch (strlen($c)) {
            case 1:
                return ord($c);
            case 2:
                $n = (ord($c[0]) & 0x3f) << 6;
                $n += ord($c[1]) & 0x3f;
                return $n;
            case 3:
                $n = (ord($c[0]) & 0x1f) << 12;
                $n += (ord($c[1]) & 0x3f) << 6;
                $n += ord($c[2]) & 0x3f;
                return $n;
            case 4:
                $n = (ord($c[0]) & 0x0f) << 18;
                $n += (ord($c[1]) & 0x3f) << 12;
                $n += (ord($c[2]) & 0x3f) << 6;
                $n += ord($c[3]) & 0x3f;
                return $n;
        }
    }
}