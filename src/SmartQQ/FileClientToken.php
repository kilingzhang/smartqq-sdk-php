<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-10
 * Time: 上午5:06
 */

namespace kilingzhang\SmartQQ;


use kilingzhang\SmartQQ\Entity\ClientToken;
use kilingzhang\SmartQQ\Interfaces\ClientTokenInterface;

class FileClientToken implements ClientTokenInterface
{

    private $path;

    public function save($clientToken)
    {
        $this->path = './ClientToken.json';
        return file_put_contents($this->path, $clientToken);
    }

    public function delete()
    {
        return unlink($this->path);
    }

    public function getClientTokenJson():string
    {
        return file_get_contents($this->path);
    }

    public function isEmpty():bool
    {
        return !file_exists($this->path);
    }
}