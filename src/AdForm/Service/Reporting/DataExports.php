<?php

namespace Digitouch\AdForm\Service\Reporting;

use Digitouch\AdForm\AbstractService;

class DataExports extends AbstractService
{

    /**
     * @param string $endPoint
     */    
    protected $endPoint = 'DataExport/DataExports';

    /**
     * @param string $method
     */
    protected $method = 'GET';

    /**
     * @param string $responseVar
     */
    protected $responseVar = 'DataExports';

    /**
     * @param string $mandatoryParams
     */
    protected $mandatoryParams = ['DataExportsIds'];


}