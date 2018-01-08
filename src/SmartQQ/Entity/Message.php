<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-8
 * Time: 下午4:25
 */

namespace kilingzhang\SmartQQ\Entity;


class Message
{
    private $msgObj;

    public $retcode;
    /**
     * message
     * group_message
     * discu_message
     * @var
     */
    public $pollType;

    /**
     * private 1
     * gruop 4
     * discus 5
     * @var
     */
    public $msgType;
    public $msgId;
    public $fromUin;
    public $groupCode;
    public $did;
    public $sendUin;
    public $toUin;
    public $time;

    public $content;
    public $font;

    /**
     * @return mixed
     */
    public function getMsgObj()
    {
        return $this->msgObj;
    }

    /**
     * @param mixed $msgObj
     */
    public function setMsgObj(string $responseMsg)
    {
        $this->msgObj = json_decode($responseMsg);
        $this->serializable();
    }

    private function serializable()
    {

    }



}