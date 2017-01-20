<?php

namespace Digitouch\AdForm\Client;

/**
 * Main Guzzle Client
 */
interface ClientInterface
{
    public function sendData($method, $uri, $options = []);
}