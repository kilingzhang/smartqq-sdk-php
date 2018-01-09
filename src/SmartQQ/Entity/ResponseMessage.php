<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-8
 * Time: 下午4:25
 */

namespace kilingzhang\SmartQQ\Entity;


class ResponseMessage
{
    private $responseMsgObj;

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
    public function getResponseMsgObj()
    {
        return $this->responseMsgObj;
    }

    /**
     * @param mixed $responseMsgObj
     */
    public function setResponseMsgObj(string $responseMsg)
    {
        $this->responseMsgObj = json_decode($responseMsg);
        $this->serializable();
    }

    private function serializable()
    {
        $this->retcode = $this->responseMsgObj->retcode;
        if($this->retcode == 0){
            $this->pollType = $this->responseMsgObj->result[0]->poll_type;
            $this->fromUin = array_key_exists('from_uin',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->from_uin : '';
            $this->msgType = array_key_exists('msg_type',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->msg_type : '';
            $this->msgId = array_key_exists('msg_id',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->msg_id : '';
            $this->groupCode = array_key_exists('group_code',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->group_code : '';
            $this->did = array_key_exists('did',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->did : '';
            $this->sendUin = array_key_exists('send_uin',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->send_uin : '';
            $this->toUin = array_key_exists('to_uin',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->to_uin : '';
            $this->time = array_key_exists('time',$this->responseMsgObj->result[0]->value) ? $this->responseMsgObj->result[0]->value->time : '';
            $this->content = '';
            for ($i = 1; $i < count($this->responseMsgObj->result[0]->value->content) ;$i++){
                if(!is_array($this->responseMsgObj->result[0]->value->content[$i])){
                    $this->content .= $this->responseMsgObj->result[0]->value->content[$i];
                }else{
                    $this->content .= '[QQ:face,id='. $this->responseMsgObj->result[0]->value->content[$i][1] .']';
                }
            }
            //TODO Font Entity
//            $this->font = $this->responseMsgObj->result[0]->value->content[$i][0];


        }
    }


}