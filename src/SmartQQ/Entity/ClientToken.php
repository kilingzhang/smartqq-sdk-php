<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-6
 * Time: 下午5:43
 */

namespace kilingzhang\SmartQQ\Entity;


class ClientToken
{
    private $ptqrtoken;
    private $checkSigUrl;
    private $qrcodePath;

    private $uin;
    private $skey;
    private $clientid = 53999199;
    private $vfwebqq;
    private $psessionid;

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
     * @return int
     */
    public function getClientid()
    {
        return $this->clientid;
    }

    /**
     * @param int $clientid
     */
    public function setClientid($clientid)
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


}