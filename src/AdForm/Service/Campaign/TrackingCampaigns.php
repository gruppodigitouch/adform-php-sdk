<?php

namespace Digitouch\AdForm\Service\Campaign;

use Digitouch\AdForm\AbstractService;

class TrackingCampaigns extends AbstractService
{

    /**
     * @param string $endPoint
     */
    protected $endPoint = 'https://api.adform.com/v1/campaigns/trackingCampaigns';

    /**
     * @param string $method
     */
    protected $method = 'GET';

    /**
     * @param string $responseVar
     */
    protected $responseVar = false;
    
    /**
     * @param string $mandatoryParams
     */
    protected $mandatoryParams = ['advertiserId'];
}