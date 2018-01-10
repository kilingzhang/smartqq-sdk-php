<?php
/**
 * Created by kilingzhang.com
 * User: kilingzhang
 * Date: 18-1-5
 * Time: 下午12:49
 */

namespace kilingzhang\SmartQQ;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use kilingzhang\SmartQQ\Entity\Font;
use kilingzhang\SmartQQ\Entity\ResponseMessage;
use kilingzhang\SmartQQ\Entity\SendMessage;
use kilingzhang\SmartQQ\Interfaces\PollMsgInterface;
use kilingzhang\SmartQQ\Utils\FaceUtils;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use kilingzhang\SmartQQ\Entity\ClientToken;
use kilingzhang\SmartQQ\Utils\EncryptUtils;
use kilingzhang\SmartQQ\Utils\MessageUtils;
use kilingzhang\SmartQQ\Utils\Utils;


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
    private $bkn;
    private $clientid = 53999199;
    private $vfwebqq;
    private $ptwebqq;
    private $psessionid;
    private $hash;
    private $supertoken;
    private $superkey;

    private $jarArray;
    private $jar;

    private $rspResultInterface;

    public function __construct(ClientToken $clientToken = null)
    {
        if ($clientToken != null) {
            $this->setClienToken($clientToken);
        }

        $this->client = new Client(['cookies' => true]);

        $this->qrcodePath = './qrcode.png';

    }

    public function CookieJartoArray():array
    {
        $cookieJar = $this->client->getConfig('cookies');
        return $cookieJar->toArray();
    }

    public static function ArraytoCookieJar(array $cookies):CookieJar
    {
        $jar = new CookieJar();
        foreach ($cookies as $value) {
            $cookie = new SetCookie();
            $cookie->setName($value['Name']);
            $cookie->setValue($value['Value']);
            $cookie->setDomain($value['Domain']);
            $cookie->setExpires($value['Expires']);
            $cookie->setPath($value['Path']);
            $jar->setCookie($cookie);
        }
        return $jar;
    }

    /**
     *
     * @param ResponseInterface $response
     * @return array
     */
    public function getCookies(ResponseInterface $response): array
    {
        $cookie = $response->getHeader('set-cookie');
        foreach ($cookie as $value) {
            preg_match('/(.*?)=(.*?);/', $value, $pre);
            $cookies[$pre[1]] = $pre[2];
        }
        return $cookies;
    }

    /**
     *
     * @return ClientToken
     */
    public function getClienToken(): ClientToken
    {
        $clienToken = new ClientToken();
        $clienToken->setUin($this->uin);
        $clienToken->setCheckSigUrl($this->checkSigUrl);
        $clienToken->setPtqrtoken($this->ptqrtoken);
        $clienToken->setQrcodePath($this->qrcodePath);

        $clienToken->setVfwebqq($this->vfwebqq);
        $clienToken->setClientid($this->clientid);
        $clienToken->setPsessionid($this->psessionid);
        $clienToken->setSkey($this->skey);
        $clienToken->setBkn($this->bkn);
        $clienToken->setPtwebqq($this->ptwebqq);
        $clienToken->setHash($this->hash);
        //CookieJarArray
        $clienToken->setJarArray($this->jarArray);
        return $clienToken;
    }

    /**
     *
     * @param ClientToken $clientToken
     */
    public function setClienToken(ClientToken $clientToken): void
    {
        $this->uin = $clientToken->getUin();
        $this->checkSigUrl = $clientToken->getCheckSigUrl();
        $this->ptqrtoken = $clientToken->getPtqrtoken();
        $this->qrcodePath = $clientToken->getQrcodePath();

        $this->vfwebqq = $clientToken->getVfwebqq();
        $this->clientid = $clientToken->getClientid();
        $this->psessionid = $clientToken->getPsessionid();
        $this->skey = $clientToken->getSkey();
        $this->bkn = $clientToken->getBkn();
        $this->ptwebqq = $clientToken->getPtwebqq();
        $this->hash = $clientToken->getHash();
        //CookieJarArray
        $this->jarArray = $clientToken->getJarArray();
        $this->jar = self::ArraytoCookieJar($this->jarArray);
    }

    public function setQRCodePath(string $path = './qrcode.png'): string
    {
        return $this->qrcodePath = $path;
    }

    /**
     *
     * @return string
     */
    public function getQRCodePath(): string
    {
        return $this->qrcodePath;
    }

    /**
     *
     * @return int
     */
    public function refreshQRCode(): int
    {
        $response = $this->client->get(URL::qrcodeURL, [
            't' => time()
        ]);
        $qrcode = $response->getBody();
        $cookies = $this->getCookies($response);
        $this->ptqrtoken = EncryptUtils::hash33($cookies['qrsig']);
        return file_put_contents($this->qrcodePath, $qrcode);
    }

    /**
     *
     * @return int
     */
    public function verifyQrCodeStatus(): int
    {
        $response = $this->client->get(URL::ptqrloginURL . "&ptqrtoken={$this->ptqrtoken}&action=0-0-" . time());
        $ptuiCB = MessageUtils::ptuiCBToArray($response->getBody());
        $code = $ptuiCB['code'];
        if ($code == self::OK_STATUS) {
            $this->checkSigUrl = $ptuiCB['link'];
//            $cookies = $this->getCookies($response);
//            $this->supertoken = $cookies['supertoken'];
//            $this->superkey = $cookies['superkey'];
        }
        return $code;
    }

    /**
     *
     * @return bool
     */
    public function QRLogin(): bool
    {
        set_time_limit(0);
        while (true) {
            $code = $this->verifyQrCodeStatus();
            if ($code == self::OK_STATUS) {
                return true;
            } elseif ($code == self::FAILURE_STATUS) {
                $this->refreshQRCode();
            }
        }
        return false;
    }

    /**
     *
     * @return string
     */
    public function getVfwebqq(): string
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1'
        ];
        $response = $this->client->get(URL::getvfwebqqURL . "&t=" . Utils::getMillisecond(), $options);
        return $this->vfwebqq = MessageUtils::getVfwebqq($response->getBody());
    }

    public function getHash(): string
    {
        return EncryptUtils::hashUin(substr($this->uin, 1, strlen($this->uin) - 1), $this->ptwebqq);
    }

    /**
     *
     * @return string
     */
    public function getPsessionid(): string
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

    /**
     *
     * @return ClientToken
     */
    public function Login(): ClientToken
    {
        $response = $this->client->get($this->checkSigUrl, [
            'allow_redirects' => false
        ]);
        $cookies = $this->getCookies($response);
        $this->ptwebqq = array_key_exists('ptwebqq', $cookies) ? $cookies['ptwebqq'] : '';
        $this->uin = array_key_exists('uin', $cookies) ? $cookies['uin'] : '';
        $this->skey = array_key_exists('skey', $cookies) ? $cookies['skey'] : '';
        $this->bkn = EncryptUtils::getBkn($this->bkn);
        $this->hash = $this->getHash();
        $this->getVfwebqq();
        $this->getPsessionid();

        $this->jarArray = $this->CookieJartoArray();
        $this->jar = self::ArraytoCookieJar($this->jarArray);

        return $this->getClienToken();
    }



    public function getFriendsList():array
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
        ];
        $options['form_params'] = [
            'r' => '{"vfwebqq":"' . $this->vfwebqq . '","hash":"' . $this->hash . '"}'
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->post(URL::getUserFriendsURL, $options);
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getGroupNameList():array
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
        ];
        $options['form_params'] = [
            'r' => '{"vfwebqq":"' . $this->vfwebqq . '","hash":"' . $this->hash . '"}'
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->post(URL::getGroupNameListURL, $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getDiscussList():array
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->get(URL::getDiscussListURL . "?clientid=53999199&psessionid={$this->psessionid}&vfwebqq={$this->vfwebqq}&t=" . Utils::getMillisecond(), $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getOnlineBuddies():array
    {
        $options['headers'] = [
            'Referer' => 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2',
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->get(URL::getOnlineBuddiesURL . "?vfwebqq={$this->vfwebqq}&clientid=53999199&psessionid={$this->psessionid}&t=" . Utils::getMillisecond(), $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getRecentList():array
    {
        $options['headers'] = [
            'Referer' => 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2',
        ];
        $options['form_params'] = [
            'r' => '{"vfwebqq":"' . $this->vfwebqq . '","clientid":53999199,"psessionid":"' . $this->psessionid . '"}'
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->post(URL::getRecentListURL, $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getSelfInfo():array
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->get(URL::getSelfInfoURL . "?t=" . Utils::getMillisecond(), $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getFriendInfoByUin($uin):array
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->get(URL::getFriendInfoURL . "?tuin={$uin}&vfwebqq={$this->vfwebqq}&clientid={$this->clientid}&psessionid={$this->psessionid}&t=" . Utils::getMillisecond(), $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getGroupInfoByGcode($gcode):array
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->get(URL::getGroupInfoURL . "?gcode={$gcode}&vfwebqq={$this->vfwebqq}&t=" . Utils::getMillisecond(), $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getDiscussInfoByDid($did):array
    {
        $options['headers'] = [
            'Referer' => 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2',
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->get(URL::getDiscussInfoURL . "?did={$did}&vfwebqq={$this->vfwebqq}&clientid={$this->clientid}&psessionid={$this->psessionid}&t=" . Utils::getMillisecond(), $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function getSingleLongNickByUin($uin):array
    {
        $options['headers'] = [
            'Referer' => 'http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->get(URL::getSingleLongNickURL . "?tuin={$uin}&vfwebqq={$this->vfwebqq}&t=" . Utils::getMillisecond(), $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);
    }

    public function pollMessage(PollMsgInterface $pollMsg)
    {
        set_time_limit(0);
        $options['headers'] = [
            'Referer' => 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2',
        ];
        $options['form_params'] = [
            'r' => '{"ptwebqq":"","clientid":53999199,"psessionid":"' . $this->psessionid . '","key":""}'
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->post(URL::pollURL, $options);
        $responseMsg = $response->getBody();
        $message = new ResponseMessage();
        $message->setResponseMsgObj($responseMsg);
        if ($message->retcode != 0) {
            $pollMsg->ErrorRetcode($message->retcode,$this->getClienToken());
        }
        $pollType = $message->pollType;
        switch ($pollType) {
            case 'message':
                $pollMsg->FreindMessage($message);
                break;
            case 'group_message':
                $pollMsg->GroupMessage($message);
                break;
            case 'discu_message':
                $pollMsg->DiscussMessage($message);
                break;

        }
        //TODO change echo to return
    }

    public function sendMsg($type, $to, $msg, Font $font):array
    {
        $message = new SendMessage();
        $message->setMessage($msg);
        $font = new Font();
        $message->setFont($font);
        switch ($type) {
            case "private":
                $url = URL::sendPrivateMessageURL;
                $param = '{"to":' . $to . ',"content":"' . $message->getContent() . '","face":594,"clientid":53999199,"msg_id":' . Utils::makeMsgId() . ',"psessionid":"' . $this->psessionid . '"}';
                break;
            case "group":
                $url = URL::sendGroupMessageURL;
                $param = '{"group_uin":' . $to . ',"content":"[' . $message->getContent() . ']","face":594,"clientid":53999199,"msg_id":' . Utils::makeMsgId() . ',"psessionid":"' . $this->psessionid . '"}';
                break;
            case "Discuss":
                $url = URL::sendDiscussMessageURL;
                $param = '{"did":' . $to . ',"content":"[' . $message->getContent() . ']","face":594,"clientid":53999199,"msg_id":' . Utils::makeMsgId() . ',"psessionid":"' . $this->psessionid . '"}';
                break;
        }

        $options['headers'] = [
            'Referer' => 'http://d1.web2.qq.com/proxy.html?v=20151105001&callback=1&id=2',
        ];
        $options['form_params'] = [
            'r' => $param
        ];
        $options['cookies'] = $this->jar;
        $response = $this->client->post($url, $options);
        //TODO change echo to return
        return \GuzzleHttp\json_decode($response->getBody(),true);

    }

    public function sendPrivateMsg($uin, $msg):array
    {
        //TODO change echo to return
        return $this->sendMsg('private', $uin, $msg, new Font());
    }

    public function sendGroupMsg($gid, $msg):array
    {
        //TODO change echo to return
        return $this->sendMsg('group', $gid, $msg, new Font());
    }

    public function sendDiscussMsg($did, $msg):array
    {
        //TODO change echo to return
        return $this->sendMsg('Discuss', $did, $msg, new Font());
    }



    public function test()
    {
//        $this->pollMessage(new PollMessageEvent());
//        echo FaceUtils::formFaces("231231212");
//        echo \GuzzleHttp\json_encode($this->getFriendsList(),JSON_UNESCAPED_UNICODE);
//        $this->getDiscussInfoByDid(3699650892);
//        echo \GuzzleHttp\json_encode($this->sendPrivateMsg(2820122243, '[QQ:face,id=1]在看亮剑'),JSON_UNESCAPED_UNICODE);
    }

}