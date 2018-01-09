<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-6
 * Time: 下午5:43
 */

namespace kilingzhang\SmartQQ\Entity;


use GuzzleHttp\Cookie\CookieJar;
use kilingzhang\SmartQQ\FileClientToken;
use kilingzhang\SmartQQ\Interfaces\ClientTokenInterface;

class ClientToken
{
//    切记不要打开注释
//    private $ptqrtoken;
//    private $checkSigUrl;
//    private $qrcodePath;
//
//    private $uin;
//    private $skey;
//    private $bkn;
//    private $clientid = 53999199;
//    private $vfwebqq;
//    private $psessionid;
//    private $ptwebqq;
//    private $hash;
//    private $jarArray;



    private $clientToken;
    private $clientTokenInterface;

    public function __construct(ClientTokenInterface $clientTokenInterface = null)
    {
        if($clientTokenInterface == null){
            $clientTokenInterface = new FileClientToken();
        }
        $this->clientTokenInterface = $clientTokenInterface;
    }


    public function __get($name)
    {
        if (array_key_exists($name, $this->clientToken)) {
            return $this->clientToken[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        $this->clientToken[$name] = $value;
    }

    public function __toString() {
        $json = \GuzzleHttp\json_encode($this->clientToken,JSON_UNESCAPED_UNICODE);
        return $json;
    }

    /**
     * @param $json|json
     * @return ClientToken
     */
    public static function toClientToken($json):ClientToken
    {
        $client = \GuzzleHttp\json_decode($json,true);
        $clientToken = new ClientToken();
        foreach ($client as $key => $value){
            $clientToken->$key = $value;
        }
        return $clientToken;
    }

    /**
     * @return mixed
     */
    public function getPtqrtoken()
    {
        return $this->ptqrtoken;
    }

    /**
     * @param mixed $ptqrtoken
     */
    public function setPtqrtoken($ptqrtoken)
    {
        $this->ptqrtoken = $ptqrtoken;
    }

    /**
     * @return mixed
     */
    public function getCheckSigUrl()
    {
        return $this->checkSigUrl;
    }

    /**
     * @param mixed $checkSigUrl
     */
    public function setCheckSigUrl($checkSigUrl)
    {
        $this->checkSigUrl = $checkSigUrl;
    }

    /**
     * @return mixed
     */
    public function getQrcodePath()
    {
        return $this->qrcodePath;
    }

    /**
     * @param mixed $qrcodePath
     */
    public function setQrcodePath($qrcodePath)
    {
        $this->qrcodePath = $qrcodePath;
    }

    /**
     * @return mixed
     */
    public function getUin()
    {
        return $this->uin;
    }

    /**
     * @param mixed $uin
     */
    public function setUin($uin)
    {
        $this->uin = $uin;
    }

    /**
     * @return mixed
     */
    public function getSkey()
    {
        return $this->skey;
    }

    /**
     * @param mixed $skey
     */
    public function setSkey($skey)
    {
        $this->skey = $skey;
    }

    /**
     * @return mixed
     */
    public function getBkn()
    {
        return $this->bkn;
    }

    /**
     * @param mixed $bkn
     */
    public function setBkn($bkn)
    {
        $this->bkn = $bkn;
    }

    /**
     * @return int
     */
    public function getClientid(): int
    {
        return $this->clientid;
    }

    /**
     * @param int $clientid
     */
    public function setClientid(int $clientid)
    {
        $this->clientid = $clientid;
    }

    /**
     * @return mixed
     */
    public function getVfwebqq()
    {
        return $this->vfwebqq;
    }

    /**
     * @param mixed $vfwebqq
     */
    public function setVfwebqq($vfwebqq)
    {
        $this->vfwebqq = $vfwebqq;
    }

    /**
     * @return mixed
     */
    public function getPsessionid()
    {
        return $this->psessionid;
    }

    /**
     * @param mixed $psessionid
     */
    public function setPsessionid($psessionid)
    {
        $this->psessionid = $psessionid;
    }

    /**
     * @return mixed
     */
    public function getPtwebqq()
    {
        return $this->ptwebqq;
    }

    /**
     * @param mixed $ptwebqq
     */
    public function setPtwebqq($ptwebqq)
    {
        $this->ptwebqq = $ptwebqq;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getJarArray()
    {
        return $this->jarArray;
    }

    /**
     * @param mixed $jar
     */
    public function setJarArray($jarArray)
    {
        $this->jarArray = $jarArray;
    }


    /**
     * @param FileClientToken|ClientTokenInterface $clientTokenInterface
     */
    public function setClientTokenInterface($clientTokenInterface)
    {
        $this->clientTokenInterface = $clientTokenInterface;
    }




    public function save(){
        return $this->clientTokenInterface->save($this);
    }

    public function delete(){
        return $this->clientTokenInterface->delete();
    }

    public function getClientTokenJson(){
        return $this->clientTokenInterface->getClientTokenJson();
    }

    public function isEmpty(){
        return $this->clientTokenInterface->isEmpty();
    }





}