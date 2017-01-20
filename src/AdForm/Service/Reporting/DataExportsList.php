<?php

namespace Digitouch\AdForm\Service\Reporting;

use Digitouch\AdForm\AbstractService;

class DataExportsList extends AbstractService
{

    /**
     * @param string $endPoint
     */    
    protected $endPoint = 'DataExport/DataExportsList';

    /**
     * @param string $method
     */
    protected $method = 'GET';

    /**
     * @param string $responseVar
     */
    protected $responseVar = 'DataExportList';


}