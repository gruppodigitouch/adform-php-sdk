<?php

namespace Digitouch\AdForm\Exception;

class MissingParamsException extends \RuntimeException
{

    public function __construct($params)
    {   
        parent::__construct('Missing Parameters: '.implode($params));
    }

}