<?php

namespace Digitouch\AdForm\Exception;

class ServiceException extends \RuntimeException
{

    public function __construct()
    {   
        parent::__construct('AdForm Service Creation Exception');
    }

}