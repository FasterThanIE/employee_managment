<?php

namespace App\Exceptions\User;

use Throwable;

class InvalidUserStatusException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}