<?php
/**
 * Created by kilingzhang.com
 * User: kilingzhang
 * Date: 18-1-5
 * Time: 下午12:49
 */

namespace SmartQQ;

use SmartQQ\Message;
use SmartQQ\Encrypt;
use SmartQQ\URL;
use SmartQQ\Utils;
use GuzzleHttp\Client;

class QQClient
{
    // 66 二维码未失效
    // 0 登陆成功
    // 67 认证中
    // 65 失效
    const OK_STATUS = 0;
    const WAITING_STATUS = 65;
    const ASKING_STATUS = 67;
    const FAILURE_STATUS = 65;


    public $client;
    public $qrcodePath;
    public $ptqrtoken;
    public $checkSigUrl;

    public function __construct()
    {
        $this->client = new Client(['cookies' => true]);
        $this->qrcodePath = './qrcode.png';
    }

    public function setQRCodePath($path = './qrcode.png')
    {
        $this->qrcodePath = $path;
    }

    public function getQRCodePath()
    {
        return $this->qrcodePath;
    }

    public function refreshQRCode()
    {
        $response = $this->client->get(URL::qrcodeUrl, [
            't' => time()
        ]);
        $qrcode = $response->getBody();
        $cookies = $this->getCookies($response);
        $this->ptqrtoken = Encrypt::hash33($cookies['qrsig']);
        return file_put_contents($this->qrcodePath, $qrcode);
    }


    public function login()
    {
        set_time_limit(0);
        while (true){
            $code = $this->verifyQrCodeStatus();
            if($code == self::OK_STATUS){
                break;
            }elseif($code == self::FAILURE_STATUS){
                $this->refreshQRCode();
            }
        }

    }


    public function verifyQrCodeStatus(){
        $response = $this->client->get(URL::ptqrloginUrl . "&ptqrtoken={$this->ptqrtoken}&action=0-0-" . time());
        $ptuiCB = Message::ptuiCBToArray($response->getBody());
        $code = $ptuiCB['code'];
        if($code == self::OK_STATUS){
            $this->checkSigUrl = $ptuiCB['link'];
        }
        return $code;
    }



    public function getCookies($response)
    {
        $cookie = $response->getHeader('set-cookie');
        foreach ($cookie as $value) {
            preg_match('/(.*?)=(.*?);/', $value, $pre);
            $cookies[$pre[1]] = $pre[2];
        }
        return $cookies;
    }


}