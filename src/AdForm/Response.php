<?php

namespace Digitouch\AdForm;

use Digitouch\AdForm\Exception\Response as AdFormResponseException;


class Response
{
    /**
     * @param stdClass $response
     */
    private $response;

    /**
     * @param string $var
     */
    private $var;


    public function __construct($response, $var)
    {
        $this->response = $response;
        $this->var = $var;
    }

    public function fetch()
    {

        if(isset($this->response->{$this->var}) && null !== $this->response->{$this->var}) {
            return $this->response->{$this->var};
        }

        $responseError = $this->response;
        if (isset($responseError->Message)) {

            switch ($responseError->Message) {
                case 'Ticket is invalid':
                    throw new AdFormResponseException\TicketInvalidException($responseError);
                    break;
                case 'Ticket header is missing':
                    throw new AdFormResponseException\TicketMissingException($responseError);
                    break;
            }
        }

        if (isset($responseError->reason)) {

            switch ($responseError->reason) {
                case 'authenticationFailed':
                    throw new AdFormResponseException\TicketInvalidException($responseError);
                    break;
                case 'unauthorized':
                    throw new AdFormResponseException\UnauthorizedException($responseError);
                    break;
                case 'unauthorizedDimensionOrMetric':
                    throw new AdFormResponseException\UnauthorizedDimensionOrMetricException($responseError);
                    break;
            }
        }

        if(!$this->var && !empty($this->response)) {
            return $this->response;
        }

        throw new AdFormResponseException\GenericResponseException($responseError);

    }

}
