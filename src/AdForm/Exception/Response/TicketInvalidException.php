<?php

namespace Digitouch\AdForm\Exception\Response;

class TicketInvalidException extends \Exception implements AdFormResponseException
{

    protected $response;

    public function __construct($response)
    {
        $message = isset($response->Message) ? $response->Message : $response->message;
        parent::__construct($message);
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