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
     *  test 2333[QQ:face,id=0]21321\n[QQ:face,id=0]
     */
    public static function formFaces($msg)
    {
//        $pre = preg_split('/(\[QQ:face,id=(\d+)\])/',$msg);
        preg_match_all('/(.*?)(\[QQ:face,id=(\d+)\])|(\[QQ:face,id=(\d+)\])(.*?)/',$msg,$pre);
        return \GuzzleHttp\json_encode($msg,JSON_UNESCAPED_UNICODE);
    }
}