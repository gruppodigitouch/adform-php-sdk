<?php

namespace Digitouch\Tests\AdForm;

use Digitouch\AdForm\ApiFactory;
use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use Digitouch\AdForm\AbstractService;
use Digitouch\AdForm\Response as AdFormResponse;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class ApiFactoryTest extends \PHPUnit_Framework_TestCase
{

    private $api; 

    public function setUp()
    {

        // Create a mock
        $responseBody = <<<JSON
{"fake": "metric"}
JSON;

        $responseSize = strlen($responseBody);
        $stubClient = $this->createMock(HttpClient::class);
        $response = new Response(200, ['Content-Length' => $responseSize], $responseBody);
        $stubClient->method('sendData')
             ->willReturn($response);

        $this->api = new ApiFactory($stubClient);

    }

    public function testCanAuthenticateClient()
    {
        $responseBody = '{"Ticket": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIs"}';
        $responseSize = strlen($responseBody);
        $stubClient = $this->createMock(HttpClient::class);
        $response = new Response(200, ['Content-Length' => $responseSize], $responseBody);
        $stubClient->method('sendData')
             ->willReturn($response);
        $api = new ApiFactory($stubClient);
        $ticket = $api->auth('user', 'password');
        $this->assertInstanceOf('Digitouch\AdForm\Auth\TicketInterface', $ticket);
    }


    public function testCanCreateUsersService()
    {
        $stubTicket = $this->createMock(TicketInterface::class);
        $users = $this->api->service(ApiFactory::USERS, $stubTicket, []);
        $this->assertInstanceOf('Digitouch\AdForm\Service', $users);
        $this->assertInstanceOf('Digitouch\AdForm\Service\User\Users', $users);
    }

    public function testCanCreateAvertisersService()
    {
        $stubTicket = $this->createMock(TicketInterface::class);
        $users = $this->api->service(ApiFactory::ADVERTISERS, $stubTicket, []);
        $this->assertInstanceOf('Digitouch\AdForm\Service', $users);
        $this->assertInstanceOf('Digitouch\AdForm\Service\Advertiser\Advertisers', $users);
    }

    public function testCanCreateCampaignsService()
    {
        $stubTicket = $this->createMock(TicketInterface::class);
        $campaigns = $this->api->service(ApiFactory::CAMPAIGNS, $stubTicket, []);
        $this->assertInstanceOf('Digitouch\AdForm\Service', $campaigns);
        $this->assertInstanceOf('Digitouch\AdForm\Service\Campaign\Campaigns', $campaigns);
    }

    public function testCanCreateTrackingCampaignsService()
    {
        $stubTicket = $this->createMock(TicketInterface::class);
        $campaigns = $this->api->service(ApiFactory::TRACKING_CAMPAIGNS, $stubTicket, ['advertiserId' => '1111']);
        $this->assertInstanceOf('Digitouch\AdForm\Service', $campaigns);
        $this->assertInstanceOf('Digitouch\AdForm\Service\Campaign\TrackingCampaigns', $campaigns);
    }

    public function testCanCreateReportingService()
    {
        $stubTicket = $this->createMock(TicketInterface::class);
        $stats = $this->api->service(ApiFactory::REPORT_STATS, $stubTicket, []);
        $this->assertInstanceOf('Digitouch\AdForm\Service\Reporting\Stats', $stats);
        $service = $this->api->service(ApiFactory::DATA_EXPORT_LIST, $stubTicket, []);
        $this->assertInstanceOf('Digitouch\AdForm\Service\Reporting\DataExportsList', $service);
        $service = $this->api->service(ApiFactory::DATA_EXPORT, $stubTicket, ['DataExportsIds'=>'111']);
        $this->assertInstanceOf('Digitouch\AdForm\Service\Reporting\DataExports', $service);
        $service = $this->api->service(ApiFactory::DATA_EXPORT_RESULT, $stubTicket, ['DataExportName'=>'Fake']);
        $this->assertInstanceOf('Digitouch\AdForm\Service\Reporting\DataExportResult', $service);

    }


    public function testCanDirectlyCallAService()
    {
        $stubTicket = $this->createMock(TicketInterface::class);
        $res = $this->api->call(ApiFactory::USERS, $stubTicket, []);

        $this->assertInstanceOf('Digitouch\AdForm\Response', $res);
    }
    /**
     * @dataProvider provideStats
     *
     * @param obj $response
     * @param array $expected
     */
    /*public function testService($response, $var, $expected)
    {
        // Configure the stub.
        $serviceStub = $this->createMock(AbstractService::class);
        $responseStub = new AdFormResponse($response, $var);
        $serviceStub->method('getResponse')
             ->willReturn($responseStub);

        $obj = new Api($serviceStub);
        $resp = $obj->call();

        $this->assertEquals($expected, $resp);
    }*/
}

