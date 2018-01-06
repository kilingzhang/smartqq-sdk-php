<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-5
 * Time: 下午11:22
 */

namespace SmartQQ\Utils;



use SmartQQ\Exception\InvalidArgumentException;

class MessageUtils
{
    public static function ptuiCBToArray($ptuiCB)
    {
        //三种不同状态时返回值
        //请求轮训时
        //ptuiCB('66','0','','0','二维码未失效。(2662345552)', '')
        //请求认证中
        //ptuiCB('67','0','','0','二维码认证中。(1167072813)', '')
        //认证成功 获取二次登录地址
        //ptuiCB('0','0','http://ptlogin2.web2.qq.com/check_sig?pttype=1&uin=1353693508&service=ptqrlogin&nodirect=0&ptsigx=d3e6324c127ecc4665f8c4838797a1e64fe1d3487f1c4ab7d5ddf23119232b5e711ff43d776808ceafda824f53e08055329fd478f69a94e195a64f02fa9b16ec&s_url=http%3A%2F%2Fw.qq.com%2Fproxy.html&f_url=&ptlang=2052&ptredirect=100&aid=501004106&daid=164&j_later=0&low_login_hour=0&regmaster=0&pt_login_type=3&pt_aid=0&pt_aaid=16&pt_light=0&pt_3rd_aid=0','0','登录成功！', '~')
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

    public static function getVfwebqq($getBody){
        /**
         * {
         *  "retcode": 0,
         *  "result": {
         *      "vfwebqq": "72ab4401aa7817e48c4faa35c4e141adfd37f4d2e00cd2bf1af8cae3323aaf7421ff9ed51ebf4140"
         *     }
         * }
         */
        $data = \GuzzleHttp\json_decode($getBody,true);
        if($data['retcode'] == 0){
            return $data['result']['vfwebqq'];
        }
        throw new InvalidArgumentException("Login Out...");
    }

    public static function getPsessionid($getBody)
    {
        /**
         *
         *   {
         *      "result":{
         *      "cip":23600812,
         *      "f":0,
         *      "index":1075,
         *      "port":47450,
         *      "psessionid":"8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857",
         *      "status":"online",
         *      "uin":1353693508,
         *      "user_state":0,
         *      "vfwebqq":"59185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857"
         *      },
         *      "retcode":0
         *  }
         */
        $data = \GuzzleHttp\json_decode($getBody,true);
        if($data['retcode'] == 0){
            return $data['result']['psessionid'];
        }
        return $getBody;
//        throw new InvalidArgumentException("Login Out...");
    }
}