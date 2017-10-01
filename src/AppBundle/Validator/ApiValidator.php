<?php

namespace AppBundle\Validator;


abstract class ApiValidator
{
    const VALIDATION_FAILED_CODE = 102;

    protected $message = 'This value is not correct';

    abstract public function validate($value);

    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }
}
