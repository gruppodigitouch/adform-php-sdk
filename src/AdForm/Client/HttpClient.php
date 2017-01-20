<?php

namespace Digitouch\AdForm\Client;

use GuzzleHttp\Client as Guzzle;

/**
 * Main Guzzle Client
 */
class HttpClient implements ClientInterface
{
    private $guzzle;

    public function __construct($options = [])
    {
        $options = array_merge($options, [
            'base_uri' => 'https://api.adform.com/Services/'
        ]);

        $this->guzzle = new Guzzle($options);
    }

    public function getGuzzle()
    {
        return $this->guzzle;
    }

    public function sendData($method, $uri, $options = [])
    {
        $options = array_merge($options, [
            'http_errors' => false,
        ]);
        $response = $this->guzzle->request($method, $uri, $options);

        return $response;
    }

}