<?php

namespace Digitouch\AdForm\Service\Reporting;

use Digitouch\AdForm\AbstractService;

class Stats extends AbstractService
{

    /**
     * @param string $endPoint
     */    
    protected $endPoint = 'https://api.adform.com/v1/reportingstats/agency/reportdata';

    /**
     * @param string $method
     */
    protected $method = 'POST';

    /**
     * @param string $responseVar
     */
    protected $responseVar = 'reportData';


}