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
        $this->retcode = $this->msgObj->retcode;
        if($this->retcode == 0){
            $this->pollType = $this->msgObj->result[0]->poll_type;
            $this->fromUin = array_key_exists('from_uin',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->from_uin : '';
            $this->msgType = array_key_exists('msg_type',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->msg_type : '';
            $this->msgId = array_key_exists('msg_id',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->msg_id : '';
            $this->groupCode = array_key_exists('group_code',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->group_code : '';
            $this->did = array_key_exists('did',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->did : '';
            $this->sendUin = array_key_exists('send_uin',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->send_uin : '';
            $this->toUin = array_key_exists('to_uin',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->to_uin : '';
            $this->time = array_key_exists('time',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value->time : '';
            $this->content = '';
            for ($i = 1; $i < count($this->msgObj->result[0]->value->content) ;$i++){
                if(!is_array($this->msgObj->result[0]->value->content[$i])){
                    $this->content .= $this->msgObj->result[0]->value->content[$i];
                }else{
                    $this->content .= '[QQ:face,id='. $this->msgObj->result[0]->value->content[$i][1] .']';
                }
            }
//            $this->font = array_key_exists('from_uin',$this->msgObj->result[0]->value) ? $this->msgObj->result[0]->value['from_uin'] : '';


        }
    }


}