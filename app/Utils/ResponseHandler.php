<?php

namespace App\Utils;

use Illuminate\Http\Response;

class ResponseHandler
{
    public $success = false;

    public static function create()
    {
        $handler = new ResponseHandler;
        return $handler;
    }

    public function isSuccess()
    {
        $this->success = true;
        return $this;
    }

    public function isFailed()
    {
        $this->success = false;
        return $this;
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function send($httpStatus = 200)
    {
        return response((array) $this, $httpStatus);
    }
}