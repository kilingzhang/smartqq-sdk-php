<?php
/**
 * Created by kilingzhang.com
 * User: kilingzhang
 * Date: 18-1-5
 * Time: 下午12:49
 */

namespace SmartQQ;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use SmartQQ\Entity\ClientToken;
use SmartQQ\Utils\EncryptUtils;
use SmartQQ\Utils\MessageUtils;
use SmartQQ\Utils\Utils;


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


    private $client;
    private $qrcodePath;
    private $checkSigUrl;

    private $ptqrtoken;
    private $uin;
    private $skey;
    private $clientid = 53999199;
    private $vfwebqq;
    private $psessionid;


    public function __construct(ClientToken $clientToken = null)
    {
        if($clientToken != null){
            $this->setClienToken($clientToken);
        }

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
        $response = $this->client->get(URL::qrcodeURL, [
            't' => time()
        ]);
        $qrcode = $response->getBody();
        $cookies = $this->getCookies($response);
        $this->ptqrtoken = EncryptUtils::hash33($cookies['qrsig']);
        return file_put_contents($this->qrcodePath, $qrcode);
    }


    public function verifyQrCodeStatus(){
        $response = $this->client->get(URL::ptqrloginURL . "&ptqrtoken={$this->ptqrtoken}&action=0-0-" . time());
        $ptuiCB = MessageUtils::ptuiCBToArray($response->getBody());
        $code = $ptuiCB['code'];
        if($code == self::OK_STATUS){
            $this->checkSigUrl = $ptuiCB['link'];
        }
        return $code;
    }



    public function QRLogin()
    {
        set_time_limit(0);
        while (true){
            $code = $this->verifyQrCodeStatus();
            if($code == self::OK_STATUS){
                return true;
            }elseif($code == self::FAILURE_STATUS){
                $this->refreshQRCode();
            }
        }
        return false;
    }

    public function Login(): ClientToken{
        $response = $this->client->get($this->checkSigUrl,[
            'allow_redirects' => false
        ]);
        $cookies = $this->getCookies($response);
        $this->uin = $cookies['uin'];
        $this->skey = $cookies['skey'];

        $this->getVfwebqq();

        $this->getPsessionid();

        return $this->getClienToken();
    }


    public function getCookies(ResponseInterface $response)
    {
        $cookie = $response->getHeader('set-cookie');
        foreach ($cookie as $value) {
            preg_match('/(.*?)=(.*?);/', $value, $pre);
            $cookies[$pre[1]] = $pre[2];
        }
        return $cookies;
    }

    public function getClienToken(): ClientToken{
        $clienToken = new ClientToken();
        $clienToken->setUin($this->uin);
        $clienToken->setCheckSigUrl($this->checkSigUrl);
        $clienToken->setPtqrtoken($this->ptqrtoken);
        $clienToken->setQrcodePath($this->qrcodePath);

        $clienToken->setVfwebqq($this->vfwebqq);
        $clienToken->setClientid($this->clientid);
        $clienToken->setPsessionid($this->psessionid);
        $clienToken->setSkey($this->skey);
        return $clienToken;
    }

    public function setClienToken(ClientToken $clientToken){
        $this->uin = $clientToken->getUin();
        $this->checkSigUrl = $clientToken->getCheckSigUrl();
        $this->ptqrtoken = $clientToken->getPtqrtoken();
        $this->qrcodePath = $clientToken->getQrcodePath();

        $this->vfwebqq = $clientToken->getVfwebqq();
        $this->clientid = $clientToken->getClientid();
        $this->psessionid = $clientToken->getPsessionid();
        $this->skey = $clientToken->getSkey();
    }

    public function getVfwebqq()
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1'
        ];
        $response = $this->client->get(URL::getvfwebqqURL . "&t=" . Utils::getMillisecond(), $options);
        return $this->vfwebqq = MessageUtils::getVfwebqq($response->getBody());
    }

    public function getPsessionid()
    {
        $options['headers'] = [
            'Referer' => 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2',
        ];
        $options['form_params'] = [
            'r' => '{"ptwebqq":"","clientid":53999199,"psessionid":"","status":"online"}'
        ];
        $response = $this->client->post(URL::login2URL, $options);
        return $this->psessionid = MessageUtils::getPsessionid($response->getBody());
    }


}