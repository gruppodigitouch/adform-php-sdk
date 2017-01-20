<?php

namespace Digitouch\AdForm\Service\Reporting;

use Digitouch\AdForm\AbstractService;

class DataExportResult extends AbstractService
{

    /**
     * @param string $endPoint
     */    
    protected $endPoint = 'DataExport/DataExportResult';

    /**
     * @param string $method
     */
    protected $method = 'GET';

    /**
     * @param string $responseVar
     */
    protected $responseVar = 'DataExportResult';

    /**
     * @param string $mandatoryParams
     */
    protected $mandatoryParams = ['DataExportName'];


}