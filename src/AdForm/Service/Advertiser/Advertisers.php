<?php

namespace Digitouch\AdForm\Service\Advertiser;

use Digitouch\AdForm\AbstractService;

class Advertisers extends AbstractService
{
    /**
     * @param string $endPoint
     */
    protected $endPoint = 'Advertiser/Advertisers';

    /**
     * @param string $method
     */
    protected $method = 'GET';

    /**
     * @param string $responseVar
     */
    protected $responseVar = 'Advertisers';
    
}