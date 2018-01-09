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
        echo 'FreindMessage recived '. $message->content .' from : ' . $message->fromUin;
    }

    public function GroupMessage(Message $message)
    {
        // TODO: Implement GroupMessage() method.
        echo 'GroupMessage recived '. $message->content .' from : ' . $message->groupCode;
    }

    public function DiscusMessage(Message $message)
    {
        // TODO: Implement DiscusMessage() method.
        echo 'DiscusMessage recived '. $message->content .' from : ' . $message->did;
    }
}