<?php

namespace Digitouch\AdForm\Exception\Response;

class TicketMissingException extends \Exception implements AdFormResponseException
{

    protected $response;

    public function __construct($response)
    {
        parent::__construct($response->Message);
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