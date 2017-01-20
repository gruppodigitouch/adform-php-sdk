<?php

namespace Digitouch\AdForm;

use Digitouch\AdForm\Client\ClientInterface;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Exception\ClientException;

class ApiFactory
{

    // User
    const USERS = 'User\\Users';

    // Campaign
    const ADVERTISERS = 'Advertiser\\Advertisers';

    // Campaign
    const CAMPAIGNS = 'Campaign\\Campaigns';

    // Reporting
    const REPORT_STATS = 'Reporting\\Stats';
    const DATA_EXPORT_LIST = 'Reporting\\DataExportsList';
    const DATA_EXPORT = 'Reporting\\DataExports';
    const DATA_EXPORT_RESULT = 'Reporting\\DataExportResult';

    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function auth($username, $password)
    {
        return (new \Digitouch\AdForm\Auth\Authenticator($this->httpClient, $username, $password))->getTicket();
    }

    public function service($type, TicketInterface $ticket, array $params = [])
    {

        $service = "Digitouch\\AdForm\\Service\\{$type}";
        return new $service($this->httpClient, $ticket, $params);

    }

    public function call($type, TicketInterface $ticket, array $params = [])
    {
        return $this->service($type, $ticket, $params)->getResponse();
    }
}