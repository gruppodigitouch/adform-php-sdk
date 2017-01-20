<?php

namespace Digitouch\AdForm\Service\User;

use Digitouch\AdForm\AbstractService;

class Users extends AbstractService
{
    /**
     * @param string $endPoint
     */
    protected $endPoint = 'User/Users';

    /**
     * @param string $method
     */
    protected $method = 'GET';

    /**
     * @param string $responseVar
     */
    protected $responseVar = 'Users';
    
}