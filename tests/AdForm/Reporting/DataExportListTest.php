<?php

namespace Digitouch\Tests\AdForm\Reporting;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;


class DataExportListTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    private $responseBody;

    public function setUp()
    {

        // Create a mock
        $this->responseBody = <<<JSON
{
  "DataExportList": [
    {
      "Id": 1234,
      "Name": "text_export"
    },
    {
      "Id": 4321,
      "Name": "text_export_2",
      "ExportType": "Web variables"
    }
  ]
}
JSON;

        $responseSize = strlen($this->responseBody);
        $stubClient = $this->createMock(HttpClient::class);
        $response = new Response(200, ['Content-Length' => $responseSize], $this->responseBody);
        $stubClient->method('sendData')
             ->willReturn($response);

        $stubTicket = $this->createMock(TicketInterface::class);

        $this->service = new \Digitouch\AdForm\Service\Reporting\DataExportsList($stubClient, $stubTicket);

    }

    /**
     * @test
     */
    public function serviceWillReturnValidResponse()
    {
        $service = $this->service;
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Reporting\DataExportsList::class, $service);
        $this->assertEquals($service->getResponse()->fetch(), json_decode($this->responseBody)->DataExportList);
    }

}