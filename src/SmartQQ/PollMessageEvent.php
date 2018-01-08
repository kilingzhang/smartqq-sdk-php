<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-7
 * Time: 下午8:15
 */

namespace kilingzhang\SmartQQ;

use kilingzhang\SmartQQ\Entity\Message;
use kilingzhang\SmartQQ\PollMsgInterface;

class PollMessageEvent implements PollMsgInterface
{

    public function FreindMessage(Message $message)
    {
        // TODO: Implement FreindMessage() method.
        echo 'FreindMessage recived from : ' . $message->form_uin;
    }

    public function GroupMessage(Message $message)
    {
        // TODO: Implement GroupMessage() method.
        echo 'GroupMessage recived from : ' . $message->group_code;
    }

    public function DiscusMessage(Message $message)
    {
        // TODO: Implement DiscusMessage() method.
        echo 'DiscusMessage recived from : ' . $message->did;
    }
}