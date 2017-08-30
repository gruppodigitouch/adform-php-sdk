<?php

namespace Digitouch\AdForm;

use Digitouch\AdForm\Auth\TicketInterface;
use Digitouch\AdForm\Client\ClientInterface;
use Digitouch\AdForm\Exception\MissingParamsException;
use Digitouch\AdForm\Exception\Response\UnauthorizedException;
use Digitouch\AdForm\Exception\ServiceException;
use Digitouch\AdForm\Response as AdFormResponse;
use Digitouch\AdForm\Service;
use stdClass;

class AbstractService implements Service
{

    /**
     * @param ClientInterface $httpClient
     */
    protected $httpClient;

    /**
     * @param TicketInterface $code
     */
    protected $ticket;

    /**
     * @param string $endPoint
     */
    protected $endPoint = null;


    /**
     * @param string $method
     */
    protected $method = 'GET';


    /**
     * @param array $params
     */
    protected $params;

    /**
     * @param string $responseVar
     */
    protected $responseVar = null;

    /**
     * @param string $mandatoryParams
     */
    protected $mandatoryParams = [];


    public function __construct(ClientInterface $httpClient, TicketInterface $ticket, array $params = [])
    {
        $this->httpClient = $httpClient;
        $this->ticket = $ticket;
        $this->params = $params;

        if(is_null($this->endPoint) || is_null($this->responseVar)) {
            throw new ServiceException;
        }

        $check = array_map(function($param) use ($params) {
            return array_key_exists($param, $params);
        }, $this->mandatoryParams);
        if(!empty($this->mandatoryParams) && in_array(false, $check)) {
            throw new MissingParamsException($this->mandatoryParams);
        }
    }


    public function getResponse()
    {

        $bodyReq = $this->method == 'GET' ? 'query' : 'json';

        $options = [
            'headers' => ['Ticket' => $this->ticket],
            $bodyReq => $this->params,
        ];

        $responseJson = $this->httpClient->sendData($this->method, $this->endPoint, $options);

        if ($responseJson->getStatusCode() === 401) {
            $response = new stdClass();
            $response->message = $responseJson->getReasonPhrase();
            throw new UnauthorizedException($response);
        }

        $response = json_decode($responseJson->getBody()->getContents());

        return new AdFormResponse($response, $this->responseVar);

    }
}
