<?php


namespace App\Libs\Structures;


class ResponseObj
{
    public $code;
    public $data;
    public $message;

    public function __construct($code, $data, $message, Meta $meta = null)
    {
        $this->code = $code;
        $this->data = $data;
        $this->message = $message;
        if($meta != null){
            $this->meta = $meta;
        }
    }

}
