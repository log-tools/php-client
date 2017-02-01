<?php

namespace nastradamus39\logger;

use nastradamus39\logger\lib\Message;

class Client {

    const METHOD_POST = 'POST';

    const METHOD_GET = 'GET';

    const API_URL = 'http://api.httplog.dev0.pro/api_v1';

    /** @var string $URL */
    private $URL;

    /** @var string $KEY */
    private $KEY;

    /** @var string $TOKEN */
    private $TOKEN;

    public function __construct($key, $token)
    {
        if(empty($key) || empty($token)) {
            throw new \Exception("Key and token not set.");
        }
        $this->KEY = $key;
        $this->TOKEN = $token;
    }

    private function headers(){
        $header = "Content-Type: application/json\r\n".
            "Authorization: Basic {$this->TOKEN}\r\n";
        return $header;
    }

    private function _send(Message $message) {

        $message->key=$this->KEY;

        $opts = ['http' => [
            'method'  => self::METHOD_POST,
            'header'  => $this->headers(),
            'content' => strval($message)
        ]];

        $context  = stream_context_create($opts);
        $resp = file_get_contents(self::API_URL."/logs", false, $context);
        return json_decode($resp);
    }

    public function warning($message)
    {
        $message = new Message(['message'=>$message]);
        $message->type = Message::TYPE_WARNING;
        return $this->_send($message);
    }

    public function notice($message)
    {
        $message = new Message(['message'=>$message]);
        $message->type = Message::TYPE_NOTICE;
        return $this->_send($message);
    }

    public function fatal($message)
    {
        $message = new Message(['message'=>$message]);
        $message->type = Message::TYPE_FATAL;
        return $this->_send($message);
    }

    public function error($message)
    {
        $message = new Message(['message'=>$message]);
        $message->type = Message::TYPE_ERROR;
        return $this->_send($message);
    }

    public function info($message)
    {
        $message = new Message(['message'=>$message]);
        $message->type = Message::TYPE_INFO;
        return $this->_send($message);
    }

}