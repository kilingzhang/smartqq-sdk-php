<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-5
 * Time: 下午11:22
 */

namespace SmartQQ;


class Message
{
    public static function ptuiCBToArray($ptuiCB)
    {
        // 66 二维码未失效
        // 0 登陆成功
        // 67 认证中
        // 65 失效
        preg_match('/ptuiCB\(\'(.*?)\',\'(.*?)\',\'(.*?)\',\'(.*?)\',\'(.*?)\', \'(.*?)\'\)/', $ptuiCB, $pre);
        return array(
            'code' => $pre[1],
            'code2' => $pre[2],
            'link' => $pre[3],
            'code3' => $pre[4],
            'msg' => $pre[5],
            'nikcname' => $pre[6],
        );
    }
}