<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-7
 * Time: 下午8:09
 */

namespace kilingzhang\SmartQQ;


interface PollMsgInterface
{
    public function FreindMessage($message);
    public function GroupMessage($message);
    public function DiscusMessage($message);
}