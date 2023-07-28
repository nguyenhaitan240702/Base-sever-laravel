<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    protected $customMessage = 'An error occurred.';

    public function __construct($message = null, $code = 0, Throwable $previous = null)
    {
        // Use the custom message if provided, otherwise use the default message
        $message = $message ?: $this->customMessage;

        parent::__construct($message, $code, $previous);
    }
}
