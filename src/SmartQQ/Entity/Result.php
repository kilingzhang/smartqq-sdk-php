<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-10
 * Time: 上午6:14
 */

namespace kilingzhang\SmartQQ\Entity;


class Result
{
    private $retcode;
    private $result;
    private $errmsg;

    /**
     * @return mixed
     */
    public function getRetcode()
    {
        return $this->retcode;
    }

    /**
     * @param mixed $retcode
     */
    public function setRetcode($retcode)
    {
        $this->retcode = $retcode;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result = \GuzzleHttp\json_decode($result,true);
    }

    /**
     * @return mixed
     */
    public function getErrmsg()
    {
        return $this->errmsg;
    }

    /**
     * @param mixed $errmsg
     */
    public function setErrmsg($errmsg)
    {
        $this->errmsg = $errmsg;
    }



}