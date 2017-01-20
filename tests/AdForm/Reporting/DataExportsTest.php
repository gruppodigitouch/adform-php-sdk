<?php

namespace Digitouch\Tests\AdForm\Reporting;

use Digitouch\AdForm\Client\HttpClient;
use Digitouch\AdForm\Auth\TicketInterface;
use GuzzleHttp\Psr7\Response;


class DataExportsTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    private $responseBody;

    public function setUp()
    {

        // Create a mock
        $this->responseBody = <<<JSON
{
  "DataExports": [
    {
      "Id": 1234,
      "Name": "fake_export"
    },
    {
      "Id": 4321,
      "Name": "fake_export_2"
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

        $this->service = new \Digitouch\AdForm\Service\Reporting\DataExports($stubClient, $stubTicket, ['DataExportsIds'=>'1234,4321']);
    }

    /**
     * @test
     */
    public function serviceWillReturnValidResponse()
    {
        $service = $this->service;
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Reporting\DataExports::class, $service);
        $res = $service->getResponse()->fetch();
        $this->assertEquals($res, json_decode($this->responseBody)->DataExports);
        $this->assertEquals($res[0]->Id, 1234);
        $this->assertEquals($res[1]->Name, 'fake_export_2');
    }

    /**
     * @test
     * @expectedException Digitouch\AdForm\Exception\MissingParamsException
     * @expectedExceptionMessage Missing Parameters: DataExportsIds
     */
    public function serviceWillReturnExcpetionIfParamsAreWrong()
    {
        $stubClient = $this->createMock(HttpClient::class);
        $stubTicket = $this->createMock(TicketInterface::class);
        $service = new \Digitouch\AdForm\Service\Reporting\DataExports($stubClient, $stubTicket, []);
        $this->assertInstanceOf(\Digitouch\AdForm\Service\Reporting\DataExports::class, $service);
    }
}