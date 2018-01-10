<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-9
 * Time: 下午3:02
 */

namespace kilingzhang\SmartQQ\Entity;


use kilingzhang\SmartQQ\Utils\FaceUtils;

class SendMessage
{
    private $font;
    private $message;
    private $content;

    /**
     * @return mixed
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param mixed $font
     */
    public function setFont(Font $font)
    {
        $this->font = $font;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


    /**
     * @return mixed
     */
    public function getContent()
    {
        $this->content = FaceUtils::formFaces($this->message);
        array_push($this->content, \GuzzleHttp\json_decode('["font",{"name":"宋体","size":10,"style":[0,0,0],"color":"000000"}]', true));
        $this->content = \GuzzleHttp\json_encode($this->content, JSON_UNESCAPED_UNICODE);
        return addslashes($this->content);
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = addslashes($this->content);
        $this->content = $content;
    }


}