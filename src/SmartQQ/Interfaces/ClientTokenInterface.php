<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-10
 * Time: 上午4:55
 */

namespace kilingzhang\SmartQQ\Interfaces;


interface ClientTokenInterface
{
    public function save($clientToken);
    public function delete();
    public function getClientTokenJson();
    public function isEmpty();
}