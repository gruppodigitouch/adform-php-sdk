<?php

namespace Digitouch\AdForm\Service\Campaign;

use Digitouch\AdForm\AbstractService;

class Campaigns extends AbstractService
{

    /**
     * @param string $endPoint
     */
    protected $endPoint = 'http://api.adform.com/v1/campaigns';

    /**
     * @param string $method
     */
    protected $method = 'GET';

    /**
     * @param string $responseVar
     */
    protected $responseVar = 'campaigns';
    
}