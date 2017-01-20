<?php

namespace Digitouch\AdForm\Exception\Response;

class GenericResponseException extends \Exception implements AdFormResponseException
{

    protected $response;

    public function __construct($response)
    {   
        parent::__construct('AdForm Response Exception');
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }


}