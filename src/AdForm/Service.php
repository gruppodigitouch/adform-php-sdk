<?php

namespace Digitouch\AdForm;

use Digitouch\AdForm\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Exception\ClientException;
use Digitouch\AdForm\Exception as AdFormException;

interface Service
{
    public function getResponse();
}