<?php

namespace Ora\Chat\Exceptions;

use Illuminate\Support\MessageBag;
use Exception;

class StorageValidationException extends Exception {

    protected $modelName;
    protected $messages;

    public function __construct($modelName, MessageBag $messages, $message = null, $code = 0, Exception $previous = null)
    {
        $this->modelName = $modelName;
        $this->messages  = $messages;

        if (is_null($message))
        {
            $message = sprintf('A validation error has occurred in model %s.', $modelName);
        }

        parent::__construct($message, (int) $code, $previous);
    }

    public function errors()
    {
        return $this->messages;
    }

}