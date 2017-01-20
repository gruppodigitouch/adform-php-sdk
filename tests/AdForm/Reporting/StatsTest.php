<?php

namespace Digitouch\Tests\AdForm\Reporting;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;


class StatsTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    private $responseBody;

    public function setUp()
    {

        // Create a mock
        $this->responseBody = <<<JSON
{
  "reportData": {
    "columnHeaders": [
      "client"
    ],
    "columns": [
      {
        "key": "client"
      }
    ],
    "rows": [
      [
        "FakeClient"
      ]
    ]
  },
  "correlationCode": "ext_32a0e4df-eaa2"
}
JSON;

        $responseSize = strlen($this->responseBody);
        $stubClient = $this->createMock(HttpClient::class);
        $response = new Response(200, ['Content-Length' => $responseSize], $this->responseBody);
        $stubClient->method('sendData')
             ->willReturn($response);

        $stubTicket = $this->createMock(TicketInterface::class);

        $this->service = new \Digitouch\AdForm\Service\Reporting\Stats($stubClient, $stubTicket);

    }

    /**
     * @test
     */
    public function serviceWillReturnValidResponse()
    {
        $service = $this->service;
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Reporting\Stats::class, $service);
        $this->assertEquals($service->getResponse()->fetch(), json_decode($this->responseBody)->reportData);
    }

}