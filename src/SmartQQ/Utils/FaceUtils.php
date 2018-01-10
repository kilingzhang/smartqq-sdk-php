<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-8
 * Time: 下午5:09
 */

namespace kilingzhang\SmartQQ\Utils;


class FaceUtils
{
    /**
     *  [QQ:face,id=0-170] to ["face",0-170]
     */
    public static function formFaces($msg)
    {
        $message = array();
        preg_match_all('/\[QQ:face,id=(\d+)\]/', $msg, $pro);
        $msg = preg_split('/\[QQ:face,id=(\d+)\]/', $msg);
        for ($i = 0; $i < ($n = count($pro[0]) > count($msg) ? count($pro[0]) : count($msg)); $i++) {
            if (isset($msg[$i])) {
                array_push($message, $msg[$i]);
            }
            if (!is_null($pro[1][$i])) {
                array_push($message, array("face", (int)$pro[1][$i]));
            }
        }
        return $message;
    }
}