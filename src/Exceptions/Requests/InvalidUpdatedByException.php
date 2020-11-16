<?php

namespace App\Exceptions\Requests;

use Throwable;

class InvalidUpdatedByException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}