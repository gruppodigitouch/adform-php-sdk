<?php

namespace Digitouch\Tests\AdForm\Reporting;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class TrackingCampaignsTest extends \PHPUnit_Framework_TestCase
{
    private $stubClient;
    private $stubTicket;
    private $responseBody;
    private $responseBodySingle;

    public function setUp()
    {

        // Create a mock
        $this->responseBodySingle = <<<JSON
{"id": 5678,"code": "fktk-it-5678"}
JSON;

        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => strlen($this->responseBodySingle)], $this->responseBodySingle),
        ]);
        $handler = HandlerStack::create($mock);

        $this->stubClient = new HttpClient(['handler' => $handler]);
        $this->stubTicket = $this->createMock(TicketInterface::class);

    }

    /**
     * @test
     * @expectedException Digitouch\AdForm\Exception\MissingParamsException
     * @expectedExceptionMessage Missing Parameters: advertiserId
     */
    public function serviceWillReturnExcpetionIfParamsAreWrong()
    {
        $stubClient = $this->createMock(HttpClient::class);
        $stubTicket = $this->createMock(TicketInterface::class);
        $service = new \Digitouch\AdForm\Service\Campaign\TrackingCampaigns($stubClient, $stubTicket, []);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Campaign\TrackingCampaigns::class, $service);
    }

    /**
     * @test
     */
    public function serviceWillReturnValidResponse()
    {
        $serviceSingle = new \Digitouch\AdForm\Service\Campaign\TrackingCampaigns($this->stubClient, $this->stubTicket, ['advertiserId' => 1234]);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Campaign\TrackingCampaigns::class, $serviceSingle);
        $resSingle = $serviceSingle->getResponse()->fetch();
        $this->assertEquals($resSingle, json_decode($this->responseBodySingle));
        $this->assertEquals($resSingle->id, 5678);
    }

}
