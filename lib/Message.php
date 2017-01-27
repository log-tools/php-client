<?php

namespace nastradamus39\logger\lib;

class Message {

    const TYPE_WARNING = 'E_WARNING';

    const TYPE_NOTICE = 'E_NOTICE';

    const TYPE_FATAL = 'E_FATAL';

    const TYPE_ERROR = 'E_ERROR';

    const TYPE_INFO = 'E_INFO';

    /**
     * @var message type
     */
    public $type = null;

    /**
     * @var message text
     */
    public $message;

    /**
     * @var file where message was generated
     */
    public $file = null;

    /**
     * @var line where message was generated
     */
    public $line = null;

    /**
     * @var key for authorization
     */
    public $key = null;


    public function __construct($params)
    {

        if( !empty($params['message']) ) {
            $this->message=strval($params['message']);
        } else {
            throw new \Exception("Message cannot be empty");
        }

        if(!empty($params['file'])) {
            $this->file = strval($params['file']);
        }

        if(!empty($params['line'])) {
            $this->line = intval($params['line']);
        }

    }

    public function __toString()
    {
        return json_encode([
                'type'      => $this->type,
                'message'   => $this->message,
                'file'      => $this->file,
                'line'      => $this->line,
                'key'       => $this->key
            ]);
    }

}