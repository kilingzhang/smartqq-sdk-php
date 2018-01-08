<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-7
 * Time: 下午8:09
 */

namespace kilingzhang\SmartQQ;


use kilingzhang\SmartQQ\Entity\Message;

interface PollMsgInterface
{
    public function FreindMessage(Message $message);
    public function GroupMessage(Message $message);
    public function DiscusMessage(Message $message);
}